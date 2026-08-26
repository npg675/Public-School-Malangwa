<?php
$slug = strtolower(trim((string)($_GET['slug'] ?? '')));
if ($slug === '' || !preg_match('/^[a-z0-9-]+$/', $slug)) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

require_once __DIR__ . '/includes/helpers.php';
$pageRow = get_page_content($slug);
if (!$pageRow) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$page = 'page';
$title = page_val($pageRow, 'title') . ' | ' . setting('site_name_en', APP_NAME_EN);
$description = (string)($pageRow['meta_description'] ?? '');
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero" style="padding:40px 0 32px">
  <div class="hero-grid" aria-hidden="true"></div>
  <div class="wrap" style="position:relative">
    <span class="hero-badge"><span class="dot"></span> <?= e(page_val($pageRow, 'title')) ?></span>
    <h1 style="color:#fff;margin:14px 0 10px"><?= e(page_val($pageRow, 'title')) ?></h1>
  </div>
</section>
<nav class="wrap" style="padding:14px 20px">
  <div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>"><?= e(t('Home', 'गृह')) ?></a><span class="sep">/</span><span><?= e(page_val($pageRow, 'title')) ?></span></div>
</nav>
<section class="section page-content" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="max-width:900px">
    <?= page_val($pageRow, 'content') ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
