<?php $page='admissions'; $title='Admissions — ECD to +2 | Shree Public Secondary School, Malangwa-2'; $description='Admission information for Shree Public Secondary School Malangwa-2 — ECD to Grade 12, +2 Science & Management (NEB). Levels, general process, documents guidance and inquiry.'; require_once __DIR__.'/includes/helpers.php'; require_once __DIR__.'/includes/header.php'; 
$admPage = get_page_content('admissions');
$admissionNotices = array_filter(get_notices(50, 'admission'));
if (empty($admissionNotices)) { $allAdm = array_filter(get_notices(8), function($n){ return strtolower($n['category']??$n['cat_en']??'')==='admission'; }); $admissionNotices = $allAdm; }
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
      @file_put_contents(__DIR__.'/uploads/inquiries.log', date('Y-m-d H:i:s')." | $name | $phone | $level\n", FILE_APPEND);
      $success = 'Thank you. Your inquiry was received — the school office will contact you with current admission information.';
    }
  }
}
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Admissions</span><h1 style="color:#fff;margin:14px 0 10px">Admission Information</h1><p class="lead" style="color:#C7D7F0;max-width:680px">ECD to Grade 12, including +2 Science &amp; Management (NEB). Availability depends on academic year, grade and seats confirmed by the school office.</p><div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap"><span style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:999px;font-size:.8rem;color:#fff">1,000+ Students • ECD–12</span><span style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:999px;font-size:.8rem;color:#fff">IEMIS 190640003</span></div></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Admissions</span></div></nav>

<!-- Admission Overview + Steps -->
<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <span class="eyebrow"><span class="dot"></span> <?= e(t('Admission Overview','भर्ना अवलोकन')) ?></span>
    <h2 style="margin:12px 0 10px;font-size:1.35rem"><?= e(t('How admission works','भर्ना प्रक्रिया कसरी चल्छ')) ?></h2>
    <?php if ($admPage && trim(page_val($admPage,'content')) !== ''): ?>
      <div style="color:var(--muted);line-height:1.7;max-width:780px;font-size:.94rem"><?= page_val($admPage,'content') ?></div>
    <?php else: ?>
    <p style="color:var(--muted);line-height:1.7;max-width:780px;font-size:.94rem">Admission availability at Shree Public depends on the <strong style="color:var(--text)">academic year, grade and number of seats</strong> as determined each year by the school administration. For current dates, fees and document requirements — especially for Grade 11 (+2 Science / Management) — always refer to the <a href="<?= e_attr(base_url('notices.php?category=admission')) ?>" style="color:var(--primary);font-weight:700">latest admission notice</a> or contact the school directly at Malangwa-2. The information below is <strong>general guidance only</strong> and does not replace an official notice from the school office. No fee amount or deadline is published on this website until verified.</p>
    <?php endif; ?>

    <div style="display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));margin-top:18px">
      <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:18px"><div style="font-weight:800;font-size:1.6rem;color:var(--primary-100)">01</div><h3 style="font-size:1rem;margin-top:4px">Explore</h3><p style="color:var(--muted);font-size:.88rem;margin-top:4px;line-height:1.6">Learn the levels — ECD, Basic (1–8), Secondary (9–10) and +2 Science/Management — and where the school is located (VH24+22W).</p></div>
      <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:18px"><div style="font-weight:800;font-size:1.6rem;color:var(--primary-100)">02</div><h3 style="font-size:1rem;margin-top:4px">Check the latest notice</h3><p style="color:var(--muted);font-size:.88rem;margin-top:4px;line-height:1.6">Review the current admission notice on the Notice Board for dates, eligibility, seats and instructions.</p></div>
      <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:18px"><div style="font-weight:800;font-size:1.6rem;color:var(--primary-100)">03</div><h3 style="font-size:1rem;margin-top:4px">Contact / Visit</h3><p style="color:var(--muted);font-size:.88rem;margin-top:4px;line-height:1.6">Visit Malangwa-2 or use the inquiry form below for fees, documents and verification steps.</p></div>
      <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:18px"><div style="font-weight:800;font-size:1.6rem;color:var(--primary-100)">04</div><h3 style="font-size:1rem;margin-top:4px">Apply</h3><p style="color:var(--muted);font-size:.88rem;margin-top:4px;line-height:1.6">Submit the admission form and required documents as directed by the office and receive confirmation.</p></div>
    </div>
    <div class="verify-banner"><svg class="ic"><use href="#i-info"/></svg><span>General guidance only. Admission dates, fees, document list and scholarship quotas are set by the school office — no fee is published until verified. Always confirm with the latest official notice.</span></div>
  </div>
