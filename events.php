<?php $page='events'; $title='Events — Shree Public Secondary School'; require_once __DIR__.'/includes/header.php'; $events=get_events(12); ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Events</span><h1 style="color:#fff;margin:14px 0 10px">Events Calendar</h1><p class="lead" style="color:#C7D7F0">Trainings, celebrations and community programs with date, location and time.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Events</span></div></nav>
<section class="section" style="padding-top:20px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div class="event-list" style="max-width:720px">
      <?php foreach($events as $ev): $d=strtotime($ev['event_date']); ?>
      <article class="event-card"><div class="event-date"><span class="d"><?= date('d',$d) ?></span><span class="m"><?= date('M Y',$d) ?></span></div><div class="event-body"><h4><?= e($ev['title_en']) ?></h4><p><?= e($ev['location_en']) ?></p><p style="margin-top:4px;color:var(--muted)"><?= e($ev['summary_en']??'') ?></p></div></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
