<?php
$page = 'home';
$title = 'Shree Public Secondary School · Malangwa-2, Sarlahi | श्री पब्लिक माध्यमिक विद्यालय';
$description = 'Shree Public Secondary School — public community school ECD to Grade 12, +2 Science & Management (NEB). Malangwa-2, Sarlahi, Madhesh Province. IEMIS 190640003.';
require_once __DIR__ . '/includes/header.php';
$notices = get_notices(5);
$events = get_events(3);
$downloads = get_downloads(6);
$albums = get_gallery_albums(6);
$newsItems = get_news(3);
?>
<!-- 9.4 Hero -->
<section class="hero">
  <div class="hero-grid" aria-hidden="true"></div>
  <div class="wrap hero-inner">
    <div class="hero-copy">
      <span class="hero-badge"><span class="dot"></span> Community School • Malangwa-2, Sarlahi</span>
      <h1>Shree Public<br>Secondary School <span class="accent">— Malangwa-2</span></h1>
      <p class="np">श्री पब्लिक माध्यमिक विद्यालय</p>
      <p class="lead">Providing public education from <strong>Early Childhood Development through Grade 12</strong> in the heart of Malangwa. <strong>1,000+ students</strong> • ECD–12 • +2 Science &amp; Management (NEB).</p>
      <div class="hero-actions">
        <a href="<?= e_attr(base_url('academics.php')) ?>" class="btn btn-gold">Explore Academics <svg class="ic"><use href="#i-arrow"/></svg></a>
        <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn" style="background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.22)">Latest Notices</a>
        <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-ghost" style="background:#fff">Admission Information</a>
      </div>
      <div class="hero-trust">
        <div class="trust-item"><div class="num">1,000+</div><div class="lbl">Students (ECD–12)</div></div>
        <div class="trust-item"><div class="num">ECD–12</div><div class="lbl">Day School • Co-ed</div></div>
        <div class="trust-item"><div class="num">IEMIS 190640003</div><div class="lbl">Public Institution</div></div>
      </div>
    </div>
    <div class="hero-art">
      <div class="art-card">
        <img src="https://images.pexels.com/photos/29659894/pexels-photo-29659894.jpeg?auto=compress&cs=tinysrgb&w=940&h=720&fit=crop" alt="School building placeholder — authentic photo to be supplied by school" width="940" height="720" loading="eager" fetchpriority="high">
      </div>
      <div class="art-chip chip-a"><svg class="ic"><use href="#i-grad"/></svg><span>1,000+ Students<small>ECD to Grade 12</small></span></div>
      <div class="art-chip chip-b"><svg class="ic"><use href="#i-book"/></svg><span>+2 Science &amp; Management<small>NEB affiliated</small></span></div>
      <div class="art-chip chip-c"><svg class="ic"><use href="#i-pin"/></svg><span>Malangwa-2, Sarlahi<small>VH24+22W · 26.8501, 85.5550</small></span></div>
    </div>
  </div>
</section>

<!-- 9.5 Quick Action Panel — 6 links -->
<section class="quick section" style="padding:18px 0 0">
  <div class="wrap">
    <div class="quick-grid">
      <a class="qa-card" href="<?= e_attr(base_url('notices.php')) ?>"><span class="qa-icon"><svg class="ic"><use href="#i-bell"/></svg></span><span class="qa-text"><h3>Latest Notices</h3><p>Circulars &amp; announcements</p></span><svg class="ic arrow"><use href="#i-arrow"/></svg></a>
      <a class="qa-card" href="<?= e_attr(base_url('results.php')) ?>"><span class="qa-icon"><svg class="ic"><use href="#i-search"/></svg></span><span class="qa-text"><h3>Exam Results</h3><p>SEE &amp; +2 results</p></span><svg class="ic arrow"><use href="#i-arrow"/></svg></a>
      <a class="qa-card" href="<?= e_attr(base_url('admissions.php')) ?>"><span class="qa-icon"><svg class="ic"><use href="#i-grad"/></svg></span><span class="qa-text"><h3>Admission</h3><p>ECD to +2 inquiry</p></span><svg class="ic arrow"><use href="#i-arrow"/></svg></a>
      <a class="qa-card" href="<?= e_attr(base_url('downloads.php')) ?>"><span class="qa-icon"><svg class="ic"><use href="#i-download"/></svg></span><span class="qa-text"><h3>Downloads</h3><p>Forms &amp; routines</p></span><svg class="ic arrow"><use href="#i-arrow"/></svg></a>
      <a class="qa-card" href="<?= e_attr(base_url('academic-calendar.php')) ?>"><span class="qa-icon"><svg class="ic"><use href="#i-calendar"/></svg></span><span class="qa-text"><h3>Academic Calendar</h3><p>Year 2082 BS</p></span><svg class="ic arrow"><use href="#i-arrow"/></svg></a>
      <a class="qa-card" href="<?= e_attr(base_url('contact.php')) ?>"><span class="qa-icon"><svg class="ic"><use href="#i-phone"/></svg></span><span class="qa-text"><h3>Contact School</h3><p>Visit &amp; directions</p></span><svg class="ic arrow"><use href="#i-arrow"/></svg></a>
    </div>
  </div>
