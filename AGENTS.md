# AGENTS.md

Guidance for AI agents in this repo — live at `https://demo.isoftro.com` (IEMIS 190640003).

## Deploy

### Production — cPanel shared hosting (authoritative)

- Host: cPanel shared hosting, domain `shreepublic.edu.np` (`APP_URL` in `.env`). Repo `https://github.com/devbaratnp/sps_school.git` (migrated from `npg675/Public-School-Malangwa`), production branch `main`.
- Pipeline: `GitHub push → webhook → https://shreepublic.edu.np/webhook.php → ~/repositories/sps_school/ (git pull) → cp to ~/public_html/` (no SSH port / GH Actions runner). No rebuild. Files in repo: `deploy.sh`, `webhook.php`, `.cpanel.yml`.
- Web server routing: single `posts` table (`post_type` news|event) via `news-events.php`; `nginx` on demo routed `/news|/events|/event` there — on cPanel `.htaccess` still has stale `news.php`/`events.php`/`results.php` rewrites, do not trust (see Gotchas).

### How to deploy to cPanel

1. **One-time — cPanel SSH Access:** generate `~/.ssh/github_repo` (or reuse), add to GitHub `Settings → Deploy keys` (`gh repo deploy-key add ~/.ssh/github_repo.pub --title "cPanel Deploy" -R devbaratnp/sps_school`).
2. **One-time — clone:** `cd ~/repositories && GIT_SSH_COMMAND="ssh -i ~/.ssh/github_repo -o StrictHostKeyChecking=no" git clone git@github.com:devbaratnp/sps_school.git`
3. **One-time — secret:** edit `~/repositories/sps_school/webhook.php` (or `~/public_html/webhook.php`) and set `$secret`; create GitHub webhook `Settings → Webhooks → https://shreepublic.edu.np/webhook.php` (push, `application/json`, same secret) or `gh api repos/devbaratnp/sps_school/hooks -f name=web -f active=true -f events[]=push -f config[url]="https://shreepublic.edu.np/webhook.php" -f config[content_type]=json -f config[secret]="..."`.
4. **Each push:** `git push origin main` (or `feat/cms-content-blocks` if `BRANCH` changed). GitHub POSTs to `webhook.php`; script does `export HOME=/home/USERNAME && cd ~/repositories/sps_school && bash deploy.sh` (`HOME` must be exported — PHP `shell_exec` has none). Manual fallback: SSH and `bash ~/repositories/sps_school/deploy.sh`.
5. **Verify:** in cPanel File Manager check `public_html/.env` still `644` and not overwritten, `uploads/` `775`, then `curl -k https://shreepublic.edu.np/` and `?lang=en`/`?lang=np`.

### Demo — Docker at demo.isoftro.com (still live, legacy for staging)

- Docker Compose at `/opt/public-school-deploy/` (not in git): bind-mount `./code` into `public-school-php` (PHP 8.4) + `public-school-web` + `public-school-mysql` (`sps_malangwa`), Traefik at `demo.isoftro.com` (`srv1184665`). Same steps as above but `cd /opt/public-school-deploy/code && git fetch origin && git diff --stat origin/... && git merge --ff-only origin/...`; perms `chmod 644 code/.env` + `chmod -R 777 uploads/<subdir> && chown -R www-data:www-data` inside container; `docker exec public-school-php php -l /var/www/html/<file>`; retry once on Traefik `000`.

## Stack

