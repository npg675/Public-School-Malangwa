<?php
$adminPage = 'gallery'; $adminTitle = 'Gallery Albums';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) { $flash = ['err','Invalid request.']; }
    else {
        $id = (int)$_GET['delete'];
        $pdo->prepare('DELETE FROM gallery_images WHERE album_id = ?')->execute([$id]);
        $pdo->prepare('DELETE FROM gallery_albums WHERE id = ?')->execute([$id]);
        $flash = ['ok','Album deleted.'];
    }
}
$albums = [];
if ($pdo && db_has_table('gallery_albums')) { try { $albums = $pdo->query("SELECT a.*, (SELECT COUNT(*) FROM gallery_images WHERE album_id=a.id) as img_count FROM gallery_albums a ORDER BY a.sort_order, a.title_en")->fetchAll(); } catch (Throwable $e) {} }
?>
<div class="top"><div><h1>Gallery Albums</h1><p>Organize school photos into albums</p></div><a href="<?= e_attr(base_url('admin/album-form.php')) ?>" class="btn btn-primary">+ New Album</a></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<div class="section-box"><table><thead><tr><th>Album</th><th>Images</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php if (empty($albums)): ?><tr><td colspan="4" class="empty">No albums yet. Create one to start adding photos.</td></tr>
<?php else: foreach ($albums as $a): ?><tr>
    <td><strong><?= e($a['title_en']) ?></strong><?php if(!empty($a['title_np'])):?><br><small style="color:#667085"><?=e($a['title_np'])?></small><?php endif;?></td>
    <td><span class="tag tag-blue"><?= $a['img_count'] ?> photos</span></td>
    <td><span class="tag <?= $a['status']==='published'?'tag-green':'tag-gold' ?>"><?= e($a['status']) ?></span></td>
    <td class="actions">
        <a href="<?= e_attr(base_url('admin/album-images.php?album='.$a['id'])) ?>" class="btn btn-sm">📷 Photos</a>
        <a href="<?= e_attr(base_url('admin/album-form.php?id='.$a['id'])) ?>" class="btn btn-sm">Edit</a>
        <a href="<?= e_attr(base_url('admin/gallery.php?delete='.$a['id'].'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete('Delete album and all its photos?')">Delete</a>
    </td>
</tr><?php endforeach; endif; ?>
</tbody></table></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
