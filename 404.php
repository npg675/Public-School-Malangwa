<?php $page='404'; $title='Page Not Found — Shree Public Secondary School'; $description='The page you are looking for does not exist.'; require_once __DIR__ . '/includes/helpers.php'; require_once __DIR__ . '/includes/header.php'; ?>
<section class="section" style="text-align:center;padding:80px 0">
  <div class="wrap" style="max-width:640px">
    <span class="eyebrow"><span class="dot"></span> 404 — Not Found</span>
    <h1 style="margin:16px 0 12px">Page not found</h1>
    <p style="color:var(--muted)">The page you are looking for does not exist or has been moved. Try searching or go back to the homepage.</p>
    <div style="margin-top:24px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
      <a href="<?= e_attr(base_url()) ?>" class="btn btn-primary">Go to Homepage</a>
      <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-ghost">Notice Board</a>
      <a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-soft">Contact School</a>
    </div>
    <form action="<?= e_attr(base_url('search.php')) ?>" method="get" style="margin-top:24px;display:flex;gap:8px;max-width:420px;margin-left:auto;margin-right:auto">
      <input type="search" name="q" placeholder="Search notices, downloads..." style="flex:1;padding:12px 14px;border:1.5px solid var(--border);border-radius:10px">
      <button class="btn btn-primary" type="submit">Search</button>
    </form>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
