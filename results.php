<?php $page='results'; $title='Results — Published Examination Results | Shree Public Secondary School'; $description='Published examination results for Shree Public Secondary School, Malangwa-2. SEE, Grade 11 and Grade 12 (NEB), internal and terminal examinations — verification guidance.'; require_once __DIR__.'/includes/header.php';
$result=null; $error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(!csrf_verify($_POST['_csrf']??'')) $error='Invalid session.';
  else {
    $symbol=trim($_POST['symbol']??''); $year=trim($_POST['year']??'');
    if($symbol==='') $error='Enter symbol / roll number.';
    else {
      $pdo=db();
      if($pdo && db_has_table('student_results')){
        try{
          $stmt=$pdo->prepare('SELECT r.*, e.class_name, e.academic_year FROM student_results r JOIN exams e ON e.id=r.exam_id WHERE r.symbol_no=:s LIMIT 1');
          $stmt->execute([':s'=>$symbol]);
          $result=$stmt->fetch();
          if(!$result) $error='No result found for symbol '.htmlspecialchars($symbol).'. Check number or contact office.';
        }catch(Throwable $e){ $error='Search unavailable. Try later.'; }
      } else {
        if($symbol==='12345') $result=['symbol_no'=>'12345','student_name'=>'Sample Student','class_name'=>'Grade 12','academic_year'=>'2081','grade'=>'B+','gpa'=>3.2];
        else $error='Demo mode — try symbol 12345 or enable DB. Real results are private per symbol.';
      }
    }
  }
}
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Results</span><h1 style="color:#fff;margin:14px 0 10px">Results Centre</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Published examination results — internal, terminal and board examinations. Only your result is shown per search. Official marksheets are verified through the school office.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Results</span></div></nav>

