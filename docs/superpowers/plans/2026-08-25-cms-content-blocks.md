# CMS Content Blocks Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Make every public page's content database-driven and admin-editable via a `content_blocks` table + admin module, wiring up existing entity tables (`academic_programs`, `staff`, `pages`, `site_settings`) and making all pages bilingual.

**Architecture:** One new `content_blocks` table (page_slug + section_key + bilingual fields) with a single admin CRUD module. Repeating card content lives in blocks; long-form prose lives in the existing `pages` table (edited via existing friendly RTE editor); factual/entity data stays in its own tables. Helpers in `includes/helpers.php` fall back to seed arrays when DB is off/empty so pages never break.

**Tech Stack:** Plain PHP 8.2+, MySQL utf8mb4, Tailwind CDN (admin), existing helper conventions (`e()`, `e_attr()`, `t()`, `current_lang()`, prepared statements only).

**Spec:** `docs/superpowers/specs/2026-08-25-cms-content-blocks-design.md`

**Verification model:** No test framework exists. Every task ends with `php -l` on touched files; final task is a full manual click-through per AGENTS.md.

---

## File Structure

```
database.sql                      MODIFY  content_blocks DDL, seeds, principal_photo, pages-row upserts,
                                          academic_programs description enrichment
includes/content-seeds.php        CREATE  master PHP array of all block seeds (single source for demo fallback)
includes/helpers.php              MODIFY  get_blocks(), block_val(), get_page_content(), page_val(),
                                          get_programs(); extend get_downloads() with category filter
admin/blocks.php                  CREATE  list module (filter by page, group by section)
admin/block-form.php              CREATE  create/edit form incl. image upload widget
admin/includes/admin_header.php   MODIFY  add "Content Blocks" nav item
index.php                         REWRITE sections from blocks/settings/entities
about.php                         REWRITE sections from blocks/settings/staff directory
academics.php                     MODIFY  intro blocks + program cards loop from academic_programs
science.php / management.php      MODIFY  intro + highlight blocks (+ committee grid on management)
faq.php                           MODIFY  faq_item blocks loop
links.php                         MODIFY  link blocks loop
publications.php                  MODIFY  intro block + downloads(publications) listing
admissions.php                    MODIFY  overview prose from pages row; t()-wrap headings
citizen-charter.php               MODIFY  intro prose from pages row
scholarships.php                  MODIFY  t()-wrap static guidance strings
docs/ADMIN.md                     MODIFY  document Content Blocks module
```

Block row shape used everywhere: keys `page_slug, section_key, sort_order, title_en, title_np, subtitle_en, subtitle_np, body_en, body_np, image_url, icon, link_url, is_active`.

---

### Task 1: Schema — `content_blocks` DDL + seeds in database.sql

**Files:**
- Modify: `database.sql` (append before final `SET FOREIGN_KEY_CHECKS=1;` line; also patch two earlier seed statements)

- [x] **Step 1: Add DDL after the `activity_logs` CREATE TABLE block**

