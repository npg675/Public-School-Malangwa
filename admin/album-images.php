<?php
$adminPage = 'gallery'; $adminTitle = 'Album Images';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;

$albumId = isset($_GET['album']) ? (int)$_GET['album'] : 0;
if (!$albumId) { header('Location: '.base_url('admin/gallery.php')); exit; }

$stmt = $pdo->prepare('SELECT * FROM gallery_albums WHERE id = ?');
$stmt->execute([$albumId]);
$album = $stmt->fetch();
if (!$album) { header('Location: '.base_url('admin/gallery.php')); exit; }

// Delete image
if (isset($_GET['delimg']) && is_numeric($_GET['delimg'])) {
    if (csrf_verify($_GET['csrf'] ?? '')) {
        $pdo->prepare('DELETE FROM gallery_images WHERE id = ? AND album_id = ?')->execute([(int)$_GET['delimg'], $albumId]);
        $flash = ['ok', 'Image removed.'];
    }
}

// Handle upload via POST (simple form fallback)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    if (!empty($_FILES['images'])) {
        $allowed = ['image/jpeg','image/png','image/webp'];
        $dir = __DIR__.'/../uploads/gallery/'.$album['slug'];
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $count = 0;
        $maxSize = 8 * 1024 * 1024;
        foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {
            if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;
            if ((int)$_FILES['images']['size'][$i] > $maxSize) continue;
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = $finfo ? finfo_file($finfo, $tmp) : false;
            if ($finfo) finfo_close($finfo);
            if (!in_array($mime, $allowed)) continue;
            $ext = $mime === 'image/jpeg' ? 'jpg' : ($mime === 'image/png' ? 'png' : 'webp');
            $name = bin2hex(random_bytes(8)).'.'.$ext;
            if (move_uploaded_file($tmp, $dir.'/'.$name)) {
                $rel = 'uploads/gallery/'.$album['slug'].'/'.$name;
                $cap = trim($_POST['captions'][$i] ?? '');
                $pdo->prepare('INSERT INTO gallery_images (album_id, image_path, caption_en, sort_order) VALUES (?,?,?,?)')
                    ->execute([$albumId, $rel, $cap, $count]);
                if (empty($album['cover_image'])) {
                    $pdo->prepare('UPDATE gallery_albums SET cover_image = ? WHERE id = ?')->execute([$rel, $albumId]);
                    $album['cover_image'] = $rel;
                }
                $count++;
            }
        }
        $flash = ['ok', "$count image(s) uploaded."];
    }
}

$images = $pdo->prepare('SELECT * FROM gallery_images WHERE album_id = ? ORDER BY sort_order');
$images->execute([$albumId]);
$images = $images->fetchAll();
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/gallery.php')) ?>">Gallery</a> <span>/</span> <span><?= e($album['title_en']) ?> — Photos</span></div>
<div class="top"><div><h1><?= e($album['title_en']) ?></h1><p><?= count($images) ?> photo(s) in this album</p></div></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>

<form method="post" enctype="multipart/form-data" class="section-box" id="albumUploadForm">
    <?= csrf_field() ?>
    <div class="album-drop-zone" id="albumDropZone">
        <input type="file" name="images[]" id="albumImages" accept="image/*" multiple hidden>
        <div class="album-drop-hint" id="albumDropHint">
            <span class="material-symbols-outlined" style="font-size:34px;color:#2364AA">add_photo_alternate</span>
            <p style="font-weight:700;color:#172033;margin:6px 0 2px">Drag &amp; drop photos here</p>
            <p style="color:#667085;font-size:.82rem">or click to browse — JPG/PNG/WebP, max 8MB each, multiple files allowed</p>
        </div>
        <div class="album-preview" id="albumPreview"></div>
    </div>
    <div style="display:flex;align-items:center;gap:12px;margin-top:12px">
        <button type="submit" class="btn btn-primary" id="albumUploadBtn" disabled>Upload photos</button>
        <small style="color:#667085" id="albumUploadNote">No photos selected yet.</small>
    </div>
