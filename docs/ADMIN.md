# Admin Guide — Shree Public Secondary School

URL: `/admin` → login. Roles: **super_admin** (all), **school_admin** (content + settings), **editor** (notices/news/events/gallery), **exam_officer** (results only).

The initial database seed creates an admin account for first-time setup. Change that password immediately from Admin → **Change Password**, and never use the seed password on a public deployment. Login attempts are rate limited per IP and email; a temporary 429 response means the lockout window must expire.

Dashboard cards: Published/Draft Notices, News, Upcoming Events, Downloads, Gallery Images, Contact Messages. Quick buttons: New Notice, New News, Upload Document, Add Event, Add Gallery.

- **Notices:** title_en/title_np, slug, reference number, category, body, attachment (pdf/docx/xlsx/jpg/png, max 8MB), thumbnail, published_at, expires_at, pinned, urgent, draft/published/archived. SEO-friendly `/notice/{slug}`.
- **Downloads:** category (Forms/Routine/Results/Calendar/Curriculum/Reports/Charter/Policies/Procurement/Publications/Scholarships/Other), file, size, date. Allowlist validation.
- **Results:** create exam (type/year/class) → import CSV (symbol_no, name, grade, gpa) → publish/unpublish. Search returns only matching row; no bulk exposure.
- **Gallery:** Albums (Campus/Classroom/Academic/Sports/Cultural/Celebrations/Community/Other) → multiple upload → reorder → cover → bilingual captions → publish. Lazy loading + lightbox.
- **People:** Leadership / Teachers / Staff / Management Committee — photo, name_en/np, designation, qualification, phone/email with public toggle, display order.
- **Citizen Charter:** HTML table + downloadable PDF, last updated date.
- **Languages:** नेपाली | EN toggle persists via cookie. Enter both versions manually; no auto-translation.

### Content Blocks (CMS page sections)
Admin → **Content Blocks** controls all repeating and singleton page sections via table `content_blocks` (`page_slug`, `section_key`, `sort_order`, bilingual `title/subtitle/body`, `image_url`, `icon`, `link_url`, `is_active`).
- **Pages & sections:**
  - `home`: `hero`(1), `stat`(4), `intro`(1), `commitment`(4), `cta_banner`(1)
  - `about`: `page_header`(1), `intro`(2), `value`(3), `timeline`(4), `facility`(4), `cta_join`(1)
  - `academics`: `intro` (long prose lives in **Pages → academics**)
  - `science`/`management`: `intro` + `highlight`(4)
  - `faq`: `faq_item`(9) → rendered as `<details>`; links use relative URLs (`/contact.php`)
  - `links`: `link`(8) → `link_url` + label/description
  - `publications`: `intro` + listing from `Downloads` filtered to category `publications`
  - Long-form prose for `admissions`, `citizen-charter`, `scholarships`, `academics`, `science`, `management` lives in **Pages** (friendly RTE editor) — Content Blocks hold cards/tiles.
- **Editing:** Page filter dropdown → grouped table (Sort | Section | Title EN/NP | Active) → Edit/Delete. Add Block pre-fills page/section from filter. Validation: at least one of `title_en`/`title_np` required.
- **Image upload:** Field `image_url` + Upload button → `POST admin/upload.php` with `subdir=blocks` → randomized name, allowlist `jpg/png/webp/pdf` max 10MB → path saved, preview shown.
- **Icon:** Material Symbols name (e.g. `volunteer_activism`, `school`) with live preview.
- **Visibility:** Active = visible, Draft = hidden (`is_active=0` filtered at query).
- **Sort:** Numeric `sort_order` — lower first within the same section.
- **Demo mode:** When `DB_DISABLED=1` or table empty, helpers fall back to `includes/content-seeds.php` (verbatim copy of DB seeds) so pages never break. Edit is disabled in demo mode.
- **Audit:** Writes logged to `activity_logs` (`block.create` / `block.update`).

Empty states: "No notices in this category", "Academic calendar will be published soon" — never broken cards.
