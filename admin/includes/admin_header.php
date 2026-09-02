<?php
require_once __DIR__ . '/../../includes/helpers.php';
if (!headers_sent()) send_security_headers();
require_login();
$adminRole = current_user_role();
$adminPage = $adminPage ?? 'dashboard';
$adminTitle = $adminTitle ?? 'Admin';
$__adminLang = admin_lang();
$__adminNp = $__adminLang === 'np';
$__adminTitleMap = [
    'Dashboard' => 'ड्यासबोर्ड',
    'Contact Messages' => 'सम्पर्क सन्देशहरू',
    'Manage Downloads' => 'डाउनलोड व्यवस्थापन',
    'Download Form' => 'डाउनलोड फारम',
    'Change Password' => 'पासवर्ड परिवर्तन',
    'Notice Form' => 'सूचना फारम',
    'Manage Staff' => 'कर्मचारी व्यवस्थापन',
    'Manage Notices' => 'सूचना व्यवस्थापन',
    'Page Form' => 'पृष्ठ फारम',
    'Manage Users' => 'प्रयोगकर्ता व्यवस्थापन',
    'Album Form' => 'एल्बम फारम',
    'Album Images' => 'एल्बम तस्बिरहरू',
    'Site Settings' => 'साइट सेटिङ',
    'Gallery Albums' => 'ग्यालरी एल्बमहरू',
    'Content Blocks' => 'सामग्री ब्लकहरू',
    'User Form' => 'प्रयोगकर्ता फारम',
    'Staff Form' => 'कर्मचारी फारम',
    'Manage News & Events' => 'समाचार र कार्यक्रम व्यवस्थापन',
    'Content Block Form' => 'सामग्री ब्लक फारम',
    'Manage Pages' => 'पृष्ठहरू व्यवस्थापन',
    'Post Form' => 'सामग्री फारम',
];
if ($__adminNp && isset($__adminTitleMap[$adminTitle])) $adminTitle = $__adminTitleMap[$adminTitle];
if (!empty($adminRequiredPerm)) {
    require_permission($adminRequiredPerm);
}
?>
<!DOCTYPE html>
<html lang="<?= $__adminNp ? 'ne' : 'en' ?>">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($adminTitle) ?> — Shree Public Secondary School</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Noto+Sans+Devanagari:wght@400;500;600;700&family=Tiro+Devanagari+Sanskrit&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter','Noto Sans Devanagari',system-ui,sans-serif;background:#F7F9FC;color:#172033;display:flex;min-height:100vh}
.sidebar-lang{display:flex;gap:6px;margin-top:8px}
.sidebar-lang button{flex:1;padding:7px 0;border-radius:8px;border:1px solid rgba(255,255,255,.22);background:transparent;color:#C7D7F0;font-weight:700;font-size:.82rem;cursor:pointer;transition:all .15s}
.sidebar-lang button.active{background:#FFCC00;color:#092A4D;border-color:#FFCC00}
.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 500,'GRAD' 0,'opsz' 24;font-size:20px;line-height:1;flex:none}
.sidebar{width:260px;background:#092A4D;color:#C7D7F0;padding:18px;flex:none;display:flex;flex-direction:column;gap:18px;position:sticky;top:0;height:100vh;overflow-y:auto}
.sidebar h2{color:#fff;font-size:1rem;font-weight:800}
.sidebar small{color:#93B4D8;font-size:.78rem}
.nav{display:flex;flex-direction:column;gap:2px}
.nav a{color:#C7D7F0;padding:10px 12px;border-radius:8px;font-weight:600;font-size:.84rem;display:flex;align-items:center;gap:11px;text-decoration:none;transition:background .15s}
.nav a:hover,.nav a.active{background:rgba(255,255,255,.10);color:#fff}
.nav a.active{background:rgba(255,255,255,.14);border-left:3px solid #FFCC00;padding-left:9px}
.nav a.active .material-symbols-outlined{color:#FFCC00}
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
.btn .material-symbols-outlined{font-size:18px}
.btn-primary{background:#123B6D;color:#fff;border-color:#123B6D}
.btn-primary:hover{background:#092A4D;border-color:#092A4D}
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

/* ---- Profile photo zoom editor ---- */
.photo-editor{margin-top:14px;border:1.5px solid #C3C6D1;border-radius:12px;padding:14px;background:#fff}
.pe-frame{width:100%;max-width:320px;margin:0 auto;aspect-ratio:1;border-radius:12px;overflow:hidden;background:#0B1B33;box-shadow:0 4px 16px rgba(9,42,77,.18);position:relative;cursor:grab}
.pe-frame.dragging{cursor:grabbing}
.pe-frame canvas{display:block;width:100%;height:100%}
.pe-controls{display:flex;gap:8px;justify-content:center;flex-wrap:wrap;margin-top:12px}
.staff-form .preview-img{display:block;width:100%;max-width:160px;height:auto;max-height:160px;aspect-ratio:1;object-fit:cover;margin:12px auto 0}
.staff-form .photo-editor{max-width:100%;overflow:hidden}
.staff-form .pe-frame{width:100%;max-width:280px}
.staff-form{padding:0}
.form-section{border:0;padding:20px 20px 4px;margin:0}
.form-section+.form-section{border-top:1px solid #E2E8F0}
.form-section legend{font-size:1rem;font-weight:800;color:#123B6D;margin-bottom:16px;padding:0}
.form-section .form-grid{margin:0}
.hint{display:block;font-size:.78rem;color:#667085;margin-top:6px;line-height:1.45}
.req{color:#C1272D}
.form-errors{margin:16px 20px 0;padding:12px 14px;border:1px solid #FECACA;border-radius:10px;background:#FDECEC;color:#C1272D;font-size:.86rem;font-weight:600}
.form-group input[aria-invalid="true"],.form-group select[aria-invalid="true"]{border-color:#C1272D;box-shadow:0 0 0 4px rgba(193,39,45,.10)}
.upload-zone:focus-visible{outline:3px solid rgba(35,100,170,.35);outline-offset:3px;border-color:#2364AA;background:#EFF6FF}
.upload-zone>span{display:block}
.advanced-photo{margin-top:14px;border-top:1px solid #F0F0F5;padding-top:10px}
.advanced-photo summary{color:#2364AA;font-size:.8rem;font-weight:700;cursor:pointer}
.advanced-photo label{display:block;font-size:.78rem;font-weight:700;margin:10px 0 6px;color:#172033}
.advanced-photo input{width:100%;padding:10px 14px;border:1.5px solid #E2E8F0;border-radius:10px;background:#F7F9FC;font-size:.9rem;font-family:inherit}
.visibility-options{display:flex;flex-direction:column;gap:10px;padding-top:26px}
.visibility-options .checkbox-row{min-height:36px}
.form-actions{position:sticky;bottom:0;display:flex;align-items:center;gap:8px;flex-wrap:wrap;padding:14px 20px 18px;background:rgba(255,255,255,.96);border-top:1px solid #E2E8F0;box-shadow:0 -6px 18px rgba(9,42,77,.05);z-index:5}
.form-actions-note{margin-left:auto;color:#667085;font-size:.78rem}
.btn:disabled{opacity:.55;cursor:wait}
@media(max-width:600px){.form-section{padding:18px 16px 2px}.form-errors{margin-inline:16px}.form-actions{padding-inline:16px}.form-actions-note{width:100%;margin-left:0}.visibility-options{padding-top:0;margin-bottom:12px}.staff-form .upload-zone{padding:20px 12px}.staff-form .preview-img{max-width:140px;max-height:140px}.staff-form .photo-editor{padding:10px}}

/* ---- Friendly content editing (non-technical users) ---- */
.form-card{background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:20px;margin-bottom:16px;box-shadow:0 4px 12px rgba(9,42,77,.06)}
.form-card>h3{display:flex;align-items:center;gap:9px;font-size:1rem;margin-bottom:16px;color:#123B6D}
.form-card>h3 .material-symbols-outlined{color:#D29A32;font-size:22px}
.hint{font-size:.78rem;color:#667085;margin-top:6px;line-height:1.5}
.req{color:#C1272D}
.slug-row{display:flex;gap:8px}
.slug-row input{flex:1}
.status-pills{display:flex;gap:10px;flex-wrap:wrap}
.status-pill{position:relative}
.status-pill input{position:absolute;opacity:0;pointer-events:none}
.status-pill span{display:inline-flex;align-items:center;gap:8px;padding:10px 18px;border:1.5px solid #E2E8F0;border-radius:10px;font-weight:700;font-size:.86rem;cursor:pointer;background:#F7F9FC;color:#667085;transition:all .15s}
.status-pill span .material-symbols-outlined{font-size:18px}
.status-pill input:checked+span{border-color:#123B6D;background:#123B6D;color:#fff}
.status-pill input:focus-visible+span{box-shadow:0 0 0 4px rgba(35,100,170,.15)}
.save-bar{position:sticky;bottom:0;background:#fff;border-top:1px solid #E2E8F0;margin-top:8px;padding:14px 0 4px;display:flex;gap:10px;align-items:center;z-index:5;flex-wrap:wrap}
.save-bar .meta{margin-left:auto;font-size:.78rem;color:#667085}
.lang-tab{display:inline-flex;align-items:center;gap:8px;padding:8px 14px;border:1.5px solid #E2E8F0;border-bottom:0;border-radius:10px 10px 0 0;font-weight:700;font-size:.84rem;background:#F7F9FC;color:#667085;cursor:pointer}
.lang-tab.active{background:#fff;color:#123B6D;border-color:#C3C6D1}
.rte{border:1.5px solid #E2E8F0;border-radius:10px;background:#fff;overflow:hidden}
.rte:focus-within{border-color:#2364AA;box-shadow:0 0 0 4px rgba(35,100,170,.12)}
.rte-toolbar{display:flex;gap:2px;flex-wrap:wrap;padding:6px;background:#F7F9FC;border-bottom:1px solid #E2E8F0}
.rte-toolbar button{min-width:34px;height:32px;padding:0 7px;border:0;background:transparent;border-radius:6px;color:#172033;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;transition:all .12s}
.rte-toolbar button:hover{background:#E8EEFF;color:#123B6D}
.rte-toolbar .sep{width:1px;height:22px;background:#E2E8F0;margin:5px 5px}
.rte-area{min-height:220px;max-height:460px;overflow-y:auto;padding:16px 18px;font-size:.95rem;line-height:1.75;outline:none}
.rte-area:empty::before{content:attr(data-placeholder);color:#9AA3B2}
.rte-area h2{font-size:1.3rem;margin:.6em 0 .3em;color:#123B6D}
.rte-area h3{font-size:1.1rem;margin:.6em 0 .3em;color:#123B6D}
.rte-area p{margin:0 0 .6em}
.rte-area ul,.rte-area ol{margin:0 0 .6em 1.4em}
.rte-area blockquote{border-left:3px solid #D29A32;padding-left:12px;color:#667085;margin:0 0 .6em}
.rte-area a{color:#2364AA}
.rte-foot{display:flex;justify-content:space-between;align-items:center;padding:6px 12px;border-top:1px solid #E2E8F0;background:#FAFBFE}
.rte-count{font-size:.74rem;color:#667085}
.checkbox-chip{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border:1.5px solid #E2E8F0;border-radius:10px;background:#F7F9FC;font-weight:700;font-size:.84rem;cursor:pointer}
.checkbox-chip input{width:18px;height:18px;accent-color:#123B6D}
</style>
</head>
<body>
<aside class="sidebar" id="sidebar">
  <div><h2>श्री पब्लिक</h2><small><?= ta('Website Management','वेबसाइट व्यवस्थापन') ?><br><?= e($_SESSION['user_name']??'') ?> • <?= e($adminRole) ?></small></div>
  <div class="sidebar-lang">
    <button class="<?= !$__adminNp ? 'active' : '' ?>" onclick="setAdminLang('en')">EN</button>
    <button class="<?= $__adminNp ? 'active' : '' ?>" onclick="setAdminLang('np')">नेपाली</button>
  </div>
  <nav class="nav">
    <a href="<?= e_attr(base_url('admin/index.php')) ?>" class="<?= $adminPage==='dashboard'?'active':'' ?>"><span class="material-symbols-outlined">space_dashboard</span><?= ta('Dashboard','ड्यासबोर्ड') ?></a>
    <?php if (can('content')): ?><div class="nav-sep"><?= ta('Content','सामग्री') ?></div><?php endif; ?>
    <?php if (can('content')): ?><a href="<?= e_attr(base_url('admin/notices.php')) ?>" class="<?= $adminPage==='notices'?'active':'' ?>"><span class="material-symbols-outlined">notifications</span><?= ta('Notices','सूचनाहरू') ?></a><?php endif; ?>
    <?php if (can('content')): ?><a href="<?= e_attr(base_url('admin/posts.php')) ?>" class="<?= $adminPage==='posts'?'active':'' ?>"><span class="material-symbols-outlined">newspaper</span><?= ta('News &amp; Events','समाचार र कार्यक्रम') ?></a><?php endif; ?>
    <?php if (can('content')): ?><a href="<?= e_attr(base_url('admin/blocks.php')) ?>" class="<?= $adminPage==='blocks'?'active':'' ?>"><span class="material-symbols-outlined">dashboard_customize</span><?= ta('Content Blocks','सामग्री ब्लकहरू') ?></a><?php endif; ?>
    <?php if (can('content')): ?><div class="nav-sep"><?= ta('Media','मिडिया') ?></div><?php endif; ?>
    <?php if (can('gallery')): ?><a href="<?= e_attr(base_url('admin/gallery.php')) ?>" class="<?= $adminPage==='gallery'?'active':'' ?>"><span class="material-symbols-outlined">photo_library</span><?= ta('Gallery','ग्यालरी') ?></a><?php endif; ?>
    <?php if (can('content')): ?><a href="<?= e_attr(base_url('admin/downloads.php')) ?>" class="<?= $adminPage==='downloads'?'active':'' ?>"><span class="material-symbols-outlined">cloud_download</span><?= ta('Downloads','डाउनलोड') ?></a><?php endif; ?>
    <?php if (can('staff')): ?><div class="nav-sep"><?= ta('People','जनशक्ति') ?></div><?php endif; ?>
    <?php if (can('staff')): ?><a href="<?= e_attr(base_url('admin/staff.php')) ?>" class="<?= $adminPage==='staff'?'active':'' ?>"><span class="material-symbols-outlined">groups</span><?= ta('Staff','कर्मचारी') ?></a><?php endif; ?>
    <?php if (can('system')): ?><div class="nav-sep"><?= ta('System','प्रणाली') ?></div><?php endif; ?>
    <?php if (can('system')): ?><a href="<?= e_attr(base_url('admin/messages.php')) ?>" class="<?= $adminPage==='messages'?'active':'' ?>"><span class="material-symbols-outlined">mail</span><?= ta('Messages','सन्देशहरू') ?></a><?php endif; ?>
    <?php if (can('system')): ?><a href="<?= e_attr(base_url('admin/settings.php')) ?>" class="<?= $adminPage==='settings'?'active':'' ?>"><span class="material-symbols-outlined">settings</span><?= ta('Settings','सेटिङ') ?></a><?php endif; ?>
    <?php if (can('users') || can('system')): ?><a href="<?= e_attr(base_url('admin/users.php')) ?>" class="<?= $adminPage==='users' && basename($_SERVER['SCRIPT_NAME'] ?? '')!=='change-password.php'?'active':'' ?>"><span class="material-symbols-outlined">manage_accounts</span><?= ta('Users','प्रयोगकर्ताहरू') ?></a><?php endif; ?>
    <a href="<?= e_attr(base_url('admin/change-password.php')) ?>" class="<?= $adminPage==='users' && basename($_SERVER['SCRIPT_NAME'] ?? '')==='change-password.php'?'active':'' ?>"><span class="material-symbols-outlined">password</span><?= ta('Change Password','पासवर्ड परिवर्तन') ?></a>
  </nav>
  <div style="margin-top:auto;display:flex;flex-direction:column;gap:8px">
    <a href="<?= e_attr(base_url()) ?>" class="btn" style="justify-content:center" target="_blank"><span class="material-symbols-outlined">language</span><?= ta('View Website','वेबसाइट हेर्नुहोस्') ?></a>
    <a href="<?= e_attr(base_url('admin/logout.php')) ?>" class="btn" style="justify-content:center;background:rgba(255,255,255,.10);color:#fff;border-color:rgba(255,255,255,.18)"><span class="material-symbols-outlined">logout</span><?= ta('Sign out','साइन आउट') ?></a>
  </div>
</aside>
<button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')" aria-label="Menu"><span class="material-symbols-outlined">menu</span></button>
<script>
function setAdminLang(lang){
  document.cookie = 'admin_lang=' + lang + '; path=/; max-age=' + (60*60*24*365);
  try{ localStorage.setItem('admin_lang', lang);}catch(e){}
  location.reload();
}
(function(){
  try{
    var stored = localStorage.getItem('admin_lang');
    if(stored && !document.cookie.includes('admin_lang')) document.cookie='admin_lang='+stored+'; path=/; max-age='+(60*60*24*365);
  }catch(e){}
})();
</script>
<main class="main">
