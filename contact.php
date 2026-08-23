<?php $page='contact'; $title='Contact — Visit, Call or Message | Shree Public Secondary School'; $description='Contact Shree Public Secondary School, Malangwa-2 — location VH24+22W, map directions, office hours and message form.'; require_once __DIR__.'/includes/header.php';
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
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Contact</span><h1 style="color:#fff;margin:14px 0 10px">Visit, call or message</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Malangwa-2, Sarlahi — Plus Code VH24+22W (26.8501032 N, 85.555064 E) · Madhesh Province 45800. Map, address, contacts and who to ask for what.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Contact</span></div></nav>

<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div class="contact-grid">
      <div class="map-wrap"><iframe src="https://www.google.com/maps?q=<?= e_attr(APP_MAP_QUERY) ?>&z=16&output=embed&hl=en" title="Map — Shree Public Secondary School, Malangwa-2 (VH24+22W)" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe><a class="map-fab" href="https://www.google.com/maps/search/?api=1&query=<?= e_attr(APP_MAP_QUERY) ?>" target="_blank" rel="noopener"><svg class="ic"><use href="#i-pin"/></svg> Get Directions — VH24+22W</a></div>
      <div>
        <h2 style="font-size:1.15rem">School location</h2>
        <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.6">Use the Plus Code <strong style="color:var(--text)">VH24+22W</strong> in Google Maps, or coordinates 26.8501032 N, 85.555064 E.</p>
        <div class="contact-cards" style="margin-top:14px">
          <div class="c-card"><span class="c-icon"><svg class="ic"><use href="#i-pin"/></svg></span><div><h4>Address</h4><p>Shree Public Secondary School<br>Malangwa-2, Sarlahi, Madhesh Province 45800, Nepal<br><span style="font-size:.82rem;color:var(--primary)">VH24+22W · 26.8501032 N, 85.555064 E</span></p></div></div>
          <div class="c-card"><span class="c-icon"><svg class="ic"><use href="#i-phone"/></svg></span><div><h4>Call</h4><?php if(APP_PHONE): ?><a class="tel" href="tel:<?= e_attr(APP_PHONE) ?>"><?= e(APP_PHONE) ?></a><?php else: ?><p><em style="color:var(--muted)">Phone — to be verified by school. Use the message form below.</em></p><?php endif; ?><p style="font-size:.82rem;margin-top:6px;color:var(--muted)">Office hours: <?= APP_OFFICE_HOURS ? e(APP_OFFICE_HOURS) : '<em>to be confirmed — see office hours on this page when verified</em>' ?></p></div></div>
          <div class="c-card"><span class="c-icon gold"><svg class="ic"><use href="#i-mail"/></svg></span><div><h4>Email</h4><p><?= APP_EMAIL?e(APP_EMAIL):'<em>to be confirmed — not published until verified</em>' ?></p></div></div>
          <div class="c-card"><span class="c-icon gold"><svg class="ic"><use href="#i-clock"/></svg></span><div><h4>IEMIS Code</h4><p><strong>190640003</strong> — Public Educational Institution • Malangwa-2, Sarlahi</p></div></div>
        </div>
        <div style="display:flex;gap:10px;margin-top:14px;flex-wrap:wrap">
          <?php if(APP_PHONE): ?><a href="tel:<?= e_attr(APP_PHONE) ?>" class="btn btn-primary">Call School</a><?php endif; ?>
          <a href="https://www.google.com/maps/search/?api=1&query=<?= e_attr(APP_MAP_QUERY) ?>" target="_blank" rel="noopener" class="btn btn-ghost">Get Directions</a>
          <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-soft">Admission Inquiry</a>
        </div>
      </div>
    </div>

    <!-- Contact reasons -->
    <div style="max-width:900px;margin:24px auto 0;display:grid;gap:14px;grid-template-columns:repeat(auto-fit,minmax(240px,1fr))">
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px">
        <h3 style="font-size:1rem">Who to contact for what</h3>
        <p style="color:var(--muted);font-size:.84rem;margin-top:6px;line-height:1.6">Contact guidance — the office will direct you to the right person.</p>
        <ul style="margin-top:10px;display:flex;flex-direction:column;gap:6px;font-size:.86rem;color:var(--muted);line-height:1.6;list-style:none">
          <li><strong style="color:var(--text)">Admission information</strong> — eligibility, seats, fees, documents</li>
          <li><strong style="color:var(--text)">Academic queries</strong> — ECD to +2 programs, curriculum</li>
          <li><strong style="color:var(--text)">Examination information</strong> — routines, results, SEE / NEB</li>
          <li><strong style="color:var(--text)">Notices &amp; documents</strong> — official notices, citizen charter, publications</li>
          <li><strong style="color:var(--text)">General administration</strong> — office, hours, venue for community programmes</li>
        </ul>
      </div>
      <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px">
        <h3 style="font-size:1rem">Before you visit</h3>
        <ul style="margin-top:10px;display:flex;flex-direction:column;gap:8px;font-size:.84rem;color:var(--muted);line-height:1.6;list-style:none">
          <li style="display:flex;gap:8px"><svg class="ic" style="color:var(--success);margin-top:2px"><use href="#i-check"/></svg><span>Check the <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">Notice Board</a> for any holiday or closure notice.</span></li>
          <li style="display:flex;gap:8px"><svg class="ic" style="color:var(--success);margin-top:2px"><use href="#i-check"/></svg><span>Bring relevant documents if your query is about admission or results.</span></li>
          <li style="display:flex;gap:8px"><svg class="ic" style="color:var(--success);margin-top:2px"><use href="#i-check"/></svg><span>For admission, first review <a href="<?= e_attr(base_url('notices.php?category=admission')) ?>" style="color:var(--primary);font-weight:700">admission notices</a> — they contain dates and requirements.</span></li>
          <li style="display:flex;gap:8px"><svg class="ic" style="color:var(--success);margin-top:2px"><use href="#i-check"/></svg><span>No phone or email is published until verified by the school. The form below is the online channel.</span></li>
        </ul>
      </div>
    </div>

    <!-- FAQ mini -->
    <div style="max-width:900px;margin:14px auto 0;background:#fff;border:1px solid var(--border);border-radius:12px;padding:18px">
      <h3 style="font-size:1rem">Quick answers</h3>
      <div style="margin-top:12px;display:grid;gap:12px">
        <details style="background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px 14px"><summary style="font-weight:700;cursor:pointer">Where is the school located?</summary><p style="color:var(--muted);font-size:.88rem;margin-top:8px;line-height:1.6">Malangwa Municipality-2, Sarlahi, Madhesh Province 45800 — Plus Code VH24+22W (26.8501032 N, 85.555064 E). See map above or <a href="https://www.google.com/maps/search/?api=1&query=<?= e_attr(APP_MAP_QUERY) ?>" target="_blank" rel="noopener" style="color:var(--primary);font-weight:700">get directions</a>.</p></details>
        <details style="background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px 14px"><summary style="font-weight:700;cursor:pointer">What levels does the school teach?</summary><p style="color:var(--muted);font-size:.88rem;margin-top:8px;line-height:1.6">ECD through Grade 12, with +2 Science and +2 Management under NEB (see <a href="<?= e_attr(base_url('academics.php')) ?>" style="color:var(--primary);font-weight:700">Academics</a>).</p></details>
        <details style="background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px 14px"><summary style="font-weight:700;cursor:pointer">How do I confirm admission requirements?</summary><p style="color:var(--muted);font-size:.88rem;margin-top:8px;line-height:1.6">Check the <a href="<?= e_attr(base_url('notices.php?category=admission')) ?>" style="color:var(--primary);font-weight:700">latest admission notice</a> or contact the school via this form or an office visit. Do not rely on a previous year's notice.</p></details>
        <details style="background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px 14px"><summary style="font-weight:700;cursor:pointer">Are examination results available online?</summary><p style="color:var(--muted);font-size:.88rem;margin-top:8px;line-height:1.6">Published online results appear in <a href="<?= e_attr(base_url('results.php')) ?>" style="color:var(--primary);font-weight:700">Results</a> when made available. Official marksheets are verified through the school office.</p></details>
      </div>
      <p style="font-size:.82rem;color:var(--muted);margin-top:12px">More: <a href="<?= e_attr(base_url('faq.php')) ?>" style="color:var(--primary);font-weight:700">Full FAQ →</a></p>
    </div>

    <!-- Message form -->
    <div style="max-width:720px;margin:24px auto 0">
      <?php if($success): ?><div style="background:var(--success-50);border:1px solid #A7F3D0;color:var(--success);padding:14px 16px;border-radius:12px;font-weight:600"><?= e($success) ?></div><?php endif; ?>
      <?php if($error): ?><div style="background:var(--red-50);border:1px solid #FECACA;color:var(--red);padding:14px 16px;border-radius:12px;font-weight:600"><?= e($error) ?></div><?php endif; ?>
      <form method="post" class="adm-form" style="margin-top:14px">
        <?= csrf_field() ?>
        <h3>Send a message</h3><p style="color:var(--muted);font-size:.88rem;margin:6px 0 14px">Spam-protected. Messages go to <strong>Admin → Communication → Contact Messages</strong> and are not shown publicly. No response time is promised — the office replies when possible.</p>
        <div class="form-grid">
          <div class="field"><label>Name <span class="req">*</span></label><input type="text" name="name" required value="<?= e($_POST['name']??'') ?>" placeholder="Your full name"></div>
          <div class="field"><label>Phone <span class="req">*</span></label><input type="tel" name="phone" required value="<?= e($_POST['phone']??'') ?>" placeholder="98XXXXXXXX"></div>
          <div class="field full"><label>Email (optional)</label><input type="email" name="email" value="<?= e($_POST['email']??'') ?>" placeholder="you@example.com"></div>
          <div class="field full"><label>Subject</label><input type="text" name="subject" value="<?= e($_POST['subject']??'') ?>" placeholder="e.g. Admission inquiry for Grade 11"></div>
          <div class="field full"><label>Message <span class="req">*</span></label><textarea name="message" required placeholder="Your message…"><?= e($_POST['message']??'') ?></textarea></div>
          <div class="full"><button class="btn btn-primary btn-lg" style="width:100%" type="submit">Send Message <svg class="ic"><use href="#i-arrow"/></svg></button></div>
        </div>
      </form>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
