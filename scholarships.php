<?php $page='scholarships'; $title='Scholarships — Shree Public Secondary School'; require_once __DIR__.'/includes/header.php'; ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Scholarships</span><h1 style="color:#fff;margin:14px 0 10px">Scholarships</h1><p class="lead" style="color:#C7D7F0">Verified scholarship notices — eligibility, quota and application details from school office.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Scholarships</span></div></nav>
<section class="section" style="padding-top:20px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div class="empty"><svg class="ic"><use href="#i-award"/></svg><h4>Scholarship notices will be published here</h4><p>Admin → Resources → Scholarships. Attach PDF with quota and criteria. No invented lists.</p></div>
    <div style="margin-top:16px;display:grid;gap:12px;grid-template-columns:1fr 1fr">
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px"><h4>Quota</h4><p style="color:var(--muted);font-size:.88rem;margin-top:4px"><em>TBC — added when notice issued.</em></p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px"><h4>How to apply</h4><p style="color:var(--muted);font-size:.88rem;margin-top:4px">See attached notice for documents and deadline. Contact office for guidance.</p></div>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