<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="display:grid;gap:20px;grid-template-columns:1fr">
    <!-- Intro -->
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)">How results are published:</strong> When the school or board publishes results, they are made available here — as a symbol / roll-number search or as downloadable PDF lists in Downloads. No full public database of students is exposed. Use the search below or browse <a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700">Downloads → Results</a> for any published PDFs. For official marksheet verification, contact the school office directly.</div>
    </div>

    <div style="display:grid;gap:20px;grid-template-columns:1fr 1fr;align-items:start">
      <!-- Result Search -->
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px">
        <h2 style="font-size:1.05rem">Result Search</h2>
        <p style="color:var(--muted);font-size:.84rem;margin-top:6px">Enter symbol / roll number. Only the matching record is returned. No addresses or contacts are exposed.</p>
        <form method="post" class="adm-form" style="margin-top:14px;box-shadow:none">
          <?= csrf_field() ?>
          <div class="form-grid">
            <div class="field full"><label>Symbol / Roll Number <span class="req">*</span></label><input type="text" name="symbol" required placeholder="e.g. 12345" value="<?= e($_POST['symbol']??'') ?>"></div>
            <div class="field"><label>Academic Year</label><select name="year"><option value="">Select year</option><option value="2082">2082</option><option value="2081" selected>2081</option><option value="2080">2080</option></select></div>
            <div class="field"><label>Class</label><select name="class"><option value="">Select class</option><option>Grade 10 (SEE)</option><option>Grade 12</option><option>Grade 11</option><option>Internal Examination</option></select></div>
            <div class="full"><button class="btn btn-primary btn-lg" style="width:100%" type="submit"><svg class="ic"><use href="#i-search"/></svg> Search Result</button></div>
          </div>
          <?php if($error): ?><div style="background:var(--red-50);border:1px solid #FECACA;color:var(--red);padding:10px 12px;border-radius:10px;margin-top:12px"><?= e($error) ?></div><?php endif; ?>
          <?php if($result): ?><div style="background:var(--success-50);border:1px solid #A7F3D0;padding:16px;border-radius:12px;margin-top:14px"><h3 style="font-size:1rem">Result Found</h3><table style="margin-top:10px;width:100%;font-size:.92rem"><tr><td style="padding:6px 0;color:var(--muted)">Symbol</td><td style="padding:6px 0;font-weight:700"><?= e($result['symbol_no']) ?></td></tr><tr><td style="padding:6px 0;color:var(--muted)">Name</td><td style="padding:6px 0;font-weight:700"><?= e($result['student_name']) ?></td></tr><tr><td style="padding:6px 0;color:var(--muted)">Class / Year</td><td style="padding:6px 0"><?= e($result['class_name']) ?> • <?= e($result['academic_year']) ?></td></tr><tr><td style="padding:6px 0;color:var(--muted)">Grade / GPA</td><td style="padding:6px 0;font-weight:700"><?= e($result['grade'] ?? '-') ?> <?= isset($result['gpa'])?'• '.e((string)$result['gpa']):'' ?></td></tr></table><p style="font-size:.78rem;color:var(--muted);margin-top:10px">Online display is for information only. The official marksheet issued by the school / board is the authoritative record.</p></div><?php endif; ?>
          <p style="font-size:.82rem;color:var(--muted);margin-top:10px;display:flex;gap:6px"><svg class="ic"><use href="#i-info"/></svg> Privacy: only the matching record is returned. Try Demo symbol <code style="background:#fff;border:1px solid var(--border);padding:2px 6px;border-radius:6px">12345</code> if DB is not configured.</p>
        </form>
      </div>

      <!-- Categories + Important info -->
      <div style="display:flex;flex-direction:column;gap:14px">
        <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:18px">
          <h3 style="font-size:1rem">Result categories</h3>
          <p style="color:var(--muted);font-size:.84rem;margin-top:6px;line-height:1.6">Published results — when available — fall into these categories. Each is also listed in Downloads and the Notice Board where applicable. No results are fabricated.</p>
          <div style="display:grid;gap:8px;grid-template-columns:1fr 1fr;margin-top:12px">
            <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px"><h4 style="font-size:.88rem">Internal Examination</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px">Unit / periodic tests</p></div>
            <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px"><h4 style="font-size:.88rem">Terminal Examination</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px">Term-end assessments</p></div>
            <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px"><h4 style="font-size:.88rem">Annual Examination</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px">Year-end (Grades 1–9)</p></div>
            <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px"><h4 style="font-size:.88rem">SEE-related information</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px">Grade 10</p></div>
            <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px"><h4 style="font-size:.88rem">Grade 11</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px">+2 — internal &amp; board</p></div>
            <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:12px"><h4 style="font-size:.88rem">Grade 12</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px">NEB board results</p></div>
          </div>
          <div style="margin-top:12px;display:flex;flex-wrap:wrap;gap:8px">
            <a href="<?= e_attr(base_url('notices.php?category=results')) ?>" class="btn btn-soft" style="font-size:.84rem">Result Notices</a>
            <a href="<?= e_attr(base_url('notices.php?category=examination')) ?>" class="btn btn-ghost" style="font-size:.84rem">Exam Notices</a>
            <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-ghost" style="font-size:.84rem">Download PDFs</a>
          </div>
        </div>
        <div style="background:var(--primary-dark);color:#C7D7F0;border-radius:12px;padding:18px">
          <h3 style="color:#fff;font-size:1rem">Important information</h3>
          <ul style="margin-top:10px;display:flex;flex-direction:column;gap:8px;font-size:.88rem;line-height:1.6;list-style:none">
            <li style="display:flex;gap:10px"><span style="color:#93B4D8"><svg class="ic"><use href="#i-check"/></svg></span><span>Online results are for quick information only. Always verify from the official marksheet / grade sheet issued by the school or the National Examinations Board.</span></li>
            <li style="display:flex;gap:10px"><span style="color:#93B4D8"><svg class="ic"><use href="#i-check"/></svg></span><span>For re-totaling, corrections or duplicate marksheets, contact the school office directly with your symbol number and year.</span></li>
            <li style="display:flex;gap:10px"><span style="color:#93B4D8"><svg class="ic"><use href="#i-check"/></svg></span><span>Board results for Grade 12 (NEB) are also verifiable via <a href="https://neb.gov.np" target="_blank" rel="noopener" style="color:var(--gold);text-decoration:underline">neb.gov.np</a>.</span></li>
          </ul>
        </div>
        <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px">
          <h3 style="font-size:1rem">Admin</h3><p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.6">Create exam → import CSV → publish / unpublish → archive. Module can stay disabled until needed. <strong>Admin → Academics → Results.</strong> Result PDFs can also be published via Downloads.</p>
        </div>
      </div>
    </div>

    <!-- Related -->
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;flex-wrap:wrap;gap:10px;align-items:center">
      <span style="font-weight:700;font-size:.88rem">Related:</span>
      <a href="<?= e_attr(base_url('notices.php?category=examination')) ?>" class="btn btn-soft">Exam Notices</a>
      <a href="<?= e_attr(base_url('notices.php?category=results')) ?>" class="btn btn-soft">Result Notices</a>
      <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-ghost">Exam Routines &amp; Downloads</a>
      <a href="<?= e_attr(base_url('academic-calendar.php')) ?>" class="btn btn-ghost">Academic Calendar</a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