</section>

<!-- 9.6 School At A Glance -->
<section class="stats">
  <div class="wrap">
    <div class="stats-grid">
      <div class="stat"><div class="num">1,000+</div><div class="lbl">Students</div><div class="sub">ECD–12 • Co-ed</div></div>
      <div class="stat"><div class="num">ECD–12</div><div class="lbl">Education</div><div class="sub">Day School</div></div>
      <div class="stat"><div class="num">2</div><div class="lbl">+2 Streams</div><div class="sub">Science • Management</div></div>
      <div class="stat"><div class="num">190640003</div><div class="lbl">IEMIS Code</div><div class="sub">Public Institution</div></div>
    </div>
  </div>
</section>

<!-- 9.7 About Preview -->
<section class="section">
  <div class="wrap">
    <div class="about-grid">
      <div class="about-copy">
        <span class="eyebrow"><span class="dot"></span> About Our School</span>
        <h2 style="margin:12px 0 14px">Education rooted in our community</h2>
        <p><strong>Shree Public Secondary School</strong> is a public / community institution in <strong>Malangwa Municipality-2, Sarlahi</strong>, Madhesh Province, serving students from <strong>ECD through Grade 12</strong>. Located in the heart of Malangwa (Plus Code VH24+22W), the school plays a central role in local public education — most families in the municipality can complete the full school journey, from early childhood to higher secondary, close to home.</p>
        <p>As a government-recognised community school (IEMIS 190640003), it implements the national curriculum of the Curriculum Development Centre, prepares students for the Secondary Education Examination (SEE) at Grade 10, and offers <strong>+2 Science</strong> and <strong>+2 Management</strong> under the National Examinations Board at Grades 11–12. Around 1,000+ students study across all levels on one campus.</p>
        <p>The school also serves as a venue for municipal and community programmes and publishes its official information — notices, calendars, results and documents — openly through this website.</p>
        <div class="about-quote">Public • Community School • Malangwa-2 • ECD–12 • +2 Science &amp; Management • IEMIS 190640003</div>
        <a href="<?= e_attr(base_url('about.php')) ?>" class="btn btn-primary">Discover Our School <svg class="ic"><use href="#i-arrow"/></svg></a>
      </div>
      <div class="about-media">
        <img src="https://images.pexels.com/photos/35385546/pexels-photo-35385546.jpeg?auto=compress&cs=tinysrgb&w=800&h=600&fit=crop" alt="School campus placeholder — authentic building photo to be added" loading="lazy" width="800" height="600">
        <div class="about-media-cap">Campus view — Malangwa-2 • <em>Placeholder until authentic school photograph is supplied</em></div>
      </div>
    </div>
  </div>
</section>

<!-- 9.8 Principal / Head Teacher Message — rendered only when verified & enabled in CMS -->
<?php $showPrincipal = setting('show_principal','0') === '1'; ?>
<?php if ($showPrincipal): ?><section class="principal section">
  <div class="wrap">
    <div class="principal-grid">
      <div class="principal-photo"><img src="<?= e_attr(setting('principal_photo','')) ?>" alt="Head Teacher" loading="lazy" onerror="this.parentElement.classList.add('principal-photo-placeholder');this.remove()"></div>
      <div class="principal-copy">
        <div class="role">Message from the Head Teacher</div>
        <h3><?= e(setting('principal_name','Head Teacher')) ?></h3>
        <div class="principal-msg"><?= nl2br(e(setting('principal_message_en',''))) ?></div>
        <a href="<?= e_attr(base_url('about.php#leadership')) ?>" class="btn btn-soft" style="margin-top:16px">Read Full Message →</a>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- 9.9 Academic Programs -->
