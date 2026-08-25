<?php
$page='gallery';
$title='Gallery — Life at Shree Public Secondary School, Malangwa-2';
$description='School life at Shree Public Secondary School — campus, classrooms, assembly, science, sports, cultural and community programs. Albums with authentic photographs.';
$useTailwind = true;
require_once __DIR__.'/includes/header.php';

$pdo = db();
$albums = []; $counts = [];
if ($pdo && db_has_table('gallery_albums')) {
    try {
        $hasImages = db_has_table('gallery_images');
        $sql = "SELECT a.*" . ($hasImages ? ", (SELECT COUNT(*) FROM gallery_images gi WHERE gi.album_id = a.id) AS photo_count" : ", 0 AS photo_count") . " FROM gallery_albums a WHERE a.status='published' ORDER BY a.sort_order, a.title_en LIMIT 24";
        $albums = $pdo->query($sql)->fetchAll();
    } catch (Throwable $e) {}
}
$catLabel = function (string $slug): string {
    $p = explode('-', $slug)[0];
    return match ($p) {
        'campus'    => 'School & Campus',
        'assembly'  => 'Assembly & Events',
        'staff'     => 'Staff & Leadership',
        'community' => 'Community Programs',
        'sports'    => 'Sports',
        'cultural'  => 'Cultural Programs',
        default     => ucwords($p),
    };
};
?>
<div class="bg-bg-surface font-body-md text-on-surface antialiased">
<main class="w-full max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">

  <!-- 1. Breadcrumb -->
  <nav aria-label="Breadcrumb" class="mb-6 flex items-center gap-2 text-label-md text-on-surface-variant">
    <a class="hover:text-primary transition-colors" href="<?= e_attr(base_url()) ?>">Home</a>
    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
    <span aria-current="page" class="text-primary font-medium">Gallery</span>
  </nav>

  <!-- 2. Page Title -->
  <header class="mb-10 text-center md:text-left">
    <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-text-heading mb-4">Photo Gallery</h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
      Explore memorable moments, activities, achievements, and events from our school.
    </p>
  </header>

  <?php if (empty($albums)): ?>
  <!-- Empty state -->
  <div class="bg-surface-lowest border border-border-base rounded-xl civic-shadow p-12 text-center">
    <span class="material-symbols-outlined text-5xl text-outline mb-4">photo_library</span>
    <h2 class="font-headline-sm text-headline-sm text-text-heading mb-2">Photos will be published soon</h2>
    <p class="font-body-md text-body-md text-on-surface-variant max-w-md mx-auto">Albums will appear here once the school publishes authentic photographs from campus life.</p>
  </div>
  <?php else: ?>

  <!-- 3. Category Filters -->
  <div class="mb-10 overflow-x-auto no-scrollbar pb-2">
    <div class="flex items-center gap-3 w-max">
      <button class="px-5 py-2.5 rounded-full font-label-md text-label-md bg-primary-container text-on-primary transition-colors">All</button>
      <?php $seen = []; foreach ($albums as $alb): $lbl = $catLabel($alb['slug']); if (in_array($lbl, $seen, true)) continue; $seen[] = $lbl; ?>
      <a href="#<?= e_attr($alb['slug']) ?>" class="px-5 py-2.5 rounded-full font-label-md text-label-md bg-surface text-on-surface-variant border border-border-base hover:bg-surface-container-high transition-colors"><?= e($lbl) ?></a>
      <?php endforeach; ?>
    </div>
  </div>

  <?php
    $featured = $albums[0];
    $rest = array_slice($albums, 1);
    $featImg = !empty($featured['cover_image']) ? base_url($featured['cover_image']) : base_url('uploads/gallery/campus/front-building-entrance.jpg');
  ?>
  <!-- 4. Featured Album -->
  <section class="mb-12 rounded-xl overflow-hidden bg-surface border border-border-base civic-shadow flex flex-col md:flex-row">
    <div class="w-full md:w-2/3 h-64 md:h-[400px] relative">
      <img class="w-full h-full object-cover" alt="<?= e_attr($featured['title_en']) ?>" src="<?= e_attr($featImg) ?>">
      <div class="absolute top-4 left-4 bg-primary-container/90 text-on-primary font-label-sm text-label-sm px-3 py-1.5 rounded-full backdrop-blur-sm">Featured Album</div>
    </div>
    <div class="w-full md:w-1/3 p-6 md:p-8 flex flex-col justify-center">
      <div class="flex items-center gap-2 mb-3">
        <span class="bg-surface-container-high text-on-surface-variant px-2.5 py-1 rounded font-label-sm text-label-sm"><?= e($catLabel($featured['slug'])) ?></span>
      </div>
      <h2 class="font-headline-md text-headline-md text-text-heading mb-3"><?= e($featured['title_en']) ?></h2>
      <p class="font-body-sm text-body-sm text-on-surface-variant mb-6"><?= e($featured['description_en'] ?? 'Photographs from ' . $featured['title_en'] . '.') ?></p>
      <div class="flex items-center gap-6 mb-8 text-on-surface-variant font-label-sm text-label-sm">
        <div class="flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[18px]">calendar_month</span>
          <span><?= e(date('M Y', strtotime($featured['created_at'] ?? 'now'))) ?></span>
        </div>
        <div class="flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[18px]">photo_library</span>
          <span><?= (int)$featured['photo_count'] ?> Photos</span>
        </div>
      </div>
      <button onclick="openLightbox(0)" class="w-full flex justify-center items-center gap-2 bg-primary-container text-on-primary hover:bg-primary transition-colors py-3 px-6 rounded-lg font-label-lg text-label-lg min-h-[44px]">
        <span class="material-symbols-outlined text-[20px]">visibility</span> View Album
      </button>
    </div>
  </section>

  <!-- 5. Photo Album Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
    <?php foreach ($rest as $i => $alb): $idx = $i + 1;
      $cover = !empty($alb['cover_image']) ? base_url($alb['cover_image']) : base_url('uploads/gallery/campus/courtyard-students-formation.jpg');
    ?>
    <article class="bg-surface rounded-xl border border-border-base overflow-hidden civic-shadow civic-hover transition-all duration-300 flex flex-col group cursor-pointer" onclick="openLightbox(<?= $idx ?>)">
      <div class="relative h-48 w-full overflow-hidden">
        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="<?= e_attr($alb['title_en']) ?>" src="<?= e_attr($cover) ?>" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
          <span class="text-white font-label-md flex items-center gap-2"><span class="material-symbols-outlined text-[20px]">zoom_in</span> View Album</span>
        </div>
      </div>
      <div class="p-5 flex-grow flex flex-col">
        <div class="mb-2">
          <span class="text-primary font-label-sm text-label-sm uppercase tracking-wider"><?= e($catLabel($alb['slug'])) ?></span>
        </div>
        <h3 class="font-headline-sm text-headline-sm text-text-heading mb-2"><?= e($alb['title_en']) ?></h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant mb-4 flex-grow"><?= e(!empty($alb['description_en']) ? mb_substr($alb['description_en'], 0, 110) : 'Photographs from ' . $alb['title_en'] . '.') ?></p>
        <div class="flex items-center justify-between mt-auto pt-4 border-t border-border-base text-on-surface-variant font-label-sm text-label-sm">
          <div class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">calendar_today</span>
            <span><?= e(date('M Y', strtotime($alb['created_at'] ?? 'now'))) ?></span>
          </div>
          <div class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">collections</span>
            <span><?= (int)$alb['photo_count'] ?> Photos</span>
          </div>
        </div>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</main>

