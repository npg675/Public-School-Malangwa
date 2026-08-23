<?php $page='events'; $title='Events — Upcoming & Scheduled | Shree Public Secondary School'; $description='Upcoming events at Shree Public Secondary School, Malangwa-2 — trainings, celebrations, community programs with date, venue and time.'; require_once __DIR__.'/includes/header.php'; $events=get_events(20); ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Events</span><h1 style="color:#fff;margin:14px 0 10px">Events Calendar</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Scheduled and upcoming activities — with date, title, venue, start time and description. Completed activities are reported as <a href="<?= e_attr(base_url('news.php')) ?>" style="color:var(--gold);text-decoration:underline">News</a>, not events.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Events</span></div></nav>
<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:18px">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)">News vs. Events:</strong> Events are <em>scheduled / upcoming</em> (with date / venue / time). Once completed, they are reported as <a href="<?= e_attr(base_url('news.php')) ?>" style="color:var(--primary);font-weight:700">News</a>. No fake school events are created. Verified community activities are listed only when confidently matched.</div>
    </div>

    <div class="event-list" style="max-width:760px">
      <?php foreach($events as $ev): $d=strtotime($ev['event_date']); ?>
      <article class="event-card"><div class="event-date"><span class="d"><?= date('d',$d) ?></span><span class="m"><?= date('M Y',$d) ?></span></div><div class="event-body"><h4><?= e(current_lang()==='np' && !empty($ev['title_np']) ? $ev['title_np'] : $ev['title_en']) ?></h4><p style="color:var(--muted);font-size:.84rem"><?= e($ev['location_en'] ?? '') ?><?php if(!empty($ev['event_time'])): ?> • <?= e($ev['event_time']) ?><?php endif; ?> <?php if(!empty($ev['category'])): ?><span style="background:var(--surface-low);border:1px solid var(--border);padding:2px 8px;border-radius:999px;font-size:.7rem;font-weight:700"><?= e($ev['category']) ?></span><?php endif; ?></p><p style="margin-top:6px;color:var(--muted);font-size:.88rem;line-height:1.6"><?= e($ev['summary_en'] ?? '') ?></p><?php if(!empty($ev['description_en'])): ?><p style="margin-top:6px;color:var(--muted);font-size:.84rem"><?= e($ev['description_en']) ?></p><?php endif; ?></div></article>
      <?php endforeach; ?>
      <?php if(empty($events)): ?><div class="empty"><svg class="ic"><use href="#i-calendar"/></svg><h4>No upcoming events right now</h4><p>Events, trainings and celebrations will be published here as scheduled. Check <a href="<?= e_attr(base_url('news.php')) ?>" style="color:var(--primary);font-weight:700">News</a> for completed activities or <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">Notice Board</a> for official notices.</p></div><?php endif; ?>
    </div>

    <div style="margin-top:18px;background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px;max-width:760px">
      <h3 style="font-size:1rem">Fields for each event</h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.6">Each event record includes: <strong>date</strong> • <strong>title</strong> • <strong>venue</strong> • <strong>start time</strong> • <strong>description</strong> • <strong>category</strong> (Academic / Sports / Cultural / Community). Managed via CMS. No placeholder events are published as real.</p>
      <div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap"><a href="<?= e_attr(base_url('news.php')) ?>" class="btn btn-soft">View News</a><a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-ghost">Notice Board</a><a href="<?= e_attr(base_url('gallery.php')) ?>" class="btn btn-ghost">Gallery</a></div>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
