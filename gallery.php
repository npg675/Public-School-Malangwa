<?php $page='gallery'; $title='Gallery — Life at Shree Public Secondary School, Malangwa-2'; $description='School life at Shree Public Secondary School — campus, classrooms, assembly, science, sports, cultural and community programs. Albums with authentic photographs.'; require_once __DIR__.'/includes/header.php'; $albums=get_gallery_albums(12); ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Gallery</span><h1 style="color:#fff;margin:14px 0 10px">Life at Shree Public Secondary School</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Campus, classroom activities, academic programs, sports, cultural programmes, community programmes and celebrations — organised in albums. The same photograph is never repeated to fill space; empty albums are hidden.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Gallery</span></div></nav>
<section class="section" style="padding-top:28px">
  <div class="wrap">
    <!-- Album categories intro -->
    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:18px">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)">Albums &amp; categories:</strong> School Campus • Classroom Activities • Academic Programs • Sports • Cultural Activities • Community Programs • Events • Celebrations. Albums are shown only when they contain photographs. <em>Placeholder stock images below are replaced by authentic school photographs when supplied — no stock is used as permanent content.</em></div>
    </div>

    <!-- Filter pills (non-functional anchor filters until JS) -->
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
      <?php $galleryCats=['All','Campus','Classrooms','Assembly & Events','Science Activities','Sports','Community Programs']; foreach($galleryCats as $gc): ?><span class="tag"><?= e($gc) ?></span><?php endforeach; ?>
    </div>

    <div class="gallery-grid">
      <?php foreach($albums as $alb): ?>
      <a class="g-tile" href="#<?= e_attr($alb['slug']) ?>" id="<?= e_attr($alb['slug']) ?>" style="min-height:180px"><img src="<?= e_attr($alb['cover']) ?>" alt="<?= e_attr($alb['title_en']) ?>" loading="lazy"><span class="cap"><?= e($alb['title_en']) ?> <small>Album • photos being updated</small></span></a>
      <?php endforeach; ?>
    </div>

    <?php if(empty($albums)): ?>
      <div class="empty" style="margin-top:18px"><svg class="ic"><use href="#i-camera"/></svg><h4>Photos will be published soon</h4><p>Albums will appear here once the school supplies authentic photographs. No photographs are duplicated to fill the grid.</p></div>
    <?php endif; ?>

    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px;margin-top:18px">
      <h3 style="font-size:1rem">About this gallery</h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.7">Frontend: responsive masonry, lightbox with keyboard support, lazy loading, and bilingual captions where supplied. Admin workflow: create album → upload multiple → reorder → set cover → add bilingual captions → publish. Empty albums are hidden automatically. <strong>Admin → Gallery.</strong></p>
      <div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap"><a href="<?= e_attr(base_url('news.php')) ?>" class="btn btn-soft">Related: News</a><a href="<?= e_attr(base_url('events.php')) ?>" class="btn btn-ghost">Events</a><a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-ghost">Contact</a></div>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
