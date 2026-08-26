<?php $page='downloads'; $title='Downloads — Resources Centre | Shree Public Secondary School'; $description='Forms, academic calendar, exam routines, results, citizen charter, policies, publications and scholarships — download centre for Shree Public Secondary School, Malangwa-2.'; require_once __DIR__.'/includes/header.php'; $downloads=get_downloads(24); $filter=$_GET['category']??'all'; $filterLower=strtolower($filter); ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Downloads</span><h1 style="color:#fff;margin:14px 0 10px">Resource &amp; Download Centre</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Forms, routines, calendars and official documents — one place, always current. Validated uploads only; no executables. Filter by category or search.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Downloads</span></div></nav>
<section class="section" style="padding-top:24px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <!-- Intro -->
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:16px">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)">What you will find here:</strong> Academic Calendar, Exam Routines, Admission Forms, Results, Citizen Charter, Scholarships, Policies and Publications. When a document is available it appears below with file type, size and publish date. Empty categories show a clean empty state — no fake files are linked.</div>
    </div>

    <!-- Category pills -->
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
      <?php $cats=['all'=>'All','academic'=>'Academic','forms'=>'Forms','routine'=>'Routine','results'=>'Results','admissions'=>'Admissions','examination'=>'Examination','citizen charter'=>'Citizen Charter','scholarships'=>'Scholarships','procurement'=>'Procurement','policies'=>'Policies','publications'=>'Publications']; foreach($cats as $k=>$v): ?><a href="?category=<?= e_attr($k) ?>" class="tag <?= $filterLower===$k?'urgent':'' ?>" style="<?= $filterLower===$k?'background:var(--primary);color:#fff':'' ?>"><?= e($v) ?></a><?php endforeach; ?>
    </div>

    <!-- Category explanation grid -->
    <div style="display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));margin-bottom:18px">
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem">Academic</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6">Academic Calendar • Curriculum resources • Book / material lists • Exam Routines</p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem">Admissions</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6">Application forms • Admission guidelines • Scholarships notices within admissions</p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem">Examination</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6">Routines • Results • Instructions</p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem">Institutional</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6">Citizen Charter • Policies • Reports • Publications</p></div>
    </div>

    <div class="download-list">
      <?php $shown=0; foreach($downloads as $dl): $catVal=strtolower($dl['cat_en']??$dl['category']??''); if($filterLower!=='all' && $catVal!==$filterLower && !str_contains($catVal,$filterLower)) continue; $shown++; ?>
      <div class="dl-row"><span class="dl-icon"><svg class="ic"><use href="#i-doc"/></svg></span><div class="dl-body"><h4><?= e(current_lang()==='np' && !empty($dl['title_np']) ? $dl['title_np'] : $dl['title_en']) ?></h4><div class="dl-meta"><span><?= e($dl['cat_en']??$dl['category']) ?></span><span>•</span><span><?= e($dl['published_at']) ?></span><span>•</span><span><?= e(format_file_size($dl['file_size']??'')) ?> <?= e($dl['file_type']??'PDF') ?></span><?php if(!empty($dl['file_type'])): ?><span style="background:var(--primary);color:#fff;padding:2px 6px;border-radius:999px;font-weight:700"><?= e($dl['file_type']) ?></span><?php endif; ?><?php if(!empty($dl['is_sample'])): ?><span style="background:var(--gold-50);border:1px solid #FDE68A;color:#6B4F00;padding:2px 8px;border-radius:999px;font-weight:700">Sample — file upload pending</span><?php endif; ?></div></div><div class="dl-actions"><?php if(!empty($dl['is_sample'])): ?><span class="btn btn-ghost" style="opacity:.55;cursor:not-allowed">File pending</span><?php else: ?><a href="<?= e_attr(media_url($dl['file_path']??'')) ?>" class="btn btn-soft">View</a><a href="<?= e_attr(media_url($dl['file_path']??'')) ?>" class="btn btn-ghost" download>Download</a><?php endif; ?></div></div>
      <?php endforeach; ?>
      <?php if($shown===0): ?>
        <div class="empty"><svg class="ic"><use href="#i-info"/></svg><h4>No documents in this category yet</h4><p>This category has no published files. When the school office uploads a document it will appear here with preview and download links. In the meantime, check <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">Notice Board</a> or <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--primary);font-weight:700">contact the school</a>.</p></div>
      <?php endif; ?>
    </div>

    <div style="margin-top:18px;background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px">
      <h3 style="font-size:1rem">Need a document not listed?</h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.6">Published files are managed by the school office (Admin → Resources → Downloads). If you need an official document that is not yet online, please <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--primary);font-weight:700">contact the school</a> or visit Malangwa-2 (VH24+22W). No temporary or unverified files are linked here.</p>
    </div>

    <div style="margin-top:16px;display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-soft">Notices</a>
      <a href="<?= e_attr(base_url('academic-calendar.php')) ?>" class="btn btn-ghost">Academic Calendar</a>
      <a href="<?= e_attr(base_url('citizen-charter.php')) ?>" class="btn btn-ghost">Citizen Charter</a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