<section class="section">
  <div class="wrap">
    <div class="section-head center">
      <span class="eyebrow"><span class="dot"></span> Learning Pathways</span>
      <h2>From early childhood to higher secondary — one continuum</h2>
      <p>Four stages leading to +2 Science and Management under NEB.</p>
    </div>
    <div class="acad-grid">
      <article class="acad-card"><span class="acad-tag">ECD</span><div class="acad-photo"><img src="https://images.pexels.com/photos/5905929/pexels-photo-5905929.jpeg?auto=compress&cs=tinysrgb&w=600&h=400&fit=crop" alt="ECD children" loading="lazy"></div><div class="acad-top"><span class="acad-icon"><svg class="ic"><use href="#i-star"/></svg></span><div><h3>Early Childhood</h3><p class="acad-level">ECD / Nursery</p></div></div><p>Play-based foundation for our youngest learners — the entry point to basic education.</p><a href="<?= e_attr(base_url('academics.php#ecd')) ?>" class="btn btn-soft" style="margin-top:12px">Learn more</a></article>
      <article class="acad-card"><span class="acad-tag">Basic</span><div class="acad-photo"><img src="https://images.pexels.com/photos/37898351/pexels-photo-37898351.jpeg?auto=compress&cs=tinysrgb&w=600&h=400&fit=crop" alt="Primary classroom" loading="lazy"></div><div class="acad-top"><span class="acad-icon alt"><svg class="ic"><use href="#i-book"/></svg></span><div><h3>Basic Level</h3><p class="acad-level">Grades 1–8</p></div></div><p>Foundational literacy, numeracy and community-rooted learning across eight grades.</p><a href="<?= e_attr(base_url('academics.php#basic')) ?>" class="btn btn-soft" style="margin-top:12px">Learn more</a></article>
      <article class="acad-card"><span class="acad-tag">Secondary</span><div class="acad-photo"><img src="https://images.pexels.com/photos/5212342/pexels-photo-5212342.jpeg?auto=compress&cs=tinysrgb&w=600&h=400&fit=crop" alt="Secondary students" loading="lazy"></div><div class="acad-top"><span class="acad-icon"><svg class="ic"><use href="#i-grad"/></svg></span><div><h3>Secondary</h3><p class="acad-level">Grades 9–10</p></div></div><p>Preparation for the Secondary Education Examination (SEE) and next-step pathways.</p><a href="<?= e_attr(base_url('academics.php#secondary')) ?>" class="btn btn-soft" style="margin-top:12px">Learn more</a></article>
      <article class="acad-card"><span class="acad-tag">+2 NEB</span><div class="acad-photo"><img src="https://images.pexels.com/photos/32213405/pexels-photo-32213405.jpeg?auto=compress&cs=tinysrgb&w=600&h=400&fit=crop" alt="Science lab" loading="lazy"></div><div class="acad-top"><span class="acad-icon gold"><svg class="ic"><use href="#i-flask"/></svg></span><div><h3>Higher Secondary</h3><p class="acad-level">Grades 11–12</p></div></div><p><strong>Science</strong> • <strong>Management</strong> — National Examinations Board programs.</p><a href="<?= e_attr(base_url('science.php')) ?>" class="btn btn-soft" style="margin-top:12px;margin-right:8px">+2 Science →</a><a href="<?= e_attr(base_url('management.php')) ?>" class="btn btn-ghost" style="margin-top:12px">+2 Management →</a></article>
    </div>
  </div>
</section>

