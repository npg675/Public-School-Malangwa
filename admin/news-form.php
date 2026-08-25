<?php
$adminPage = 'news'; $adminTitle = 'News Form';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null; $editing = isset($_GET['id']) && is_numeric($_GET['id']); $row = null; $categories = [];
if ($pdo && db_has_table('news_categories')) { try { $categories = $pdo->query("SELECT * FROM news_categories ORDER BY id")->fetchAll(); } catch (Throwable $e) {} }
if ($editing) { $stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?'); $stmt->execute([(int)$_GET['id']]); $row = $stmt->fetch(); if (!$row) { header('Location: '.base_url('admin/news.php')); exit; } }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $d = ['title_en'=>trim($_POST['title_en']??''),'title_np'=>trim($_POST['title_np']??''),'slug'=>trim($_POST['slug']??''),'category_id'=>$_POST['category_id']?:null,'excerpt_en'=>trim($_POST['excerpt_en']??''),'excerpt_np'=>trim($_POST['excerpt_np']??''),'content_en'=>$_POST['content_en']??'','content_np'=>$_POST['content_np']??'','cover_image'=>trim($_POST['cover_image']??''),'published_at'=>$_POST['published_at']??date('Y-m-d H:i:s'),'status'=>$_POST['status']??'draft'];
    if (empty($d['title_en'])) { $flash = ['err','Title required.']; }
    else {
        if (empty($d['slug'])) $d['slug'] = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/','-',$d['title_en']),'-'));
        if ($editing) { $s=[]; foreach($d as $k=>$v) $s[]="`$k`=:$k"; $d[':id']=(int)$_GET['id']; $pdo->prepare('UPDATE news SET '.implode(', ',$s).' WHERE id=:id')->execute($d); $flash=['ok','News updated.']; }
        else { $d['created_by']=$_SESSION['user_id']??null; $c=implode('`, `',array_keys($d)); $v=':'.implode(', :',array_keys($d)); $pdo->prepare("INSERT INTO news (`$c`) VALUES ($v)")->execute($d); $flash=['ok','News created.']; }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/news.php')) ?>">News</a> <span>/</span> <span><?= $editing?'Edit':'New' ?></span></div>
<div class="top"><h1><?= $editing?'Edit News':'New News' ?></h1></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post" class="section-box"><?= csrf_field() ?>
<div class="form-grid">
    <div class="form-group"><label>Title (English) *</label><input type="text" name="title_en" required value="<?= e($row['title_en']??'') ?>"></div>
    <div class="form-group"><label>Title (Nepali)</label><input type="text" name="title_np" value="<?= e($row['title_np']??'') ?>"></div>
    <div class="form-group"><label>Slug</label><input type="text" name="slug" value="<?= e($row['slug']??'') ?>"></div>
    <div class="form-group"><label>Category</label><select name="category_id"><option value="">— Select —</option><?php foreach($categories as $c): ?><option value="<?=$c['id']?>" <?=($row['category_id']??'')==$c['id']?'selected':''?>><?=e($c['name_en'])?></option><?php endforeach;?></select></div>
    <div class="form-group"><label>Status</label><select name="status"><option value="draft" <?=($row['status']??'draft')==='draft'?'selected':''?>>Draft</option><option value="published" <?=($row['status']??'')==='published'?'selected':''?>>Published</option></select></div>
    <div class="form-group"><label>Published At</label><input type="datetime-local" name="published_at" value="<?= e($row['published_at']?date('Y-m-d\TH:i',strtotime($row['published_at'])):date('Y-m-d\TH:i')) ?>"></div>
    <div class="form-group form-full"><label>Cover Image</label><input type="text" name="cover_image" value="<?= e($row['cover_image']??'') ?>" placeholder="uploads/news/..."><div class="upload-zone" style="margin-top:8px;padding:16px" onclick="this.querySelector('input').click()"><input type="file" accept="image/*" style="display:none" onchange="var z=this.closest('.upload-zone');uploadFile(this.files[0],function(e,r){if(e){alert(e);return}z.querySelector('input[name=cover_image]').value=r.path;z.querySelector('input[name=cover_image]').dispatchEvent(new Event('change'))})"><small>Click or drag to upload cover image</small></div></div>
    <div class="form-group form-full"><label>Excerpt (English)</label><input type="text" name="excerpt_en" value="<?= e($row['excerpt_en']??'') ?>" maxlength="400"></div>
    <div class="form-group form-full"><label>Excerpt (Nepali)</label><input type="text" name="excerpt_np" value="<?= e($row['excerpt_np']??'') ?>" maxlength="400"></div>
    <div class="form-group form-full" style="margin-bottom:16px"><label style="display:block;font-weight:700;font-size:.82rem;margin-bottom:6px">Content (English)</label>
    <div class="rte" id="rte-news-en">
        <div class="rte-toolbar">
            <button type="button" data-cmd="formatBlock" data-val="H2" title="Section heading"><span class="material-symbols-outlined">format_h2</span></button>
            <button type="button" data-cmd="bold" title="Bold"><span class="material-symbols-outlined">format_bold</span></button>
            <button type="button" data-cmd="italic" title="Italic"><span class="material-symbols-outlined">format_italic</span></button>
            <span class="sep"></span>
            <button type="button" data-cmd="insertUnorderedList" title="Bullet list"><span class="material-symbols-outlined">format_list_bulleted</span></button>
            <button type="button" data-cmd="insertOrderedList" title="Numbered list"><span class="material-symbols-outlined">format_list_numbered</span></button>
            <span class="sep"></span>
            <button type="button" data-cmd="createLink" title="Add link"><span class="material-symbols-outlined">link</span></button>
            <button type="button" data-cmd="removeFormat" title="Clear formatting"><span class="material-symbols-outlined">format_clear</span></button>
        </div>
        <div class="rte-area" style="min-height:180px" contenteditable="true" data-placeholder="Write the news story here…"></div>
        <input type="hidden" name="content_en" value="<?= e($row['content_en']??'') ?>">
        <div class="rte-foot"><span class="rte-count"></span></div>
    </div></div>
    <div class="form-group form-full" style="margin-bottom:16px"><label style="display:block;font-weight:700;font-size:.82rem;margin-bottom:6px">Content (Nepali)</label>
    <div class="rte" id="rte-news-np">
        <div class="rte-toolbar">
            <button type="button" data-cmd="formatBlock" data-val="H2" title="Section heading"><span class="material-symbols-outlined">format_h2</span></button>
            <button type="button" data-cmd="bold" title="Bold"><span class="material-symbols-outlined">format_bold</span></button>
            <button type="button" data-cmd="italic" title="Italic"><span class="material-symbols-outlined">format_italic</span></button>
            <span class="sep"></span>
            <button type="button" data-cmd="insertUnorderedList" title="Bullet list"><span class="material-symbols-outlined">format_list_bulleted</span></button>
            <button type="button" data-cmd="insertOrderedList" title="Numbered list"><span class="material-symbols-outlined">format_list_numbered</span></button>
            <span class="sep"></span>
            <button type="button" data-cmd="createLink" title="Add link"><span class="material-symbols-outlined">link</span></button>
            <button type="button" data-cmd="removeFormat" title="Clear formatting"><span class="material-symbols-outlined">format_clear</span></button>
        </div>
        <div class="rte-area" style="min-height:180px" contenteditable="true" data-placeholder="यहाँ समाचार लेख्नुहोस्…"></div>
        <input type="hidden" name="content_np" value="<?= e($row['content_np']??'') ?>">
        <div class="rte-foot"><span class="rte-count"></span></div>
    </div></div>
</div>
<div style="display:flex;gap:8px;margin-top:16px"><button type="submit" class="btn btn-primary"><?= $editing?'Update':'Create' ?></button><a href="<?= e_attr(base_url('admin/news.php')) ?>" class="btn">Cancel</a></div>
</form>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
