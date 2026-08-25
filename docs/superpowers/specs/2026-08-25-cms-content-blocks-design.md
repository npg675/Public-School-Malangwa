# Design: Full CMS Coverage via Content Blocks

Date: 2026-08-25
Status: Approved (pending implementation plan)
Scope: Make every public page's content database-driven and editable from the admin panel.

## 1. Context (audit findings)

Already DB-driven: notices, news, events, results, downloads, gallery listing, contact messages.

Hardcoded / English-only today:

- `index.php` — hero stats, About blurb, Learning Pathways cards, Commitment items,
  Head Teacher quote (duplicates unused `site_settings` keys), homepage gallery tiles, CTA banner.
- `about.php` — intro, vision/mission/values, timeline, facilities, fake staff counts;
  ignores seeded `pages` row and the real `staff` table.
- `academics.php`, `faq.php`, `links.php`, `publications.php`, `management.php`, `science.php` — fully static.
- `pages` table + admin Pages module exist but no public page reads from them.

Existing DB assets to wire up instead of duplicating: `academic_programs`, `staff`,
gallery tables, `site_settings` (principal name/message/photo, enrollment, contact),
`pages` (long-form prose), `notices/events/downloads` helpers.

## 2. Goals / Non-goals

**Goals**

- All visible copy on public pages comes from the DB and is editable in admin.
- Every content field bilingual (`_en` / `_np`), rendered by `current_lang()`.
- Visual output unchanged after migration (seeds carry current exact text).
- Works in demo mode (`DB_DISABLED=1`) with identical content.

**Non-goals**

- No drag-drop builder, no revisions/history, no auto-translation.
- No new JS/CSS dependencies; admin keeps Tailwind CDN pattern.
- Legacy `*.html` files untouched. `menus` table stays out of scope.

## 3. Data model

New table (added to `database.sql`; CREATE TABLE IF NOT EXISTS + INSERT IGNORE seeds,
safe to re-run on live installs):

```sql
content_blocks (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  page_slug    VARCHAR(100) NOT NULL,   -- 'home','about','academics','faq','links',
                                        -- 'publications','management','science'
  section_key  VARCHAR(100) NOT NULL,   -- see inventory below
  sort_order   INT DEFAULT 0,
  title_en     VARCHAR(255) NULL,  title_np     VARCHAR(255) NULL,
  subtitle_en  VARCHAR(255) NULL,  subtitle_np  VARCHAR(255) NULL,
  body_en      MEDIUMTEXT NULL,    body_np      MEDIUMTEXT NULL,
  image_url    VARCHAR(255) NULL,
  icon         VARCHAR(50)  NULL,  -- Material Symbols name
  link_url     VARCHAR(255) NULL,
  is_active    TINYINT(1) DEFAULT 1,
  updated_by   INT UNSIGNED NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_blocks_page (page_slug, section_key, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

Field semantics per section (documented in form labels):

| section_key | rows | title | subtitle | body | image/icon/link |
|---|---|---|---|---|---|
| home `hero` | 1 | headline | badge pill | lead paragraph | bg image |
| home `stat` | 4 | value ("45+") | — | label ("Qualified Teachers") | — |
| home `intro` | 1 | heading | — | paragraph | — |
| home `commitment` | 4 | label | — | — | icon |
| home `cta_banner` | 1 | heading | — | line | — |
| about `page_header` | 1 | H1 | location chip | — | — |
| about `intro` | 2 | heading(row 1) | — | paragraph | — |
| about `value` | 3 | Vision/Mission/Values | — | text | icon |
| about `timeline` | 4 | year BS | year AD | milestone text | — |
| about `facility` | 4 | name | — | description | photo |
| about `cta_join` | 1 | heading | — | line | — |
| academics `intro`, publications `intro`, management `intro`, science `intro` | 1–3 | heading | — | paragraph | — |
| science `highlight`, management `highlight` | n | label | — | text | icon |
| faq `faq_item` | n | question | — | answer | — |
| links `link` | n | link label | — | — | icon + link_url |

Singleton sections = one row; repeats = N rows ordered by `sort_order`.

`site_settings` gains key `principal_photo`; already-seeded keys reused as-is:
`principal_name`, `principal_message_en/np`, `show_principal`, `students_display`,
`iemis_code`, address/phone/email keys. (Hero background image lives on the hero
block's `image_url` — no extra setting.)

## 4. Helpers (`includes/helpers.php`)

```php
get_blocks(string $page, ?string $section = null): array
  // Active rows for page (optionally one section), ordered.
  // Falls back to built-in seed arrays (verbatim copy of DB seeds) when DB
  // disabled/empty — pages never render broken.