<!-- 9.10 Notice & Information Centre -->
<section class="notice-centre section">
  <div class="wrap">
    <div class="section-head">
      <span class="eyebrow"><span class="dot"></span> Official Information</span>
      <h2>Notice &amp; Information Centre</h2>
      <p>The functional heart of the homepage — latest official notices plus important links.</p>
    </div>
    <div class="notice-layout">
      <div class="notice-main">
        <h3>Latest Notices <span class="count"><?= count($notices) ?></span></h3>
        <?php if (empty($notices)): ?>
          <div class="empty"><svg class="ic"><use href="#i-info"/></svg><h4>No notices published yet</h4><p>Official notices will appear here as soon as the school office publishes them.</p></div>
        <?php else: foreach ($notices as $n): $isUrgent = !empty($n['is_urgent']); $isPinned = !empty($n['is_pinned']); $cat = $n['cat_en'] ?? $n['category'] ?? 'General'; $title = (current_lang()==='np' && !empty($n['title_np'])) ? $n['title_np'] : $n['title_en']; $summary = (current_lang()==='np' && !empty($n['summary_np'])) ? $n['summary_np'] : ($n['summary_en'] ?? ''); $date = strtotime($n['published_at']); ?>
          <article class="notice-card <?= $isPinned?'pinned':'' ?>">
            <div class="notice-date"><span class="d"><?= date('d',$date) ?></span><span class="m"><?= date('M',$date) ?></span></div>
            <div class="notice-body">
              <h4><a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>"><?= e($title) ?></a></h4>
              <?php if($summary): ?><p><?= e($summary) ?></p><?php endif; ?>
              <div class="notice-meta">
                <span class="tag <?= $isUrgent?'urgent':'' ?>"><?= $isUrgent?'Urgent • ':'' ?><?= e($cat) ?></span>
                <?php if(!empty($n['is_sample'])): ?><span class="tag" style="background:var(--gold-50);border-color:#FDE68A;color:#6B4F00">Sample</span><?php endif; ?>
                <?php if($isPinned): ?><span class="tag pinned">Pinned</span><?php endif; ?>
                <?php if(!empty($n['reference_number'])): ?><span style="color:var(--muted)">Ref: <?= e($n['reference_number']) ?></span><?php endif; ?>
                <?php if(!empty($n['attachment_type'])): ?><span style="display:inline-flex;align-items:center;gap:4px;color:var(--muted)"><svg class="ic" style="width:14px;height:14px"><use href="#i-doc"/></svg> <?= strtoupper(e($n['attachment_type'])) ?></span><?php endif; ?>
                <a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>" style="margin-left:auto;font-weight:700;color:var(--primary)">View →</a>
              </div>
            </div>
          </article>
        <?php endforeach; endif; ?>
        <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-primary" style="margin-top:12px">View Complete Notice Board <svg class="ic"><use href="#i-arrow"/></svg></a>
      </div>
      <div class="notice-side">
        <h3>Important Links</h3>
        <div class="side-links">
          <a class="side-link" href="<?= e_attr(base_url('citizen-charter.php')) ?>"><svg class="ic"><use href="#i-doc"/></svg> Citizen Charter <span style="margin-left:auto;color:var(--muted-2)">→</span></a>
          <a class="side-link" href="<?= e_attr(base_url('downloads.php')) ?>"><svg class="ic"><use href="#i-download"/></svg> Downloads Centre</a>
          <a class="side-link" href="<?= e_attr(base_url('results.php')) ?>"><svg class="ic"><use href="#i-search"/></svg> Result Search</a>
          <a class="side-link" href="<?= e_attr(base_url('academic-calendar.php')) ?>"><svg class="ic"><use href="#i-calendar"/></svg> Academic Calendar</a>
          <a class="side-link" href="<?= e_attr(base_url('scholarships.php')) ?>"><svg class="ic"><use href="#i-award"/></svg> Scholarships</a>
          <a class="side-link" href="<?= e_attr(base_url('links.php')) ?>"><svg class="ic"><use href="#i-book"/></svg> Government Links</a>
        </div>
        <div class="verify-banner" style="margin-top:16px"><svg class="ic"><use href="#i-info"/></svg><span>Notices support Nepali titles, pinned/urgent flags, expiry dates and PDF attachments — managed in Admin → Notices.</span></div>
      </div>
    </div>
  </div>
</section>

