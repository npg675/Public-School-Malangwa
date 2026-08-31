<?php
$adminPage = 'gallery'; $adminTitle = 'Album Form';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null; $editing = isset($_GET['id']) && is_numeric($_GET['id']); $row = null;
if ($editing) { try { $stmt = $pdo->prepare('SELECT * FROM gallery_albums WHERE id = ?'); $stmt->execute([(int)$_GET['id']]); $row = $stmt->fetch(); } catch (Throwable $e) { error_log('Album load failed: '.$e->getMessage()); $flash=['err','Album could not be loaded. Check the database connection.']; } if (!$row && !$flash) { header('Location: '.base_url('admin/gallery.php')); exit; } }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $d = ['slug'=>trim($_POST['slug']??''),'title_en'=>trim($_POST['title_en']??''),'title_np'=>trim($_POST['title_np']??''),'description_en'=>trim($_POST['description_en']??''),'cover_image'=>trim($_POST['cover_image']??''),'sort_order'=>(int)($_POST['sort_order']??0),'status'=>in_array($_POST['status']??'draft',['draft','published'],true) ? $_POST['status'] : 'draft'];
    if (empty($d['title_en'])) { $flash = ['err','Title required.']; }
    else {
        if (empty($d['slug'])) $d['slug'] = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/','-',$d['title_en']),'-'));
        try { if ($editing) { $s=[]; foreach($d as $k=>$v) $s[]="`$k`=:$k"; $d[':id']=(int)$_GET['id']; $pdo->prepare('UPDATE gallery_albums SET '.implode(', ',$s).' WHERE id=:id')->execute($d); $flash=['ok','Album updated.']; } else { $c=implode('`, `',array_keys($d)); $v=':'.implode(', :',array_keys($d)); $pdo->prepare("INSERT INTO gallery_albums (`$c`) VALUES ($v)")->execute($d); $flash=['ok','Album created.']; } } catch (Throwable $e) { error_log('Album save failed: '.$e->getMessage()); $flash=['err','Album could not be saved. Check the slug and database connection.']; }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/gallery.php')) ?>">Gallery</a> <span>/</span> <span><?= $editing?'Edit':'New' ?> Album</span></div>
<div class="top"><h1><?= $editing?'Edit Album':'New Album' ?></h1></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post" class="section-box"><?= csrf_field() ?>
<div class="form-grid">
    <div class="form-group"><label>Title (English) *</label><input type="text" name="title_en" required value="<?= e($row['title_en']??'') ?>"></div>
    <div class="form-group"><label>Title (Nepali)</label><input type="text" name="title_np" value="<?= e($row['title_np']??'') ?>"></div>
    <div class="form-group"><label>Slug</label><input type="text" name="slug" value="<?= e($row['slug']??'') ?>"></div>
    <div class="form-group"><label>Sort Order</label><input type="number" name="sort_order" value="<?= e($row['sort_order']??'0') ?>"></div>
    <div class="form-group"><label>Status</label><select name="status"><option value="draft" <?=($row['status']??'draft')==='draft'?'selected':''?>>Draft</option><option value="published" <?=($row['status']??'')==='published'?'selected':''?>>Published</option></select></div>
    <div class="form-group form-full"><label>Cover Image</label><input type="text" name="cover_image" value="<?= e($row['cover_image']??'') ?>" placeholder="uploads/gallery/..." id="albumCoverPath"><div class="upload-zone" style="margin-top:8px;padding:18px" onclick="this.querySelector('input[type=file]').click()"><input type="file" accept="image/jpeg,image/png,image/webp" style="display:none" onchange="var input=document.getElementById('albumCoverPath');var preview=document.getElementById('albumCoverPreview');uploadFile(this.files[0],function(err,res){if(err){alert(err);return}input.value=res.path;preview.src='<?= e_attr(base_url('')) ?>'+res.path;preview.style.display='block'},'gallery')"><small>Click or drag to upload a JPG, PNG or WebP cover image</small><img id="albumCoverPreview" class="preview-img" src="<?= e_attr(!empty($row['cover_image']) ? stored_file_url($row['cover_image']) : '') ?>" alt="Current cover" style="<?= !empty($row['cover_image']) ? '' : 'display:none' ?>"></div></div>
    <div class="form-group form-full"><label>Description</label><textarea name="description_en" rows="3"><?= e($row['description_en']??'') ?></textarea></div>
</div>
<div style="display:flex;gap:8px;margin-top:16px"><button type="submit" class="btn btn-primary"><?= $editing?'Update':'Create' ?></button><a href="<?= e_attr(base_url('admin/gallery.php')) ?>" class="btn">Cancel</a></div>
</form>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
