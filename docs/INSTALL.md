# Installation — Shree Public Secondary School

1. **Requirements:** PHP 8.2+, MySQL 8 / MariaDB, Apache (mod_rewrite, mod_headers, mod_expires, mod_deflate). Extensions: pdo_mysql, mbstring, gd/fileinfo.
2. Import `database.sql` via phpMyAdmin or `mysql -u user -p db < database.sql`. Seed roles, categories, settings, default admin.
3. `cp .env.example .env` — set `APP_URL`, DB credentials, mail. `DB_DISABLED=1` runs demo without DB.
4. Upload all files to hosting. `chmod 755` directories, `chmod 644` files. Make `uploads/` writable (`755` or `775`). Keep `.env` outside `public_html` if possible or deny via `.htaccess` (already).
5. Visit `/admin/login.php` — sign in `admin@shreepublic.edu.np` / `Admin@123`, change password, add school admin/editor users.
6. Replace placeholders: logo (`assets/img/logo.png`), phone/email/hours (Admin → Website → Settings), principal (People → Leadership), labs/library/sports toggles, 10–20 original photos (Media → Gallery).
7. Test: notices, downloads, result search (symbol `12345` demo), contact form, language toggle (नेपाली | EN), map `26.8501032,85.555064`, 404/500, sitemap, robots.

