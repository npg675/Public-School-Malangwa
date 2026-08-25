<?php 
$page='academics'; $title='Academics — ECD to +2 Science & Management (NEB) | Shree Public Secondary School'; $description='ECD through Grade 12 at Shree Public Secondary School, Malangwa-2. Basic Level, Secondary (SEE), and +2 Science & Management under NEB.'; 
require_once __DIR__.'/includes/helpers.php';
require_once __DIR__.'/includes/header.php';
$ov = get_page_content('academics');
$programs = get_programs();
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> <?= e(t('Academics','शैक्षिक')) ?></span><h1 style="color:#fff;margin:14px 0 10px">ECD to Grade 12<br><span style="color:var(--gold)">+2 Science &amp; Management (NEB)</span></h1><p class="lead" style="color:#C7D7F0;max-width:680px">Continuous pathway in one community school — early years through NEB higher secondary. Curriculum per Curriculum Development Centre (CDC); SEE at Grade 10; NEB at Grades 11–12.</p><div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap"><span style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:999px;font-size:.8rem;color:#fff">IEMIS 190640003</span><span style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:999px;font-size:.8rem;color:#fff">Co-educational • Day School</span></div></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>"><?= e(t('Home','गृह')) ?></a><span class="sep">/</span><span><?= e(t('Academics','शैक्षिक')) ?></span></div></nav>

<!-- Academic Overview -->
<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <span class="eyebrow"><span class="dot"></span> <?= e(t('Academic Overview','शैक्षिक अवलोकन')) ?></span>
    <?php if ($ov && trim(page_val($ov,'content')) !== ''): ?>
      <div style="margin:12px 0 12px;color:var(--muted);line-height:1.75;max-width:760px"><?= page_val($ov,'content') ?></div>
    <?php else: ?>
      <h2 style="margin:12px 0 12px;font-size:1.4rem"><?= e(t('One continuum — from early childhood to higher secondary','एक निरन्तरता — प्रारम्भिक बाल्यकालदेखि उच्च माध्यमिकसम्म')) ?></h2>
      <p style="color:var(--muted);max-width:760px;line-height:1.75">Shree Public Secondary School offers the full national school structure in a single institution. Students can enter at Early Childhood Development (ECD) and progress without changing school through <strong>Basic Level (Grades 1–8)</strong>, <strong>Secondary Level (Grades 9–10)</strong> and <strong>Higher Secondary (Grades 11–12)</strong>. The two higher secondary streams currently offered are <strong>+2 Science</strong> and <strong>+2 Management</strong> under the National Examinations Board (NEB). The school follows the national curriculum framework maintained by the Curriculum Development Centre (CDC) and the examination systems of SEE and NEB. Specific subject combinations, timetables and fee tables are published only after confirmation by the school office.</p>
    <?php endif; ?>

    <div class="wrap" style="display:grid;gap:20px;margin-top:24px">
      <?php
      $levelIcon = ['ecd'=>'star','basic_1_5'=>'book','basic_6_8'=>'grad','secondary_9_10'=>'grad','higher_secondary'=>'flask'];
      $levelTag = ['ecd'=>'Early','basic_1_5'=>'Basic 1–5','basic_6_8'=>'Basic 6–8','secondary_9_10'=>'SEE','higher_secondary'=>'NEB • +2'];
      $levelLabel = ['ecd'=>'Early Childhood','basic_1_5'=>'Primary','basic_6_8'=>'Lower Secondary','secondary_9_10'=>'Secondary • SEE','higher_secondary'=>'Grade 11–12 • NEB'];
      foreach ($programs as $p):
        $lvl = $p['level'] ?? '';
        $icon = $levelIcon[$lvl] ?? 'book';
        $tag = $levelTag[$lvl] ?? $lvl;
        $lbl = $levelLabel[$lvl] ?? $lvl;
        if ($lvl==='higher_secondary' && !empty($p['stream'])) { $lbl = 'Grade 11–12 • NEB • '.$p['stream']; $tag = 'NEB • +2 • '.$p['stream']; }
        $title = t($p['title_en'] ?? '', $p['title_np'] ?? $p['title_en'] ?? '');
        $descEn = $p['description_en'] ?? '';
        $descNp = $p['description_np'] ?? '';
        $desc = current_lang()==='np' && trim($descNp)!=='' ? $descNp : $descEn;
      ?>
      <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:22px">
        <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
          <span style="width:42px;height:42px;border-radius:8px;background:var(--primary);color:#fff;display:grid;place-items:center"><svg class="ic"><use href="#i-<?= e($icon) ?>"/></svg></span>
          <div><h2 style="font-size:1.15rem"><?= e($title) ?></h2><p style="color:var(--muted);font-size:.84rem"><?= e($lbl) ?></p></div>
          <span style="margin-left:auto;font-size:.7rem;background:var(--primary-fixed);color:var(--primary);padding:4px 10px;border-radius:999px;font-weight:700"><?= e($tag) ?></span>
        </div>
        <div style="color:var(--muted);line-height:1.75;margin-top:14px;font-size:.92rem"><?= $desc ?></div>
        <?php if ($lvl==='higher_secondary'): ?>
          <?php if (strtolower($p['stream']??'')==='science'): ?><a href="<?= e_attr(base_url('science.php')) ?>" class="btn btn-soft" style="margin-top:12px;display:inline-flex">Explore Science →</a>
          <?php elseif (strtolower($p['stream']??'')==='management'): ?><a href="<?= e_attr(base_url('management.php')) ?>" class="btn btn-soft" style="margin-top:12px;display:inline-flex">Explore Management →</a><?php endif; ?>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Enrollment & Curriculum helpers -->
