# cPanel Deployment — Shree Public Secondary School

1. **Database:** cPanel → MySQL Databases → create `sps_malangwa` + user, import `database.sql` via phpMyAdmin.
2. **Files:** File Manager or FTP → `public_html` (or `public_html/shreepublic`). Upload zip, extract. Move `.env` one level above `public_html` and update path in `config/config.php` if needed.
3. **Domain:** Set `APP_URL=https://shreepublic.edu.np` in `.env`. Uncomment HTTPS redirect in `.htaccess` after SSL.
4. **Permissions:** `uploads/` 755/775 so PHP can write PDFs/images. Denied executables already in `.htaccess`.
5. **PHP:** Select PHP 8.2+ in cPanel → Select PHP Version. Enable `pdo_mysql`, `mbstring`, `gd`.
6. **Cron (optional):** Backup DB daily: `mysqldump -u USER -p'PASS' DB | gzip > ~/backups/sps_$(date +\%F).sql.gz`
7. **Test:** Homepage notice bar, Quick Actions (6), stats, search, language toggle, result symbol `12345`, contact form rate limit, map directions.
