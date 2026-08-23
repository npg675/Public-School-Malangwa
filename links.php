<?php $page='links'; $title='Useful Links — Government & Education Portals | Shree Public Secondary School'; $description='Government and education links — Ministry of Education, CEHRD, NEB, CDC, SEE, Malangwa Municipality and Madhesh Province.'; require_once __DIR__.'/includes/header.php'; ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Useful Links</span><h1 style="color:#fff;margin:14px 0 10px">Government &amp; Educational Links</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Direct links to MOEST, CEHRD, NEB, Curriculum Development Centre, SEE and Malangwa Municipality — all external, open in a new tab, clearly marked.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Useful Links</span></div></nav>
<section class="section" style="padding-top:28px">
  <div class="wrap">
    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:18px">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)">External portals:</strong> All links below open in a new tab. They are independent government or board websites — not part of this school site. For guidance on how to use each portal, follow the description under each link. Links are managed via <strong>Admin → Resources → Useful Links</strong>.</div>
    </div>
    <div class="gov-grid">
      <a class="gov-link" href="https://moest.gov.np" target="_blank" rel="noopener"><span style="flex:1">Ministry of Education, Science &amp; Technology<br><span style="font-weight:400;font-size:.78rem;color:var(--muted)">Policy, national education information</span></span><span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://cehrd.gov.np" target="_blank" rel="noopener"><span style="flex:1">CEHRD — Center for Education and Human Resource Development<br><span style="font-weight:400;font-size:.78rem;color:var(--muted)">IEMIS, school education administration</span></span><span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://neb.gov.np" target="_blank" rel="noopener"><span style="flex:1">National Examinations Board (NEB)<br><span style="font-weight:400;font-size:.78rem;color:var(--muted)">Grade 11–12 registration, examinations, results</span></span><span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://cdc.gov.np" target="_blank" rel="noopener"><span style="flex:1">Curriculum Development Centre (CDC)<br><span style="font-weight:400;font-size:.78rem;color:var(--muted)">Curriculum, textbooks, learning materials</span></span><span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://see.gov.np" target="_blank" rel="noopener"><span style="flex:1">SEE<br><span style="font-weight:400;font-size:.78rem;color:var(--muted)">Secondary Education Examination</span></span><span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://malangwamun.gov.np" target="_blank" rel="noopener"><span style="flex:1">Malangwa Municipality<br><span style="font-weight:400;font-size:.78rem;color:var(--muted)">Local government — ward, municipal notices</span></span><span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://madhesh.gov.np" target="_blank" rel="noopener"><span style="flex:1">Madhesh Province<br><span style="font-weight:400;font-size:.78rem;color:var(--muted)">Provincial government</span></span><span class="ext">external ↗</span></a>
      <a class="gov-link" href="https://www.nea.gov.np" target="_blank" rel="noopener"><span style="flex:1">National Education-related Portals<br><span style="font-weight:400;font-size:.78rem;color:var(--muted)">Additional references — verify before use</span></span><span class="ext">external ↗</span></a>
    </div>
    <div style="margin-top:18px;background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px">
      <h3 style="font-size:1rem">Related on this site</h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.6">School-curated information lives on <a href="<?= e_attr(base_url('academics.php')) ?>" style="color:var(--primary);font-weight:700">Academics</a>, <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">Notice Board</a> and <a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700">Downloads</a>.</p>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