<section class="section" style="padding:28px 0">
  <div class="wrap">
    <div style="display:grid;gap:18px;grid-template-columns:1.1fr .9fr">
      <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:18px"><h3 style="font-size:1rem"><?= e(t('Enrollment (IEMIS 2081/82)','भर्ना (IEMIS २०८१/८२)')) ?></h3><p style="color:var(--muted);font-size:.82rem;margin:6px 0 10px">Source: CEHRD / Edusanjal public listing. Homepage displays <strong>1,000+ Students</strong> to avoid fixing a single year.</p>
        <table style="width:100%;border-collapse:collapse;font-size:.88rem"><thead><tr style="background:var(--primary);color:#fff"><th style="padding:8px;text-align:left"><?= e(t('Grade','कक्षा')) ?></th><th style="padding:8px;text-align:right">2081/82</th></tr></thead><tbody>
          <tr style="background:var(--bg)"><td style="padding:6px 8px;border-bottom:1px solid var(--border)">ECD</td><td style="padding:6px 8px;text-align:right;border-bottom:1px solid var(--border)">11</td></tr>
          <tr><td style="padding:6px 8px;border-bottom:1px solid var(--border)">Gr 1–5</td><td style="padding:6px 8px;text-align:right;border-bottom:1px solid var(--border)">53 / 27 / 48 / 58 / 57</td></tr>
          <tr style="background:var(--bg)"><td style="padding:6px 8px;border-bottom:1px solid var(--border)">Gr 6–8</td><td style="padding:6px 8px;text-align:right;border-bottom:1px solid var(--border)">103 / 110 / 172</td></tr>
          <tr><td style="padding:6px 8px;border-bottom:1px solid var(--border)">Gr 9–10</td><td style="padding:6px 8px;text-align:right;border-bottom:1px solid var(--border)">185 / 173</td></tr>
          <tr style="background:var(--bg)"><td style="padding:6px 8px;border-bottom:1px solid var(--border)">Gr 11–12</td><td style="padding:6px 8px;text-align:right;border-bottom:1px solid var(--border)">34 / 54</td></tr>
          <tr style="background:var(--primary-dark);color:#fff;font-weight:700"><td style="padding:8px"><?= e(t('Total','जम्मा')) ?></td><td style="padding:8px;text-align:right">1,085</td></tr>
        </tbody></table>
      </div>
      <div style="display:flex;flex-direction:column;gap:14px">
        <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px"><h3 style="font-size:1rem"><?= e(t('Curriculum & Examination','पाठ्यक्रम र परीक्षा')) ?></h3><p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.7">Follows the CDC curriculum. SEE at Grade 10; NEB examinations at Grades 11–12. Academic calendars, timetables and book lists are published as PDFs in <a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700">Downloads</a> and the <a href="<?= e_attr(base_url('academic-calendar.php')) ?>" style="color:var(--primary);font-weight:700">Academic Calendar</a>. National information: <a href="https://cdc.gov.np" target="_blank" rel="noopener" style="color:var(--primary);font-weight:700">CDC</a> · <a href="https://neb.gov.np" target="_blank" rel="noopener" style="color:var(--primary);font-weight:700">NEB</a> · <a href="https://see.gov.np" target="_blank" rel="noopener" style="color:var(--primary);font-weight:700">SEE</a>.</p></div>
        <div style="background:var(--primary-dark);color:#C7D7F0;border-radius:12px;padding:18px"><h3 style="color:#fff"><?= e(t('Admission for 2082','२०८२ को लागि भर्ना')) ?></h3><p style="color:#93B4D8;font-size:.88rem;margin-top:6px;line-height:1.6">Eligibility, seats, fees and document requirements for each level are confirmed by the school office each year.</p><a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-gold" style="margin-top:12px"><?= e(t('Admission Inquiry →','भर्ना सोधपुछ →')) ?></a></div>
      </div>
    </div>
  </div>
</section>

<!-- Related links -->
<section class="section" style="background:var(--surface-low);border-top:1px solid var(--border)">
  <div class="wrap">
    <h3 style="font-size:1rem"><?= e(t('Related','सम्बन्धित')) ?></h3>
    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:12px">
      <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-primary"><?= e(t('Admission Information →','भर्ना जानकारी →')) ?></a>
      <a href="<?= e_attr(base_url('academic-calendar.php')) ?>" class="btn btn-soft"><?= e(t('Academic Calendar','शैक्षिक पात्रो')) ?></a>
      <a href="<?= e_attr(base_url('results.php')) ?>" class="btn btn-soft"><?= e(t('Results','नतिजा')) ?></a>
      <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-ghost"><?= e(t('Downloads','डाउनलोड')) ?></a>
      <a href="<?= e_attr(base_url('about.php')) ?>" class="btn btn-ghost"><?= e(t('About School','विद्यालयबारे')) ?></a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
