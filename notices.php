<?php $page='notices'; $title='Notice Board — Official Notices | Shree Public Secondary School'; $description='Official notices, exam routines, admission updates, scholarships, holidays and procurement from Shree Public Secondary School, Malangwa-2. Search and filter by category and year.'; require_once __DIR__.'/includes/header.php';
$cat = $_GET['category'] ?? null;
$q = trim($_GET['q'] ?? '');
$year = trim($_GET['year'] ?? '');
$all = get_notices(80, $cat && $cat!=='all' ? $cat : null);
if ($q!=='') { $all = array_filter($all, function($n) use($q){ $hay=strtolower(($n['title_en']??'').' '.($n['title_np']??'').' '.($n['reference_number']??'').' '.($n['summary_en']??'')); return str_contains($hay, strtolower($q)); }); }
if ($year!=='' && $year!=='all') { $all = array_filter($all, function($n) use($year){ return date('Y', strtotime($n['published_at']))===$year; }); }
$cats = ['all'=>'All','general'=>'General','examination'=>'Examination','admission'=>'Admission','results'=>'Results','scholarship'=>'Scholarship','holiday'=>'Holiday','vacancy'=>'Vacancy','procurement'=>'Procurement','event'=>'Event','urgent'=>'Urgent'];
$years = ['all'=>'All years','2026'=>'2026','2025'=>'2025'];
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Notice Board</span><h1 style="color:#fff;margin:14px 0 10px">Official Notices</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Official announcements, exam information, holiday notices, admission updates, scholarships, vacancies and procurement — published by the school office. Nepali titles supported; pinned &amp; urgent notices appear first.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Notice Board</span></div></nav>
<section class="section" style="padding-top:24px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <!-- Intro -->
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;margin-bottom:18px;display:flex;gap:12px;align-items:flex-start">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.6"><strong style="color:var(--text)">How to use this page:</strong> Search by keyword or reference number, filter by category and year, and open a notice for the full text and PDF attachment. Pinned notices stay at the top until their expiry date. Expired or draft notices are not shown.</div>
    </div>
    <!-- Filters -->
    <form method="get" style="display:flex;gap:10px;flex-wrap:wrap;align-items:end;margin-bottom:14px;background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px">
      <div class="field" style="flex:1;min-width:200px"><label>Search</label><input type="search" name="q" value="<?= e($q) ?>" placeholder="Keyword, reference number, title..."></div>
      <div class="field"><label>Category</label><select name="category"><?php foreach($cats as $k=>$label): ?><option value="<?= e($k) ?>" <?= $cat===$k?'selected':'' ?>><?= e($label) ?></option><?php endforeach; ?></select></div>
      <div class="field"><label>Year</label><select name="year"><?php foreach($years as $k=>$label): ?><option value="<?= e($k) ?>" <?= $year===$k?'selected':'' ?>><?= e($label) ?></option><?php endforeach; ?></select></div>
      <button class="btn btn-primary" type="submit"><svg class="ic"><use href="#i-search"/></svg> Search</button>
      <?php if($q||$cat||$year): ?><a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-ghost">Clear</a><?php endif; ?>
    </form>
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
      <?php foreach($cats as $k=>$label): ?><a href="<?= e_attr(base_url('notices.php?category='.$k.($year&&$year!=='all'?'&year='.$year:''))) ?>" class="tag <?= $cat===$k?'urgent':'' ?>" style="<?= $cat===$k?'background:var(--primary);color:#fff':'' ?>"><?= e($label) ?></a><?php endforeach; ?>
    </div>
    <div style="display:flex;gap:10px;align-items:center;margin-bottom:14px;font-size:.84rem;color:var(--muted);flex-wrap:wrap">
      <span style="background:var(--surface-low);border:1px solid var(--border);padding:6px 10px;border-radius:999px"><?= count($all) ?> notice(s)<?= $q?' for "'.e($q).'"':'' ?><?= $cat&&$cat!=='all'?' in '.e($cats[$cat]??$cat):'' ?></span>
      <?php if($q||$cat||$year): ?><span>• Filtered view — <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">clear filters</a></span><?php endif; ?>
    </div>
    <?php if(empty($all)): ?><div class="empty"><svg class="ic"><use href="#i-info"/></svg><h4>No notices in this view</h4><p>Try another category, year or keyword. Official notices will appear here as soon as the school office publishes them. Not all categories have content yet — empty states are intentional.</p><div style="margin-top:12px;display:flex;gap:8px;justify-content:center;flex-wrap:wrap"><a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-soft">View all notices</a><a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-ghost">Contact office</a></div></div>
    <?php else: foreach($all as $n): $d=strtotime($n['published_at']); $titleTxt=(current_lang()==='np'&&!empty($n['title_np']))?$n['title_np']:$n['title_en']; ?>
      <article class="notice-card <?= !empty($n['is_pinned'])?'pinned':'' ?>">
        <div class="notice-date"><span class="d"><?= date('d',$d) ?></span><span class="m"><?= date('M Y',$d) ?></span></div>
        <div class="notice-body">
          <h4><a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>"><?= e($titleTxt) ?></a></h4>
          <?php if(!empty($n['summary_en'])): ?><p><?= e($n['summary_en']) ?></p><?php endif; ?>
          <div class="notice-meta">
            <span class="tag <?= !empty($n['is_urgent'])?'urgent':'' ?>"><?= !empty($n['is_urgent'])?'Urgent • ':'' ?><?= e($n['cat_en'] ?? $n['category'] ?? 'General') ?></span>
            <?php if(!empty($n['is_sample'])): ?><span class="tag" style="background:var(--gold-50);border-color:#FDE68A;color:#6B4F00">Sample</span><?php endif; ?>
            <?php if(!empty($n['is_pinned'])): ?><span class="tag pinned">Pinned</span><?php endif; ?>
            <?php if(!empty($n['reference_number'])): ?><span style="color:var(--muted)">Ref: <?= e($n['reference_number']) ?></span><?php endif; ?>
            <span style="color:var(--muted-2)">Published: <?= e(date('F j, Y',$d)) ?></span>
            <a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>" style="margin-left:auto;font-weight:700;color:var(--primary)">View →</a>
            <?php if(!empty($n['attachment_type'])): ?><span style="display:inline-flex;align-items:center;gap:4px;background:var(--primary);color:#fff;padding:4px 8px;border-radius:999px;font-weight:700"><svg class="ic" style="width:14px;height:14px"><use href="#i-doc"/></svg> <?= strtoupper(e($n['attachment_type'])) ?></span><?php endif; ?>
          </div>
        </div>
      </article>
    <?php endforeach; endif; ?>

    <!-- Archive helper -->
    <div style="margin-top:20px;background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px">
      <h3 style="font-size:1rem">Archive</h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.6">Notices are also browsable by year. Use the Year filter above or visit <a href="<?= e_attr(base_url('notices.php?year=2026')) ?>" style="color:var(--primary);font-weight:700">2026 archive</a> / <a href="<?= e_attr(base_url('notices.php?year=2025')) ?>" style="color:var(--primary);font-weight:700">2025 archive</a>. Older notices remain searchable via keyword.</p>
    </div>

    <div style="margin-top:16px;display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-soft">Downloads</a>
      <a href="<?= e_attr(base_url('academic-calendar.php')) ?>" class="btn btn-ghost">Academic Calendar</a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