```sql
-- Content blocks (CMS page sections)
CREATE TABLE IF NOT EXISTS content_blocks (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  page_slug VARCHAR(100) NOT NULL,
  section_key VARCHAR(100) NOT NULL,
  sort_order INT DEFAULT 0,
  title_en VARCHAR(255) NULL,
  title_np VARCHAR(255) NULL,
  subtitle_en VARCHAR(255) NULL,
  subtitle_np VARCHAR(255) NULL,
  body_en MEDIUMTEXT NULL,
  body_np MEDIUMTEXT NULL,
  image_url VARCHAR(255) NULL,
  icon VARCHAR(50) NULL,
  link_url VARCHAR(255) NULL,
  is_active TINYINT(1) DEFAULT 1,
  updated_by INT UNSIGNED NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_blocks_page (page_slug, section_key, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

- [x] **Step 2: Patch existing seeds. In the `site_settings` INSERT, add one row to the VALUES list:**
`('principal_photo','uploads/gallery/staff/leadership-team-photo.jpg')`

In the `academic_programs` INSERT change the ON DUPLICATE clause to:
`ON DUPLICATE KEY UPDATE title_en=VALUES(title_en), description_en=VALUES(description_en), description_np=VALUES(description_np);`
and give each of the 6 rows full descriptions (EN text = first paragraph of the current academics.php detail section for that level; NP translation). Example row:
```sql
('ecd','ECD / Nursery','ecd',NULL,1,'<p>Play-based start to formal schooling — early language, early numeracy, creative expression and social habits under the CDC national framework. Readiness for Grade 1 is emphasised over premature formal testing.</p>','<p>राष्ट्रिय पाठ्यक्रम (सीडीसी) अनुसार खेलमार्फत सिकाइ — प्रारम्भिक भाषा, अंक ज्ञान, सिर्जनात्मक अभिव्यक्ति र सामाजिक बानी। कक्षा १ को तयारीलाई प्राथमिकता।</p>'),
```
(same pattern for grades-1-5, grades-6-8, grades-9-10, plus2-science, plus2-management using their current detail paragraphs)

- [x] **Step 3: Add pages-table seed upserts (replaces the current `INSERT IGNORE INTO pages` statement)**

Use `INSERT INTO pages (...) VALUES (...) ON DUPLICATE KEY UPDATE title_np=VALUES(title_np), content_en=VALUES(content_en), content_np=VALUES(content_np);` for slugs: `about`, `admissions`, `citizen-charter`, `scholarships`, `academics`, `science`, `management`. EN bodies = current hardcoded copy from each .php file (converted to `<h2>/<h3>/<p>/<ul><li>` HTML); NP = authored translations. Keep existing `faq`/`publications` rows as-is (INSERT IGNORE fine).

- [x] **Step 4: Append content-block seeds (INSERT IGNORE, slug-less; guard with NOT EXISTS on page_slug+section_key+sort_order)**

Full seed set (45 rows — copy strings verbatim from includes/content-seeds.php created in Task 2):

home: hero(1), stat(4: "45+"/"Qualified Teachers", "1,000+"/"Students", "1947"/"Established", "98%"/"Pass Rate"), intro(1), commitment(4: volunteer_activism/National Curriculum, workspace_premium/Two NEB Streams, biotech/Community Focus, handshake/Government Oversight), cta_banner(1).
about: page_header(1), intro(2), value(3: visibility/Vision, school/Mission, workspace_premium/Values), timeline(4: "2003 BS|1947 AD|Establishment...", "2040 BS||Expansion to secondary level (Grade 10).", "2065 BS||Introduction of Higher Secondary (+2) programs.", "2080 BS||Modernization with ICT-integrated Smart Classrooms."), facility(4: staff-room-interior.jpg/Science Laboratory, staff-room-computer.jpg/ICT Lab, headmaster-office.jpg/Library, courtyard-students-formation.jpg/Sports Ground), cta_join(1).
faq: faq_item(9 Q/A pairs from current faq.php, answers keep internal `<a href>` links rewritten with relative URLs like `/contact.php`).
links: link(8 rows: moest/cehrd/neb/cdc/see/malangwamun/madhesh/nea with link_url + body=description line).
science: intro(1 = 3 current overview paragraphs as HTML), highlight(4: Scientific reasoning, Mathematics, Analytical thinking, Practical understanding & problem solving).
management: intro(1), highlight(4: Business understanding, Accounting concepts, Economics, Organisational thinking communication & entrepreneurship).
publications: intro(1).

Every string gets EN + authored NP. Seed statement pattern:

```sql
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,body_en,body_np,icon,image_url,link_url)
SELECT * FROM (SELECT 'home' ps,'stat' sk,2 so,'1,000+' te,'१,०००+' tn,NULL se,NULL sn,NULL be,NULL bn,'groups' ic,NULL iu,NULL lu) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='stat' AND sort_order=2);
```
(repeat per row; nullable columns omitted when unused)

- [x] **Step 5: Syntax check**

Run: `php -l database.sql` is not applicable — instead verify by importing:
`Get-Content database.sql | mysql -u root -p <dbname>` (or import via phpMyAdmin locally)
Expected: no SQL errors; `SELECT COUNT(*) FROM content_blocks` returns 45.

- [x] **Step 6: Commit**
```bash
git add database.sql
git commit -m "feat: content_blocks schema + bilingual CMS seeds"
```

---

### Task 2: Demo fallback — `includes/content-seeds.php`

**Files:**
- Create: `includes/content-seeds.php`

- [x] **Step 1: Create file returning the master seed array**

```php
<?php
declare(strict_types=1);
function cms_seed_blocks(): array {
  return [
    ['page_slug'=>'home','section_key'=>'hero','sort_order'=>0,
     'title_en'=>'Shree Public Secondary School — Malangwa-2','title_np'=>'श्री पब्लिक माध्यमिक विद्यालय — मलंगवा-२',
     'subtitle_en'=>'Admissions Open 2082','subtitle_np'=>'भर्ना खुला २०८२',
     'body_en'=>'Providing public education from Early Childhood Development through Grade 12 in the heart of Malangwa. ECD–12 • +2 Science & Management (NEB).',
     'body_np'=>'मलंगवाको केन्द्रमा बालविकासदेखि कक्षा १२ सम्म सार्वजनिक शिक्षा। ईसीडी–१२ • +२ विज्ञान तथा व्यवस्थापन (एनईबी)।',
     'image_url'=>'uploads/hero/hero-main-gate-jubilee.jpg','icon'=>NULL,'link_url'=>NULL],
    // ... remaining 44 rows identical to Task 1 Step 4 SQL strings ...
  ];
}
```

- [x] **Step 2: Lint** — Run: `php -l includes/content-seeds.php`. Expected: `No syntax errors`.

- [x] **Step 3: Commit** — `git add includes/content-seeds.php; git commit -m "feat: CMS block seed data source"`

---

### Task 3: Helpers — get_blocks / block_val / get_page_content / get_programs

**Files:**
- Modify: `includes/helpers.php` (append after `get_gallery_albums()`; modify `get_downloads()` signature)

- [x] **Step 1: Add functions (complete code)**

```php
require_once __DIR__ . '/content-seeds.php';

