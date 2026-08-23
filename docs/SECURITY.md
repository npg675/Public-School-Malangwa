# Security Checklist — Shree Public Secondary School

- [ ] Default admin password changed, strong passwords enforced
- [ ] `.env` not in git, permissions 600, outside `public_html` if possible
- [ ] `password_hash` / `password_verify` only (no plain text)
- [ ] All queries via PDO prepared statements
- [ ] CSRF token on every POST (`csrf_field()` / `csrf_verify()`)
- [ ] `htmlspecialchars` on all output (`e()`)
- [ ] Secure session cookies (`httponly`, `samesite`), `session_regenerate_id` on login
- [ ] Rate limiting: login 5/5min, forms 3–5/5min
- [ ] RBAC enforced per route (super_admin / school_admin / editor / exam_officer)
- [ ] Uploads: allowlist pdf/docx/xlsx/jpg/png, MIME check, `finfo`, randomized names, 8MB limit, executables blocked in `uploads/.htaccess`
- [ ] Security headers: X-Frame-Options SAMEORIGIN, X-Content-Type-Options nosniff, Referrer-Policy, Permissions-Policy
- [ ] Production error handling — no SQL errors exposed; 404/500 pages
- [ ] Activity logs for notice/result/user changes
- [ ] Backups daily (see BACKUP.md)

Test: try SQL injection (`' OR 1=1`), XSS (`<script>`), CSRF without token, oversized upload, executable rename.
