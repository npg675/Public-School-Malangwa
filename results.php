<?php $page='results'; $title='Results — Shree Public Secondary School'; require_once __DIR__.'/includes/header.php';
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
        // demo: check sample
        if($symbol==='12345') $result=['symbol_no'=>'12345','student_name'=>'Sample Student','class_name'=>'Grade 12','academic_year'=>'2081','grade'=>'B+','gpa'=>3.2];
        else $error='Demo mode — try symbol 12345 or enable DB. Real results are private per symbol.';
      }
    }
  }
}
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Results</span><h1 style="color:#fff;margin:14px 0 10px">Result Search</h1><p class="lead" style="color:#C7D7F0;max-width:640px">Enter symbol / roll number. Only your result is shown — no public student database.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Results</span></div></nav>
<section class="section" style="padding-top:20px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="max-width:640px">
    <form method="post" class="adm-form">
      <?= csrf_field() ?>
      <div class="form-grid">
        <div class="field full"><label>Symbol / Roll Number <span class="req">*</span></label><input type="text" name="symbol" required placeholder="e.g. 12345" value="<?= e($_POST['symbol']??'') ?>"></div>
        <div class="field"><label>Academic Year</label><select name="year"><option value="">Select year</option><option>2081</option><option>2080</option><option>2082</option></select></div>
        <div class="field"><label>Class</label><select name="class"><option value="">Select class</option><option>Grade 10 (SEE)</option><option>Grade 12</option></select></div>
        <div class="full"><button class="btn btn-primary btn-lg" style="width:100%" type="submit"><svg class="ic"><use href="#i-search"/></svg> Search Result</button></div>
      </div>
      <?php if($error): ?><div style="background:var(--red-50);border:1px solid #FECACA;color:var(--red);padding:10px 12px;border-radius:10px;margin-top:12px"><?= e($error) ?></div><?php endif; ?>
      <?php if($result): ?><div style="background:var(--success-50);border:1px solid #A7F3D0;padding:16px;border-radius:12px;margin-top:14px"><h3 style="font-size:1rem">Result Found</h3><table style="margin-top:10px;width:100%;font-size:.92rem"><tr><td style="padding:6px 0;color:var(--muted)">Symbol</td><td style="padding:6px 0;font-weight:700"><?= e($result['symbol_no']) ?></td></tr><tr><td style="padding:6px 0;color:var(--muted)">Name</td><td style="padding:6px 0;font-weight:700"><?= e($result['student_name']) ?></td></tr><tr><td style="padding:6px 0;color:var(--muted)">Class / Year</td><td style="padding:6px 0"><?= e($result['class_name']) ?> • <?= e($result['academic_year']) ?></td></tr><tr><td style="padding:6px 0;color:var(--muted)">Grade / GPA</td><td style="padding:6px 0;font-weight:700"><?= e($result['grade'] ?? '-') ?> <?= isset($result['gpa'])?'• '.e((string)$result['gpa']):'' ?></td></tr></table></div><?php endif; ?>
      <p style="font-size:.82rem;color:var(--muted);margin-top:10px"><svg class="ic"><use href="#i-info"/></svg> Privacy: only the matching record is returned. No addresses or phone numbers are exposed.</p>
    </form>
    <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px;margin-top:16px">
      <h3 style="font-size:1rem">Admin</h3><p style="color:var(--muted);font-size:.88rem;margin-top:6px">Create exam → import CSV → publish/unpublish → archive. Module can stay disabled until needed. Admin → Academics → Results.</p>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