function get_blocks(string $page, ?string $section = null): array {
    $pdo = db();
    if ($pdo && db_has_table('content_blocks')) {
        try {
            $sql = 'SELECT * FROM content_blocks WHERE is_active = 1 AND page_slug = :page';
            $params = [':page' => $page];
            if ($section !== null) { $sql .= ' AND section_key = :sec'; $params[':sec'] = $section; }
            $sql .= ' ORDER BY sort_order, id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll();
            if ($rows || $section !== null) return $section !== null ? $rows : [];
        } catch (Throwable $e) {}
    }
    $out = [];
    foreach (cms_seed_blocks() as $b) {
        if ($b['page_slug'] === $page && ($section === null || $b['section_key'] === $section)) $out[] = $b;
    }
    usort($out, fn($a,$b) => [$a['section_key'],(int)$a['sort_order']] <=> [$b['section_key'],(int)$b['sort_order']]);
    return $out;
}

function block_val(array $b, string $field): string {
    $lang = current_lang();
    $v = (string)($b[$field . '_' . $lang] ?? '');
    if ($v === '') $v = (string)($b[$field . '_en'] ?? '');
    return $v;
}

function get_page_content(string $slug): ?array {
    $pdo = db();
    if ($pdo && db_has_table('pages')) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ? AND status='published' LIMIT 1");
            $stmt->execute([$slug]);
            $row = $stmt->fetch();
            if ($row) return $row;
        } catch (Throwable $e) {}
    }
    return null;
}

function page_val(?array $row, string $field): string {
    if (!$row) return '';
    $lang = current_lang();
    $v = (string)($row[$field . '_' . $lang] ?? '');
    if ($v === '') $v = (string)($row[$field . '_en'] ?? '');
    return $v;
}

