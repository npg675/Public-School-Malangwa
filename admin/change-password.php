<?php
$adminPage = 'users'; $adminTitle = 'Change Password';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db();
$flash = null;
$userId = (int)($_SESSION['user_id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $current = (string)($_POST['current_password'] ?? '');
    $password = (string)($_POST['password'] ?? '');
    $confirm = (string)($_POST['password_confirmation'] ?? '');
    if (!$pdo || !$userId) {
        $flash = ['err', 'Password changes require a connected database account.'];
    } elseif (strlen($password) < 10 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        $flash = ['err', 'Use at least 10 characters with at least one letter and one number.'];
    } elseif ($password !== $confirm) {
        $flash = ['err', 'New passwords do not match.'];
    } else {
        try {
            $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ? AND is_active = 1 LIMIT 1');
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
            if (!$user || !password_verify($current, $user['password_hash'])) {
                $flash = ['err', 'Current password is incorrect.'];
            } else {
                $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?')->execute([password_hash($password, PASSWORD_DEFAULT), $userId]);
                session_regenerate_id(true);
                $flash = ['ok', 'Password changed. Use the new password next time you sign in.'];
            }
        } catch (Throwable $e) {
            error_log('Password change failed: '.$e->getMessage());
            $flash = ['err', 'Password could not be changed. Check the database connection and try again.'];
        }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/index.php')) ?>">Dashboard</a> <span>/</span> <span>Change Password</span></div>
<div class="top"><div><h1>Change Password</h1><p>Update the password for your own admin account.</p></div></div>
<?php if ($flash): ?><div class="flash flash-<?= e($flash[0]) ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post" class="section-box" style="max-width:640px">
    <?= csrf_field() ?>
    <div class="form-group"><label>Current password *</label><input type="password" name="current_password" required autocomplete="current-password"></div>
    <div class="form-group"><label>New password *</label><input type="password" name="password" required minlength="10" autocomplete="new-password"><div class="hint">At least 10 characters, including one letter and one number.</div></div>
    <div class="form-group"><label>Confirm new password *</label><input type="password" name="password_confirmation" required minlength="10" autocomplete="new-password"></div>
    <button type="submit" class="btn btn-primary">Change Password</button>
</form>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