<!-- 6. Album Lightbox (Hidden by default) -->
<div class="fixed inset-0 z-[100] bg-black/95 hidden flex-col" id="lightbox">
  <div class="flex justify-between items-center p-4 text-white">
    <div class="font-body-md">
      <span class="opacity-70" id="lb-album">Album</span> &nbsp;|&nbsp;
      <span class="font-medium" id="lb-counter">1 / 1</span>
    </div>
    <button aria-label="Close lightbox" class="p-2 hover:bg-white/10 rounded-full transition-colors" onclick="closeLightbox()">
      <span class="material-symbols-outlined text-[28px]">close</span>
    </button>
  </div>
  <div class="flex-grow flex items-center justify-center relative px-4 md:px-12">
    <button id="lb-prev" class="absolute left-4 md:left-8 p-3 bg-black/50 hover:bg-white/20 rounded-full text-white transition-colors z-10 backdrop-blur-sm" onclick="lbStep(-1)">
      <span class="material-symbols-outlined text-[32px]">chevron_left</span>
    </button>
    <div class="relative w-full max-w-5xl max-h-[75vh] flex justify-center">
      <img id="lb-img" class="max-w-full max-h-[75vh] object-contain shadow-2xl" alt="" src="">
    </div>
    <button id="lb-next" class="absolute right-4 md:right-8 p-3 bg-black/50 hover:bg-white/20 rounded-full text-white transition-colors z-10 backdrop-blur-sm" onclick="lbStep(1)">
      <span class="material-symbols-outlined text-[32px]">chevron_right</span>
    </button>
  </div>
  <div class="p-6 text-center text-white bg-gradient-to-t from-black/80 to-transparent">
    <p class="font-body-lg text-body-lg max-w-3xl mx-auto" id="lb-caption"></p>
  </div>
</div>

<?php if (!empty($albums)): ?>
<script>
  const LB_ALBUMS = [
    <?php foreach ($albums as $alb):
      $cover = !empty($alb['cover_image']) ? base_url($alb['cover_image']) : base_url('uploads/gallery/campus/courtyard-students-formation.jpg');
    ?>
    { title: <?= json_encode($alb['title_en']) ?>, cover: <?= json_encode($cover) ?>, count: <?= (int)$alb['photo_count'] ?>, caption: <?= json_encode($alb['description_en'] ?: ('Photographs from ' . $alb['title_en'] . '.')) ?> },
    <?php endforeach; ?>
  ];
  let lbIndex = 0;
  const lightbox = document.getElementById('lightbox');

  function openLightbox(i) {
    lbIndex = i;
    renderLb();
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }
  function closeLightbox() {
    lightbox.classList.add('hidden');
    lightbox.classList.remove('flex');
    document.body.style.overflow = 'auto';
  }
  function lbStep(d) { lbIndex = (lbIndex + d + LB_ALBUMS.length) % LB_ALBUMS.length; renderLb(); }
  function renderLb() {
    const a = LB_ALBUMS[lbIndex];
    document.getElementById('lb-album').textContent = a.title;
    document.getElementById('lb-counter').textContent = (lbIndex + 1) + ' / ' + LB_ALBUMS.length;
    document.getElementById('lb-img').src = a.cover;
    document.getElementById('lb-img').alt = a.title;
    document.getElementById('lb-caption').textContent = a.caption + ' — ' + a.count + ' photos in this album.';
  }
  document.addEventListener('keydown', function (e) {
    if (lightbox.classList.contains('hidden')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') lbStep(-1);
    if (e.key === 'ArrowRight') lbStep(1);
  });
</script>
<?php endif; ?>

</div>
<?php require_once __DIR__.'/includes/footer.php'; ?>
