# AGENTS.md

Guidance for AI coding agents working in this repository.

## Project overview

Public website + CMS for **Shree Public Secondary School**, Malangwa-2, Sarlahi, Madhesh Province, Nepal (IEMIS 190640003). Bilingual (Nepali + English). Built for cPanel shared hosting — no build step, no Composer/npm dependencies.

**Stack:** PHP 8.2+ (runs locally on PHP 8.4), MySQL 8 / MariaDB (`utf8mb4_unicode_ci` — required for Devanagari), vanilla JS, semantic HTML.

## Setup

1. Create a database, then import `database.sql` (full schema + seed data; safe to re-run).
   - `database-seed-pages.sql` is an optional extra seed for static pages.
2. Copy `.env.example` → `.env` and fill DB credentials.
   - Set `DB_DISABLED=1` for demo mode without a database (sample data).
3. Default admin login: `admin@shreepublic.edu.np` / `Admin@123` (change immediately).
4. `uploads/` must be writable.

## Structure

```
config/        config.php (app bootstrap), database.php (PDO singleton)
includes/      helpers.php (escaping, CSRF, auth, i18n), header.php, footer.php
admin/         CMS panel: login.php, index.php, CRUD modules per entity,
               admin/includes/ (header/footer/helpers/tailwind_head)
assets/        css/style.css (design tokens), js/main.js, img/
uploads/       user uploads — blocked executables, randomized names; do NOT commit new binaries
docs/          INSTALL.md, CPANEL.md, ADMIN.md, SECURITY.md, BACKUP.md
database.sql   normalized schema + seeds (18 tables)
*.php pages    public pages: index, about, academics, admissions, notices, notice,
               news, events, results, downloads, publications, gallery, contact,
               search, faq, citizen-charter, scholarships, academic-calendar, links...
```

## Conventions

- **Canonical pages are `*.php`.** The legacy `*.html` files (about.html, index.html, etc.) are outdated design references — never edit them; they will be deleted eventually.
- **Bilingual content:** every content field has `_en` and `_np` suffixes (e.g., `title_en` / `title_np`). Never auto-translate; both versions are entered manually. Language toggle persists via cookie (`?lang=np|en`).
- **Escaping:** always output via helpers from `includes/helpers.php` (`e()` or equivalent). Use PDO prepared statements only — no string-concatenated SQL.
- **Security:** password_hash, CSRF tokens on all forms, secure session cookies, RBAC roles (`super_admin`, `school_admin`, `editor`, `exam_officer`), upload allowlist (pdf/docx/xlsx/jpg/png, max 8MB) with MIME validation. Audit-log sensitive actions to `activity_logs`.
- **Admin panel:** plain-PHP CRUD modules following the existing pattern in `admin/*.php` (list page + `-form.php` per entity, using `admin/includes/header.php` / `footer.php`). Admin UI uses Tailwind via CDN (`tailwind_head.php`) + Material Symbols icons.
- **Design:** Deep Institutional Blue `#123B6D`, Government Red `#C1272D`, Gold `#D29A32`, background `#F7F9FC`. Fonts: Inter + Noto Sans Devanagari. Target WCAG 2.2 AA. Mobile-first; works on cheap Android + slow connections.
- **CMS-driven content:** all user-visible page content should come from the database (`pages` table for static page bodies, `site_settings` key/value for global strings like phone/email/principal message). No hardcoded copy in templates where an admin-editable value exists. Empty states show friendly placeholder text ("will be published soon") — never broken cards.
- **No comments unless asked; no emojis unless asked.**

## Verification

There is no test framework or lint config. Verify changes with:

```
php -l <file>                 # syntax check every touched PHP file
php -S localhost:8000         # run site from project root; click through affected pages
```

Check both EN and NP language variants of any page you change, and confirm the corresponding admin module still saves correctly.

## Git

Small focused commits, conventional style used historically: `feat: ...`, `fix: ...`, or short imperative summaries. Do not commit secrets (`.env` is gitignored) or large binary uploads.
