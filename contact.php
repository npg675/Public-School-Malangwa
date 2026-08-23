<?php $page='contact'; $title='Contact — Shree Public Secondary School'; require_once __DIR__.'/includes/header.php';
$success=null; $error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(!csrf_verify($_POST['_csrf']??'')) $error='Invalid session.';
  elseif(!rate_limit('contact_'.($_SERVER['REMOTE_ADDR']??'anon'),5,300)) $error='Too many messages. Try later.';
  else {
    $name=trim($_POST['name']??''); $phone=trim($_POST['phone']??''); $email=trim($_POST['email']??''); $subject=trim($_POST['subject']??''); $msg=trim($_POST['message']??'');
    if(mb_strlen($name)<2 || !preg_match('/^[+]?[0-9][0-9\s\-]{6,14}$/',$phone) || mb_strlen($msg)<5) $error='Please fill name, valid phone and message.';
    else {
      $pdo=db(); if($pdo && db_has_table('contact_messages')){
        try{ $stmt=$pdo->prepare('INSERT INTO contact_messages (name,phone,email,subject,message) VALUES (:n,:p,:e,:s,:m)'); $stmt->execute([':n'=>$name,':p'=>$phone,':e'=>$email?:null,':s'=>$subject?:null,':m'=>$msg]); }catch(Throwable $e){}
      }
      @file_put_contents(__DIR__.'/uploads/contact.log', date('Y-m-d H:i:s')." | $name | $phone | $subject | $msg\n", FILE_APPEND);
      $success='Thank you — your message was sent to the school office. We will reply by phone if needed.';
    }
  }
}
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Contact</span><h1 style="color:#fff;margin:14px 0 10px">Visit, call or message</h1><p class="lead" style="color:#C7D7F0;max-width:640px">Malangwa-2, Sarlahi — VH24+22W · 26.8501032, 85.555064</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Contact</span></div></nav>
<section class="section" style="padding-top:20px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div class="contact-grid">
      <div class="map-wrap"><iframe src="https://www.google.com/maps?q=<?= e_attr(APP_MAP_QUERY) ?>&z=16&output=embed&hl=en" title="Map" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe><a class="map-fab" href="https://www.google.com/maps/search/?api=1&query=<?= e_attr(APP_MAP_QUERY) ?>" target="_blank" rel="noopener"><svg class="ic"><use href="#i-pin"/></svg> Get Directions — VH24+22W</a></div>
      <div>
        <div class="contact-cards">
          <div class="c-card"><span class="c-icon"><svg class="ic"><use href="#i-pin"/></svg></span><div><h4>Address</h4><p>Shree Public Secondary School<br>Malangwa-2, Sarlahi, Madhesh 45800, Nepal<br><span style="font-size:.82rem;color:var(--primary)">VH24+22W · 26.8501032, 85.555064</span></p></div></div>
          <div class="c-card"><span class="c-icon"><svg class="ic"><use href="#i-phone"/></svg></span><div><h4>Call</h4><?php if(APP_PHONE): ?><a class="tel" href="tel:<?= e_attr(APP_PHONE) ?>"><?= e(APP_PHONE) ?></a><?php else: ?><p><em>To be verified — use form below.</em></p><?php endif; ?></div></div>
          <div class="c-card"><span class="c-icon gold"><svg class="ic"><use href="#i-mail"/></svg></span><div><h4>Email</h4><p><?= APP_EMAIL?e(APP_EMAIL):'<em>To be confirmed</em>' ?></p></div></div>
          <div class="c-card"><span class="c-icon gold"><svg class="ic"><use href="#i-clock"/></svg></span><div><h4>Office Hours</h4><p><?= APP_OFFICE_HOURS?e(APP_OFFICE_HOURS):'<em>To be confirmed — call office</em>' ?></p></div></div>
        </div>
      </div>
    </div>
    <div style="max-width:720px;margin:24px auto 0">
      <?php if($success): ?><div style="background:var(--success-50);border:1px solid #A7F3D0;color:var(--success);padding:14px 16px;border-radius:12px;font-weight:600"><?= e($success) ?></div><?php endif; ?>
      <?php if($error): ?><div style="background:var(--red-50);border:1px solid #FECACA;color:var(--red);padding:14px 16px;border-radius:12px;font-weight:600"><?= e($error) ?></div><?php endif; ?>
      <form method="post" class="adm-form" style="margin-top:14px">
        <?= csrf_field() ?>
        <h3>Send a message</h3><p style="color:var(--muted);font-size:.88rem;margin:6px 0 14px">Spam-protected. Messages go to Admin → Communication → Contact Messages. Not shown publicly.</p>
        <div class="form-grid">
          <div class="field"><label>Name <span class="req">*</span></label><input type="text" name="name" required value="<?= e($_POST['name']??'') ?>"></div>
          <div class="field"><label>Phone <span class="req">*</span></label><input type="tel" name="phone" required value="<?= e($_POST['phone']??'') ?>"></div>
          <div class="field full"><label>Email (optional)</label><input type="email" name="email" value="<?= e($_POST['email']??'') ?>"></div>
          <div class="field full"><label>Subject</label><input type="text" name="subject" value="<?= e($_POST['subject']??'') ?>"></div>
          <div class="field full"><label>Message <span class="req">*</span></label><textarea name="message" required><?= e($_POST['message']??'') ?></textarea></div>
          <div class="full"><button class="btn btn-primary btn-lg" style="width:100%" type="submit">Send Message <svg class="ic"><use href="#i-arrow"/></svg></button></div>
        </div>
      </form>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
