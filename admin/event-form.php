<?php
$adminPage = 'events'; $adminTitle = 'Event Form';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null; $editing = isset($_GET['id']) && is_numeric($_GET['id']); $row = null;
if ($editing) { $stmt = $pdo->prepare('SELECT * FROM events WHERE id = ?'); $stmt->execute([(int)$_GET['id']]); $row = $stmt->fetch(); if (!$row) { header('Location: '.base_url('admin/events.php')); exit; } }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $d = ['title_en'=>trim($_POST['title_en']??''),'title_np'=>trim($_POST['title_np']??''),'slug'=>trim($_POST['slug']??''),'description_en'=>$_POST['description_en']??'','description_np'=>$_POST['description_np']??'','location_en'=>trim($_POST['location_en']??''),'location_np'=>trim($_POST['location_np']??''),'event_date'=>$_POST['event_date']??'','event_time'=>trim($_POST['event_time']??''),'cover_image'=>trim($_POST['cover_image']??''),'status'=>$_POST['status']??'draft'];
    if (empty($d['title_en']) || empty($d['event_date'])) { $flash = ['err','Title and Date required.']; }
    else {
        if (empty($d['slug'])) $d['slug'] = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/','-',$d['title_en']),'-'));
        if ($editing) { $s=[]; foreach($d as $k=>$v) $s[]="`$k`=:$k"; $d[':id']=(int)$_GET['id']; $pdo->prepare('UPDATE events SET '.implode(', ',$s).' WHERE id=:id')->execute($d); $flash=['ok','Event updated.']; }
        else { $c=implode('`, `',array_keys($d)); $v=':'.implode(', :',array_keys($d)); $pdo->prepare("INSERT INTO events (`$c`) VALUES ($v)")->execute($d); $flash=['ok','Event created.']; }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/events.php')) ?>">Events</a> <span>/</span> <span><?= $editing?'Edit':'New' ?></span></div>
<div class="top"><h1><?= $editing?'Edit Event':'New Event' ?></h1></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post" class="section-box"><?= csrf_field() ?>
<div class="form-grid">
    <div class="form-group"><label>Title (English) *</label><input type="text" name="title_en" required value="<?= e($row['title_en']??'') ?>"></div>
    <div class="form-group"><label>Title (Nepali)</label><input type="text" name="title_np" value="<?= e($row['title_np']??'') ?>"></div>
    <div class="form-group"><label>Slug</label><input type="text" name="slug" value="<?= e($row['slug']??'') ?>"></div>
    <div class="form-group"><label>Date *</label><input type="date" name="event_date" required value="<?= e($row['event_date']??'') ?>"></div>
    <div class="form-group"><label>Time</label><input type="text" name="event_time" value="<?= e($row['event_time']??'') ?>" placeholder="e.g. 10:00 AM - 2:00 PM"></div>
    <div class="form-group"><label>Status</label><select name="status"><option value="draft" <?=($row['status']??'draft')==='draft'?'selected':''?>>Draft</option><option value="published" <?=($row['status']??'')==='published'?'selected':''?>>Published</option></select></div>
    <div class="form-group"><label>Location (English)</label><input type="text" name="location_en" value="<?= e($row['location_en']??'') ?>"></div>
    <div class="form-group"><label>Location (Nepali)</label><input type="text" name="location_np" value="<?= e($row['location_np']??'') ?>"></div>
    <div class="form-group form-full"><label>Cover Image</label><input type="text" name="cover_image" value="<?= e($row['cover_image']??'') ?>" placeholder="uploads/..."></div>
    <div class="form-group form-full"><label>Description (English)</label><textarea name="description_en" rows="5"><?= e($row['description_en']??'') ?></textarea></div>
    <div class="form-group form-full"><label>Description (Nepali)</label><textarea name="description_np" rows="5"><?= e($row['description_np']??'') ?></textarea></div>
</div>
<div style="display:flex;gap:8px;margin-top:16px"><button type="submit" class="btn btn-primary"><?= $editing?'Update':'Create' ?></button><a href="<?= e_attr(base_url('admin/events.php')) ?>" class="btn">Cancel</a></div>
</form>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
