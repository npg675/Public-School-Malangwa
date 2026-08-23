<?php require_once __DIR__.'/../includes/helpers.php'; require_login(); $role=current_user_role(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Dashboard — Shree Public Secondary School</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}body{font-family:Inter,system-ui,sans-serif;background:#F7F9FC;color:#172033;display:flex;min-height:100vh}
.sidebar{width:260px;background:#092A4D;color:#C7D7F0;padding:18px;flex:none;display:flex;flex-direction:column;gap:18px}
.sidebar h2{color:#fff;font-size:1rem;font-weight:800} .sidebar small{color:#93B4D8}
.nav{display:flex;flex-direction:column;gap:4px} .nav a{color:#C7D7F0;padding:10px 12px;border-radius:8px;font-weight:600;font-size:.88rem;display:flex;justify-content:space-between}
.nav a:hover,.nav a.active{background:rgba(255,255,255,.10);color:#fff}
.main{flex:1;padding:24px;overflow:auto}
.top{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:12px}
.cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px}
.card{background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:16px;box-shadow:0 4px 12px rgba(9,42,77,.06)}
.card .num{font-size:1.6rem;font-weight:800;color:#123B6D} .card .lbl{font-size:.78rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#667085}
.btn{padding:10px 14px;border-radius:8px;font-weight:700;font-size:.84rem;border:1px solid #E2E8F0;background:#fff;color:#123B6D;text-decoration:none;display:inline-flex;gap:6px;align-items:center}
.btn-primary{background:#123B6D;color:#fff;border-color:#123B6D} .btn-gold{background:#D29A32;color:#1F2540;border-color:#D29A32}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:16px}
.section{background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:16px}
.section h3{font-size:1rem;margin-bottom:10px}
@media(max-width:800px){.sidebar{width:100%;position:sticky} body{flex-direction:column} .grid2{grid-template-columns:1fr}}
</style>
</head>
<body>
<aside class="sidebar">
  <div><h2>श्री पब्लिक</h2><small>Website Management • <?= htmlspecialchars($_SESSION['user_name']??'') ?> • <?= htmlspecialchars($role) ?></small></div>
  <nav class="nav">
    <a href="<?= htmlspecialchars(base_url('admin/index.php')) ?>" class="active">Dashboard</a>
    <a href="#">Content: Pages</a>
    <a href="#">Notices</a>
    <a href="#">News &amp; Events</a>
    <a href="#">Academics / Calendar / Results</a>
    <a href="#">People: Leadership / Staff</a>
    <a href="#">Media: Gallery / Files</a>
    <a href="#">Resources: Downloads / Charter</a>
    <a href="#">Communication: Messages</a>
    <a href="#">Website: Menus / SEO / Settings</a>
    <a href="#">System: Users / Roles / Logs</a>
  </nav>
  <div style="margin-top:auto;display:flex;flex-direction:column;gap:8px">
    <a href="<?= htmlspecialchars(base_url()) ?>" class="btn" style="justify-content:center">View Website</a>
    <a href="<?= htmlspecialchars(base_url('admin/logout.php')) ?>" class="btn" style="justify-content:center;background:rgba(255,255,255,.10);color:#fff;border-color:rgba(255,255,255,.18)">Sign out</a>
  </div>
</aside>
<main class="main">
  <div class="top">
    <div><h1 style="font-size:1.4rem">Dashboard</h1><p style="color:#667085;font-size:.88rem">Shree Public Secondary School — Malangwa-2 • IEMIS 190640003</p></div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
      <a href="#" class="btn btn-primary">+ New Notice</a>
      <a href="#" class="btn">+ New News</a>
      <a href="#" class="btn">Upload Document</a>
      <a href="#" class="btn">Add Event</a>
      <a href="#" class="btn">Add Gallery</a>
    </div>
  </div>
  <div class="cards">
    <div class="card"><div class="num">5</div><div class="lbl">Published Notices</div><div style="font-size:.78rem;color:#667085;margin-top:4px">2 drafts • 1 pinned</div></div>
    <div class="card"><div class="num">2</div><div class="lbl">Draft Notices</div></div>
    <div class="card"><div class="num">3</div><div class="lbl">News</div></div>
    <div class="card"><div class="num">3</div><div class="lbl">Upcoming Events</div></div>
    <div class="card"><div class="num">6</div><div class="lbl">Downloads</div></div>
    <div class="card"><div class="num">12</div><div class="lbl">Gallery Images</div></div>
    <div class="card"><div class="num">4</div><div class="lbl">Contact Messages</div><div style="font-size:.78rem;color:#667085;margin-top:4px">2 unread</div></div>
  </div>
  <div class="grid2">
    <div class="section">
      <h3>Recent Activity</h3>
      <ul style="font-size:.88rem;color:#667085;display:flex;flex-direction:column;gap:8px;list-style:none">
        <li>• Notice "Admission Open 2082" published — 2026-04-15</li>
        <li>• Download "Academic Calendar 2082" uploaded — 2026-04-05</li>
        <li>• Event "16-Day Campaign" added — Nov 2025</li>
        <li>• Contact message from parent — 2026-04-16</li>
      </ul>
    </div>
    <div class="section">
      <h3>Quick Setup Checklist</h3>
      <ul style="font-size:.88rem;display:flex;flex-direction:column;gap:8px;list-style:none">
        <li>☐ Upload official logo &amp; set brand colors</li>
        <li>☐ Verify &amp; enter phone / email / hours</li>
        <li>☐ Add principal name / photo / message → enable homepage section</li>
        <li>☐ Confirm labs / library / sports → enable commitment items</li>
        <li>☐ Import real notices with PDFs</li>
        <li>☐ Replace gallery placeholders with 10–20 originals</li>
        <li>☐ Publish Citizen Charter &amp; calendar</li>
      </ul>
      <div style="background:#FDF6E3;border:1px dashed #FDE68A;padding:10px 12px;border-radius:10px;margin-top:12px;font-size:.82rem;color:#6B4F00">RBAC: Super Admin (everything) • School Admin (content + settings) • Editor (notices/news/gallery) • Exam Officer (results only).</div>
    </div>
  </div>
  <div style="margin-top:16px;background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:16px">
    <h3>Security</h3>
    <p style="color:#667085;font-size:.88rem;margin-top:6px">password_hash, PDO prepared statements, CSRF, XSS escaping, secure session cookies, rate limiting, upload allowlist (pdf/docx/xlsx/jpg/png), randomized filenames, audit logs.</p>
  </div>
</main>
</body>
</html>
