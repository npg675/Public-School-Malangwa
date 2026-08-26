<?php
$adminPage = 'downloads'; $adminTitle = 'Manage Downloads';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) { $flash = ['err','Invalid request.']; }
    else { $pdo->prepare('DELETE FROM downloads WHERE id = ?')->execute([(int)$_GET['delete']]); $flash = ['ok','Download deleted.']; }
}
$items = [];
if ($pdo && db_has_table('downloads')) { try { $items = $pdo->query("SELECT d.*, c.name_en as cat_en FROM downloads d LEFT JOIN download_categories c ON c.id=d.category_id ORDER BY d.published_at DESC LIMIT 100")->fetchAll(); } catch (Throwable $e) { error_log('Downloads list failed: ' . $e->getMessage()); } }
?>
<div class="top"><div><h1>Downloads</h1><p>Forms, routines, calendars, and documents</p></div><a href="<?= e_attr(base_url('admin/download-form.php')) ?>" class="btn btn-primary">+ Upload Document</a></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<div class="section-box"><table><thead><tr><th>Title</th><th>Category</th><th>Size</th><th>Downloads</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php if (empty($items)): ?><tr><td colspan="6" class="empty">No downloads yet.</td></tr>
<?php else: foreach ($items as $d): ?><tr>
    <td><strong><?= e($d['title_en']) ?></strong><?php if(!empty($d['title_np'])):?><br><small style="color:#667085"><?=e($d['title_np'])?></small><?php endif;?></td>
    <td><span class="tag tag-blue"><?= e($d['cat_en']??'Document') ?></span></td>
    <td><small><?= e($d['file_size']??'') ?></small></td>
    <td><small><?= (int)($d['download_count']??0) ?></small></td>
    <td><span class="tag <?= $d['status']==='published'?'tag-green':'tag-gold' ?>"><?= e($d['status']) ?></span></td>
    <td class="actions"><a href="<?= e_attr(base_url('admin/download-form.php?id='.$d['id'])) ?>" class="btn btn-sm">Edit</a><a href="<?= e_attr(base_url('admin/downloads.php?delete='.$d['id'].'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</a></td>
</tr><?php endforeach; endif; ?>
</tbody></table></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
