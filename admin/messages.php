<?php
$adminPage = 'messages'; $adminTitle = 'Contact Messages';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;

if (isset($_GET['read']) && is_numeric($_GET['read'])) {
    $pdo->prepare('UPDATE contact_messages SET is_read=1 WHERE id=?')->execute([(int)$_GET['read']]);
}
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (csrf_verify($_GET['csrf'] ?? '')) {
        $pdo->prepare('DELETE FROM contact_messages WHERE id=?')->execute([(int)$_GET['delete']]);
        $flash = ['ok', 'Message deleted.'];
    }
}

$items = [];
if ($pdo && db_has_table('contact_messages')) { try { $items = $pdo->query("SELECT * FROM contact_messages ORDER BY is_read ASC, created_at DESC LIMIT 100")->fetchAll(); } catch (Throwable $e) {} }

$unread = 0;
if ($pdo && db_has_table('contact_messages')) { try { $unread = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read=0")->fetchColumn(); } catch (Throwable $e) {} }
?>
<div class="top"><div><h1>Contact Messages</h1><p><?= $unread ?> unread message(s)</p></div></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<div class="section-box"><table><thead><tr><th style="width:30px"></th><th>From</th><th>Subject</th><th>Date</th><th>Actions</th></tr></thead><tbody>
<?php if (empty($items)): ?><tr><td colspan="5" class="empty">No messages yet.</td></tr>
<?php else: foreach ($items as $m): ?>
<tr style="<?= $m['is_read']?'':'background:#FAFBFE;font-weight:600' ?>">
    <td><?= $m['is_read']?'':'🔴' ?></td>
    <td><strong><?= e($m['name']) ?></strong><br><small style="color:#667085"><?= e($m['phone']) ?><?= $m['email']?' · '.e($m['email']):'' ?></small></td>
    <td><small><?= e($m['subject']??'(no subject)') ?></small><br><small style="color:#667085;max-width:300px;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= e(substr($m['message'],0,100)) ?></small></td>
    <td><small><?= e(date('M j, g:i A', strtotime($m['created_at']))) ?></small></td>
    <td class="actions">
        <?php if (!$m['is_read']): ?><a href="<?= e_attr(base_url('admin/messages.php?read='.$m['id'])) ?>" class="btn btn-sm btn-gold">Mark Read</a><?php endif; ?>
        <a href="<?= e_attr(base_url('admin/messages.php?delete='.$m['id'].'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</a>
    </td>
</tr>
<?php endforeach; endif; ?>
</tbody></table></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
