<?php $page='notices'; $title='Notice Board — Shree Public Secondary School'; require_once __DIR__.'/includes/header.php';
$cat = $_GET['category'] ?? null;
$q = trim($_GET['q'] ?? '');
$all = get_notices(50, $cat && $cat!=='all' ? $cat : null);
if ($q!=='') { $all = array_filter($all, function($n) use($q){ $hay=strtolower(($n['title_en']??'').' '.($n['title_np']??'').' '.($n['reference_number']??'')); return str_contains($hay, strtolower($q)); }); }
$cats = ['all'=>'All','general'=>'General','examination'=>'Examination','admission'=>'Admission','holiday'=>'Holiday','vacancy'=>'Vacancy','scholarship'=>'Scholarship','procurement'=>'Procurement','results'=>'Results','urgent'=>'Urgent'];
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Notice Board</span><h1 style="color:#fff;margin:14px 0 10px">Official Notices</h1><p class="lead" style="color:#C7D7F0;max-width:640px">Search by category, year or keyword. Nepali titles supported. Pinned &amp; urgent notices on top.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Notice Board</span></div></nav>
<section class="section" style="padding-top:20px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <form method="get" style="display:flex;gap:10px;flex-wrap:wrap;align-items:end;margin-bottom:18px">
      <div class="field" style="flex:1;min-width:200px"><label>Search</label><input type="search" name="q" value="<?= e($q) ?>" placeholder="Keyword, reference number..."></div>
      <div class="field"><label>Category</label><select name="category" onchange="this.form.submit()"><?php foreach($cats as $k=>$label): ?><option value="<?= e($k) ?>" <?= $cat===$k?'selected':'' ?>><?= e($label) ?></option><?php endforeach; ?></select></div>
      <button class="btn btn-primary" type="submit"><svg class="ic"><use href="#i-search"/></svg> Search</button>
      <?php if($q||$cat): ?><a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-ghost">Clear</a><?php endif; ?>
    </form>
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
      <?php foreach($cats as $k=>$label): ?><a href="<?= e_attr(base_url('notices.php?category='.$k)) ?>" class="tag <?= $cat===$k?'urgent':'' ?>" style="<?= $cat===$k?'background:var(--primary);color:#fff':'' ?>"><?= e($label) ?></a><?php endforeach; ?>
    </div>
    <?php if(empty($all)): ?><div class="empty"><svg class="ic"><use href="#i-info"/></svg><h4>No notices in this category</h4><p>Try another category or check back after the school publishes.</p></div>
    <?php else: foreach($all as $n): $d=strtotime($n['published_at']); $titleTxt=(current_lang()==='np'&&!empty($n['title_np']))?$n['title_np']:$n['title_en']; ?>
      <article class="notice-card <?= !empty($n['is_pinned'])?'pinned':'' ?>">
        <div class="notice-date"><span class="d"><?= date('d',$d) ?></span><span class="m"><?= date('M Y',$d) ?></span></div>
        <div class="notice-body">
          <h4><a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>"><?= e($titleTxt) ?></a></h4>
          <?php if(!empty($n['summary_en'])): ?><p><?= e($n['summary_en']) ?></p><?php endif; ?>
          <div class="notice-meta">
            <span class="tag <?= !empty($n['is_urgent'])?'urgent':'' ?>"><?= e($n['cat_en'] ?? $n['category'] ?? 'General') ?></span>
            <?php if(!empty($n['is_pinned'])): ?><span class="tag pinned">Pinned</span><?php endif; ?>
            <?php if(!empty($n['reference_number'])): ?><span>Ref: <?= e($n['reference_number']) ?></span><?php endif; ?>
            <a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>" style="margin-left:auto;font-weight:700;color:var(--primary)">View →</a>
            <?php if(!empty($n['attachment_type'])): ?><a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>" class="btn btn-soft" style="padding:6px 10px;font-size:.78rem"><svg class="ic"><use href="#i-download"/></svg> PDF</a><?php endif; ?>
          </div>
        </div>
      </article>
    <?php endforeach; endif; ?>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