<!-- 9.11 Latest News & Events -->
<section class="section">
  <div class="wrap">
    <div class="section-head">
      <span class="eyebrow"><span class="dot"></span> News &amp; Events</span>
      <h2>Campus life, separate from official notices</h2>
      <p>News celebrates activity; notices carry official information — they are not mixed.</p>
    </div>
    <div class="news-grid">
      <div>
        <h3 style="font-size:1rem;margin-bottom:12px">Latest News</h3>
        <?php if (empty($newsItems)): ?>
          <div class="empty" style="margin-bottom:12px"><svg class="ic"><use href="#i-pen"/></svg><h4>No news published yet</h4><p>Reports of completed school activities — academic, community, sports and cultural — will appear here once published by the school.</p></div>
          <a href="<?= e_attr(base_url('news.php')) ?>" class="btn btn-soft">About the News section →</a>
        <?php else: ?>
        <div style="display:grid;gap:14px">
          <?php foreach ($newsItems as $nw): $cat = $nw['cat_en'] ?? 'News'; $ttl = (current_lang()==='np' && !empty($nw['title_np'])) ? $nw['title_np'] : $nw['title_en']; $excerpt = (current_lang()==='np' && !empty($nw['excerpt_np'])) ? $nw['excerpt_np'] : ($nw['excerpt_en'] ?? ''); $d=strtotime($nw['published_at']); ?>
          <article class="news-card" style="display:flex;gap:0;flex-direction:row">
            <?php if(!empty($nw['cover_image'])): ?><div class="news-thumb" style="width:160px;flex:none;height:auto;min-height:120px"><img src="<?= e_attr(base_url('uploads/'.ltrim($nw['cover_image'],'/'))) ?>" alt="" loading="lazy" onerror="this.parentElement.style.display='none'"></div><?php endif; ?>
            <div class="news-body" style="flex:1">
              <div class="news-meta"><span><?= e($cat) ?></span><span>•</span><span><?= e(date('M j, Y',$d)) ?></span></div>
              <h3><?= e($ttl) ?></h3>
              <?php if($excerpt): ?><p><?= e($excerpt) ?></p><?php endif; ?>
              <a href="<?= e_attr(base_url('news.php')) ?>" style="font-weight:700;color:var(--primary);font-size:.84rem;margin-top:8px;display:inline-flex">Read more →</a>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
        <a href="<?= e_attr(base_url('news.php')) ?>" class="btn btn-soft" style="margin-top:14px">View All News</a>
        <?php endif; ?>
      </div>
      <div>
        <h3 style="font-size:1rem;margin-bottom:12px">Upcoming Events</h3>
        <div class="event-list">
          <?php foreach ($events as $ev): $d=strtotime($ev['event_date']); ?>
          <article class="event-card">
            <div class="event-date"><span class="d"><?= date('d',$d) ?></span><span class="m"><?= date('M',$d) ?></span></div>
            <div class="event-body"><h4><?= e(current_lang()==='np' && !empty($ev['title_np']) ? $ev['title_np'] : $ev['title_en']) ?></h4><p><?= e($ev['location_en'] ?? '') ?><?php if(!empty($ev['event_time'])): ?> • <?= e($ev['event_time']) ?><?php endif; ?></p><p style="margin-top:4px"><?= e($ev['summary_en'] ?? '') ?></p></div>
          </article>
          <?php endforeach; ?>
          <?php if(empty($events)): ?><div class="empty"><h4>No upcoming events</h4><p>Events, trainings and celebrations will be published here.</p></div><?php endif; ?>
        </div>
        <a href="<?= e_attr(base_url('events.php')) ?>" class="btn btn-ghost" style="margin-top:14px;width:100%">View Events Calendar</a>
      </div>
    </div>
  </div>
</section>

