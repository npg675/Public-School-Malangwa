<?php
$adminPage = 'news'; $adminTitle = 'Manage News';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db();
$flash = null;

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) { $flash = ['err', 'Invalid request.']; }
    else { $pdo->prepare('DELETE FROM news WHERE id = ?')->execute([(int)$_GET['delete']]); $flash = ['ok', 'News deleted.']; }
}

$items = [];
if ($pdo && db_has_table('news')) {
    try { $items = $pdo->query("SELECT n.*, c.name_en as cat_en FROM news n LEFT JOIN news_categories c ON c.id=n.category_id ORDER BY n.published_at DESC LIMIT 100")->fetchAll(); } catch (Throwable $e) { error_log('News list failed: ' . $e->getMessage()); }
}
?>
<div class="top"><div><h1>News</h1><p>School news, reports, and activity highlights</p></div><a href="<?= e_attr(base_url('admin/news-form.php')) ?>" class="btn btn-primary">+ New News</a></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<div class="section-box"><table><thead><tr><th>Title</th><th>Category</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php if (empty($items)): ?><tr><td colspan="5" class="empty">No news yet.</td></tr>
<?php else: foreach ($items as $n): ?><tr>
    <td><strong><?= e($n['title_en']) ?></strong><?php if (!empty($n['title_np'])): ?><br><small style="color:#667085"><?= e($n['title_np']) ?></small><?php endif; ?></td>
    <td><span class="tag tag-blue"><?= e($n['cat_en'] ?? 'General') ?></span></td>
    <td><small><?= e(date('M j, Y', strtotime($n['published_at']))) ?></small></td>
    <td><span class="tag <?= $n['status']==='published'?'tag-green':'tag-gold' ?>"><?= e($n['status']) ?></span></td>
    <td class="actions"><a href="<?= e_attr(base_url('admin/news-form.php?id='.$n['id'])) ?>" class="btn btn-sm">Edit</a><a href="<?= e_attr(base_url('admin/news.php?delete='.$n['id'].'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</a></td>
</tr><?php endforeach; endif; ?>
</tbody></table></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
