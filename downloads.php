<?php $page='downloads'; $title='Downloads — Shree Public Secondary School'; require_once __DIR__.'/includes/header.php'; $downloads=get_downloads(12); $filter=$_GET['category']??'all'; ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Downloads</span><h1 style="color:#fff;margin:14px 0 10px">Download Centre</h1><p class="lead" style="color:#C7D7F0;max-width:640px">Forms, routines, calendars, policies — validated uploads, no executables.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Downloads</span></div></nav>
<section class="section" style="padding-top:20px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
      <?php $cats=['all'=>'All','Forms'=>'Forms','Routine'=>'Routine','Academic Calendar'=>'Calendar','Citizen Charter'=>'Charter','Scholarships'=>'Scholarships']; foreach($cats as $k=>$v): ?><a href="?category=<?= e_attr($k) ?>" class="tag <?= $filter===$k?'urgent':'' ?>" style="<?= $filter===$k?'background:var(--primary);color:#fff':'' ?>"><?= e($v) ?></a><?php endforeach; ?>
    </div>
    <div class="download-list">
      <?php foreach($downloads as $dl): if($filter!=='all' && strtolower($dl['cat_en']??'')!==strtolower($filter) && strtolower($dl['category']??'')!==strtolower($filter)) continue; ?>
      <div class="dl-row"><span class="dl-icon"><svg class="ic"><use href="#i-doc"/></svg></span><div class="dl-body"><h4><?= e($dl['title_en']) ?></h4><div class="dl-meta"><span><?= e($dl['cat_en']??$dl['category']) ?></span><span>•</span><span><?= e($dl['published_at']) ?></span><span>•</span><span><?= e($dl['file_size']??'') ?> <?= e($dl['file_type']??'PDF') ?></span></div></div><div class="dl-actions"><a href="#" class="btn btn-soft">View</a><a href="#" class="btn btn-ghost">Download</a></div></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
