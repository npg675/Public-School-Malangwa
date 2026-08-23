<?php $page='publications'; $title='Publications — Annual Reports & Documents | Shree Public Secondary School'; $description='Publications from Shree Public Secondary School, Malangwa-2 — annual reports, prospectus, school improvement plans and transparency documents.'; require_once __DIR__.'/includes/header.php'; ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Publications</span><h1 style="color:#fff;margin:14px 0 10px">Publications</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Annual reports, school improvement plans, prospectus and other transparency documents — published here when available from the school administration.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Publications</span></div></nav>
<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:18px">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)">What is published:</strong> School annual reports, financial summaries (as approved for disclosure), School Improvement Plan (SIP) summaries, prospectus and similar institutional publications. Documents are shown with title, category, publish date and file type. No placeholder documents are linked.</div>
    </div>

    <div style="display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));margin-bottom:18px">
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem">Annual Reports</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6">Yearly activity and accountability summaries.</p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem">School Improvement Plan</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6">Improvement priorities and actions.</p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem">Prospectus / Information Booklet</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6">Overview for parents and students.</p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem">Financial / Transparency</h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6">Published summaries as approved for disclosure.</p></div>
    </div>

    <div class="empty"><svg class="ic"><use href="#i-book"/></svg><h4>No publications yet</h4><p>When publications are available they will appear here as cards with PDF preview and download links, and also in <a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700">Downloads → Publications</a>. Managed via <strong>Admin → Resources → Publications</strong>.</p>
      <div style="margin-top:12px;display:flex;gap:8px;justify-content:center;flex-wrap:wrap"><a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-soft">Browse Downloads</a><a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-ghost">Contact office</a></div>
    </div>

    <div style="margin-top:16px;display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-soft">Downloads Centre →</a>
      <a href="<?= e_attr(base_url('citizen-charter.php')) ?>" class="btn btn-ghost">Citizen Charter</a>
      <a href="<?= e_attr(base_url('about.php')) ?>" class="btn btn-ghost">About School</a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
