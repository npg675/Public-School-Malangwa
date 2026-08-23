<?php $page='500'; $title='Something went wrong — Shree Public Secondary School'; require_once __DIR__ . '/includes/header.php'; ?>
<section class="section" style="text-align:center;padding:80px 0">
  <div class="wrap" style="max-width:640px">
    <span class="eyebrow" style="background:var(--red-50);border-color:#FECACA;color:var(--red)"><span class="dot" style="background:var(--red)"></span> 500 — Server Error</span>
    <h1 style="margin:16px 0 12px">Something went wrong</h1>
    <p style="color:var(--muted)">We are working to fix this. Please try again in a moment or contact the school office.</p>
    <div style="margin-top:24px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
      <a href="<?= e_attr(base_url()) ?>" class="btn btn-primary">Homepage</a>
      <a href="https://www.google.com/maps/search/?api=1&query=<?= e_attr(APP_MAP_QUERY) ?>" target="_blank" rel="noopener" class="btn btn-ghost">Get Directions</a>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