- PHP 8.2+ (live 8.4), MySQL 8 `utf8mb4_unicode_ci` (required for Devanagari), vanilla JS, no Composer/npm/build step. No `composer.json`/`package.json`/`opencode.json`.
- Default admin `admin@shreepublic.edu.np` / `Admin@123`.
- Entrypoints: `index.php`, `about.php`, `notices.php`/`notice.php`, `news-events.php`, `downloads.php`, `gallery.php`, plus `admin/*.php`. Shared wiring: `config/config.php` (constants, `.env` loader, `base_url()`/`asset()`, `DEFAULT_LANG='np'`), `config/database.php` (`db()` with `DB_DISABLED=1` demo fallback, `PDO::ATTR_TIMEOUT=>3`), `includes/helpers.php` (CSRF, `e()`/`e_attr()`, i18n `t()`/`ta()`, `setting()`/`all_settings()`, `get_blocks()`, `rate_limit()`, RBAC `can()`).
- Tokens in `assets/css/style.css` (`:root --primary:#001e40`, etc.) and `includes/tailwind_head.php` (CDN Tailwind for Stitch pages); admin shell in `admin/includes/admin_header.php` (Tailwind CDN + Material Symbols, `#092A4D`/`#123B6D`).

## Commands

- Always syntax-check touched PHP: `docker exec public-school-php php -l /var/www/html/<file>` or locally `php -l D:\www\sps\<file>`.
- Manual helpers (gitignored in `tests/`): `php tests/staff-helpers-test.php`, `php tests/staff-image-responsive-test.php`, `powershell -File tests/mobile-layout.ps1`.
- No lint/typecheck/test framework. No `npm`/`composer` scripts. `DB_DISABLED=1` runs without DB (sample notices/downloads + `includes/content-seeds.php` fallback).

## Architecture

- **DB** (`database.sql` is source of truth schema, not seed): `notices`+`notice_categories`, `posts`+`news_categories`, `downloads`+`download_categories`, `gallery_albums`/`gallery_images`, `staff`/`staff_categories`, `content_blocks` (`page_slug`, `section_key`, `sort_order`, bilingual `title/subtitle/body`, `image_url`, `icon`, `link_url`, `is_active`), `pages` (long prose), `site_settings` (`key`/`value`), `users`, `activity_logs`. Collation `utf8mb4_unicode_ci`.
- **CMS split**: `pages` holds long-form prose (admissions, academics, science, management…); `content_blocks` holds cards/tiles/hero/stats/timeline/FAQ/links. `includes/content-seeds.php` (`cms_seed_blocks()`) mirrors DB seeds for demo/empty-DB fallback. `includes/header.php` reads `site_settings` for logo/address/phone/IEMIS via `setting()`.
- **Uploads** (gitignored): `uploads/` + `uploads/staff/` + `uploads/blocks/` + `uploads/gallery/`. Helpers `media_url()`/`stored_file_url()`/`staff_photo_url()` normalize to `uploads/...`. `admin/upload.php` validates MIME allowlist (`jpg/png/webp/pdf/docx/xlsx`), `max 8MB`, `subdir` regex `^[A-Za-z0-9_-]+`, random hex name, `0777` mkdir, `0644` file.
- **i18n**: every content column has `_en`/`_np`. Public lang cookie `site_lang`, admin separate `admin_lang` cookie; helpers `current_lang()`/`admin_lang()` default `np`. Never auto-translate; use `t()`/`ta()` and `block_val()`/`page_val()` helpers.

## Admin pattern

- Shell: `admin/includes/admin_header.php` + `admin_footer.php`. Each entity: list page + `-form.php` (e.g. `notices.php`/`notice-form.php`, `posts.php`/`post-form.php`, `staff.php`/`staff-form.php`, `blocks.php`/`block-form.php`). All POSTs use `csrf_field()`/`csrf_verify()`.
- RBAC in `includes/helpers.php:486`: `super_admin` [content,staff,gallery,system,users], `school_admin` [content,staff,gallery,system], `editor` [content,staff,gallery], `exam_officer` [content]. Gate with `can()`/`require_permission()`.
- **Content Blocks** (`admin/blocks.php`): filter by `page_slug` in `['home','about','academics','admissions','faq','links','publications','management','science']`, grouped by `section_key`/`sort_order`. Sections: `home: hero(1), stat(4), intro(1), commitment(4), cta_banner(1)`; `about: page_header(1), intro(2), value(3), timeline(4), facility(4), cta_join(1)`; `science`/`management: intro+highlight(4)`; `faq: faq_item(9)` as `<details>`; `links: link(8)`. Requires `title_en` or `title_np`. Staff photo editor: 600×600 canvas, JPEG 0.9, subdir `staff`, drag/zoom.

