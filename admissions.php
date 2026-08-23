<?php $page='admissions'; $title='Admissions — ECD to +2'; require_once __DIR__.'/includes/header.php'; 
if ($_SERVER['REQUEST_METHOD']==='POST') {
  if (!csrf_verify($_POST['_csrf'] ?? '')) { $error='Invalid session. Please refresh.'; }
  elseif (!rate_limit('admission_'.($_SERVER['REMOTE_ADDR']??'anon'), 3, 300)) { $error='Too many submissions. Please try later.'; }
  else {
    $name=trim($_POST['name']??''); $phone=trim($_POST['phone']??''); $level=trim($_POST['level']??'');
    if (mb_strlen($name)<2 || !preg_match('/^[+]?[0-9][0-9\s\-]{6,14}$/',$phone) || !$level) { $error='Please fill all required fields correctly.'; }
    else {
      $pdo=db(); if($pdo && db_has_table('contact_messages')){
        try{ $stmt=$pdo->prepare('INSERT INTO contact_messages (name,phone,subject,message) VALUES (:n,:p,:s,:m)'); $stmt->execute([':n'=>$name,':p'=>$phone,':s'=>'Admission inquiry: '.$level,':m'=>'Level: '.$level]); }catch(Throwable $e){}
      }
      // log to file fallback
      @file_put_contents(__DIR__.'/uploads/inquiries.log', date('Y-m-d H:i:s')." | $name | $phone | $level\n", FILE_APPEND);
      $success = 'Thank you. Your inquiry was received — the school office will contact you with current admission information.';
    }
  }
}
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Admissions</span><h1 style="color:#fff;margin:14px 0 10px">How admission works</h1><p class="lead" style="color:#C7D7F0;max-width:640px">Four clear steps — from exploring to visiting Malangwa-2 and applying with verified documents.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Admissions</span></div></nav>
<section class="section" style="padding-top:20px">
  <div class="wrap">
    <div style="display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));margin-bottom:18px">
      <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:18px"><div style="font-weight:800;font-size:1.6rem;color:var(--primary-100)">01</div><h3 style="font-size:1rem">Explore</h3><p style="color:var(--muted);font-size:.88rem;margin-top:4px">Learn ECD→12, +2 Science/Management, location VH24+22W.</p></div>
      <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:18px"><div style="font-weight:800;font-size:1.6rem;color:var(--primary-100)">02</div><h3 style="font-size:1rem">Inquire</h3><p style="color:var(--muted);font-size:.88rem;margin-top:4px">Contact office — early years, basic, secondary or +2.</p></div>
      <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:18px"><div style="font-weight:800;font-size:1.6rem;color:var(--primary-100)">03</div><h3 style="font-size:1rem">Visit</h3><p style="color:var(--muted);font-size:.88rem;margin-top:4px">Visit Malangwa-2 for verified fees and documents.</p></div>
      <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:18px"><div style="font-weight:800;font-size:1.6rem;color:var(--primary-100)">04</div><h3 style="font-size:1rem">Apply</h3><p style="color:var(--muted);font-size:.88rem;margin-top:4px">Submit verified admission form and required documents.</p></div>
    </div>
    <div class="verify-banner"><svg class="ic"><use href="#i-info"/></svg><span>Admission dates, fees, document list and scholarships are set by the school office. No fee is published until verified.</span></div>

    <div style="display:grid;gap:20px;grid-template-columns:1fr;max-width:760px;margin:22px auto 0">
      <?php if(!empty($success)): ?><div style="background:var(--success-50);border:1px solid #A7F3D0;color:var(--success);padding:14px 16px;border-radius:12px;font-weight:600"><?= e($success) ?></div><?php endif; ?>
      <?php if(!empty($error)): ?><div style="background:var(--red-50);border:1px solid #FECACA;color:var(--red);padding:14px 16px;border-radius:12px;font-weight:600"><?= e($error) ?></div><?php endif; ?>
      <form method="post" class="adm-form" novalidate>
        <?= csrf_field() ?>
        <h3>Admission Inquiry</h3><p style="color:var(--muted);font-size:.88rem;margin:6px 0 14px">Tell us which level and your phone — office will reply with current details.</p>
        <div class="form-grid">
          <div class="field"><label for="a-name">Parent / Guardian Name <span class="req">*</span></label><input type="text" id="a-name" name="name" required placeholder="Your full name" value="<?= e($_POST['name']??'') ?>"></div>
          <div class="field"><label for="a-phone">Phone <span class="req">*</span></label><input type="tel" id="a-phone" name="phone" required placeholder="984..." value="<?= e($_POST['phone']??'') ?>"></div>
          <div class="field full"><label for="a-level">Admission Level <span class="req">*</span></label><select id="a-level" name="level" required><option value="" disabled <?= empty($_POST['level'])?'selected':'' ?>>Select a level</option><option <?= ($_POST['level']??'')==='ECD / Nursery'?'selected':'' ?>>ECD / Nursery</option><option>Basic Level — Grades 1–5</option><option>Basic Level — Grades 6–8</option><option>Secondary — Grades 9–10 (SEE)</option><option>+2 Science (Class 11–12, NEB)</option><option>+2 Management (Class 11–12, NEB)</option><option>Not sure yet — need guidance</option></select></div>
          <div class="full"><button type="submit" class="btn btn-primary btn-lg" style="width:100%">Send Admission Inquiry <svg class="ic"><use href="#i-arrow"/></svg></button><p style="font-size:.78rem;color:var(--muted);margin-top:10px;display:flex;gap:6px"><svg class="ic"><use href="#i-info"/></svg> This goes to the school office inbox (contact_messages). No data is shown publicly.</p></div>
        </div>
      </form>
      <div style="display:grid;gap:12px;grid-template-columns:1fr 1fr">
        <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:14px"><h4>Documents (TBC)</h4><p style="color:var(--muted);font-size:.84rem;margin-top:4px">Typically: birth certificate, previous grade sheet, photos. Final list from office.</p></div>
        <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:14px"><h4>Scholarships</h4><p style="color:var(--muted);font-size:.84rem;margin-top:4px">See <a href="<?= e_attr(base_url('scholarships.php')) ?>" style="color:var(--primary);font-weight:700">Scholarships</a> for verified notices.</p></div>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
