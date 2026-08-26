# cPanel Deployment — Shree Public Secondary School

1. **Database:** cPanel → MySQL Databases → create `sps_malangwa` + user, import `database.sql` via phpMyAdmin.
2. **Files:** File Manager or FTP → `public_html` (or `public_html/shreepublic`). Upload zip, extract. Move `.env` one level above `public_html` and update path in `config/config.php` if needed.
3. **Domain:** Set `APP_URL=https://shreepublic.edu.np` in `.env`. Uncomment HTTPS redirect in `.htaccess` after SSL.
4. **Permissions:** `uploads/` 755/775 so PHP can write PDFs/images. Denied executables already in `.htaccess`. Set `RATE_LIMIT_DIR` to a private writable directory outside `public_html` when the host supports it, with permissions limited to the PHP user.
5. **PHP:** Select PHP 8.2+ in cPanel → Select PHP Version. Enable `pdo_mysql`, `mbstring`, `fileinfo`, and `gd`.
6. **PHP-FPM:** In cPanel → MultiPHP Manager, enable PHP-FPM for the domain if available. The repository includes `.user.ini` for application limits such as `max_execution_time=60`, `max_input_time=60`, `memory_limit=128M`, `max_input_vars=2000`, and `max_file_uploads=20`; allow a few minutes for PHP-FPM to reload it. The FPM pool settings (`pm.max_children`, `pm.max_requests`, and process limits) are host-level settings; ask the hosting provider to tune them for the account's RAM and inspect the PHP-FPM error log for worker exhaustion. Do not add `php_value` or `pm.*` directives to application `.htaccess` or PHP files.
7. **Admin password:** Sign in with the database account created by `database.sql`, then open Admin → Change Password. Do not keep the seed password in production. If demo mode is required, set both `DEMO_ADMIN_EMAIL` and a bcrypt `DEMO_ADMIN_PASSWORD_HASH`; the application does not ship with a hardcoded demo password.
8. **Cron (optional):** Backup DB daily: `mysqldump -u USER -p'PASS' DB | gzip > ~/backups/sps_$(date +\%F).sql.gz`
9. **Test:** Homepage notice bar, Quick Actions (6), stats, search, language toggle, result symbol `12345`, contact form rate limit, map directions, admin login, password change, and an 8MB upload boundary.
