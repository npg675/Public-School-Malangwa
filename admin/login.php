<?php
require_once __DIR__.'/../includes/helpers.php';
if (!headers_sent()) send_security_headers();
if (is_logged_in()) { header('Location: '.base_url('admin/index.php')); exit; }
$error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(!csrf_verify($_POST['_csrf']??'')) $error='Invalid session.';
  elseif(!rate_limit('login_ip_'.($_SERVER['REMOTE_ADDR']??'anon'),20,300,$retryIpAfter) || !rate_limit('login_account_'.($_SERVER['REMOTE_ADDR']??'anon').'_'.strtolower(trim($_POST['email']??'')),5,300,$retryAccountAfter)) { $retryAfter=max((int)($retryIpAfter??0),(int)($retryAccountAfter??0)); http_response_code(429); $error='Too many attempts. Try again in '.max(1,(int)$retryAfter).' seconds.'; }
  else {
    $email=trim($_POST['email']??''); $pass=$_POST['password']??'';
    $pdo=db();
    if($pdo && db_has_table('users')){
      try {
        $stmt=$pdo->prepare('SELECT u.*, r.slug as role_slug FROM users u JOIN roles r ON r.id=u.role_id WHERE u.email=:e AND u.is_active=1 LIMIT 1');
        $stmt->execute([':e'=>$email]);
        $user=$stmt->fetch();
        if($user && password_verify($pass, $user['password_hash'])){
          session_regenerate_id(true);
          $_SESSION['user_id']=$user['id']; $_SESSION['user_role']=$user['role_slug']; $_SESSION['user_name']=$user['name']; $_SESSION['user_email']=$user['email'];
          if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            $pdo->prepare('UPDATE users SET password_hash=:hash WHERE id=:id')->execute([':hash'=>password_hash($pass, PASSWORD_DEFAULT), ':id'=>$user['id']]);
          }
          $pdo->prepare('UPDATE users SET last_login_at=NOW() WHERE id=:id')->execute([':id'=>$user['id']]);
          header('Location: '.base_url('admin/index.php')); exit;
        } else $error='Invalid email or password.';
      } catch (Throwable $e) {
        error_log('Admin login database failure: '.$e->getMessage());
        $error='Admin login is temporarily unavailable. Please try again later.';
      }
    } else {
      $demoEmail = trim((string)env('DEMO_ADMIN_EMAIL', ''));
      $demoHash = trim((string)env('DEMO_ADMIN_PASSWORD_HASH', ''));
      if (env('DB_DISABLED', '0') === '1' && $demoEmail !== '' && $demoHash !== '' && hash_equals(strtolower($demoEmail), strtolower($email)) && password_verify($pass, $demoHash)) {
        session_regenerate_id(true);
        $_SESSION['user_id']=0; $_SESSION['user_role']='super_admin'; $_SESSION['user_name']='Demo Admin'; $_SESSION['user_email']=$demoEmail;
        header('Location: '.base_url('admin/index.php')); exit;
      }
      $error='Admin login is unavailable until the database is connected.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Login — Shree Public Secondary School</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}body{font-family:Inter,system-ui,sans-serif;background:#F7F9FC;color:#172033;display:grid;place-items:center;min-height:100vh;padding:20px}
.card{background:#fff;border:1px solid #E2E8F0;border-radius:16px;box-shadow:0 20px 48px rgba(9,42,77,.12);padding:32px;width:100%;max-width:420px}
h1{font-size:1.4rem;font-weight:800;color:#123B6D;text-align:center} .sub{color:#667085;font-size:.88rem;text-align:center;margin:8px 0 18px}
.field label{font-weight:700;font-size:.82rem;display:block;margin-bottom:6px} .field input{width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;background:#F7F9FC;font-size:.96rem}
.field input:focus{outline:none;border-color:#2364AA;box-shadow:0 0 0 4px rgba(35,100,170,.12);background:#fff}
.btn{width:100%;padding:14px;background:#123B6D;color:#fff;border:0;border-radius:10px;font-weight:700;font-size:.96rem;cursor:pointer;margin-top:16px}
.btn:hover{background:#092A4D}
.err{background:#FDECEC;border:1px solid #FECACA;color:#C1272D;padding:10px 12px;border-radius:10px;font-size:.84rem;margin-bottom:12px}
.note{font-size:.76rem;color:#667085;text-align:center;margin-top:14px}
</style>
</head>
<body>
<form method="post" class="card">
  <h1>Website Management</h1>
  <p class="sub">Shree Public Secondary School — Malangwa-2<br>IEMIS 190640003 • Secure sign-in</p>
  <?php if($error): ?><div class="err"><?= e($error) ?></div><?php endif; ?>
  <?= csrf_field() ?>
  <div class="field" style="margin-bottom:12px"><label>Email</label><input type="email" name="email" required value="<?= e_attr($_POST['email']??'admin@shreepublic.edu.np') ?>" autocomplete="username"></div>
  <div class="field"><label>Password</label><input type="password" name="password" required autocomplete="current-password" placeholder="••••••••"></div>
  <button class="btn" type="submit">Sign in</button>
  <p class="note">Use the admin account created in the database. Change its password after signing in.</p>
  <p class="note"><a href="<?= e_attr(base_url()) ?>" style="color:#123B6D;font-weight:700">← Back to website</a></p>
</form>
</body>
</html>
