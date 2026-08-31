<?php
$adminPage = 'posts'; $adminTitle = 'Post Form';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null; $editing = isset($_GET['id']) && is_numeric($_GET['id']); $row = null; $categories = [];
if ($pdo && db_has_table('news_categories')) { try { $categories = $pdo->query("SELECT * FROM news_categories ORDER BY id")->fetchAll(); } catch (Throwable $e) { error_log('News categories load failed: '.$e->getMessage()); } }
if ($editing) { try { $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?'); $stmt->execute([(int)$_GET['id']]); $row = $stmt->fetch(); } catch (Throwable $e) { error_log('Post load failed: '.$e->getMessage()); $flash=['err','Post could not be loaded. Check the database connection.']; } if (!$row && !$flash) { header('Location: '.base_url('admin/posts.php')); exit; } }
$postType = $row['post_type'] ?? ($_GET['type'] ?? 'news');
if (!in_array($postType, ['news','event'], true)) { $postType = 'news'; }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $d = ['post_type'=>in_array($_POST['post_type']??'news',['news','event'],true)?$_POST['post_type']:'news','title_en'=>trim($_POST['title_en']??''),'title_np'=>trim($_POST['title_np']??''),'slug'=>trim($_POST['slug']??''),'category_id'=>!empty($_POST['category_id'])?(int)$_POST['category_id']:null,'excerpt_en'=>trim($_POST['excerpt_en']??''),'excerpt_np'=>trim($_POST['excerpt_np']??''),'content_en'=>$_POST['content_en']??'','content_np'=>$_POST['content_np']??'','cover_image'=>trim($_POST['cover_image']??''),'location_en'=>trim($_POST['location_en']??''),'location_np'=>trim($_POST['location_np']??''),'event_date'=>$_POST['event_date']?:null,'event_time'=>trim($_POST['event_time']??''),'published_at'=>$_POST['published_at']??date('Y-m-d H:i:s'),'status'=>in_array($_POST['status']??'draft',['draft','published'],true) ? $_POST['status'] : 'draft'];
    $d['location_en'] = $d['post_type']==='event' ? $d['location_en'] : '';
    $d['location_np'] = $d['post_type']==='event' ? $d['location_np'] : '';
    $d['event_date']  = $d['post_type']==='event' ? $d['event_date']  : null;
    $d['event_time']  = $d['post_type']==='event' ? $d['event_time']  : '';
    if (empty($d['title_en'])) { $flash = ['err','Title required.']; }
    elseif ($d['post_type']==='event' && empty($d['event_date'])) { $flash = ['err','Event date required.']; }
    else {
        if (empty($d['slug'])) $d['slug'] = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/','-',$d['title_en']),'-'));
        try { if ($editing) { $s=[]; foreach($d as $k=>$v) $s[]="`$k`=:$k"; $d[':id']=(int)$_GET['id']; $pdo->prepare('UPDATE posts SET '.implode(', ',$s).' WHERE id=:id')->execute($d); $flash=['ok','Post updated.']; } else { $d['created_by']=$_SESSION['user_id']??null; $c=implode('`, `',array_keys($d)); $v=':'.implode(', :',array_keys($d)); $pdo->prepare("INSERT INTO posts (`$c`) VALUES ($v)")->execute($d); $flash=['ok','Post created.']; } } catch (Throwable $e) { error_log('Post save failed: '.$e->getMessage()); $flash=['err','Post could not be saved. Check the slug and database connection.']; }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/posts.php')) ?>">News &amp; Events</a> <span>/</span> <span><?= $editing?'Edit':'New' ?></span></div>
<div class="top"><h1><?= $editing?'Edit Post':'New Post' ?></h1></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post" class="section-box"><?= csrf_field() ?>
<div class="form-grid">
    <div class="form-group"><label>Type *</label><select name="post_type" id="post_type"><option value="news" <?=$postType==='news'?'selected':''?>>News (completed activity)</option><option value="event" <?=$postType==='event'?'selected':''?>>Event (scheduled / upcoming)</option></select></div>
    <div class="form-group"><label>Title (English) *</label><input type="text" name="title_en" required value="<?= e($row['title_en']??'') ?>"></div>
    <div class="form-group"><label>Title (Nepali)</label><input type="text" name="title_np" value="<?= e($row['title_np']??'') ?>"></div>
    <div class="form-group"><label>Slug</label><input type="text" name="slug" value="<?= e($row['slug']??'') ?>"></div>
    <div class="form-group"><label>Category</label><select name="category_id"><option value="">— Select —</option><?php foreach($categories as $c): ?><option value="<?=$c['id']?>" <?=($row['category_id']??'')==$c['id']?'selected':''?>><?=e($c['name_en'])?></option><?php endforeach;?></select></div>
    <div class="form-group"><label>Status</label><select name="status"><option value="draft" <?=($row['status']??'draft')==='draft'?'selected':''?>>Draft</option><option value="published" <?=($row['status']??'')==='published'?'selected':''?>>Published</option></select></div>
    <div class="form-group event-fields"><label>Date *</label><input type="date" name="event_date" value="<?= e($row['event_date']??'') ?>"></div>
    <div class="form-group event-fields"><label>Time</label><input type="text" name="event_time" value="<?= e($row['event_time']??'') ?>" placeholder="e.g. 10:00 AM - 2:00 PM"></div>
    <div class="form-group event-fields"><label>Location (English)</label><input type="text" name="location_en" value="<?= e($row['location_en']??'') ?>"></div>
    <div class="form-group event-fields"><label>Location (Nepali)</label><input type="text" name="location_np" value="<?= e($row['location_np']??'') ?>"></div>
    <div class="form-group"><label>Published At</label><input type="datetime-local" name="published_at" value="<?= e(!empty($row['published_at'])?date('Y-m-d\TH:i',strtotime($row['published_at'])):date('Y-m-d\TH:i')) ?>"></div>
    <div class="form-group form-full"><label>Cover Image</label><input type="text" name="cover_image" value="<?= e($row['cover_image']??'') ?>" placeholder="uploads/..."><div class="upload-zone" style="margin-top:8px;padding:16px" onclick="this.querySelector('input').click()"><input type="file" accept="image/*" style="display:none" onchange="var z=this.closest('.upload-zone');uploadFile(this.files[0],function(e,r){if(e){alert(e);return}z.querySelector('input[name=cover_image]').value=r.path;z.querySelector('input[name=cover_image]').dispatchEvent(new Event('change'))})"><small>Click or drag to upload cover image</small></div></div>
    <div class="form-group form-full"><label>Excerpt (English)</label><input type="text" name="excerpt_en" value="<?= e($row['excerpt_en']??'') ?>" maxlength="400"></div>
    <div class="form-group form-full"><label>Excerpt (Nepali)</label><input type="text" name="excerpt_np" value="<?= e($row['excerpt_np']??'') ?>" maxlength="400"></div>
    <div class="form-group form-full" style="margin-bottom:16px"><label style="display:block;font-weight:700;font-size:.82rem;margin-bottom:6px">Content (English)</label>
    <div class="rte" id="rte-post-en">
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
        <div class="rte-area" style="min-height:180px" contenteditable="true" data-placeholder="Write the story here…"></div>
        <input type="hidden" name="content_en" value="<?= e($row['content_en']??'') ?>">
        <div class="rte-foot"><span class="rte-count"></span></div>
    </div></div>
    <div class="form-group form-full" style="margin-bottom:16px"><label style="display:block;font-weight:700;font-size:.82rem;margin-bottom:6px">Content (Nepali)</label>
    <div class="rte" id="rte-post-np">
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
        <div class="rte-area" style="min-height:180px" contenteditable="true" data-placeholder="यहाँ विवरण लेख्नुहोस्…"></div>
        <input type="hidden" name="content_np" value="<?= e($row['content_np']??'') ?>">
        <div class="rte-foot"><span class="rte-count"></span></div>
    </div></div>
</div>
<div style="display:flex;gap:8px;margin-top:16px"><button type="submit" class="btn btn-primary"><?= $editing?'Update':'Create' ?></button><a href="<?= e_attr(base_url('admin/posts.php')) ?>" class="btn">Cancel</a></div>
</form>
<script>
(function(){
    var pt=document.getElementById('post_type');
    function sync(){var ev=pt.value==='event';document.querySelectorAll('.event-fields').forEach(function(el){el.style.display=ev?'':'none';});}
    pt.addEventListener('change',sync);sync();
})();
</script>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
