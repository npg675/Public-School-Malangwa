<?php $page='academic-calendar'; $title='Academic Calendar — Shree Public Secondary School'; require_once __DIR__.'/includes/header.php'; ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Academic Calendar</span><h1 style="color:#fff;margin:14px 0 10px">Academic Calendar 2082</h1><p class="lead" style="color:#C7D7F0">Bikram Sambat + AD where needed. Dates set by school office.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Academic Calendar</span></div></nav>
<section class="section" style="padding-top:20px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div class="empty"><svg class="ic"><use href="#i-calendar"/></svg><h4>Academic calendar will be published soon</h4><p>Admin → Academics → Academic Calendar. Supports BS display date + AD, PDF and HTML.</p></div>
    <div style="margin-top:16px;display:flex;gap:10px"><a href="#" class="btn btn-primary">View Calendar PDF</a><a href="#" class="btn btn-ghost">Download</a></div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