## Git

- Current branch `feat/cms-content-blocks` tracks `origin/feat/cms-content-blocks` (`origin/HEAD -> origin/main`). Also `main` exists. Use small conventional commits (`feat:`, `fix:`).
- `git push` fails on this host (`fatal: could not read Username`, no credentials) — pushes happen elsewhere. Do not attempt.
- Working tree always has untracked `uploads/*` + `.audit/` and sometimes `admin/upload.php` 0777 fix. Never `git clean` (deletes live uploads). Incoming changes only touch `*.php`/`css`/`js`/config, so fast-forward is safe, but verify `git diff --stat origin/...` first.

## Gotchas — hard-earned, will bite you

- **`database.sql` DO NOT re-import**: seed rows contain garbled Devanagari and unsupported `NULL`-in-derived-table/`INTERSECT` syntax that fails on MySQL 8. Live DB is source of truth. Seed new data with `INSERT IGNORE ... SELECT` (as `posts` was seeded from `news`+`events`), not the dump's `INSERT` rows.
- **`.env` permissions**: `/opt/public-school-deploy/.env` is `600 root` → PHP-FPM `www-data` cannot read; cPanel `~/public_html/.env` must stay `644` and never be overwritten by `deploy.sh`. On edit, keep a readable copy or site breaks.
- **Uploads owner**: PHP-FPM runs as `www-data` uid 33 (Docker) / `nobody` on cPanel, not root. `is_writable()` from CLI lies. On `move_uploaded_file(): Unable to move` / `Failed to save file`, run `chmod -R 777 uploads/<subdir>` + `chown -R www-data:www-data uploads/<subdir>` inside `public-school-php` (or `chmod -R 775 uploads/` on cPanel).
- **`get_blocks()` (`includes/helpers.php:263`) must return `[]` not `false` even when `$section===null` or no rows, else frontend CMS edits silently vanish.
- **`rate_limit()` (`includes/helpers.php:445`)** uses `RATE_LIMIT_DIR` (default `sys_get_temp_dir()/sps-rate-limit`) + `LOCK_EX` on `sps_rate_<sha256>.json`. Guard `stream_get_contents` returning `false` before `json_decode` (PHP 8 TypeError otherwise).
- **Legacy `*.html`** (`about.html`, `index.html`, etc.) are stale design refs — never edit. Results module removed (`adc441e`), `/results` 404s. News/events unified to `news-events.php`.
- **Staff visibility**: `get_staff_directory()` groups by `staff_categories.slug` but falls back — `administration` with `designation_en` matching `/committee|smc|chairperson|chairman|member/` → `committee`. Hide records where `name_en`/`name_np` empty or `—`/`-`. Only `is_active=1` shown; order by `c.sort_order, display_order, name_en`.
- **Downloads filtering**: `get_downloads()` drops rows where local `file_path` missing on disk (unless `https://`), so broken uploads show empty state not 404.
- **First-request `000` timeout**: Traefik occasionally times out first request after a change — retry once before debugging; app responds <200ms on retry.

## Verification

- No test/lint config. For each touched PHP: `php -l` (or `docker exec public-school-php php -l /var/www/html/<file>`).
- Hit the page over HTTPS (`https://demo.isoftro.com/...`) and retry once on `000`. Check both `?lang=en` and `?lang=np` variants and the corresponding admin form still saves.
- `docs/` (`ADMIN.md`, `SECURITY.md`, `BACKUP.md`, `TEST_REPORT.md`) is cPanel-oriented — prefer this file + executable config on live.

