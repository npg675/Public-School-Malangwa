<?php $page='citizen-charter'; $title='Citizen Charter — नागरिक वडापत्र | Shree Public Secondary School'; $description='Citizen Charter (नागरिक वडापत्र) of Shree Public Secondary School, Malangwa-2 — services, required documents, responsible officer, time, fees and complaint point.'; require_once __DIR__.'/includes/header.php'; ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Citizen Charter</span><h1 style="color:#fff;margin:14px 0 10px">नागरिक वडापत्र — Citizen Charter</h1><p class="lead" style="color:#C7D7F0;max-width:680px">What the Citizen Charter means in a public community school, which services it covers, and the official table (services, documents, officer, time, fees, complaint point). Plus downloadable PDF when available.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Citizen Charter</span></div></nav>
<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <!-- Intro -->
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:20px">
      <span class="eyebrow"><span class="dot"></span> About the Citizen Charter</span>
      <h2 style="margin:12px 0 10px;font-size:1.25rem">What this document represents</h2>
      <div style="color:var(--muted);line-height:1.75;font-size:.92rem;display:flex;flex-direction:column;gap:10px;max-width:760px">
        <p>In Nepal's public institutions a <strong style="color:var(--text)">Citizen Charter / नागरिक वडापत्र</strong> is a public notice that tells citizens exactly which <strong style="color:var(--text)">services</strong> the institution provides, <strong style="color:var(--text)">what documents</strong> are required for each service, <strong style="color:var(--text)">who is responsible</strong>, what <strong style="color:var(--text)">time</strong> it should take, what <strong style="color:var(--text)">fee</strong> (if any) applies, and <strong style="color:var(--text)">where to complain</strong> if the service is not delivered as stated.</p>
        <p>For a community school such as Shree Public Secondary School, typical services listed include admission, issuance of transfer / character / migration certificates, examination-related services, scholarships, and provision of official documents (e.g. grade sheets, letters). This page will display the school's official Citizen Charter as supplied and approved by the school administration.</p>
        <p><em>Until the official Charter table and PDF are supplied, the structured table below is kept empty intentionally. No service, timeframe or fee is invented or assumed. When the school provides the approved charter, Admin publishes it via <strong>Resources → Citizen Charter — HTML + PDF</strong> and this explanatory note is replaced by the official last-updated date and complaint-contact.</em></p>
      </div>
    </div>

    <div style="display:flex;gap:10px;flex-wrap:wrap;margin:18px 0 16px;align-items:center">
      <a href="#" class="btn btn-primary" onclick="event.preventDefault();alert('Official PDF will be downloadable here once the school supplies it.');"><svg class="ic"><use href="#i-download"/></svg> Download Official PDF</a>
      <span style="font-size:.82rem;color:var(--muted);background:var(--surface-low);border:1px solid var(--border);padding:8px 12px;border-radius:999px">Last updated: <em>to be set by admin after verification</em></span>
      <span style="font-size:.82rem;color:var(--muted)">Contact / complaint point: <em>to be published with verified charter</em></span>
    </div>

    <div style="overflow:auto;border:1px solid var(--border);border-radius:12px">
      <table style="width:100%;border-collapse:collapse;font-size:.88rem;min-width:760px">
        <thead><tr style="background:var(--primary);color:#fff"><th style="padding:11px;text-align:left;min-width:160px">Service / सेवा</th><th style="padding:11px;text-align:left">Required Documents / आवश्यक कागजात</th><th style="padding:11px;text-align:left">Responsible Person / जिम्मेवार व्यक्ति</th><th style="padding:11px;text-align:left">Expected Time / लाग्ने समय</th><th style="padding:11px;text-align:left">Applicable Fee / शुल्क</th><th style="padding:11px;text-align:left">Contact / Complaint Point</th></tr></thead>
        <tbody>
          <tr style="background:var(--bg)"><td style="padding:12px;border-bottom:1px solid var(--border)"><em>Sample format — to be filled</em></td><td style="padding:12px;border-bottom:1px solid var(--border)">—</td><td style="padding:12px;border-bottom:1px solid var(--border)">—</td><td style="padding:12px;border-bottom:1px solid var(--border)">—</td><td style="padding:12px;border-bottom:1px solid var(--border)">—</td><td style="padding:12px;border-bottom:1px solid var(--border)">—</td></tr>
          <tr><td colspan="6" style="padding:20px;text-align:center;color:var(--muted)">
            <svg class="ic" style="width:28px;height:28px;margin:0 auto 8px;color:var(--muted-2)"><use href="#i-info"/></svg>
            <div style="font-weight:600">Official Citizen Charter information will be published here as provided by the school.</div>
            <div style="font-size:.82rem;margin-top:6px">Admin can edit this table via Resources → Citizen Charter — HTML + PDF. No unverified values are published. For immediate help, please <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--primary);font-weight:700">contact the school</a>.</div>
          </td></tr>
        </tbody>
      </table>
    </div>
    <div class="verify-banner" style="margin-top:14px"><svg class="ic"><use href="#i-info"/></svg><span>Structure ready: service, documents, responsible person, expected time, applicable fee, contact / complaint point. Fill only with verified institutional data from the school administration.</span></div>

    <div style="margin-top:16px;background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px">
      <h3 style="font-size:1rem">Where to get help meanwhile</h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.6">If you need an official document or service today, visit the school office at Malangwa-2 (VH24+22W) during school hours or <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--primary);font-weight:700">message the school</a>. Office hours and phone are published on the Contact page when verified.</p>
    </div>

    <div style="margin-top:16px;display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-soft">Downloads</a>
      <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-ghost">Notice Board</a>
      <a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-ghost">Contact</a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
