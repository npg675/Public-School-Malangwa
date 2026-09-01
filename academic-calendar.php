<?php $page='academic-calendar'; $title='Academic Calendar 2082 — Shree Public Secondary School, Malangwa-2'; $description='Academic calendar for Shree Public Secondary School, Malangwa-2 — Bikram Sambat 2082, terms, holidays, examinations and events.'; require_once __DIR__.'/includes/header.php'; $calendarDownloads = get_downloads(4, 'academic-calendar'); $calendarDownload = $calendarDownloads[0] ?? null; ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Academic Calendar</span><h1 style="color:#fff;margin:14px 0 10px">Academic Calendar 2082 BS</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Bikram Sambat with AD where helpful. Official calendar with terms, holidays, examinations, admissions and events — set by the school office. Also available as downloadable PDF in Downloads.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Academic Calendar</span></div></nav>
<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:18px">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)">Bikram Sambat calendar:</strong> Nepal's school year runs on Bikram Sambat. This page displays the official 2082 BS calendar as HTML with key dates and as a downloadable PDF. Dates are set by the school office each year — this page does not assume a generic calendar. When published, the HTML table and PDF are kept in sync by Admin.</div>
    </div>

    <div style="display:grid;gap:14px;grid-template-columns:1fr 1fr;margin-bottom:18px">
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.9rem">What the calendar includes</h4><p style="font-size:.84rem;color:var(--muted);margin-top:6px;line-height:1.6">Session start / end • Terms • School holidays • Examination periods • Admission windows • Major events. Each entry shows both BS and AD where helpful.</p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.9rem">How to get it</h4><p style="font-size:.84rem;color:var(--muted);margin-top:6px;line-height:1.6">View the calendar as PDF (printable) or browse the HTML table below once published. Academic notices are also published on the <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">Notice Board</a>.</p></div>
    </div>

    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:18px">
      <?php if ($calendarDownload): ?>
        <a href="<?= e_attr(media_url($calendarDownload['file_path'])) ?>" target="_blank" rel="noopener" class="btn btn-primary"><svg class="ic"><use href="#i-calendar"/></svg> View Calendar PDF (2082)</a>
        <a href="<?= e_attr(media_url($calendarDownload['file_path'])) ?>" download class="btn btn-ghost"><svg class="ic"><use href="#i-download"/></svg> Download PDF</a>
      <?php else: ?>
        <span class="btn btn-ghost" style="opacity:.55;cursor:not-allowed"><svg class="ic"><use href="#i-calendar"/></svg> Calendar PDF will be published soon</span>
      <?php endif; ?>
      <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-soft">Downloads → Calendar</a>
    </div>

    <div style="overflow:auto;border:1px solid var(--border);border-radius:12px;margin-bottom:16px">
      <table style="width:100%;border-collapse:collapse;font-size:.88rem;min-width:640px">
        <thead><tr style="background:var(--primary);color:#fff"><th style="padding:10px;text-align:left">Period / Event</th><th style="padding:10px;text-align:left">Approx. Date (BS)</th><th style="padding:10px;text-align:left">Note</th></tr></thead>
        <tbody>
          <tr style="background:var(--bg)"><td colspan="3" style="padding:20px;text-align:center;color:var(--muted)"><svg class="ic" style="width:28px;height:28px;margin:0 auto 8px;color:var(--muted-2)"><use href="#i-calendar"/></svg><div style="font-weight:600">Academic calendar will be published soon</div><div style="font-size:.84rem;margin-top:6px">The official calendar PDF is managed in <strong>Admin → Resources → Downloads</strong>. No placeholder dates are shown as official.</div></td></tr>
        </tbody>
      </table>
    </div>

    <div style="background:var(--primary-dark);color:#C7D7F0;border-radius:12px;padding:18px;display:flex;gap:14px;align-items:flex-start">
      <svg class="ic" style="color:var(--gold);width:22px;height:22px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;line-height:1.6"><strong style="color:#fff">Until published:</strong> For term dates and holiday information, refer to the latest <a href="<?= e_attr(base_url('notices.php?category=holiday')) ?>" style="color:var(--gold);text-decoration:underline">holiday notices</a> on the Notice Board or <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--gold);text-decoration:underline">contact the school</a>. The calendar — when available — will cover the same information comprehensively.</div>
    </div>

    <div style="margin-top:16px;display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-soft">Notice Board</a>
      <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-ghost">Downloads</a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
