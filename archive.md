# Archive — deprecated / removed features

This file documents features that were removed from the active site. Anything here may exist in
older commits (see `git log`) or in the database schema, but it is no longer part of the live
public site, the admin panel, or the user-facing navigation. Keep this file when you want context
about why something is gone and how it was replaced.

---

## Removed: Online "Results" module (admin import + public result search)

**Status:** Removed from code and navigation.

### What was removed

The results flow let staff import examination results (SEE, NEB, Internal) by pasting or
dragging a CSV/XLSX file, manage "exams", mark them published/unpublished, and let visitors
search a single result by symbol / roll number.

Files that no longer exist (deleted):

- `admin/results.php` — admin CRUD / CSV-XLSX import UI for exams and student results.
- `results.php` — public "Results Centre" with symbol / roll-number search.
- `result.php` — legacy public single-result view (if it existed).

Navigation and cross-links removed:

- `includes/header.php` — desktop nav item, Academics dropdown link, mobile-menu link, and
  Academics dropdown active-state reference.
- `includes/footer.php` — Academic column link and mobile quick-bar link.
- `admin/includes/admin_header.php` — "Results" sidebar link.
- `sitemap.php` — `results.php` entry in the `$pages` array.
- `search.php` — Results page entry in the search index and the "Results" popular link.
- `academics.php` — "Results" related-section button.
- `academic-calendar.php`, `notices.php` — "Results" buttons.
- `contact.php` — the hardcoded FAQ item "Are examination results available online?" was
  reworded to point to Notice Board + Downloads instead of the removed results page.
- `includes/content-seeds.php` — the FAQ item seed body was updated to remove the `/results.php`
  link (applies to fresh database imports).

### Why it was removed

- The site flagged a preference to retire the per-student result search and import flow.
- Result documents are now published as normal Downloads (the `results` category in
  `downloads.php`) and result announcements go through the Notice Board — no dedicated result
  database or search widget is maintained.

### Database tables (retained but now unused by the codebase)

The schema in `database.sql` still defines the following tables for the module. They are **not**
queried or written by any current code. They were kept so no real imported result data is
destroyed; drop them if you are certain the data is no longer needed:

- `exam_types` — SEE / Grade 12 (NEB) / Internal labels.
- `exams` — an examination instance (`exam_type_id`, `academic_year`, `class_name`, `title_en`).
- `student_results` — per-student rows (`exam_id`, `symbol_no`, `student_name`, `grade`, `gpa`,
  `result_status`); cascades on exam delete.

Optional clean-up SQL if you want to remove them for good:

```sql
DROP TABLE IF EXISTS student_results;
DROP TABLE IF EXISTS exams;
DROP TABLE IF EXISTS exam_types;
```

### How results are handled now

- Publish result PDFs / lists under **Downloads → Results** (`downloads.php`, category `results`).
- Make result announcements through the Notice Board (`notices.php`, category `results`).
- Board results (Grade 12 / SEE) remain verifiable directly at `https://neb.gov.np`.