<!-- 9.12 Why Our School / Educational Commitment -->
<section class="section" style="background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
  <div class="wrap">
    <div class="section-head center">
      <span class="eyebrow"><span class="dot"></span> Educational Commitment</span>
      <h2>What we stand for — verified, not advertised</h2>
      <p>Each commitment below is CMS-controlled. Facilities appear only after verification.</p>
    </div>
    <div class="commit-grid">
      <div class="commit-item"><svg class="ic"><use href="#i-check"/></svg><div><h4>Inclusive Public Education</h4><p>A community school serving all families in Malangwa-2 — co-educational, day school, ECD to Grade 12.</p></div></div>
      <div class="commit-item"><svg class="ic"><use href="#i-check"/></svg><div><h4>National Curriculum</h4><p>Teaching follows the CDC national curriculum, with SEE at Grade 10 and NEB examinations at +2.</p></div></div>
      <div class="commit-item"><svg class="ic"><use href="#i-check"/></svg><div><h4>Two NEB Streams</h4><p>+2 Science and +2 Management — higher secondary without leaving the community.</p></div></div>
      <div class="commit-item"><svg class="ic"><use href="#i-check"/></svg><div><h4>One Campus, Full Journey</h4><p>Students progress from early childhood to Grade 12 on a single campus in central Malangwa.</p></div></div>
      <div class="commit-item"><svg class="ic"><use href="#i-check"/></svg><div><h4>Community Engagement</h4><p>Venue for municipal and community programmes — e.g., 16-Day Campaign venue, Nov 2025.</p></div></div>
      <div class="commit-item"><svg class="ic"><use href="#i-check"/></svg><div><h4>Open Information</h4><p>Notices, calendars, results and documents published openly on this website for students, parents and citizens.</p></div></div>
      <div class="commit-item"><svg class="ic"><use href="#i-award"/></svg><div><h4>Student Support</h4><p>Scholarship notices and guidance — see the Scholarships page for verified announcements.</p></div></div>
      <div class="commit-item pending"><svg class="ic"><use href="#i-star"/></svg><div><h4>Facilities Directory</h4><p>Lab, library and sports details are listed only after verification by the school administration.</p></div></div>
    </div>
  </div>
</section>

<!-- 9.13 Photo Story / Gallery -->
<section class="section">
  <div class="wrap">
    <div class="section-head center">
      <span class="eyebrow"><span class="dot"></span> Life at School</span>
      <h2>Life at Shree Public Secondary School</h2>
      <p>Authentic moments — placeholders until original school photographs are supplied.</p>
    </div>
    <div class="gallery-grid">
      <?php $first = array_shift($albums); if($first): ?>
      <a class="g-tile span2" href="<?= e_attr(base_url('gallery.php#'.$first['slug'])) ?>"><img src="<?= e_attr($first['cover']) ?>" alt="<?= e_attr($first['title_en']) ?>" loading="lazy"><span class="cap"><?= e($first['title_en']) ?> <small>Album • photos being updated</small></span></a>
      <?php endif; ?>
      <?php foreach ($albums as $alb): ?>
      <a class="g-tile" href="<?= e_attr(base_url('gallery.php#'.$alb['slug'])) ?>"><img src="<?= e_attr($alb['cover']) ?>" alt="<?= e_attr($alb['title_en']) ?>" loading="lazy"><span class="cap"><?= e($alb['title_en']) ?> <small>Album</small></span></a>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:18px"><a href="<?= e_attr(base_url('gallery.php')) ?>" class="btn btn-primary">Explore Gallery <svg class="ic"><use href="#i-arrow"/></svg></a></div>
  </div>
</section>

<!-- 9.14 Downloads & Resources -->
<section class="section" style="background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
  <div class="wrap">
    <div class="section-head">
      <span class="eyebrow"><span class="dot"></span> Resources</span>
      <h2>Downloads &amp; Resources</h2>
      <p>Forms, routines, calendars and official documents — one place, always current.</p>
    </div>
    <div class="download-list">
      <?php foreach ($downloads as $dl): ?>
      <div class="dl-row">
        <span class="dl-icon"><svg class="ic"><use href="#i-doc"/></svg></span>
        <div class="dl-body"><h4><?= e(current_lang()==='np' && !empty($dl['title_np']) ? $dl['title_np'] : $dl['title_en']) ?></h4><div class="dl-meta"><span><?= e($dl['cat_en'] ?? $dl['category'] ?? 'Document') ?></span><span>•</span><span><?= e($dl['published_at']) ?></span><span>•</span><span><?= e($dl['file_size'] ?? '') ?> <?= e($dl['file_type'] ?? 'PDF') ?></span><?php if(!empty($dl['is_sample'])): ?><span style="background:var(--gold-50);border:1px solid #FDE68A;color:#6B4F00;padding:2px 8px;border-radius:999px;font-weight:700">Sample</span><?php endif; ?></div></div>
        <div class="dl-actions"><a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-soft">View</a><a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-ghost">Download</a></div>
      </div>
      <?php endforeach; ?>
      <?php if(empty($downloads)): ?><div class="empty"><h4>No documents yet</h4><p>Academic calendar, routines and forms will be published here.</p></div><?php endif; ?>
    </div>
    <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-primary" style="margin-top:16px">Browse All Downloads</a>
  </div>
