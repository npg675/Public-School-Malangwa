<?php
$adminPage = 'users'; $adminTitle = 'Manage Users';
$adminRequiredPerm = 'system';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) { $flash = ['err','Invalid request.']; }
    elseif ((int)$_GET['delete'] === (int)($_SESSION['user_id']??0)) { $flash = ['err','Cannot delete yourself.']; }
    else { $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([(int)$_GET['delete']]); $flash = ['ok','User deleted.']; }
}

$items = $roles = [];
if ($pdo) {
    if (db_has_table('users')) { try { $items = $pdo->query("SELECT u.*, r.name as role_name, r.slug as role_slug FROM users u JOIN roles r ON r.id=u.role_id ORDER BY u.name")->fetchAll(); } catch (Throwable $e) { error_log('Users list failed: ' . $e->getMessage()); } }
    if (db_has_table('roles')) { try { $roles = $pdo->query("SELECT * FROM roles ORDER BY id")->fetchAll(); } catch (Throwable $e) { error_log('Roles list failed: ' . $e->getMessage()); } }
}
?>
<div class="top"><div><h1>Users</h1><p>Manage admin panel access</p></div><a href="<?= e_attr(base_url('admin/user-form.php')) ?>" class="btn btn-primary">+ Add User</a></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<div class="section-box"><table><thead><tr><th>User</th><th>Email</th><th>Role</th><th>Status</th><th>Last Login</th><th>Actions</th></tr></thead><tbody>
<?php if (empty($items)): ?><tr><td colspan="6" class="empty">No users found.</td></tr>
<?php else: foreach ($items as $u): ?><tr>
    <td><strong><?= e($u['name']) ?></strong></td>
    <td><small><?= e($u['email']) ?></small></td>
    <td><span class="tag tag-blue"><?= e($u['role_name']) ?></span></td>
    <td><span class="tag <?= $u['is_active']?'tag-green':'tag-red' ?>"><?= $u['is_active']?'Active':'Disabled' ?></span></td>
    <td><small><?= $u['last_login_at'] ? e(date('M j, g:i A', strtotime($u['last_login_at']))) : 'Never' ?></small></td>
    <td class="actions">
        <a href="<?= e_attr(base_url('admin/user-form.php?id='.$u['id'])) ?>" class="btn btn-sm">Edit</a>
        <?php if ((int)$u['id'] !== (int)($_SESSION['user_id']??0)): ?>
            <a href="<?= e_attr(base_url('admin/users.php?delete='.$u['id'].'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</a>
        <?php endif; ?>
    </td>
</tr><?php endforeach; endif; ?>
</tbody></table></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
