<?php
require_once __DIR__ . '/../../includes/helpers.php';
require_login();
$adminRole = current_user_role();
$adminPage = $adminPage ?? 'dashboard';
$adminTitle = $adminTitle ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($adminTitle) ?> — Shree Public Secondary School</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Inter,system-ui,sans-serif;background:#F7F9FC;color:#172033;display:flex;min-height:100vh}
.sidebar{width:260px;background:#092A4D;color:#C7D7F0;padding:18px;flex:none;display:flex;flex-direction:column;gap:18px;position:sticky;top:0;height:100vh;overflow-y:auto}
.sidebar h2{color:#fff;font-size:1rem;font-weight:800}
.sidebar small{color:#93B4D8;font-size:.78rem}
.nav{display:flex;flex-direction:column;gap:2px}
.nav a{color:#C7D7F0;padding:10px 12px;border-radius:8px;font-weight:600;font-size:.84rem;display:flex;align-items:center;gap:10px;text-decoration:none;transition:background .15s}
.nav a:hover,.nav a.active{background:rgba(255,255,255,.10);color:#fff}
.nav a.active{background:rgba(255,255,255,.14);border-left:3px solid #FFCC00;padding-left:9px}
.nav-sep{font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;color:#5A7FA0;padding:12px 12px 4px;font-weight:700}
.main{flex:1;padding:24px;overflow:auto;min-width:0}
.top{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:12px}
.top h1{font-size:1.4rem;font-weight:800;color:#123B6D}
.top p{color:#667085;font-size:.88rem}
.cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:12px;margin-bottom:20px}
.card{background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:16px;box-shadow:0 4px 12px rgba(9,42,77,.06)}
.card .num{font-size:1.6rem;font-weight:800;color:#123B6D}
.card .lbl{font-size:.76rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#667085}
.btn{padding:10px 14px;border-radius:8px;font-weight:700;font-size:.84rem;border:1px solid #E2E8F0;background:#fff;color:#123B6D;text-decoration:none;display:inline-flex;gap:6px;align-items:center;cursor:pointer;transition:all .15s}
.btn:hover{background:#F7F9FC;border-color:#C3C6D1}
.btn-primary{background:#123B6D;color:#fff;border-color:#123B6D}
.btn-primary:hover{background:#092A4D}
.btn-gold{background:#D29A32;color:#1F2540;border-color:#D29A32}
.btn-danger{background:#fff;color:#C1272D;border-color:#FECACA}
.btn-danger:hover{background:#FDECEC}
.btn-sm{padding:6px 10px;font-size:.78rem}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.section-box{background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:16px;margin-bottom:16px}
.section-box h3{font-size:1rem;margin-bottom:10px}
table{width:100%;border-collapse:collapse;font-size:.88rem}
th{text-align:left;padding:10px 12px;background:#F7F9FC;border-bottom:2px solid #E2E8F0;font-weight:700;color:#667085;font-size:.78rem;text-transform:uppercase;letter-spacing:.04em}
td{padding:10px 12px;border-bottom:1px solid #F0F0F5}
tr:hover td{background:#FAFBFE}
.tag{display:inline-block;padding:3px 10px;border-radius:999px;font-size:.74rem;font-weight:700;border:1px solid #E2E8F0;background:#F7F9FC;color:#667085}
.tag-green{background:#E0F2F2;border-color:#93C5C5;color:#099090}
.tag-red{background:#FDECEC;border-color:#FECACA;color:#C1272D}
.tag-gold{background:#FFF8CC;border-color:#FDE68A;color:#6B4F00}
.tag-blue{background:#DBEAFE;border-color:#93C5FD;color:#1E40AF}
.empty{text-align:center;padding:40px 20px;color:#667085}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.form-group{margin-bottom:16px}
.form-group label{display:block;font-weight:700;font-size:.82rem;margin-bottom:6px;color:#172033}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:10px 14px;border:1.5px solid #E2E8F0;border-radius:10px;background:#F7F9FC;font-size:.92rem;font-family:inherit}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:#2364AA;box-shadow:0 0 0 4px rgba(35,100,170,.12);background:#fff}
.form-group textarea{min-height:120px;resize:vertical}
.form-full{grid-column:1/-1}
.breadcrumbs{font-size:.84rem;color:#667085;margin-bottom:16px;display:flex;gap:6px;align-items:center}
.breadcrumbs a{color:#2364AA;text-decoration:none}
.breadcrumbs a:hover{text-decoration:underline}
.flash{padding:12px 16px;border-radius:10px;font-size:.88rem;margin-bottom:16px;font-weight:600}
.flash-ok{background:#E0F2F2;border:1px solid #93C5C5;color:#065F5F}
.flash-err{background:#FDECEC;border:1px solid #FECACA;color:#C1272D}
.upload-zone{border:2px dashed #C3C6D1;border-radius:12px;padding:32px;text-align:center;color:#667085;cursor:pointer;transition:all .2s}
.upload-zone:hover,.upload-zone.dragover{border-color:#2364AA;background:#EFF6FF;color:#2364AA}
.preview-img{max-width:200px;max-height:140px;border-radius:8px;object-fit:cover;border:1px solid #E2E8F0;margin-top:8px}
.actions{display:flex;gap:6px;flex-wrap:wrap}
.pagination{display:flex;gap:4px;margin-top:16px;justify-content:center}
.pagination a,.pagination span{padding:6px 12px;border-radius:8px;font-size:.84rem;font-weight:600;text-decoration:none;border:1px solid #E2E8F0;color:#123B6D}
.pagination span.current{background:#123B6D;color:#fff;border-color:#123B6D}
@media(max-width:900px){.sidebar{width:100%;position:fixed;z-index:100;transform:translateX(-100%);transition:transform .2s}body{flex-direction:column}.sidebar.open{transform:translateX(0)}.grid2,.form-grid{grid-template-columns:1fr}.mobile-toggle{display:block!important}}
.mobile-toggle{display:none;position:fixed;bottom:20px;right:20px;z-index:101;width:48px;height:48px;border-radius:50%;background:#123B6D;color:#fff;border:0;font-size:1.4rem;box-shadow:0 4px 16px rgba(0,0,0,.2);cursor:pointer}
.checkbox-row{display:flex;align-items:center;gap:8px}
.checkbox-row input[type=checkbox]{width:18px;height:18px;accent-color:#123B6D}
</style>
</head>
<body>
<aside class="sidebar" id="sidebar">
  <div><h2>श्री पब्लिक</h2><small>Website Management<br><?= e($_SESSION['user_name']??'') ?> • <?= e($adminRole) ?></small></div>
  <nav class="nav">
    <a href="<?= e_attr(base_url('admin/index.php')) ?>" class="<?= $adminPage==='dashboard'?'active':'' ?>">📊 Dashboard</a>
    <div class="nav-sep">Content</div>
    <a href="<?= e_attr(base_url('admin/notices.php')) ?>" class="<?= $adminPage==='notices'?'active':'' ?>">🔔 Notices</a>
    <a href="<?= e_attr(base_url('admin/news.php')) ?>" class="<?= $adminPage==='news'?'active':'' ?>">📰 News</a>
    <a href="<?= e_attr(base_url('admin/events.php')) ?>" class="<?= $adminPage==='events'?'active':'' ?>">📅 Events</a>
    <a href="<?= e_attr(base_url('admin/pages.php')) ?>" class="<?= $adminPage==='pages'?'active':'' ?>">📄 Pages</a>
    <div class="nav-sep">Media</div>
    <a href="<?= e_attr(base_url('admin/gallery.php')) ?>" class="<?= $adminPage==='gallery'?'active':'' ?>">🖼️ Gallery</a>
    <a href="<?= e_attr(base_url('admin/downloads.php')) ?>" class="<?= $adminPage==='downloads'?'active':'' ?>">📥 Downloads</a>
    <div class="nav-sep">People</div>
    <a href="<?= e_attr(base_url('admin/staff.php')) ?>" class="<?= $adminPage==='staff'?'active':'' ?>">👥 Staff</a>
    <div class="nav-sep">System</div>
    <a href="<?= e_attr(base_url('admin/results.php')) ?>" class="<?= $adminPage==='results'?'active':'' ?>">📊 Results</a>
    <a href="<?= e_attr(base_url('admin/messages.php')) ?>" class="<?= $adminPage==='messages'?'active':'' ?>">✉️ Messages</a>
    <a href="<?= e_attr(base_url('admin/settings.php')) ?>" class="<?= $adminPage==='settings'?'active':'' ?>">⚙️ Settings</a>
    <a href="<?= e_attr(base_url('admin/users.php')) ?>" class="<?= $adminPage==='users'?'active':'' ?>">🔑 Users</a>
  </nav>
  <div style="margin-top:auto;display:flex;flex-direction:column;gap:8px">
    <a href="<?= e_attr(base_url()) ?>" class="btn" style="justify-content:center" target="_blank">🌐 View Website</a>
    <a href="<?= e_attr(base_url('admin/logout.php')) ?>" class="btn" style="justify-content:center;background:rgba(255,255,255,.10);color:#fff;border-color:rgba(255,255,255,.18)">Sign out</a>
  </div>
</aside>
<button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')" aria-label="Menu">☰</button>
<main class="main">
