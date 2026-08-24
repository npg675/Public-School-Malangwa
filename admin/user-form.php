<?php
$adminPage = 'users'; $adminTitle = 'User Form';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null; $editing = isset($_GET['id']) && is_numeric($_GET['id']); $row = null; $roles = [];
if ($pdo && db_has_table('roles')) { try { $roles = $pdo->query("SELECT * FROM roles ORDER BY id")->fetchAll(); } catch (Throwable $e) {} }
if ($editing) { $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?'); $stmt->execute([(int)$_GET['id']]); $row = $stmt->fetch(); if (!$row) { header('Location: '.base_url('admin/users.php')); exit; } }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role_id = (int)($_POST['role_id'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || !$role_id) {
        $flash = ['err', 'Name, Email, and Role are required.'];
    } elseif (!$editing && empty($password)) {
        $flash = ['err', 'Password is required for new users.'];
    } else {
        if ($editing) {
            $sets = 'name=:name, email=:email, role_id=:role_id, is_active=:is_active';
            $params = [':name'=>$name, ':email'=>$email, ':role_id'=>$role_id, ':is_active'=>$is_active, ':id'=>(int)$_GET['id']];
            if (!empty($password)) {
                $sets .= ', password_hash=:pw';
                $params[':pw'] = password_hash($password, PASSWORD_DEFAULT);
            }
            $pdo->prepare("UPDATE users SET $sets WHERE id=:id")->execute($params);
            $flash = ['ok', 'User updated.'];
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $pdo->prepare('INSERT INTO users (name, email, password_hash, role_id, is_active) VALUES (?,?,?,?,?)')
                ->execute([$name, $email, $hash, $role_id, $is_active]);
            $flash = ['ok', 'User created.'];
        }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/users.php')) ?>">Users</a> <span>/</span> <span><?= $editing?'Edit':'Add' ?></span></div>
<div class="top"><h1><?= $editing?'Edit User':'Add User' ?></h1></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post" class="section-box"><?= csrf_field() ?>
<div class="form-grid">
    <div class="form-group"><label>Name *</label><input type="text" name="name" required value="<?= e($row['name']??'') ?>"></div>
    <div class="form-group"><label>Email *</label><input type="email" name="email" required value="<?= e($row['email']??'') ?>"></div>
    <div class="form-group"><label>Password <?= $editing?'(leave blank to keep current)':'*' ?></label><input type="password" name="password" <?= $editing?'':'required' ?> minlength="6"></div>
    <div class="form-group"><label>Role *</label><select name="role_id" required><option value="">— Select —</option><?php foreach($roles as $r): ?><option value="<?=$r['id']?>" <?=($row['role_id']??'')==$r['id']?'selected':''?>><?=e($r['name'])?></option><?php endforeach;?></select></div>
    <div class="form-group form-full"><div class="checkbox-row"><input type="checkbox" name="is_active" id="is_active" <?=($row['is_active']??1)?'checked':''?>><label for="is_active" style="margin:0">Active account</label></div></div>
</div>
<div style="display:flex;gap:8px;margin-top:16px"><button type="submit" class="btn btn-primary"><?= $editing?'Update':'Create' ?></button><a href="<?= e_attr(base_url('admin/users.php')) ?>" class="btn">Cancel</a></div>
</form>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