</section>

<!-- Academic Levels + General Process -->
<section class="section" style="background:var(--bg)">
  <div class="wrap" style="display:grid;gap:18px;grid-template-columns:1fr 1fr">
    <!-- Levels -->
    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:20px">
      <h3 style="font-size:1.05rem">Academic levels — where you can enrol</h3>
      <p style="color:var(--muted);font-size:.84rem;margin-top:6px">Possible enrollment levels depending on year and seats. Not every grade has vacancies every year.</p>
      <div style="display:flex;flex-direction:column;gap:10px;margin-top:14px">
        <div style="display:flex;gap:12px;align-items:flex-start;background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px"><span style="width:36px;height:36px;border-radius:8px;background:var(--primary);color:#fff;display:grid;place-items:center;flex:none"><svg class="ic"><use href="#i-star"/></svg></span><div><h4 style="font-size:.92rem">ECD / Nursery</h4><p style="font-size:.82rem;color:var(--muted);margin-top:4px;line-height:1.6">Early childhood — entry to basic education. Contact office for age guidance where applicable.</p></div></div>
        <div style="display:flex;gap:12px;align-items:flex-start;background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px"><span style="width:36px;height:36px;border-radius:8px;background:var(--surface-tint);color:#fff;display:grid;place-items:center;flex:none"><svg class="ic"><use href="#i-book"/></svg></span><div><h4 style="font-size:.92rem">Basic Level — Grades 1–8</h4><p style="font-size:.82rem;color:var(--muted);margin-top:4px;line-height:1.6">Primary (1–5) and Lower Secondary (6–8). Continuous eight-year progression on the same campus.</p></div></div>
        <div style="display:flex;gap:12px;align-items:flex-start;background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px"><span style="width:36px;height:36px;border-radius:8px;background:var(--primary-container);color:#fff;display:grid;place-items:center;flex:none"><svg class="ic"><use href="#i-grad"/></svg></span><div><h4 style="font-size:.92rem">Secondary — Grades 9–10 (SEE)</h4><p style="font-size:.82rem;color:var(--muted);margin-top:4px;line-height:1.6">Secondary pathway culminating in SEE at end of Grade 10.</p></div></div>
        <div style="display:flex;gap:12px;align-items:flex-start;background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px"><span style="width:36px;height:36px;border-radius:8px;background:var(--heritage-gold);color:var(--primary);display:grid;place-items:center;flex:none"><svg class="ic"><use href="#i-flask"/></svg></span><div><h4 style="font-size:.92rem">Grade 11 &amp; 12 — +2 Science / Management (NEB)</h4><p style="font-size:.82rem;color:var(--muted);margin-top:4px;line-height:1.6">Higher secondary under NEB. Subject combinations confirmed annually. See <a href="<?= e_attr(base_url('academics.php#plus2-detail')) ?>" style="color:var(--primary);font-weight:700">Academics → +2</a> and linked stream pages.</p></div></div>
      </div>
      <p style="font-size:.78rem;color:var(--muted-2);margin-top:10px"><em>Grade 12 admission (transfer) availability varies by year and NEB rules — confirm with office.</em></p>
    </div>

    <!-- General Application Process -->
    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:20px">
      <h3 style="font-size:1.05rem">General application process</h3>
      <p style="color:var(--muted);font-size:.84rem;margin-top:6px">Illustrative general steps. The school's actual procedure for the current year takes precedence.</p>
      <ol style="margin-top:14px;display:flex;flex-direction:column;gap:10px;list-style:none;counter-reset:adm">
        <li style="display:flex;gap:12px;align-items:flex-start"><span style="width:28px;height:28px;border-radius:50%;background:var(--primary);color:#fff;display:grid;place-items:center;font-weight:700;font-size:.8rem;flex:none">1</span><div><h4 style="font-size:.92rem">Review the current admission notice</h4><p style="font-size:.84rem;color:var(--muted);margin-top:4px;line-height:1.6">Check <a href="<?= e_attr(base_url('notices.php?category=admission')) ?>" style="color:var(--primary);font-weight:700">Notice Board → Admission</a> for eligibility, seats and deadline.</p></div></li>
        <li style="display:flex;gap:12px;align-items:flex-start"><span style="width:28px;height:28px;border-radius:50%;background:var(--primary);color:#fff;display:grid;place-items:center;font-weight:700;font-size:.8rem;flex:none">2</span><div><h4 style="font-size:.92rem">Contact or visit the school</h4><p style="font-size:.84rem;color:var(--muted);margin-top:4px;line-height:1.6">Visit Malangwa-2 or message the office to confirm availability, fees and requirements.</p></div></li>
        <li style="display:flex;gap:12px;align-items:flex-start"><span style="width:28px;height:28px;border-radius:50%;background:var(--primary);color:#fff;display:grid;place-items:center;font-weight:700;font-size:.8rem;flex:none">3</span><div><h4 style="font-size:.92rem">Collect and submit required documents</h4><p style="font-size:.84rem;color:var(--muted);margin-top:4px;line-height:1.6">Forms and documents as listed in the notice (see guidance below).</p></div></li>
        <li style="display:flex;gap:12px;align-items:flex-start"><span style="width:28px;height:28px;border-radius:50%;background:var(--primary);color:#fff;display:grid;place-items:center;font-weight:700;font-size:.8rem;flex:none">4</span><div><h4 style="font-size:.92rem">Verification (academic / administrative)</h4><p style="font-size:.84rem;color:var(--muted);margin-top:4px;line-height:1.6">Office verifies records; Grade 11 applicants may have additional eligibility checks per NEB rules.</p></div></li>
        <li style="display:flex;gap:12px;align-items:flex-start"><span style="width:28px;height:28px;border-radius:50%;background:var(--success);color:#fff;display:grid;place-items:center;font-weight:700;font-size:.8rem;flex:none">5</span><div><h4 style="font-size:.92rem">Receive admission confirmation</h4><p style="font-size:.84rem;color:var(--muted);margin-top:4px;line-height:1.6">Confirmed by the school office once verification is complete.</p></div></li>
      </ol>
      <div style="margin-top:14px;background:var(--gold-50);border:1px dashed #E9C35E;border-radius:10px;padding:12px;font-size:.82rem;color:#6B4F00;line-height:1.6">This is <strong>general guidance only</strong>. If the published admission notice differs, the notice applies.</div>
    </div>
  </div>
