<?php $page='news'; $title='News — Shree Public Secondary School'; require_once __DIR__.'/includes/header.php'; ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> News</span><h1 style="color:#fff;margin:14px 0 10px">School News</h1><p class="lead" style="color:#C7D7F0">Activities, competitions, programs and achievements — separate from official notices.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>News</span></div></nav>
<section class="section" style="padding-top:20px">
  <div class="wrap">
    <div style="display:grid;gap:14px;grid-template-columns:repeat(auto-fill,minmax(280px,1fr))">
      <?php $news=[
        ['title'=>'Annual Parents Meeting','date'=>'2026-03-18','cat'=>'Community','img'=>'https://images.pexels.com/photos/5212345/pexels-photo-5212345.jpeg?auto=compress&cs=tinysrgb&w=600&h=400&fit=crop'],
        ['title'=>'Science Exhibition Grade 10','date'=>'2026-02-20','cat'=>'Academic','img'=>'https://images.pexels.com/photos/6208728/pexels-photo-6208728.jpeg?auto=compress&cs=tinysrgb&w=600&h=400&fit=crop'],
        ['title'=>'Inter-House Sports Week','date'=>'2026-02-10','cat'=>'Sports','img'=>'https://images.pexels.com/photos/36871459/pexels-photo-36871459.jpeg?auto=compress&cs=tinysrgb&w=600&h=400&fit=crop'],
      ]; foreach($news as $n): ?>
      <article class="news-card"><div class="news-thumb"><img src="<?= e_attr($n['img']) ?>" alt="" loading="lazy"></div><div class="news-body"><div class="news-meta"><span><?= e($n['cat']) ?></span><span>•</span><span><?= e($n['date']) ?></span></div><h3><?= e($n['title']) ?></h3><p>Sample news — replace with school's own photos and bilingual content via Admin → News.</p><a href="#" style="font-weight:700;color:var(--primary);font-size:.84rem;margin-top:8px;display:inline-flex">Read more →</a></div></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
