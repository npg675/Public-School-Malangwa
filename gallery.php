<?php $page='gallery'; $title='Gallery — Life at Shree Public Secondary School'; require_once __DIR__.'/includes/header.php'; $albums=get_gallery_albums(12); ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Gallery</span><h1 style="color:#fff;margin:14px 0 10px">Life at Shree Public Secondary School</h1><p class="lead" style="color:#C7D7F0;max-width:640px">Campus, classrooms, assembly, sports, cultural programs — authentic photos replace placeholders.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Gallery</span></div></nav>
<section class="section" style="padding-top:20px">
  <div class="wrap">
    <div class="gallery-grid">
      <?php foreach($albums as $alb): ?>
      <a class="g-tile" href="#<?= e_attr($alb['slug']) ?>" id="<?= e_attr($alb['slug']) ?>"><img src="<?= e_attr($alb['cover']) ?>" alt="<?= e_attr($alb['title_en']) ?>" loading="lazy"><span class="cap"><?= e($alb['title_en']) ?> <small><?= (int)$alb['count'] ?> photos</small></span></a>
      <?php endforeach; ?>
    </div>
    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px;margin-top:18px">
      <h3 style="font-size:1rem">Lightbox &amp; Admin</h3><p style="color:var(--muted);font-size:.88rem;margin-top:6px">Frontend: responsive masonry, lightbox, keyboard support, lazy loading. Admin: create album → upload multiple → reorder → cover → bilingual captions → publish. No foreign stock in production.</p>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