</section>

<!-- Documents guidance + Notices pull -->
<section class="section" style="background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
  <div class="wrap" style="display:grid;gap:18px;grid-template-columns:1fr 1fr">
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:20px">
      <h3 style="font-size:1.05rem">Commonly requested documents — guidance only</h3>
      <p style="font-size:.82rem;color:var(--muted);margin-top:6px;line-height:1.6"><strong style="color:var(--text)">Not official requirements.</strong> Depending on the grade and current school requirements, applicants <em>may be asked to provide</em> documents such as those below. Final list is set by the school office and published in the admission notice.</p>
      <ul style="margin-top:14px;display:grid;gap:8px;grid-template-columns:1fr 1fr;list-style:none">
        <li style="display:flex;gap:8px;align-items:flex-start;font-size:.88rem;color:var(--muted)"><svg class="ic" style="color:var(--success);margin-top:2px"><use href="#i-check"/></svg><span>Birth registration / age document</span></li>
        <li style="display:flex;gap:8px;align-items:flex-start;font-size:.88rem;color:var(--muted)"><svg class="ic" style="color:var(--success);margin-top:2px"><use href="#i-check"/></svg><span>Previous academic records / grade sheet</span></li>
        <li style="display:flex;gap:8px;align-items:flex-start;font-size:.88rem;color:var(--muted)"><svg class="ic" style="color:var(--success);margin-top:2px"><use href="#i-check"/></svg><span>Transfer / character certificate (where applicable)</span></li>
        <li style="display:flex;gap:8px;align-items:flex-start;font-size:.88rem;color:var(--muted)"><svg class="ic" style="color:var(--success);margin-top:2px"><use href="#i-check"/></svg><span>Passport-size photographs</span></li>
        <li style="display:flex;gap:8px;align-items:flex-start;font-size:.88rem;color:var(--muted)"><svg class="ic" style="color:var(--success);margin-top:2px"><use href="#i-check"/></svg><span>Guardian identification</span></li>
        <li style="display:flex;gap:8px;align-items:flex-start;font-size:.88rem;color:var(--muted)"><svg class="ic" style="color:var(--success);margin-top:2px"><use href="#i-check"/></svg><span>Other documents as specified in notice</span></li>
      </ul>
      <p style="font-size:.82rem;color:var(--primary);margin-top:12px;font-weight:600">Please confirm the actual required documents with the school before preparing your application.</p>
    </div>
    <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:20px">
      <h3 style="font-size:1.05rem">Latest admission notices</h3>
      <p style="font-size:.82rem;color:var(--muted);margin-top:6px">Pulled automatically from the Notice Board (category: Admission).</p>
      <div style="display:flex;flex-direction:column;gap:10px;margin-top:14px">
        <?php if(empty($admissionNotices)): ?>
          <div class="empty" style="padding:18px"><svg class="ic"><use href="#i-info"/></svg><h4>No admission notice right now</h4><p>When the school office publishes an admission notice it will appear here and on the Notice Board. Meanwhile, use the inquiry form below.</p></div>
        <?php else: foreach(array_slice($admissionNotices,0,3) as $n): $d=strtotime($n['published_at']); $ttl=(current_lang()==='np'&&!empty($n['title_np']))?$n['title_np']:$n['title_en']; ?>
          <a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>" style="background:#fff;border:1px solid var(--border);border-radius:10px;padding:12px;display:flex;gap:12px;align-items:flex-start">
            <span style="width:46px;height:46px;border-radius:8px;background:var(--primary);color:#fff;display:flex;flex-direction:column;align-items:center;justify-content:center;flex:none"><span style="font-weight:700;font-size:.9rem;line-height:1"><?= date('d',$d) ?></span><span style="font-size:.6rem;opacity:.85"><?= date('M',$d) ?></span></span>
            <span style="flex:1;min-width:0"><span style="font-weight:700;font-size:.9rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden"><?= e($ttl) ?></span><span style="font-size:.78rem;color:var(--muted)">Ref: <?= e($n['reference_number']??'—') ?> • <?= e(date('M j, Y',$d)) ?></span></span><span style="color:var(--primary);font-weight:700;flex:none">→</span>
          </a>
        <?php endforeach; endif; ?>
      </div>
      <div style="margin-top:14px;display:flex;gap:8px;flex-wrap:wrap">
        <a href="<?= e_attr(base_url('notices.php?category=admission')) ?>" class="btn btn-soft">View all admission notices →</a>
        <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-ghost">Admission forms</a>
      </div>
    </div>
  </div>
