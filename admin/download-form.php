<?php
$adminPage = 'downloads'; $adminTitle = 'Download Form';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null; $editing = isset($_GET['id']) && is_numeric($_GET['id']); $row = null; $cats = [];
if ($pdo && db_has_table('download_categories')) { try { $cats = $pdo->query("SELECT * FROM download_categories ORDER BY sort_order")->fetchAll(); } catch (Throwable $e) { error_log('Download categories load failed: '.$e->getMessage()); } }
if ($editing) {
    try { $stmt = $pdo->prepare('SELECT * FROM downloads WHERE id = ?'); $stmt->execute([(int)$_GET['id']]); $row = $stmt->fetch(); }
    catch (Throwable $e) { error_log('Download load failed: '.$e->getMessage()); $flash = ['err','Download could not be loaded. Check the database connection.']; }
    if (!$row && !$flash) { header('Location: '.base_url('admin/downloads.php')); exit; }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $fileSize = trim((string)($_POST['file_size'] ?? ''));
    $d = ['title_en'=>trim($_POST['title_en']??''),'title_np'=>trim($_POST['title_np']??''),'category_id'=>$_POST['category_id']?:null,'file_path'=>trim($_POST['file_path']??''),'file_size'=>$fileSize === '' ? null : (ctype_digit($fileSize) ? (int)$fileSize : null),'file_type'=>trim($_POST['file_type']??''),'published_at'=>$_POST['published_at']??date('Y-m-d H:i:s'),'status'=>in_array($_POST['status']??'draft',['draft','published'],true) ? $_POST['status'] : 'draft'];
    if (empty($d['title_en']) || empty($d['file_path'])) { $flash = ['err','Title and File required.']; }
    elseif ($fileSize !== '' && !ctype_digit($fileSize)) { $flash = ['err','File size must be entered in bytes, for example 1228800.']; }
    else {
        try {
            if ($editing) { $s=[]; foreach($d as $k=>$v) $s[]="`$k`=:$k"; $d[':id']=(int)$_GET['id']; $pdo->prepare('UPDATE downloads SET '.implode(', ',$s).' WHERE id=:id')->execute($d); $flash=['ok','Updated.']; }
            else { $d['created_by']=$_SESSION['user_id']??null; $c=implode('`, `',array_keys($d)); $v=':'.implode(', :',array_keys($d)); $pdo->prepare("INSERT INTO downloads (`$c`) VALUES ($v)")->execute($d); $flash=['ok','Created.']; }
        } catch (Throwable $e) { error_log('Download save failed: '.$e->getMessage()); $flash=['err','Download could not be saved. Check the file path and database connection.']; }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/downloads.php')) ?>">Downloads</a> <span>/</span> <span><?= $editing?'Edit':'New' ?></span></div>
<div class="top"><h1><?= $editing?'Edit Download':'New Download' ?></h1></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post" class="section-box"><?= csrf_field() ?>
<div class="form-grid">
    <div class="form-group"><label>Title (English) *</label><input type="text" name="title_en" required value="<?= e($row['title_en']??'') ?>"></div>
    <div class="form-group"><label>Title (Nepali)</label><input type="text" name="title_np" value="<?= e($row['title_np']??'') ?>"></div>
    <div class="form-group"><label>Category</label><select name="category_id"><option value="">— Select —</option><?php foreach($cats as $c): ?><option value="<?=$c['id']?>" <?=($row['category_id']??'')==$c['id']?'selected':''?>><?=e($c['name_en'])?></option><?php endforeach;?></select></div>
    <div class="form-group"><label>File Path *</label><input type="text" name="file_path" required value="<?= e($row['file_path']??'') ?>" placeholder="uploads/... or URL"></div>
    <div class="form-group"><label>File Size (bytes)</label><input type="number" min="0" name="file_size" value="<?= e($row['file_size']??'') ?>" placeholder="e.g. 1228800"><div class="hint">The database stores bytes and formats the value on the website.</div></div>
    <div class="form-group"><label>File Type</label><input type="text" name="file_type" value="<?= e($row['file_type']??'') ?>" placeholder="PDF, DOCX, etc."></div>
    <div class="form-group"><label>Published At</label><input type="datetime-local" name="published_at" value="<?= e(!empty($row['published_at'])?date('Y-m-d\TH:i',strtotime($row['published_at'])):date('Y-m-d\TH:i')) ?>"></div>
    <div class="form-group"><label>Status</label><select name="status"><option value="draft" <?=($row['status']??'draft')==='draft'?'selected':''?>>Draft</option><option value="published" <?=($row['status']??'')==='published'?'selected':''?>>Published</option></select></div>
</div>
<div style="display:flex;gap:8px;margin-top:16px"><button type="submit" class="btn btn-primary"><?= $editing?'Update':'Create' ?></button><a href="<?= e_attr(base_url('admin/downloads.php')) ?>" class="btn">Cancel</a></div>
</form>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
