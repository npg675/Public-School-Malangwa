<?php
$adminPage = 'posts'; $adminTitle = 'Manage News & Events';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;
$type = isset($_GET['type']) && in_array($_GET['type'], ['news','event'], true) ? $_GET['type'] : '';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) { $flash = ['err', 'Invalid request.']; }
    else { $pdo->prepare('DELETE FROM posts WHERE id = ?')->execute([(int)$_GET['delete']]); $flash = ['ok', ucfirst($type ?: 'Post') . ' deleted.']; }
}

$items = [];
if ($pdo && db_has_table('posts')) {
    try {
        $sql = "SELECT p.*, c.name_en as cat_en FROM posts p LEFT JOIN news_categories c ON c.id=p.category_id";
        if ($type) { $sql .= " WHERE p.post_type = :type"; }
        $sql .= " ORDER BY p.published_at DESC LIMIT 100";
        $stmt = $pdo->prepare($sql);
        if ($type) { $stmt->bindValue(':type', $type); }
        $stmt->execute(); $items = $stmt->fetchAll();
    } catch (Throwable $e) { error_log('Posts list failed: ' . $e->getMessage()); }
}
?>
<div class="top"><div><h1><?= $type === 'event' ? 'Events' : 'News & Events' ?></h1><p>School news reports and scheduled events — one content type</p></div><a href="<?= e_attr(base_url('admin/post-form.php')) ?>" class="btn btn-primary">+ New Post</a></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px">
    <a href="<?= e_attr(base_url('admin/posts.php')) ?>" class="btn btn-sm <?= $type===''?'btn-primary':'' ?>">All</a>
    <a href="<?= e_attr(base_url('admin/posts.php?type=news')) ?>" class="btn btn-sm <?= $type==='news'?'btn-primary':'' ?>">News</a>
    <a href="<?= e_attr(base_url('admin/posts.php?type=event')) ?>" class="btn btn-sm <?= $type==='event'?'btn-primary':'' ?>">Events</a>
</div>
<div class="section-box"><table><thead><tr><th>Title</th><th>Type</th><th>Category</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php if (empty($items)): ?><tr><td colspan="6" class="empty">No <?= $type ?: 'posts' ?> yet.</td></tr>
<?php else: foreach ($items as $n): ?><tr>
    <td><strong><?= e($n['title_en']) ?></strong><?php if (!empty($n['title_np'])): ?><br><small style="color:#667085"><?= e($n['title_np']) ?></small><?php endif; ?></td>
    <td><span class="tag <?= $n['post_type']==='event'?'tag-gold':'tag-blue' ?>"><?= e(ucfirst($n['post_type'])) ?></span></td>
    <td><span class="tag"><?= e($n['cat_en'] ?? 'General') ?></span></td>
    <td><small><?= e($n['post_type']==='event' && !empty($n['event_date']) ? date('M j, Y', strtotime($n['event_date'])) : date('M j, Y', strtotime($n['published_at']))) ?></small></td>
    <td><span class="tag <?= $n['status']==='published'?'tag-green':'tag-gold' ?>"><?= e($n['status']) ?></span></td>
    <td class="actions"><a href="<?= e_attr(base_url('admin/post-form.php?id='.$n['id'])) ?>" class="btn btn-sm">Edit</a><a href="<?= e_attr(base_url('admin/posts.php?delete='.$n['id'].($type?'&type='.$type:'').'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</a></td>
</tr><?php endforeach; endif; ?>
</tbody></table></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