</form>
<style>
.album-drop-zone{border:2px dashed #C3C6D1;border-radius:14px;padding:28px 20px;text-align:center;color:#667085;cursor:pointer;background:#F7F9FC;transition:all .2s}
.album-drop-zone:hover,.album-drop-zone.dragover{border-color:#2364AA;background:#EFF6FF}
.album-drop-hint{pointer-events:none}
.album-preview{display:flex;flex-wrap:wrap;gap:10px;margin-top:14px;justify-content:center}
.album-preview .thumb{width:96px;height:96px;object-fit:cover;border-radius:10px;border:2px solid #E2E8F0;box-shadow:0 1px 4px rgba(0,0,0,.08)}
.album-preview .over{position:relative}
.album-preview .over .badge{position:absolute;top:4px;right:4px;background:rgba(18,59,109,.85);color:#fff;font-size:.62rem;font-weight:700;padding:1px 5px;border-radius:999px}
</style>
<script>
(function(){
    var zone=document.getElementById('albumDropZone');
    var input=document.getElementById('albumImages');
    var preview=document.getElementById('albumPreview');
    var hint=document.getElementById('albumDropHint');
    var btn=document.getElementById('albumUploadBtn');
    var note=document.getElementById('albumUploadNote');
    var files=[];
    var MAX=8*1024*1024;
    var ALLOWED=['image/jpeg','image/png','image/webp'];

    function withFiles(list){
        var added=Array.from(list||[]).filter(function(f){
            return f.type && ALLOWED.indexOf(f.type)!==-1 && f.size<=MAX;
        }).filter(function(f){
            return !files.some(function(x){return x.name===f.name&&x.size===f.size&&x.lastModified===f.lastModified});
        });
        if(!added.length)return;
        files=files.concat(added);
        syncInput();
        renderPreviews();
    }
    function syncInput(){
        var dt=new DataTransfer();
        files.forEach(function(f){dt.items.add(f)});
        input.files=dt.files;
        btn.disabled=files.length===0;
        note.textContent=files.length+' photo(s) selected — '+formatSize(files.reduce(function(s,f){return s+f.size},0))+' total, ready to upload';
    }
    function renderPreviews(){
        preview.innerHTML='';
        hint.style.display=files.length?'none':'';
        files.forEach(function(f,i){
            var box=document.createElement('div');box.className='over';
            var img=document.createElement('img');img.className='thumb';img.alt=f.name;
            var url=URL.createObjectURL(f);img.onload=function(){URL.revokeObjectURL(url)};img.src=url;
            var b=document.createElement('span');b.className='badge';b.textContent=(i+1);
            box.appendChild(img);box.appendChild(b);preview.appendChild(box);
        });
    }
    function formatSize(b){return b>1048576?(b/1048576).toFixed(1)+' MB':Math.round(b/1024)+' KB';}

    zone.addEventListener('click',function(e){if(e.target!==zone&&!zone.contains(e.target))return;input.click()});
    zone.addEventListener('dragover',function(e){e.preventDefault();zone.classList.add('dragover')});
    zone.addEventListener('dragleave',function(){zone.classList.remove('dragover')});
    zone.addEventListener('drop',function(e){e.preventDefault();zone.classList.remove('dragover');withFiles(e.dataTransfer.files)});
    input.addEventListener('change',function(){withFiles(input.files)});
})();
</script>

<div class="section-box" style="margin-top:16px">
    <h3>Photos in Album</h3>
    <?php if (empty($images)): ?>
        <div class="empty">No photos yet. Upload some above.</div>
    <?php else: ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-top:12px">
        <?php foreach ($images as $img): ?>
            <div style="background:#F7F9FC;border:1px solid #E2E8F0;border-radius:10px;overflow:hidden">
                <img src="<?= e_attr(base_url($img['image_path'])) ?>" alt="<?= e($img['caption_en']??'') ?>" style="width:100%;height:140px;object-fit:cover" onerror="this.style.display='none'">
                <div style="padding:8px">
                    <small style="color:#667085;display:block;word-break:break-all"><?= e(basename($img['image_path'])) ?></small>
                    <?php if (!empty($img['caption_en'])): ?><small style="color:#172033;display:block;margin-top:4px"><?= e($img['caption_en']) ?></small><?php endif; ?>
                    <a href="<?= e_attr(base_url('admin/album-images.php?album='.$albumId.'&delimg='.$img['id'].'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" style="margin-top:6px;font-size:.72rem" onclick="return confirmDelete('Remove this photo?')">Remove</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
