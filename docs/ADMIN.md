# Admin Guide — Shree Public Secondary School

URL: `/admin` → login. Roles: **super_admin** (all), **school_admin** (content + settings), **editor** (notices/news/events/gallery), **exam_officer** (results only).

Dashboard cards: Published/Draft Notices, News, Upcoming Events, Downloads, Gallery Images, Contact Messages. Quick buttons: New Notice, New News, Upload Document, Add Event, Add Gallery.

- **Notices:** title_en/title_np, slug, reference number, category, body, attachment (pdf/docx/xlsx/jpg/png, max 8MB), thumbnail, published_at, expires_at, pinned, urgent, draft/published/archived. SEO-friendly `/notice/{slug}`.
- **Downloads:** category (Forms/Routine/Results/Calendar/Curriculum/Reports/Charter/Policies/Procurement/Publications/Scholarships/Other), file, size, date. Allowlist validation.
- **Results:** create exam (type/year/class) → import CSV (symbol_no, name, grade, gpa) → publish/unpublish. Search returns only matching row; no bulk exposure.
- **Gallery:** Albums (Campus/Classroom/Academic/Sports/Cultural/Celebrations/Community/Other) → multiple upload → reorder → cover → bilingual captions → publish. Lazy loading + lightbox.
- **People:** Leadership / Teachers / Staff / Management Committee — photo, name_en/np, designation, qualification, phone/email with public toggle, display order.
- **Citizen Charter:** HTML table + downloadable PDF, last updated date.
- **Languages:** नेपाली | EN toggle persists via cookie. Enter both versions manually; no auto-translation.

Empty states: "No notices in this category", "Academic calendar will be published soon" — never broken cards.
