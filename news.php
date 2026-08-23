<?php $page='news'; $title='News — School News & Updates | Shree Public Secondary School'; $description='School news from Shree Public Secondary School, Malangwa-2 — academic activities, community programs, sports, cultural events. News is separate from official notices.'; require_once __DIR__.'/includes/header.php'; $newsItems = get_news(12); ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> News</span><h1 style="color:#fff;margin:14px 0 10px">School News</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Completed activities and stories from campus life — academic, community, sports and cultural. <strong style="color:#fff">News celebrates activity; notices carry official information.</strong> They are not mixed.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>News</span></div></nav>
<section class="section" style="padding-top:28px">
  <div class="wrap">
    <!-- Intro -->
    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:16px">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)">What belongs here:</strong> reports of <em>completed</em> school activities — academic programmes, community events, student activities, sports and cultural celebrations. Official circulars (exam routines, admissions, holidays) are published on the <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">Notice Board</a>, never here.</div>
    </div>

    <?php if(empty($newsItems)): ?>
      <div class="empty" style="margin-bottom:18px"><svg class="ic"><use href="#i-pen"/></svg><h4>No news published yet</h4><p>When the school publishes a report of a completed activity it will appear here as a card with cover photo, category and date. Managed via <strong>Admin → News</strong>. Meanwhile, official information lives on the Notice Board.</p></div>
    <?php else: ?>
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
      <?php $seen=[]; foreach($newsItems as $n){ $c=$n['cat_en']??'General'; if(!in_array($c,$seen,true)){ $seen[]=$c; echo '<span class="tag">'.e($c).'</span>'; } } ?>
    </div>
    <div style="display:grid;gap:14px;grid-template-columns:repeat(auto-fill,minmax(300px,1fr))">
      <?php foreach($newsItems as $n): $ttl=(current_lang()==='np'&&!empty($n['title_np']))?$n['title_np']:$n['title_en']; $exc=(current_lang()==='np'&&!empty($n['excerpt_np']))?$n['excerpt_np']:($n['excerpt_en']??''); $d=strtotime($n['published_at']); ?>
      <article class="news-card">
        <?php if(!empty($n['cover_image'])): ?><div class="news-thumb"><img src="<?= e_attr(base_url('uploads/'.ltrim($n['cover_image'],'/'))) ?>" alt="<?= e_attr($ttl) ?>" loading="lazy" onerror="this.parentElement.style.display='none'"></div><?php endif; ?>
        <div class="news-body">
          <div class="news-meta"><span><?= e($n['cat_en'] ?? 'General') ?></span><span>•</span><span><?= e(date('M j, Y',$d)) ?></span></div>
          <h3><?= e($ttl) ?></h3>
          <?php if($exc): ?><p><?= e($exc) ?></p><?php endif; ?>
          <a href="<?= e_attr(base_url('news.php')) ?>" style="font-weight:700;color:var(--primary);font-size:.84rem;margin-top:8px;display:inline-flex">Read more →</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;margin-top:18px">
      <h3 style="font-size:1rem">Publishing &amp; admin</h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.7">News supports bilingual titles/excerpts, categories, cover images and dates via CMS. Scheduled / upcoming activities belong in <a href="<?= e_attr(base_url('events.php')) ?>" style="color:var(--primary);font-weight:700">Events</a>; completed ones are reported here. Gallery albums are linked from articles as related content.</p>
    </div>

    <div style="margin-top:16px;display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('events.php')) ?>" class="btn btn-soft">Upcoming Events →</a>
      <a href="<?= e_attr(base_url('gallery.php')) ?>" class="btn btn-ghost">Gallery</a>
      <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-ghost">Notice Board</a>
      <a href="<?= e_attr(base_url('about.php')) ?>" class="btn btn-ghost">About School</a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
