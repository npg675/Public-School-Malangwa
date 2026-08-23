# Shree Public Secondary School — Malangwa-2, Sarlahi

**श्री पब्लिक माध्यमिक विद्यालय** · Malangwa Municipality-2, Sarlahi, Madhesh Province, Nepal · IEMIS **190640003**

Production-ready public information portal — Digital School Office + Public Information Portal + Institutional Website. Built per Master Build Prompt v2026 (trust, accountability, accessibility, bilingual, mobile-first).

- **Stack:** PHP 8.2+ (clean MVC-lite), MySQL 8 / MariaDB, vanilla JS, semantic HTML, maintainable tokens — cPanel-friendly, no heavy framework.
- **Design:** Modern Nepal Public Institution — Deep Institutional Blue `#123B6D`, Government Red `#C1272D`, Gold `#D29A32`, background `#F7F9FC`. Inter + Noto Sans Devanagari. WCAG 2.2 AA.
- **Languages:** नेपाली | EN with cookie persistence, `title_en/title_np` fields, no auto machine translation.
- **Homepage order:** Utility header → Main header → Notice bar → Hero → 6 Quick Actions → At-a-Glance → About → Principal → Learning Pathways (4) → Notice Centre (2/3 + 1/3) → News & Events → Commitment → Gallery → Downloads → Govt Links → Contact & Map → Footer (4-col).

## Quick start
1. Import `database.sql` (utf8mb4). Creates 18 tables with indexes & seed.
2. Copy `.env.example` to `.env` and fill DB + mail. Or set `DB_DISABLED=1` for demo mode (sample notices/downloads).
3. Upload to cPanel `public_html`. Ensure `uploads/` writable, `.htaccess` active.
4. Default admin: `admin@shreepublic.edu.np` / `Admin@123` — change immediately (password_hash).
5. Replace placeholders: logo, phone/email/hours, principal, labs/library/sports, SMC, history, 10–20 original photos.

## Structure
```
config/        config.php, database.php
includes/      helpers.php, header.php, footer.php
admin/         login.php, index.php, logout.php (+ CMS stubs)
assets/css/    style.css (tokens)
assets/js/     main.js
uploads/       attachments (blocked executables, randomized names)
database.sql   normalized schema
.env.example   secure config template
.htaccess      clean URLs, security headers, caching, error pages
sitemap.php    dynamic sitemap.xml
robots.txt     Sitemap + disallow admin/uploads
404.php, 500.php
index.php + about.php, academics.php, admissions.php, notices.php, notice.php, news.php, events.php, results.php, downloads.php, publications.php, citizen-charter.php, scholarships.php, gallery.php, contact.php, search.php, academic-calendar.php, links.php
```

## Security
password_hash, PDO prepared statements, CSRF tokens, XSS escaping, secure session cookies + regeneration, brute-force/rate limiting (login, forms), RBAC (super_admin / school_admin / editor / exam_officer), upload allowlist + MIME validation + randomized names + size limits, credentials outside web root (`.env`), production error handling, audit logs, security headers (SAMEORIGIN, nosniff, referrer, permissions).

## Docs
- `docs/INSTALL.md` — installation
- `docs/CPANEL.md` — cPanel deployment
- `docs/ADMIN.md` — content management
- `docs/SECURITY.md` — checklist
- `docs/BACKUP.md` — backup

## Quality bar
Parent finds today's notice in 5s (Quick Actions + Notice bar + 6-card panel). Works on cheap Android, mobile data, slow connections. No invented data — every unverified field is a clearly labelled CMS placeholder.

## License
For Shree Public Secondary School, Malangwa-2. Replace `APP_URL` in `.env` before launch.