block_val(array $block, string $field): string
  // Returns ${field}_en or ${field}_np per current_lang();
  // falls back to the other language when the requested one is empty.

get_page_content(string $slug): ?array
  // Published pages-table row for long-form prose pages.
```

Prepared statements only; results escaped at output via `e()`.

## 5. Admin panel

New module following the existing list+form pattern:

- `admin/blocks.php` — list filtered by page dropdown, grouped by section;
  add/edit/delete, active toggle, numeric sort_order. "Add block" pre-fills
  page/section from query params.
- `admin/block-form.php` — EN/NP inputs side-by-side; image upload through the
  existing allowlist uploader (pdf/docx/xlsx/jpg/png max 8MB → images here);
  icon text input with live Material Symbols preview; validation: at least one
  of title_en/title_np required per row.
- Nav entry "Content Blocks" in `admin/includes/header.php`.
- RBAC: `super_admin`, `school_admin`, `editor`. CSRF token on forms.
  Writes logged to `activity_logs`.

## 6. Page-by-page mapping

| Page | Section → source |
|---|---|
| home | hero, stat×4, intro, commitment×4, cta_banner → `content_blocks`; quote → `site_settings` principal keys + `principal_photo`; pathways → `academic_programs` (active, ordered); notices/events/downloads/gallery → existing helpers |
| about | page_header, intro×2, value×3, timeline×4, facility×4, cta_join → `content_blocks`; At-a-Glance → `site_settings` (name, type static, enrollment, coverage static chips, location, IEMIS); Leadership & Team → `staff` directory grouped by `staff_categories` (replaces fake counts) |
| academics | intro → blocks; program cards → `academic_programs` grouped by level; +2 streams keep deep-links to science/management pages |
| admissions | prose → `pages` slug `admissions` (already seeded EN+NP) |
| faq | intro (optional) + `faq_item` blocks |
| links | `link` blocks |
| publications | intro → block; listing → `downloads` filtered to category slug `publications` (no new module needed) |
| management | intro + highlights → blocks; committee members → `staff` (category `committee`) |
| science | intro + highlights → blocks; lab photos → blocks with images |
| citizen-charter, scholarships | prose → `pages` rows (seed both languages) |

All pages render via `current_lang()`; empty sections show the friendly
placeholder convention ("will be published soon").

## 7. Seeds & migration

- `database.sql` gains the `content_blocks` DDL + INSERT IGNORE seeds carrying
  **today's exact hardcoded copy**, EN and NP (NP translated manually now, once —
  this is the one-time content authoring step, not runtime auto-translation).
- Missing `pages` seeds added: `citizen-charter`, `scholarships` (EN+NP).
- Re-runnable against a live install without data loss; fresh imports get everything.
- Demo-mode fallback arrays in helpers duplicate the same strings verbatim.

## 8. Verification

1. `php -l` every touched PHP file.
2. `php -S localhost:8000` from project root.
3. Click through every mapped page in EN and NP, with DB enabled and with `DB_DISABLED=1`.
4. Admin round-trip: edit a block → verify public page reflects it; toggle inactive → hides;
   delete → placeholder appears.
5. Confirm uploads still validate and `activity_logs` records block edits.

## 9. Risks / notes

- One-time NP authoring for newly-bilingual strings; flagged placeholders used where
  school must confirm wording (per "no invented data" rule).
- `publications` standalone table left unused (deprecated later); page serves from downloads.
- No FULLTEXT/index concerns; charset stays utf8mb4_unicode_ci throughout.
