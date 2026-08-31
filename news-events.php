<?php $page='posts'; $type=(isset($_GET['type'])&&in_array($_GET['type'],['news','event'],true))?$_GET['type']:''; $title='News & Events — School Updates | Shree Public Secondary School'; $description='News and events from Shree Public Secondary School, Malangwa-2 — completed activities, scheduled programs, sports, cultural events and reports from campus life.'; require_once __DIR__.'/includes/header.php'; $items=get_posts($type, 24); ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> News &amp; Events</span><h1 style="color:#fff;margin:14px 0 10px">School News &amp; Events</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Completed activities and scheduled programs from campus life — academic, community, sports and cultural. Official circulars live on the <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--gold);text-decoration:underline">Notice Board</a>.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>News &amp; Events</span></div></nav>
<section class="section" style="padding-top:28px">
  <div class="wrap">
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:18px">
      <a href="<?= e_attr(base_url('news-events.php')) ?>" class="btn btn-sm <?= $type===''?'btn-primary':'' ?>">All</a>
      <a href="<?= e_attr(base_url('news-events.php?type=news')) ?>" class="btn btn-sm <?= $type==='news'?'btn-primary':'' ?>">News</a>
      <a href="<?= e_attr(base_url('news-events.php?type=event')) ?>" class="btn btn-sm <?= $type==='event'?'btn-primary':'' ?>">Events</a>
    </div>

    <?php if(empty($items)): ?>
      <div class="empty" style="margin-bottom:18px"><svg class="ic"><use href="#i-pen"/></svg><h4><?= $type==='event' ? 'No events published yet' : ($type==='news' ? 'No news published yet' : 'No news or events published yet') ?></h4><p>When the school publishes a report of a completed activity or a scheduled program, it will appear here as a card. Managed via <strong>Admin → News &amp; Events</strong>. Meanwhile, official information lives on the Notice Board.</p></div>
    <?php else: ?>
    <div style="display:grid;gap:14px;grid-template-columns:repeat(auto-fill,minmax(300px,1fr))">
      <?php foreach($items as $n): $isEvent=($n['post_type']??'')==='event'; $ttl=(current_lang()==='np'&&!empty($n['title_np']))?$n['title_np']:$n['title_en']; $exc=(current_lang()==='np'&&!empty($n['excerpt_np']))?$n['excerpt_np']:($n['excerpt_en']??''); $loc=(current_lang()==='np'&&!empty($n['location_np']))?$n['location_np']:($n['location_en']??''); $d=$isEvent?strtotime($n['event_date']):strtotime($n['published_at']); ?>
      <article class="news-card">
        <?php if(!empty($n['cover_image'])): ?><div class="news-thumb"><img src="<?= e_attr(media_url($n['cover_image'])) ?>" alt="<?= e_attr($ttl) ?>" loading="lazy" onerror="this.parentElement.style.display='none'"></div><?php endif; ?>
        <div class="news-body">
          <div class="news-meta">
            <?php if($isEvent): ?><span class="tag tag-gold" style="background:rgba(210,154,50,.15);color:#9a6f1d">Event</span><?php else: ?><span class="tag tag-blue">News</span><?php endif; ?>
            <span><?= e($n['cat_en'] ?? 'General') ?></span>
            <?php if($isEvent): ?><span>•</span><span><?= e(date('M j, Y',$d)) ?><?= !empty($n['event_time'])?' • '.e($n['event_time']):'' ?></span><?php else: ?><span>•</span><span><?= e(date('M j, Y',$d)) ?></span><?php endif; ?>
          </div>
          <h3><?= e($ttl) ?></h3>
          <?php if($isEvent && !empty($loc)): ?><p style="color:var(--primary);font-size:.8rem;font-weight:700;margin-top:2px"><?= e($loc) ?></p><?php endif; ?>
          <?php if($exc): ?><p><?= e($exc) ?></p><?php endif; ?>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;margin-top:18px">
      <h3 style="font-size:1rem">What belongs here</h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.7">News reports <em>completed</em> activities (academic programmes, community events, sports, cultural celebrations). Events are <em>scheduled / upcoming</em> programs with date, venue and time. Official circulars (exam routines, admissions, holidays) are published on the <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">Notice Board</a>.</p>
    </div>

    <div style="margin-top:16px;display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('gallery.php')) ?>" class="btn btn-ghost">Gallery</a>
      <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-ghost">Notice Board</a>
      <a href="<?= e_attr(base_url('about.php')) ?>" class="btn btn-ghost">About School</a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
