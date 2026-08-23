<?php $page='search'; $q=trim($_GET['q']??''); $title='Search — '.($q?htmlspecialchars($q).' — ':'').'Shree Public Secondary School'; require_once __DIR__.'/includes/header.php';
$results=[];
// Static pages index
$pagesIndex = [
  ['type'=>'Page','title'=>'About the School','url'=>base_url('about.php'),'meta'=>'Introduction, at a glance, educational role','kw'=>'about school introduction community history role'],
  ['type'=>'Page','title'=>'Academics — ECD to Grade 12','url'=>base_url('academics.php'),'meta'=>'ECD, Basic, Secondary (SEE), +2','kw'=>'academics ecd basic secondary see curriculum grade class'],
  ['type'=>'Page','title'=>'+2 Science (NEB)','url'=>base_url('science.php'),'meta'=>'Program overview & pathways','kw'=>'science plus2 neb physics chemistry biology stream'],
  ['type'=>'Page','title'=>'+2 Management (NEB)','url'=>base_url('management.php'),'meta'=>'Program overview & pathways','kw'=>'management plus2 neb accounting business economics commerce'],
  ['type'=>'Page','title'=>'Admissions','url'=>base_url('admissions.php'),'meta'=>'Levels, process, documents guidance','kw'=>'admission bharna enrollment apply form fees documents'],
  ['type'=>'Page','title'=>'Notice Board','url'=>base_url('notices.php'),'meta'=>'Official notices by category','kw'=>'notice suchana board announcement circular'],
  ['type'=>'Page','title'=>'Results','url'=>base_url('results.php'),'meta'=>'Result search & categories','kw'=>'result natija see neb marksheet gpa symbol roll'],
  ['type'=>'Page','title'=>'Downloads','url'=>base_url('downloads.php'),'meta'=>'Forms, routines, calendars','kw'=>'download form routine calendar pdf document'],
  ['type'=>'Page','title'=>'Academic Calendar 2082','url'=>base_url('academic-calendar.php'),'meta'=>'Terms, holidays, exams','kw'=>'calendar patro 2082 holiday term exam date'],
  ['type'=>'Page','title'=>'Citizen Charter (नागरिक वडापत्र)','url'=>base_url('citizen-charter.php'),'meta'=>'Services, documents, time, fees','kw'=>'citizen charter nagarik badapatra service fee complaint'],
  ['type'=>'Page','title'=>'Scholarships','url'=>base_url('scholarships.php'),'meta'=>'Verified scholarship notices','kw'=>'scholarship chhatravritti quota eligibility'],
  ['type'=>'Page','title'=>'Publications','url'=>base_url('publications.php'),'meta'=>'Annual reports & documents','kw'=>'publication report prospectus sip annual'],
  ['type'=>'Page','title'=>'News','url'=>base_url('news.php'),'meta'=>'Completed activities','kw'=>'news samachar activity event report'],
  ['type'=>'Page','title'=>'Events','url'=>base_url('events.php'),'meta'=>'Upcoming events calendar','kw'=>'event karyakram upcoming scheduled venue'],
  ['type'=>'Page','title'=>'Gallery','url'=>base_url('gallery.php'),'meta'=>'Photo albums','kw'=>'gallery photo tasbir album campus classroom sports'],
  ['type'=>'Page','title'=>'Useful Links','url'=>base_url('links.php'),'meta'=>'Government & education portals','kw'=>'links moest cehrd neb cdc see municipality madhesh government'],
  ['type'=>'Page','title'=>'Contact','url'=>base_url('contact.php'),'meta'=>'Map, address, message form','kw'=>'contact sampark phone email map address location malangwa directions'],
  ['type'=>'Page','title'=>'FAQ','url'=>base_url('faq.php'),'meta'=>'Frequently asked questions','kw'=>'faq question answer jigyasa help'],
];
if($q!==''){
  $ql = strtolower($q);
  foreach($pagesIndex as $p){ if(str_contains(strtolower($p['title'].' '.$p['meta'].' '.$p['kw']),$ql)) $results[]=['type'=>$p['type'],'title'=>$p['title'],'url'=>$p['url'],'meta'=>$p['meta']]; }
  $all=get_notices(50);
  foreach($all as $n){ if(str_contains(strtolower(($n['title_en']??'').' '.($n['title_np']??'').' '.($n['summary_en']??'')), $ql)) $results[]=['type'=>'Notice','title'=>$n['title_en'],'url'=>base_url('notice.php?slug='.$n['slug']),'meta'=>$n['cat_en']??'Notice']; }
  $dls=get_downloads(20);
  foreach($dls as $d){ if(str_contains(strtolower($d['title_en']), $ql)) $results[]=['type'=>'Download','title'=>$d['title_en'],'url'=>base_url('downloads.php'),'meta'=>$d['cat_en']??'Document']; }
}
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Search</span><h1 style="color:#fff;margin:14px 0 10px">Search</h1><p class="lead" style="color:#C7D7F0;max-width:640px">Search pages, notices and downloads. Unicode Nepali is supported.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Search</span></div></nav>
<section class="section" style="padding-top:24px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="max-width:720px">
    <form method="get" style="display:flex;gap:10px">
      <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search notices, downloads, pages..." style="flex:1;padding:12px 14px;border:1.5px solid var(--border);border-radius:10px;background:var(--surface-low)">
      <button class="btn btn-primary" type="submit"><svg class="ic"><use href="#i-search"/></svg> Search</button>
    </form>
    <?php if($q!==''): ?>
      <p style="color:var(--muted);margin-top:14px"><?= count($results) ?> result(s) for <strong><?= e($q) ?></strong> — across pages, notices and downloads.</p>
      <div style="display:flex;flex-direction:column;gap:10px;margin-top:14px">
        <?php if(empty($results)): ?><div class="empty"><h4>No results found</h4><p>Try another keyword — or go directly to the <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">Notice Board</a>, <a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700">Downloads</a> or <a href="<?= e_attr(base_url('sitemap.php')) ?>" style="color:var(--primary);font-weight:700">Sitemap</a>.</p></div>
        <?php else: foreach($results as $r): ?>
        <a href="<?= e_attr($r['url']) ?>" style="display:flex;justify-content:space-between;gap:12px;background:var(--surface-low);border:1px solid var(--border);border-radius:10px;padding:14px;align-items:center"><span><strong><?= e($r['title']) ?></strong><br><span style="font-size:.78rem;color:var(--muted)"><?= e($r['type']) ?> • <?= e($r['meta']) ?></span></span><span style="color:var(--primary)">→</span></a>
        <?php endforeach; endif; ?>
      </div>
    <?php else: ?>
      <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;margin-top:16px">
        <h3 style="font-size:.95rem">Popular destinations</h3>
        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:10px">
          <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-soft">Notice Board</a>
          <a href="<?= e_attr(base_url('results.php')) ?>" class="btn btn-soft">Results</a>
          <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-soft">Admissions</a>
          <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-ghost">Downloads</a>
          <a href="<?= e_attr(base_url('academic-calendar.php')) ?>" class="btn btn-ghost">Academic Calendar</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
