<?php
$adminPage = 'pages'; $adminTitle = 'Page Form';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null; $editing = isset($_GET['id']) && is_numeric($_GET['id']); $row = null;
if ($editing) { $stmt = $pdo->prepare('SELECT * FROM pages WHERE id = ?'); $stmt->execute([(int)$_GET['id']]); $row = $stmt->fetch(); if (!$row) { header('Location: '.base_url('admin/pages.php')); exit; } }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $d = ['slug'=>trim($_POST['slug']??''),'title_en'=>trim($_POST['title_en']??''),'title_np'=>trim($_POST['title_np']??''),'content_en'=>$_POST['content_en']??'','content_np'=>$_POST['content_np']??'','meta_description'=>trim($_POST['meta_description']??''),'status'=>$_POST['status']??'draft'];
    if (empty($d['title_en']) || empty($d['slug'])) { $flash = ['err','Title and Slug required.']; }
    else {
        $d['updated_by'] = $_SESSION['user_id'] ?? null;
        if ($editing) { $s=[]; foreach($d as $k=>$v) $s[]="`$k`=:$k"; $d[':id']=(int)$_GET['id']; $pdo->prepare('UPDATE pages SET '.implode(', ',$s).' WHERE id=:id')->execute($d); $flash=['ok','Page updated.']; }
        else { $c=implode('`, `',array_keys($d)); $v=':'.implode(', :',array_keys($d)); $pdo->prepare("INSERT INTO pages (`$c`) VALUES ($v)")->execute($d); $flash=['ok','Page created.']; }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/pages.php')) ?>">Pages</a> <span>/</span> <span><?= $editing?'Edit':'New' ?></span></div>
<div class="top"><h1><?= $editing?'Edit Page':'New Page' ?></h1></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post" class="section-box"><?= csrf_field() ?>
<div class="form-grid">
    <div class="form-group"><label>Title (English) *</label><input type="text" name="title_en" required value="<?= e($row['title_en']??'') ?>"></div>
    <div class="form-group"><label>Title (Nepali)</label><input type="text" name="title_np" value="<?= e($row['title_np']??'') ?>"></div>
    <div class="form-group"><label>Slug *</label><input type="text" name="slug" required value="<?= e($row['slug']??'') ?>" placeholder="e.g. about, admissions"></div>
    <div class="form-group"><label>Status</label><select name="status"><option value="draft" <?=($row['status']??'draft')==='draft'?'selected':''?>>Draft</option><option value="published" <?=($row['status']??'')==='published'?'selected':''?>>Published</option></select></div>
    <div class="form-group form-full"><label>Meta Description</label><input type="text" name="meta_description" value="<?= e($row['meta_description']??'') ?>" maxlength="255"></div>
    <div class="form-group form-full"><label>Content (English)</label><textarea name="content_en" rows="12"><?= e($row['content_en']??'') ?></textarea></div>
    <div class="form-group form-full"><label>Content (Nepali)</label><textarea name="content_np" rows="12"><?= e($row['content_np']??'') ?></textarea></div>
</div>
<div style="display:flex;gap:8px;margin-top:16px"><button type="submit" class="btn btn-primary"><?= $editing?'Update':'Create' ?></button><a href="<?= e_attr(base_url('admin/pages.php')) ?>" class="btn">Cancel</a></div>
</form>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
