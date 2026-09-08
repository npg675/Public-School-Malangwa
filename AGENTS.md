# AGENTS.md

Guidance for AI coding agents working in this repository (source of `https://demo.isoftro.com`).

## Context: this is a Docker deploy, not cPanel

Despite the README's cPanel language, this repo is deployed on this server as a **Docker Compose stack** at `/opt/public-school-deploy/`:

- `docker-compose.yml` + `nginx.conf` + `php/Dockerfile`/`fpm-custom.conf` live in `/opt/public-school-deploy/` (NOT in git).
- `./code` (this repo) is bind-mounted into `public-school-php` (writable) and `public-school-web` (read-only). **PHP/nginx changes take effect immediately on file save — no rebuild/restart needed.**
- Served at `demo.isoftro.com` via Traefik (Coolify). Public IP `72.61.237.41`, hostname `srv1184665`.
- Containers: `public-school-php`, `public-school-web`, `public-school-mysql`. DB `sps_malangwa`, root pw in `/opt/public-school-deploy/.env`.

To run repo-local tooling: `docker exec public-school-php php -l /var/www/html/<file>` (syntax check) or `docker exec public-school-php php ...` to execute against the live DB.

## Project overview

Public website + CMS for **Shree Public Secondary School**, Malangwa-2, Sarlahi, Madhesh Province, Nepal (IEMIS 190640003). Bilingual (Nepali + English). No build step, no Composer/npm dependencies. PHP 8.2+ (live: 8.4), MySQL 8 (`utf8mb4_unicode_ci` — required for Devanagari), vanilla JS.

**Default admin login:** `admin@shreepublic.edu.np` / `Admin@123`.

## Setup (local/from scratch — for reference only)

1. Import `database.sql` (full schema; see **database.sql warning** below).
2. Copy `.env.example` → `.env`, fill DB credentials. `DB_DISABLED=1` = demo mode without DB.
3. `uploads/` must be writable.

## database.sql is NOT safe to import as-is — DO NOT re-import

- Multiple seed rows contain **garbled/mojibake Devanagari** (news/events/downloads/posts) — importing corrupts Nepali text.
- Content blocks use unsupported MySQL 8 `NULL`-in-derived-table constructs (43 `INTERSECT`/derived-table errors) unless converted to `INSERT IGNORE ... VALUES`.
- The live site's DB is the source of truth. To move data into the live DB, use `INSERT IGNORE ... SELECT` from old tables (this is how `posts` was seeded from `news`+`events`), **not** the seed rows.

## Removed/renamed modules (stale doc claims)

- `news.php`, `events.php` → **unified `news-events.php`** (driven by `posts` table). nginx routes `/news`, `/events`, `/event` → `news-events.php`.
- `results.php` + `admin/results.php` + results module were **removed** (commit adc441e); `/results` now 404s. There is no results admin anymore.
- Legacy `*.html` files (`about.html`, `index.html`, etc.) are stale design references — never edit them.

## Git workflow (critical)

- Local working branch is `main`. Upstream development/push target is **`origin/feat/cms-content-blocks`**. After upstream pushes, sync with:
  `git fetch origin && git merge --ff-only origin/feat/cms-content-blocks` (fast-forward; local `main` is always a direct ancestor of the pushed branch).
- **`git push` to GitHub fails** — no credentials configured on this host (`fatal: could not read Username`). Pushes are done from elsewhere. Don't attempt/promise pushes.
- The working tree almost always has **intentional uncommitted changes**: `admin/upload.php` (mkdir 0777 fix), and `uploads/*` binaries (photos, teacher images) which are gitignored/untracked. Before any `git pull`/merge, verify the incoming commits don't touch these files (they don't — only `*.php`/css/js/config), then fast-forward; the untracked files survive untouched. Never `git clean` — it would delete live uploads.
- Small focused commits, conventional style (`feat:`, `fix:`, ...). Do not commit secrets or large binaries.

## Operational gotchas (learned the hard way)

- **`.env` permissions:** the live `/opt/public-school-deploy/.env` is `600 root`; PHP-FPM (www-data) cannot read it → site breaks. The repo copy `code/.env` MUST stay `644` and readable. If you edit `.env`, preserve a readable copy.
- **Timeouts/intermittent `000`:** first request after a change occasionally times out at the Traefik proxy — always retry before diagnosing; the app itself is fine (200 in <200ms on retry, no hung MySQL queries).
- **`get_blocks()`** (`includes/helpers.php`) must return `$rows ?: []` even when `$section === null`, or admin CMS edits won't propagate to the frontend.
- **`rate_limit()`** does `json_decode(file_get_contents())` — must check the read returned `!== false` before decoding, to avoid a PHP 8 TypeError.
- **`admin/upload.php`** uses `mkdir(..., 0777, ...)` (0755 breaks web write) and `uploads/` needs `chmod -R 777` for PHP-FPM writes. **PHP-FPM workers run as uid 33 (www-data), NOT root** — even though `docker exec php ...` and CLI run as root. If uploads fail with "Failed to save file" / `move_uploaded_file(): Unable to move`, the target dir (`uploads/staff/`, `uploads/`, etc.) is likely not writable by www-data: apply `chmod -R 777 <dir>` + `chown -R www-data:www-data <dir>`. `is_writable()` from CLI will lie (root); test as www-data or check the actual dir mode.
- **Staff photos** live in `uploads/staff/` (untracked). Staff records are in the `staff` table, `category_id`: 1=leadership, 2=administration, 3=teaching, 4=non_teaching, 5=committee. Photo path stored relative e.g. `uploads/staff/m1.jpg`.
- **Pexels API key** for generating placeholder images is maintained in this session's context; fetch portrait URLs, download to `uploads/staff/`, `chmod -R 777` + `chown www-data`.

## Conventions

- **Bilingual:** every content field has `_en`/`_np` suffixes (`title_en`/`title_np`). Never auto-translate; enter both manually. Language persists via cookie/`?lang=np|en`; default is now Nepali.
- **Escaping/security:** output via helpers (`e()`/`e_attr()`); PDO prepared statements only (no string-concatenated SQL); password_hash, CSRF on all forms, RBAC roles (`super_admin`, `school_admin`, `editor`, `exam_officer`), upload allowlist with MIME validation.
- **Admin panel:** plain-PHP CRUD modules following the existing pattern: list page + `-form.php` per entity in `admin/`, using `admin/includes/header.php`/`footer.php`. Tailwind via CDN + Material Symbols icons.
- **CMS-driven content:** page content from DB (`pages`, `site_settings`, `content_blocks`). No hardcoded copy where an admin-editable value exists. Empty states show friendly placeholders, never broken cards.
- **Design:** Deep Institutional Blue `#123B6D`, Government Red `#C1272D`, Gold `#D29A32`, bg `#F7F9FC`. Inter + Noto Sans Devanagari. WCAG 2.2 AA. Mobile-first.
- **No comments unless asked; no emojis unless asked.**

## Verification

No test framework or lint config. Verify with:
- `docker exec public-school-php php -l /var/www/html/<file>` on every touched PHP file.
- Check the affected page over HTTPS (`https://demo.isoftro.com/...`) — and its admin form still saves.
- Check **both** EN and NP variants of any page you change.

See `docs/` for ADMIN, INSTALL, CPANEL, SECURITY, BACKUP (mostly cPanel-oriented; for this live host trust the Docker context above over CPANEL.md).
