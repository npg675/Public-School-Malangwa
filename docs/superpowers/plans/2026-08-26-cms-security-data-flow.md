# CMS and security data-flow repair implementation plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Make CMS edits persist predictably from admin forms to the database and public pages, while fixing the confirmed login, rate-limit, upload, and shared-settings failures.

**Architecture:** Keep the existing plain PHP/PDO architecture. Use `site_settings` as the single source for shared school identity/contact data, `content_blocks` for homepage/about sections, and the existing entity tables for notices, news, events, staff, and gallery. Add one safe re-runnable migration for the live schema and keep demo fallbacks only for unavailable databases, never for an empty live table.

**Tech Stack:** PHP 8.2+, PDO MySQL/MariaDB, MySQL `utf8mb4`, vanilla JavaScript, Apache/cPanel PHP-FPM.

---

### Task 1: Repair helper data flow and shared settings

**Files:**
- Modify: `includes/helpers.php`
- Modify: `includes/header.php`
- Modify: `includes/footer.php`
- Modify: `contact.php`
- Modify: `index.php`
- Modify: `about.php`

- [ ] Fix `get_blocks()` to return live rows, centralize settings access, and return empty arrays for empty live tables.
- [ ] Stop notices, events, downloads, and gallery helpers from replacing an empty live result with sample content.
- [ ] Add one safe media URL helper so stored `uploads/...` paths are not prefixed twice.
- [ ] Replace shared header/footer/contact constants with `setting()` values and use config constants only as unavailable-DB defaults.
- [ ] Lint all touched PHP files.

### Task 2: Repair CRUD field/schema mismatches

**Files:**
- Modify: `admin/notice-form.php`
- Modify: `admin/event-form.php`
- Modify: `admin/album-form.php`
- Modify: `admin/album-images.php`
- Modify: `admin/download-form.php`
- Modify: `admin/news-form.php`
- Modify: `admin/page-form.php`
- Modify: `admin/settings.php`

- [ ] Remove nonexistent notice summary columns from write queries and derive list summaries from description where needed.
- [ ] Validate allowed status values, dates, slugs, and required bilingual content server-side.
- [ ] Preserve existing images/paths when editing text without a new upload.
- [ ] Surface PDO failures as admin errors instead of silently swallowing them.
- [ ] Lint all touched PHP files.

### Task 3: Add the missing live CMS schema and upload safety

**Files:**
- Create: `database-migrations/2026-08-26-cms-security.sql`
- Modify: `database.sql`
- Modify: `admin/upload.php`
- Modify: `admin/includes/admin_footer.php`
- Modify: `.htaccess`

- [ ] Add a re-runnable `content_blocks` migration matching the current code and seed existing content blocks.
- [ ] Make upload subdirectories path-safe, enforce the project’s 8MB allowlist, and return clear JSON errors.
- [ ] Keep image edits from deleting the prior path and ensure stored paths match public URLs.
- [ ] Deny executable uploads and protect rate-limit storage.

### Task 4: Fix authentication, session handling, and rate limiting

**Files:**
- Modify: `config/config.php`
- Modify: `includes/helpers.php`
- Modify: `admin/login.php`
- Create: `admin/change-password.php`
- Modify: `admin/includes/admin_header.php`
- Modify: `.env.example`
- Modify: `docs/ADMIN.md`
- Modify: `docs/CPANEL.md`

- [ ] Configure the named session before `session_start()` with secure cookie flags and a bounded lifetime.
- [ ] Replace the race-prone unlocked JSON rate limiter with a locked, shared-file implementation and retry metadata.
- [ ] Remove the hardcoded demo password from the login screen and fail closed when the database is unavailable unless explicit demo credentials are configured.
- [ ] Enforce server-side password policy, allow a logged-in admin to change their own password, and prevent disabling/deleting the last active super admin.
- [ ] Document the PHP-FPM boundary: pool worker limits are cPanel/server settings, while this app provides bounded DB/file work and useful error logging.

### Task 5: Verify the complete flows

**Files:**
- Modify: `docs/TEST_REPORT.md`

- [ ] Run PHP syntax checks over all touched files.
- [ ] Import/apply the migration and verify the live table/row counts.
- [ ] Test login, failed-login throttling, password change, settings-to-header/footer/contact, homepage/about blocks, notice CRUD, staff CRUD, gallery upload/edit, and EN/NP rendering.
- [ ] Run the local PHP server and check for warnings, SQL errors, broken image paths, and mobile overflow.
- [ ] Record the final mapping and evidence in the implementation report.
