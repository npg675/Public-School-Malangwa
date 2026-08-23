<?php $page='citizen-charter'; $title='Citizen Charter — नागरिक वडापत्र'; require_once __DIR__.'/includes/header.php'; ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Citizen Charter</span><h1 style="color:#fff;margin:14px 0 10px">नागरिक वडापत्र</h1><p class="lead" style="color:#C7D7F0">Citizen Charter — services, documents, responsible officer, time and fees. Plus downloadable PDF.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Citizen Charter</span></div></nav>
<section class="section" style="padding-top:20px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px"><a href="#" class="btn btn-primary"><svg class="ic"><use href="#i-download"/></svg> Download Official PDF</a><span style="font-size:.82rem;color:var(--muted);align-self:center">Last updated: <em>to be set by admin</em></span></div>
    <div style="overflow:auto;border:1px solid var(--border);border-radius:12px">
      <table style="width:100%;border-collapse:collapse;font-size:.88rem;min-width:720px">
        <thead><tr style="background:var(--primary);color:#fff"><th style="padding:10px;text-align:left">Service</th><th style="padding:10px;text-align:left">Required Documents</th><th style="padding:10px;text-align:left">Responsible Officer</th><th style="padding:10px;text-align:left">Expected Time</th><th style="padding:10px;text-align:left">Fee</th><th style="padding:10px;text-align:left">Complaint Officer</th></tr></thead>
        <tbody>
          <tr style="background:var(--bg)"><td style="padding:12px;border-bottom:1px solid var(--border)"><em>Sample — to be filled</em></td><td style="padding:12px;border-bottom:1px solid var(--border)">—</td><td style="padding:12px;border-bottom:1px solid var(--border)">—</td><td style="padding:12px;border-bottom:1px solid var(--border)">—</td><td style="padding:12px;border-bottom:1px solid var(--border)">—</td><td style="padding:12px;border-bottom:1px solid var(--border)">—</td></tr>
          <tr><td colspan="6" style="padding:18px;text-align:center;color:var(--muted)">Admin can edit this table via Resources → Citizen Charter — HTML + PDF. No unverified values are published.</td></tr>
        </tbody>
      </table>
    </div>
    <div class="verify-banner" style="margin-top:14px"><svg class="ic"><use href="#i-info"/></svg><span>Structure ready: service, documents, officer, time, fee, complaint officer. Fill only with verified data.</span></div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
