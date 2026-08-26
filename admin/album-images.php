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

<form method="post" enctype="multipart/form-data" class="section-box">
    <?= csrf_field() ?>
    <div class="form-group"><label>Upload Photos (JPG/PNG/WebP, max 8MB each)</label>
        <input type="file" name="images[]" accept="image/*" multiple required style="margin-bottom:8px">
        <small style="color:#667085">Select multiple files. Optional: add captions below each after upload.</small>
    </div>
    <button type="submit" class="btn btn-primary">Upload to Album</button>
</form>

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
