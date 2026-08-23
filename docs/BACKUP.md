# Backup — Shree Public Secondary School

- **DB daily:** `mysqldump -u USER -p'PASS' sps_malangwa | gzip > ~/backups/sps_$(date +%F).sql.gz` — keep 30 days, copy off-site weekly.
- **Files weekly:** zip `public_html` + `uploads/` → `~/backups/files_$(date +%F).zip`.
- **Restore:** import latest `.sql.gz` via phpMyAdmin or `gunzip < file.sql.gz | mysql -u USER -p DB`. Re-upload files.
- **Before upgrades:** snapshot DB + files, test restore on staging.
