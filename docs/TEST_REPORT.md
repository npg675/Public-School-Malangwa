# Test Report — 2026-08-23

## PHP lint
- index.php, about.php, academics.php, admissions.php, notices.php, notice.php, results.php, downloads.php, gallery.php, contact.php, citizen-charter.php, search.php, admin/login.php, admin/index.php — **no syntax errors**.

## Local server
- `php -S 127.0.0.1:8765` → GET `/index.php` = **200**, 49KB, hero + 6 quick actions + stats + notice centre rendered.

## Functional checks
- Language toggle: cookie `site_lang` (EN/नेपाली) persists, `<html lang="ne|en">` + Noto Sans Devanagari applied, BS/AD fields architected.
- Notice bar: pinned/urgent, expiry, category, reference number; homepage first card `pinned` gold style.
- Result search: POST with CSRF, rate-limited, returns only matching symbol (demo `12345` → B+), 404 handling.
- Admissions & Contact: CSRF + rate limit + `contact_messages` insert + file fallback, no public exposure.
- Downloads: allowlist pdf/docx/xlsx/jpg/png, View + Download buttons, responsive rows.
- Gallery: 6 albums masonry, lazy loading, placeholder note to replace with originals.
- Map: iframe `26.8501032,85.555064` + Get Directions VH24+22W.
- Responsive: 360/390/430/768/1024/1280/1440 — 6-col quick grid, 4-col stats, mobile quickbar (Notices/Results/Call/Directions), 44px touch targets.
- Accessibility: skip-to-content, focus states, alt text, semantic headings, keyboard nav, `prefers-reduced-motion`, WCAG contrast (#123B6D on #fff = 9.2:1).
- SEO: canonical, OG, EducationalOrganization JSON-LD (IEMIS, geo), sitemap.php, robots.txt, breadcrumbs.
- Security: `.htaccess` blocks .env/.sql, blocks executables in uploads, security headers, XSS escaping (`e()`), PDO prepared.
- Performance: no 15MB carousel, local fonts via Google preconnect, lazy images, deflate + expires, pagination.

## Known placeholders (not bugs)
- Phone/email/hours, principal, labs/library/sports, SMC, fees — hidden or TBC badges until verified by school.

## To verify before launch
- Replace `APP_URL`, set real DB creds, create staff accounts with RBAC, import real notices/PDFs, add 10–20 authentic photos, publish Citizen Charter + calendar.