</section>

<!-- Inquiry form -->
<section class="section" style="background:var(--bg)">
  <div class="wrap">
    <div style="max-width:760px;margin:0 auto">
      <?php if(!empty($success)): ?><div style="background:var(--success-50);border:1px solid #A7F3D0;color:var(--success);padding:14px 16px;border-radius:12px;font-weight:600"><?= e($success) ?></div><?php endif; ?>
      <?php if(!empty($error)): ?><div style="background:var(--red-50);border:1px solid #FECACA;color:var(--red);padding:14px 16px;border-radius:12px;font-weight:600"><?= e($error) ?></div><?php endif; ?>
      <form method="post" class="adm-form" novalidate style="margin-top:14px">
        <?= csrf_field() ?>
        <h3>Admission Inquiry</h3><p style="color:var(--muted);font-size:.88rem;margin:6px 0 14px">Tell us which level and your phone — the office will reply with current details. Messages are stored in Admin → Communication.</p>
        <div class="form-grid">
          <div class="field"><label for="a-name">Parent / Guardian Name <span class="req">*</span></label><input type="text" id="a-name" name="name" required placeholder="Your full name" value="<?= e($_POST['name']??'') ?>"></div>
          <div class="field"><label for="a-phone">Phone <span class="req">*</span></label><input type="tel" id="a-phone" name="phone" required placeholder="98XXXXXXXX" value="<?= e($_POST['phone']??'') ?>"></div>
          <div class="field full"><label for="a-level">Admission Level <span class="req">*</span></label><select id="a-level" name="level" required><option value="" disabled <?= empty($_POST['level'])?'selected':'' ?>>Select a level</option><option value="ECD / Nursery" <?= ($_POST['level']??'')==='ECD / Nursery'?'selected':'' ?>>ECD / Nursery</option><option value="Basic Level — Grades 1–5" <?= ($_POST['level']??'')==='Basic Level — Grades 1–5'?'selected':'' ?>>Basic Level — Grades 1–5</option><option value="Basic Level — Grades 6–8" <?= ($_POST['level']??'')==='Basic Level — Grades 6–8'?'selected':'' ?>>Basic Level — Grades 6–8</option><option value="Secondary — Grades 9–10 (SEE)" <?= ($_POST['level']??'')==='Secondary — Grades 9–10 (SEE)'?'selected':'' ?>>Secondary — Grades 9–10 (SEE)</option><option value="+2 Science (Class 11–12, NEB)" <?= ($_POST['level']??'')==='+2 Science (Class 11–12, NEB)'?'selected':'' ?>>+2 Science (Class 11–12, NEB)</option><option value="+2 Management (Class 11–12, NEB)" <?= ($_POST['level']??'')==='+2 Management (Class 11–12, NEB)'?'selected':'' ?>>+2 Management (Class 11–12, NEB)</option><option value="Not sure yet — need guidance" <?= ($_POST['level']??'')==='Not sure yet — need guidance'?'selected':'' ?>>Not sure yet — need guidance</option></select></div>
          <div class="full"><button type="submit" class="btn btn-primary btn-lg" style="width:100%">Send Admission Inquiry <svg class="ic"><use href="#i-arrow"/></svg></button><p style="font-size:.78rem;color:var(--muted);margin-top:10px;display:flex;gap:6px"><svg class="ic"><use href="#i-info"/></svg> This goes to the school office inbox (contact_messages). No data is shown publicly. Response by phone when office confirms availability.</p></div>
        </div>
      </form>

      <!-- Downloads CTA + Contact CTA -->
      <div style="display:grid;gap:12px;grid-template-columns:1fr 1fr;margin-top:16px">
        <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px"><h4 style="font-size:.92rem">Admission downloads</h4><p style="color:var(--muted);font-size:.84rem;margin-top:4px;line-height:1.6">Forms and guidelines — when available, published in the Downloads centre under Admissions.</p><a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700;font-size:.88rem;margin-top:8px;display:inline-flex">Browse Downloads →</a></div>
        <div style="background:var(--primary-dark);color:#C7D7F0;border-radius:12px;padding:16px"><h4 style="color:#fff;font-size:.92rem">Need to confirm directly?</h4><p style="color:#93B4D8;font-size:.84rem;margin-top:4px;line-height:1.6">Visit Malangwa-2 (VH24+22W) or message the school. Office hours are posted on the Contact page when verified.</p><a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-gold" style="margin-top:10px">Contact School →</a></div>
      </div>

      <div style="margin-top:16px;background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:14px;display:flex;gap:10px">
        <svg class="ic" style="color:var(--primary);margin-top:2px"><use href="#i-info"/></svg>
        <p style="font-size:.82rem;color:var(--muted);line-height:1.6"><strong>Related:</strong> <a href="<?= e_attr(base_url('academics.php')) ?>" style="color:var(--primary);font-weight:700">Academics</a> · <a href="<?= e_attr(base_url('science.php')) ?>" style="color:var(--primary);font-weight:700">+2 Science</a> · <a href="<?= e_attr(base_url('management.php')) ?>" style="color:var(--primary);font-weight:700">+2 Management</a> · <a href="<?= e_attr(base_url('scholarships.php')) ?>" style="color:var(--primary);font-weight:700">Scholarships</a> · <a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700">Downloads</a></p>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