function get_programs(): array {
    $pdo = db();
    if ($pdo && db_has_table('academic_programs')) {
        try {
            $rows = $pdo->query('SELECT * FROM academic_programs WHERE is_active = 1 ORDER BY sort_order')->fetchAll();
            if ($rows) return $rows;
        } catch (Throwable $e) {}
    }
    return [
        ['slug'=>'ecd','title_en'=>'ECD / Nursery','level'=>'ecd','stream'=>NULL,'description_en'=>'<p>Play-based start to formal schooling.</p>'],
        ['slug'=>'grades-9-10','title_en'=>'Grades 9–10 (SEE)','level'=>'secondary_9_10','stream'=>NULL,'description_en'=>'<p>SEE pathway.</p>'],
        ['slug'=>'plus2-science','title_en'=>'+2 Science','level'=>'higher_secondary','stream'=>'Science','description_en'=>'<p>NEB science stream.</p>'],
    ];
}
```

Note the `get_blocks` subtlety: when DB works but a specific section has no rows yet, return `[]` (real empty state) — fallback seeds only apply when the whole table is missing/empty or DB disabled. When `$section===null` and table empty → fallback.

- [x] **Step 2: Extend get_downloads with category filter**

Change signature line 115 to `function get_downloads(int $limit = 6, ?string $category = null): array {` and inside the try, after building base SQL add:
```php
$params = [];
if ($category) { $sql = str_replace('WHERE d.status', 'WHERE c.slug = :cat AND d.status', $sql); $params[':cat'] = $category; }
$stmt = $pdo->prepare($sql);
foreach ($params as $k=>$v) $stmt->bindValue($k,$v);
$stmt->bindValue(':lim',$limit,PDO::PARAM_INT);
```

- [x] **Step 3: Lint + smoke** — `php -l includes/helpers.php`; then `php -S localhost:8000` and load homepage (old template still works — helpers are additive). Expected: no errors.
- [x] **Step 4: Commit** — `git commit -am "feat: content-block and page-content helpers"`

---

### Task 4: Admin module — blocks.php + block-form.php + nav

**Files:**
- Create: `admin/blocks.php`, `admin/block-form.php`
- Modify: `admin/includes/admin_header.php` (nav, after Pages link)

- [x] **Step 1: Nav item**

After the Pages `<a>` line insert:
```html
<a href="<?= e_attr(base_url('admin/blocks.php')) ?>" class="<?= $adminPage==='blocks'?'active':'' ?>"><span class="material-symbols-outlined">dashboard_customize</span>Content Blocks</a>
```

- [x] **Step 2: admin/blocks.php (complete)** — follows pages.php pattern: `$adminPage='blocks'; require admin_header.php`; delete action with csrf; page filter dropdown (GET `?page=home`) over known slugs `[home, about, academics, admissions, faq, links, publications, management, science]`; query `SELECT * FROM content_blocks [WHERE page_slug=:p] ORDER BY page_slug, section_key, sort_order LIMIT 200`; render grouped table rows: Sort | Section | Title(en/np stacked) | Active tag | Edit/Delete buttons; "+ Add Block" button linking `block-form.php?page=<selected>`.

- [x] **Step 3: admin/block-form.php (complete)** — pages-form pattern: edit via `?id`; POST handler validating `title_en OR title_np` non-empty, sanitizing ints; build `$d` array of all 12 columns + updated_by; INSERT/UPDATE with named placeholders (same implode technique as page-form). Form cards:
  1. Placement — page_slug select + section_key select (options per page from constant array `BLOCK_SECTIONS`, e.g. home => hero/stat/intro/commitment/cta_banner; about => page_header/intro/value/timeline/facility/cta_join; faq => note/faq_item; links => link; publications => intro; management/science => intro/highlight; academics => intro; admissions => step) + sort_order number input.
  2. Text English — title/subtitle inputs + body textarea (accepts simple HTML).
  3. Text नेपाली — same three fields.
  4. Media & link — image_url hidden field + upload button (JS `fetch('upload.php',{method:'POST',body:FormData(file,subdir:'blocks')})` → sets field + preview img), icon text input with live preview `<span class="material-symbols-outlined" id="iconPreview"></span>`, link_url input.
  5. Visibility — active/draft status pills.
  Save bar like page-form. Log write:
```php
try { $pdo->prepare('INSERT INTO activity_logs (user_id,action,entity_type,entity_id,detail) VALUES (?,?,?,?,?)')
       ->execute([$_SESSION['user_id']??null, $editing?'block.update':'block.create','content_blocks',(string)($d[':id']??$pdo->lastInsertId()),$d['page_slug'].':'.$d['section_key']]); } catch (Throwable $e) {}
```

- [x] **Step 4: Verify** — `php -l` both files; log into `/admin`, create a test block on `home/intro`; confirm it appears in list; delete it. Expected round-trip works.
- [x] **Step 5: Commit** — `git commit -am "feat: Content Blocks admin module"`

---

### Task 5: index.php rewrite

**Files:**
- Modify: `index.php`

- [x] **Step 1: Fetch data at top (after existing helper calls)**

```php
$blocks   = get_blocks('home');
$sec      = function(string $k) use ($blocks): array { return array_values(array_filter($blocks, fn($b) => $b['section_key'] === $k)); };
$first    = function(string $k) use ($sec): ?array { return $sec($k)[0] ?? null; };
$hero     = $first('hero'); $intro = $first('intro'); $cta = $first('cta_banner');
$programs = get_programs();
```

- [x] **Step 2: Replace Hero section markup** — badge text `e(block_val($hero,'subtitle'))`; h1 `e(block_val($hero,'title'))` (drop gold span; uniform white); lead paragraph `e(block_val($hero,'body'))` with `<?= e(APP_STUDENTS_DISPLAY) ?>` students figure prepended via separate sentence already inside copy — keep APP_STUDENTS_DISPLAY stat tile driven by setting; hero bg `base_url($hero['image_url'] ?: 'uploads/hero/hero-main-gate-jubilee.jpg')`.
Stat tiles become `<?php foreach ($sec('stat') as $st): ?>` loop rendering `e(block_val($st,'title'))` value + `e(block_val($st,'body'))` label (replace Students hardcode with setting('students_display') at seed level — value stored in block).

- [x] **Step 3: About section** — heading `e(block_val($intro,'title'))`, paragraph `e(block_val($intro,'body'))`.

- [x] **Step 4: Learning Pathways** — replace 4 hardcoded anchors with loop over `$programs`:
icon map by level: ecd→child_care, basic_1_5→menu_book, basic_6_8→menu_book, secondary_9_10→school, higher_secondary→science; badge label map (Early Childhood / Grades 1-8 / Grades 9-10 / stream names); higher_secondary cards link science.php/management.php by stream; others → academics.php. Card body shows `e(strip_tags(block-level description))` — use program row directly: `mb_strimwidth(strip_tags((string)($p['description_en'] ?? '')), 0, 90, '…')` for the EN-only mini blurb (homepage tiles stay compact; full bilingual text lives on academics.php).

- [x] **Step 5: Commitment loop** — `foreach ($sec('commitment') as $c)` rendering icon + `e(block_val($c,'title'))`.

- [x] **Step 6: Quote section** — drive from settings:
```php
$showQuote = setting('show_principal','1') === '1' && setting('principal_name') !== '';
```
Markup uses `setting('principal_photo')`, `e(setting('principal_message_' . current_lang()))` falling back to `_en`, name `setting('principal_name')`, role line `t('Head Teacher','प्रधानाध्यापक')`. Wrap whole section in `<?php if ($showQuote): ?>`.

- [x] **Step 7: Gallery section** — replace hardcoded masonry with `get_gallery_albums(4)` loop: first album spans 2×2 with cover overlay label `e(block-free: album title_en)`, others plain covers; keep hover CSS classes identical. Empty albums → keep section but show placeholder tile "Photos coming soon."

- [x] **Step 8: CTA banner** — heading/body from `$cta` block; keep buttons/admission link + APP_PHONE logic unchanged.

- [x] **Step 9: Verify** — `php -l index.php`; run server; check EN + NP (`?lang=np` cookie via toggle) render both languages from seeds; check DB-disabled mode (`DB_DISABLED=1` in .env) still renders.
- [x] **Step 10: Commit** — `git commit -am "feat: CMS-driven homepage sections"`

---

### Task 6: about.php rewrite

**Files:**
- Modify: `about.php`

- [x] **Step 1: Data setup** — same `$blocks/$sec/$first` closure pattern for page_slug `'about'`; `$staffGroups = get_staff_directory();`

- [x] **Step 2: Page header** — H1 from page_header block (`block_val(...,'title')`), location chip `t('Malangwa-2, Sarlahi','मलंगवा-२, सर्लाही')`.

- [x] **Step 3: Intro** — loop `foreach ($sec('intro') as $i => $ip)`: first row renders h2 heading + body, subsequent rows body only.

- [x] **Step 4: Values** — loop `$sec('value')`: icon, title, body (replaces Vision/Mission/Values hardcodes).

- [x] **Step 5: At-a-Glance** — institution name `t(APP_NAME_EN equivalent via setting('site_name_en'), setting('site_name_np'))`; type chip `t('Public / Community','सरकारी / सामुदायिक')`; enrollment `setting('students_display')`; coverage chips static t(); location `t(setting-based address)` use `setting('address_'.current_lang())`; IEMIS `APP_IEMIS`.

- [x] **Step 6: Timeline** — loop `$sec('timeline')`: title=year BS, subtitle=year AD, body=text.

- [x] **Step 7: Facilities** — loop `$sec('facility')`: image_url, title, body.

- [x] **Step 8: Leadership & Team** — replace fake counts:
Leadership grid loops `$staffGroups['leadership']` (photo_url or initials fallback via `staff_initials()`); if empty keep ONE dashed "Profile coming soon" card.
Below: committee grid from `$staffGroups['committee']`; teaching grid `$staffGroups['teaching']`; administration `$staffGroups['administration']` + non_teaching merged; each group hidden entirely when empty; group headings via `t()` pairs (Leadership/नेतृत्व etc.).

- [x] **Step 9: CTA join** — from `cta_join` block.

- [x] **Step 10: Verify both langs + DB-off; lint; Commit** — `git commit -am "feat: CMS-driven about page with real staff directory"`

---

### Task 7: academics.php rewrite

**Files:**
- Modify: `academics.php`

- [x] **Step 1:** Hero/breadcrumb/enrollment table/related-links chrome stays; wrap chrome labels in `t()` (Overview→अवलोकन, Enrollment→भर्ना, Related→सम्बन्धित, grade rows keep numerals).
- [x] **Step 2:** Overview paragraph replaced by pages-body slot:
```php
$ov = get_page_content('academics');
if ($ov) { echo page_val($ov,'content'); } else { /* legacy hardcoded paragraph */ }
```
- [x] **Step 3:** Replace BOTH the 6-card grid and the 4 verbose detail sections with ONE loop over `get_programs()` rendering rich cards (same visual style as old detail boxes): icon/tag/level-label maps by `level` enum; title `t($p['title_en'],$p['title_np'])`; description raw HTML `t($p['description_en'],$p['description_np'])` (trusted admin HTML); higher_secondary cards append Explore Science/Management deep-link buttons.
- [x] **Step 4:** Verify EN/NP + DB-off (fallback programs render); lint; Commit.

---

### Task 8: science.php + management.php

**Files:**
- Modify: `science.php`, `management.php`

- [x] **Step 1 (both):** Intro block singleton replaces overview paragraphs (render `block_val($intro,'body')` raw HTML); verify-banner/gold-note/pathway boxes remain chrome wrapped in `t()` with authored NP strings.
- [x] **Step 2 (both):** Learning-focus grid loops `$sec('highlight')`: icon + title + body.
- [x] **Step 3 (management only):** After highlights add Committee section:
```php
$groups = get_staff_directory();
```
render `$groups['committee']` member cards (photo/initials, name, designation); hide section when empty.
- [x] **Step 4:** Verify both langs + DB-off; lint; Commit.

---

### Task 9: faq.php + links.php + publications.php

**Files:**
- Modify: `faq.php`, `links.php`, `publications.php`

- [x] **Step 1 (faq):** Loop `$sec('faq_item')` into `<details>` elements (summary=title, body raw HTML). Note-box + CTA footer chrome wrapped `t()`. Empty state keeps existing style.
- [x] **Step 2 (links):** Loop `$sec('link')` into `.gov-link` anchors: `href=e_attr(link_url)`, label=title, description=body; external-note chrome t().
- [x] **Step 3 (publications):** Intro block replaces info-box text; category explainer tiles chrome t(); listing area:
```php
$pubs = get_downloads(12, 'publications');
```
Render download cards (existing downloads-page card style) or keep the intentional empty state when none.
- [x] **Step 4:** Verify ×2 langs ×2 db-modes; lint ×3; Commit.

---

### Task 10: admissions / citizen-charter / scholarships wiring

**Files:**
- Modify: `admissions.php`, `citizen-charter.php`, `scholarships.php`

- [x] **Step 1 (admissions):** Overview `<p>` becomes:
```php
$admPage = get_page_content('admissions');
if ($admPage && trim(page_val($admPage,'content')) !== '') { echo page_val($admPage,'content'); }
else { /* existing hardcoded <p> retained as fallback */ }
```
Wrap these chrome strings in `t()`: "How admission works"/"भर्ना प्रक्रिया कसरी चल्छ", four step titles+blurts, levels list titles, documents checklist items, form labels.
- [x] **Step 2 (citizen-charter):** Intro box text becomes pages-body slot (slug `citizen-charter`) with same fallback pattern; wrap table headers (already bilingual) and help-box in `t()`.
- [x] **Step 3 (scholarships):** Wrap the two guidance cards ("Quota & eligibility"/"How to apply") + hero lead in `t()`.
- [x] **Step 4:** Verify ×2 langs; lint ×3; Commit.

---

### Task 11: Full verification + docs

**Files:**
- Modify: `docs/ADMIN.md`

- [x] **Step 1: Lint sweep** —
```bash
Get-ChildItem *.php, admin\*.php, includes\*.php, config\*.php -File | ForEach-Object { php -l $_.FullName }
```
Expected: `No syntax errors detected` for every file.

- [x] **Step 2: Runtime matrix** — `php -S localhost:8000`; visit index, about, academics, science, management, faq, links, publications, admissions, citizen-charter, scholarships in EN and NP with (a) DB enabled fresh import of patched database.sql, (b) `DB_DISABLED=1`. Expected: identical structure, translated copy, no PHP warnings.

- [x] **Step 3: Admin round-trip** — login → Content Blocks: edit home hero title → homepage reflects it; toggle inactive → hides; delete a stat → placeholder/remaining stats fine; upload an image through the form → path saved + renders. Edit Pages → Academics → verify academics page body updates. Confirm activity_logs rows written.

- [x] **Step 4: Docs** — add to docs/ADMIN.md a "Content Blocks" section: what it controls, page/section glossary, image upload note, demo-mode behavior.

- [x] **Step 5: Final commit** — `git commit -am "docs: content blocks admin guide"`

---

## Self-review notes

- Spec §6 mapping vs tasks: home/about/academics/faq/links/publications/management/science/citizen-charter/scholarships/admissions all covered (Tasks 5–10). ✔
- Refinement vs spec worth knowing: academics verbose detail sections are folded into `academic_programs.description_*` seeds and rendered as rich program cards (one loop) rather than keeping duplicated hardcoded boxes — content preserved verbatim, visuals consolidated. Long-form prose for academics/science/management/admissions/citizen-charter goes through the existing admin **Pages** editor (already CMS) instead of inventing a second prose system.
- Type/name consistency: `get_blocks(string,string|null):array`, `block_val(array,string):string`, `get_page_content(string):?array`, `page_val(?array,string):string`, `get_programs():array`, `get_downloads(int,?string):array` used identically across Tasks 5–10. ✔