</section>

<!-- 9.15 Government & Educational Links -->
<section class="section">
  <div class="wrap">
    <div class="section-head">
      <span class="eyebrow"><span class="dot"></span> Official Resources</span>
      <h2>Government &amp; Educational Links</h2>
      <p>External portals — open in new tabs, clearly marked.</p>
    </div>
    <div class="gov-grid">
      <a class="gov-link" href="https://moest.gov.np" target="_blank" rel="noopener">Ministry of Education, Science &amp; Technology <span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://cehrd.gov.np" target="_blank" rel="noopener">CEHRD <span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://neb.gov.np" target="_blank" rel="noopener">National Examinations Board <span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://cdc.gov.np" target="_blank" rel="noopener">Curriculum Development Centre <span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://see.gov.np" target="_blank" rel="noopener">SEE <span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://malangwamun.gov.np" target="_blank" rel="noopener">Malangwa Municipality <span class="ext">external ↗</span></a>
    </div>
  </div>
</section>

<!-- 9.16 Contact & Map -->
<section class="section" style="background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div class="section-head">
      <span class="eyebrow"><span class="dot"></span> Visit Us</span>
      <h2>Visit Our School</h2>
      <p>Malangwa-2, Sarlahi — with map and directions.</p>
    </div>
    <div class="contact-grid">
      <div class="map-wrap">
        <iframe src="https://www.google.com/maps?q=<?= e_attr(APP_MAP_QUERY) ?>&z=16&output=embed&hl=en" title="Map — Shree Public Secondary School, Malangwa-2 (VH24+22W)" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
        <a class="map-fab" href="https://www.google.com/maps/search/?api=1&query=<?= e_attr(APP_MAP_QUERY) ?>" target="_blank" rel="noopener"><svg class="ic"><use href="#i-pin"/></svg> Get Directions — VH24+22W</a>
      </div>
      <div class="contact-info">
        <div class="contact-cards">
          <div class="c-card"><span class="c-icon"><svg class="ic"><use href="#i-pin"/></svg></span><div><h4>Address</h4><p>Shree Public Secondary School<br>Malangwa-2, Sarlahi<br>Madhesh Province 45800, Nepal<br><span style="font-size:.82rem;color:var(--primary)">VH24+22W · 26.8501032, 85.555064</span></p></div></div>
          <div class="c-card"><span class="c-icon"><svg class="ic"><use href="#i-phone"/></svg></span><div><h4>Call</h4><?php if(APP_PHONE): ?><a class="tel" href="tel:<?= e_attr(APP_PHONE) ?>"><?= e(APP_PHONE) ?></a><?php else: ?><p><em style="color:var(--muted)">Phone — to be verified by school. Contact form below.</em></p><?php endif; ?><p style="font-size:.82rem;margin-top:6px">Office hours: <?= APP_OFFICE_HOURS ? e(APP_OFFICE_HOURS) : '<em>to be confirmed</em>' ?></p></div></div>
          <div class="c-card"><span class="c-icon gold"><svg class="ic"><use href="#i-mail"/></svg></span><div><h4>Email</h4><p><?= APP_EMAIL ? e(APP_EMAIL) : '<em>to be confirmed — not published until verified</em>' ?></p></div></div>
          <div class="c-card"><span class="c-icon gold"><svg class="ic"><use href="#i-clock"/></svg></span><div><h4>IEMIS Code</h4><p><strong>190640003</strong> — Public Educational Institution</p></div></div>
        </div>
        <div class="c-actions">
          <?php if(APP_PHONE): ?><a href="tel:<?= e_attr(APP_PHONE) ?>" class="btn btn-primary">Call School</a><?php endif; ?>
          <a href="https://www.google.com/maps/search/?api=1&query=<?= e_attr(APP_MAP_QUERY) ?>" target="_blank" rel="noopener" class="btn btn-ghost">Get Directions</a>
          <a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-soft">Message School</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
