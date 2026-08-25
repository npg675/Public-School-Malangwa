<?php
$adminPage = 'notices'; $adminTitle = 'Manage Notices';
require_once __DIR__ . '/includes/admin_header.php';

$pdo = db();
$flash = null;

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) {
        $flash = ['err', 'Invalid request.'];
    } else {
        $id = (int)$_GET['delete'];
        $pdo->prepare('DELETE FROM notices WHERE id = ?')->execute([$id]);
        $flash = ['ok', 'Notice deleted.'];
    }
}

// Fetch notices
$notices = [];
if ($pdo && db_has_table('notices')) {
    try {
        $stmt = $pdo->query("SELECT n.*, c.name_en as cat_en FROM notices n LEFT JOIN notice_categories c ON c.id = n.category_id ORDER BY n.is_pinned DESC, n.published_at DESC LIMIT 100");
        $notices = $stmt->fetchAll();
    } catch (Throwable $e) {}
}
?>

<div class="top">
    <div><h1>Notices</h1><p>Manage official school notices, circulars, and announcements</p></div>
    <a href="<?= e_attr(base_url('admin/notice-form.php')) ?>" class="btn btn-primary">+ New Notice</a>
</div>

<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>

<div class="section-box">
    <table>
        <thead>
            <tr>
                <th style="width:40px"><span class="material-symbols-outlined" style="font-size:16px">push_pin</span></th>
                <th>Title</th>
                <th>Category</th>
                <th>Published</th>
                <th>Status</th>
                <th style="width:140px">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($notices)): ?>
            <tr><td colspan="6" class="empty">No notices yet. Click "+ New Notice" to create one.</td></tr>
        <?php else: foreach ($notices as $n): ?>
            <tr>
                <td><?= $n['is_pinned'] ? '<span class="material-symbols-outlined" style="font-size:17px;color:#D29A32">push_pin</span>' : '' ?></td>
                <td>
                    <strong><?= e($n['title_en']) ?></strong>
                    <?php if (!empty($n['title_np'])): ?><br><small style="color:#667085"><?= e($n['title_np']) ?></small><?php endif; ?>
                    <?php if ($n['is_urgent']): ?> <span class="tag tag-red">Urgent</span><?php endif; ?>
                </td>
                <td><span class="tag tag-blue"><?= e($n['cat_en'] ?? 'General') ?></span></td>
                <td><small><?= e(date('M j, Y', strtotime($n['published_at']))) ?></small></td>
                <td><span class="tag <?= $n['status'] === 'published' ? 'tag-green' : ($n['status'] === 'archived' ? 'tag-red' : 'tag-gold') ?>"><?= e($n['status']) ?></span></td>
                <td class="actions">
                    <a href="<?= e_attr(base_url('admin/notice-form.php?id=' . $n['id'])) ?>" class="btn btn-sm">Edit</a>
                    <a href="<?= e_attr(base_url('admin/notices.php?delete=' . $n['id'] . '&csrf=' . csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete('Delete this notice?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
