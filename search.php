<?php $page='search'; $q=trim($_GET['q']??''); $title='Search — '.($q?htmlspecialchars($q).' — ':'').'Shree Public Secondary School'; require_once __DIR__.'/includes/header.php';
$results=[];
if($q!==''){
  $all=get_notices(50);
  foreach($all as $n){ if(str_contains(strtolower($n['title_en'].' '.$n['title_np']), strtolower($q))) $results[]=['type'=>'Notice','title'=>$n['title_en'],'url'=>base_url('notice.php?slug='.$n['slug']),'meta'=>$n['cat_en']??'Notice']; }
  $dls=get_downloads(20);
  foreach($dls as $d){ if(str_contains(strtolower($d['title_en']), strtolower($q))) $results[]=['type'=>'Download','title'=>$d['title_en'],'url'=>base_url('downloads.php'),'meta'=>$d['cat_en']]; }
}
?>
<section class="section" style="padding-top:32px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="max-width:720px">
    <h1 style="font-size:1.6rem">Search</h1>
    <form method="get" style="display:flex;gap:10px;margin-top:14px">
      <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search notices, downloads, pages..." style="flex:1;padding:12px 14px;border:1.5px solid var(--border);border-radius:10px;background:var(--bg)">
      <button class="btn btn-primary" type="submit"><svg class="ic"><use href="#i-search"/></svg> Search</button>
    </form>
    <?php if($q!==''): ?>
      <p style="color:var(--muted);margin-top:14px"><?= count($results) ?> result(s) for <strong><?= e($q) ?></strong> — Unicode Nepali supported.</p>
      <div style="display:flex;flex-direction:column;gap:10px;margin-top:14px">
        <?php if(empty($results)): ?><div class="empty"><h4>No results</h4><p>Try another keyword or browse Notice Board / Downloads.</p></div>
        <?php else: foreach($results as $r): ?>
        <a href="<?= e_attr($r['url']) ?>" style="display:flex;justify-content:space-between;gap:12px;background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:14px"><span><strong><?= e($r['title']) ?></strong> <span style="font-size:.78rem;color:var(--muted)">— <?= e($r['type']) ?> • <?= e($r['meta']) ?></span></span><span style="color:var(--primary)">→</span></a>
        <?php endforeach; endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
