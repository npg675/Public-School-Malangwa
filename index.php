<?php
$page = 'home';
$title = 'Shree Public Secondary School — Malangwa-2, Sarlahi | श्री पब्लिक माध्यमिक विद्यालय';
$description = 'Shree Public Secondary School — government community school in Malangwa-2, Sarlahi, Madhesh Province. ECD to Grade 12 with +2 Science & Management (NEB). IEMIS 190640003.';
$useTailwind = true;
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/header.php';

$homeNotices = get_notices(5);
$homeEvents  = get_events(3);
$homeDownloads = get_downloads(6);

$blocks   = get_blocks('home');
$sec      = function(string $k) use ($blocks): array { return array_values(array_filter($blocks, fn($b) => $b['section_key'] === $k)); };
$first    = function(string $k) use ($sec): ?array { return $sec($k)[0] ?? null; };
$hero     = $first('hero'); $intro = $first('intro'); $cta = $first('cta_banner');
$programs = get_programs();
$galleryAlbums = get_gallery_albums(4);
$showQuote = setting('show_principal','1') === '1' && setting('principal_name') !== '';
$principalPhoto = setting('principal_photo','uploads/gallery/staff/leadership-team-photo.jpg');
$principalMsg = setting('principal_message_' . current_lang(), '');
if ($principalMsg === '') $principalMsg = setting('principal_message_en','');
$catChip = function (?string $slug): string {
    return match ($slug) {
        'admission'   => 'bg-secondary-container text-on-secondary-container',
        'examination' => 'bg-[#ffdad6] text-[#93000a]',
        'vacancy'     => 'bg-primary-fixed text-on-primary-fixed',
        'scholarship' => 'bg-secondary-fixed text-on-secondary-fixed',
        'holiday'     => 'bg-tertiary-fixed text-tertiary-container',
        default       => 'bg-surface-variant text-on-surface-variant',
    };
};
$dlIcon = function (?string $type): string {
    $t = strtoupper($type ?? '');
    if ($t === 'PDF') return 'picture_as_pdf';
    if ($t === 'ZIP') return 'folder_zip';
    if ($t === 'XLSX' || $t === 'XLS') return 'table_chart';
    if ($t === 'DOCX' || $t === 'DOC') return 'description';
    return 'draft';
};
?>
<div class="bg-bg-surface font-body-md text-on-surface antialiased">

<!-- Hero Section -->
<section class="relative bg-primary overflow-hidden">
  <div class="absolute inset-0 opacity-40">
    <img alt="Shree Public Secondary School campus" class="w-full h-full object-cover" src="<?= e_attr(base_url($hero['image_url'] ?? 'uploads/hero/hero-main-gate-jubilee.jpg')) ?>">
    <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/80 to-transparent"></div>
  </div>
  <div class="relative max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-16 md:py-24 grid lg:grid-cols-2 gap-12 items-center">
    <div class="text-white space-y-6">
      <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full">
        <span class="w-2 h-2 rounded-full bg-active-gold animate-pulse"></span>
        <span class="font-label-md text-label-md text-active-gold"><?= e($hero ? block_val($hero,'subtitle') : 'Admissions Open 2082') ?></span>
      </div>
      <h1 class="font-display-lg text-display-lg text-white leading-tight max-md:text-4xl"><?= e($hero ? block_val($hero,'title') : 'Shree Public Secondary School — Malangwa-2') ?></h1>
      <p class="font-body-lg text-body-lg text-surface-container-highest max-w-xl">
        <?= e($hero ? block_val($hero,'body') : 'Providing public education from Early Childhood Development through Grade 12 in the heart of Malangwa. ECD–12 • +2 Science & Management (NEB).') ?>
      </p>
      <div class="flex flex-wrap gap-4 pt-4">
        <a href="<?= e_attr(base_url('admissions.php')) ?>" class="bg-active-gold text-primary font-label-lg text-label-lg px-8 py-4 rounded-lg hover:bg-tertiary-fixed-dim transition-all min-h-[44px] shadow-lg shadow-active-gold/20 inline-flex items-center">Apply for Admission</a>
        <a href="<?= e_attr(base_url('academics.php')) ?>" class="bg-transparent border-2 border-white text-white font-label-lg text-label-lg px-8 py-4 rounded-lg hover:bg-white/10 transition-all min-h-[44px] inline-flex items-center">Explore Programs</a>
      </div>
    </div>
    <div class="grid grid-cols-2 gap-4 lg:ml-auto">
      <?php foreach ($sec('stat') as $st): ?>
      <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl flex flex-col items-center justify-center text-center">
        <span class="font-headline-lg text-headline-lg text-active-gold"><?= e(block_val($st,'title')) ?></span>
        <span class="font-label-md text-label-md text-white mt-1"><?= e(block_val($st,'body')) ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- About Section -->
<section class="py-16 md:py-24 bg-surface max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
  <div class="max-w-3xl mx-auto text-center space-y-6">
    <h2 class="font-headline-lg text-headline-lg text-primary"><?= e($intro ? block_val($intro,'title') : 'About Our School') ?></h2>
    <p class="font-body-lg text-body-lg text-on-surface-variant">
      <?= e($intro ? block_val($intro,'body') : 'Shree Public Secondary School is a government-recognised community educational institution situated in the heart of Malangwa Municipality-2, Sarlahi District, Madhesh Province. Registered under IEMIS Code '.APP_IEMIS.', our school plays a central role in providing accessible education to the local community.') ?>
    </p>
  </div>
</section>

<!-- Quick Access Section -->
<section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop -mt-8 relative z-10">
  <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
    <a class="bg-surface-lowest p-6 rounded-xl soft-shadow border border-border-base flex flex-col items-center text-center group hover:-translate-y-1 transition-transform" href="<?= e_attr(base_url('citizen-charter.php')) ?>">
      <div class="w-12 h-12 bg-surface-container-low rounded-full flex items-center justify-center mb-4 group-hover:bg-primary-container group-hover:text-active-gold transition-colors text-primary-container"><span class="material-symbols-outlined">description</span></div>
      <h3 class="font-label-lg text-label-lg text-text-heading">Citizen Charter</h3>
    </a>
    <a class="bg-surface-lowest p-6 rounded-xl soft-shadow border border-border-base flex flex-col items-center text-center group hover:-translate-y-1 transition-transform" href="<?= e_attr(base_url('notices.php')) ?>">
      <div class="w-12 h-12 bg-surface-container-low rounded-full flex items-center justify-center mb-4 group-hover:bg-primary-container group-hover:text-active-gold transition-colors text-primary-container"><span class="material-symbols-outlined">campaign</span></div>
      <h3 class="font-label-lg text-label-lg text-text-heading">Notices</h3>
    </a>
    <a class="bg-surface-lowest p-6 rounded-xl soft-shadow border border-border-base flex flex-col items-center text-center group hover:-translate-y-1 transition-transform" href="<?= e_attr(base_url('results.php')) ?>">
      <div class="w-12 h-12 bg-surface-container-low rounded-full flex items-center justify-center mb-4 group-hover:bg-primary-container group-hover:text-active-gold transition-colors text-primary-container"><span class="material-symbols-outlined">assignment_turned_in</span></div>
      <h3 class="font-label-lg text-label-lg text-text-heading">Result Search</h3>
    </a>
    <a class="bg-surface-lowest p-6 rounded-xl soft-shadow border border-border-base flex flex-col items-center text-center group hover:-translate-y-1 transition-transform" href="<?= e_attr(base_url('downloads.php')) ?>">
      <div class="w-12 h-12 bg-surface-container-low rounded-full flex items-center justify-center mb-4 group-hover:bg-primary-container group-hover:text-active-gold transition-colors text-primary-container"><span class="material-symbols-outlined">download</span></div>
      <h3 class="font-label-lg text-label-lg text-text-heading">Downloads</h3>
    </a>
    <a class="bg-surface-lowest p-6 rounded-xl soft-shadow border border-border-base flex flex-col items-center text-center group hover:-translate-y-1 transition-transform col-span-2 md:col-span-1" href="<?= e_attr(base_url('academic-calendar.php')) ?>">
      <div class="w-12 h-12 bg-surface-container-low rounded-full flex items-center justify-center mb-4 group-hover:bg-primary-container group-hover:text-active-gold transition-colors text-primary-container"><span class="material-symbols-outlined">calendar_month</span></div>
      <h3 class="font-label-lg text-label-lg text-text-heading">Calendar</h3>
    </a>
  </div>
</section>

<!-- Notices & Events -->
<section class="py-16 md:py-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid lg:grid-cols-12 gap-12">
  <div class="lg:col-span-7 space-y-6">
    <div class="flex justify-between items-end border-b-2 border-border-base pb-4">
      <div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Notice Board</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Latest updates from the administration</p>
      </div>
      <a class="font-label-md text-label-md text-secondary hover:text-primary-container flex items-center gap-1" href="<?= e_attr(base_url('notices.php')) ?>">View All <span class="material-symbols-outlined text-[18px]">arrow_forward</span></a>
    </div>
    <div class="bg-surface-lowest rounded-xl soft-shadow border border-border-base overflow-hidden">
      <ul class="divide-y divide-border-base">
        <?php if (empty($homeNotices)): ?>
        <li class="p-8 text-center text-on-surface-variant font-body-md">No notices published yet. Check back soon.</li>
        <?php else: foreach ($homeNotices as $n):
          $ts = strtotime($n['published_at'] ?? 'now');
        ?>
        <li class="p-5 hover:bg-surface-container-low transition-colors flex gap-4 items-start">
          <div class="<?= !empty($n['is_pinned']) ? 'bg-primary-container text-white' : 'bg-surface-dim text-primary' ?> rounded-lg p-2 text-center min-w-[70px] shrink-0">
            <span class="block font-label-sm text-[10px] uppercase"><?= e(date('M', $ts)) ?></span>
            <span class="block font-headline-md text-headline-md"><?= e(date('j', $ts)) ?></span>
          </div>
          <div class="flex-1">
            <span class="inline-block font-label-sm text-[11px] px-2 py-0.5 rounded-full mb-2 <?= $catChip($n['cat_slug'] ?? null) ?>"><?= e($n['cat_en'] ?? 'General') ?></span>
            <h3 class="font-label-lg text-label-lg text-text-heading leading-tight mb-1"><a class="hover:text-secondary" href="<?= e_attr(base_url('notice.php?slug=' . urlencode($n['slug']))) ?>"><?= e($n['title_en']) ?></a></h3>
          </div>
        </li>
        <?php endforeach; endif; ?>
      </ul>
    </div>
  </div>
  <div class="lg:col-span-5 space-y-6">
    <div class="flex justify-between items-end border-b-2 border-border-base pb-4">
      <div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Upcoming Events</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Mark your calendar</p>
      </div>
      <a class="font-label-md text-label-md text-secondary hover:text-primary-container flex items-center gap-1" href="<?= e_attr(base_url('events.php')) ?>">All Events <span class="material-symbols-outlined text-[18px]">arrow_forward</span></a>
    </div>
    <div class="grid grid-cols-1 gap-4">
      <?php if (empty($homeEvents)): ?>
      <div class="bg-primary-container rounded-xl p-6 text-white soft-shadow font-body-md">No upcoming events right now.</div>
      <?php else: foreach ($homeEvents as $ev): ?>
      <a href="<?= e_attr(base_url('events.php')) ?>" class="bg-primary-container rounded-xl p-5 text-white flex flex-col justify-between soft-shadow hover:bg-masthead-navy transition-colors">
        <div>
          <span class="material-symbols-outlined text-active-gold mb-2 text-[32px]">event</span>
          <h4 class="font-label-lg text-label-lg leading-tight"><?= e($ev['title_en'] ?? '') ?></h4>
          <p class="font-body-sm text-body-sm text-primary-fixed mt-2 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">calendar_month</span> <?= e(date('M j, Y', strtotime($ev['event_date']))) ?></p>
          <?php if (!empty($ev['location_en'])): ?><p class="font-body-sm text-body-sm text-primary-fixed mt-1 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">location_on</span> <?= e($ev['location_en']) ?></p><?php endif; ?>
        </div>
      </a>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>

<!-- Academic Programs -->
<section class="bg-surface py-16 md:py-24 border-y border-border-base">
  <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
    <div class="text-center max-w-2xl mx-auto mb-12">
      <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Learning Pathways</h2>
      <p class="font-body-lg text-body-lg text-on-surface-variant">Comprehensive educational pathways designed to nurture potential at every stage of development.</p>
    </div>
    <div class="grid md:grid-cols-4 gap-6">
      <?php
      $iconMap = ['ecd'=>'child_care','basic_1_5'=>'menu_book','basic_6_8'=>'menu_book','secondary_9_10'=>'school','higher_secondary'=>'science'];
      $badgeMap = ['ecd'=>'Early Childhood','basic_1_5'=>'Grades 1-8','basic_6_8'=>'Grades 1-8','secondary_9_10'=>'Grades 9-10'];
      foreach ($programs as $p):
        $lvl = $p['level'] ?? '';
        $icon = $iconMap[$lvl] ?? 'school';
        if (($lvl==='higher_secondary')) { $badge = $p['stream'] ?? 'NEB'; $link = strtolower($p['stream']??'')==='science' ? base_url('science.php') : (strtolower($p['stream']??'')==='management' ? base_url('management.php') : base_url('academics.php')); }
        else { $badge = $badgeMap[$lvl] ?? $p['level']; $link = base_url('academics.php'); }
        $desc = mb_strimwidth(strip_tags((string)($p['description_en'] ?? '')), 0, 90, '…');
        $title = t($p['title_en'] ?? '', $p['title_np'] ?? $p['title_en'] ?? '');
      ?>
      <a href="<?= e_attr($link) ?>" class="bg-surface-lowest rounded-2xl p-6 soft-shadow border border-border-base hover:border-primary-container transition-colors group block">
        <div class="w-12 h-12 bg-surface-container-low rounded-xl flex items-center justify-center mb-4 text-primary-container group-hover:bg-primary-container group-hover:text-white transition-colors"><span class="material-symbols-outlined text-[24px]"><?= e($icon) ?></span></div>
        <h3 class="font-headline-sm text-headline-sm text-text-heading mb-2"><?= e($title) ?></h3>
        <div class="bg-surface-variant text-on-surface-variant font-label-sm inline-block px-3 py-1 rounded-full mb-3"><?= e($badge) ?></div>
        <?php if ($desc): ?><p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2"><?= e($desc) ?></p><?php endif; ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="py-16 md:py-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
  <div class="text-center max-w-2xl mx-auto mb-12">
    <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Educational Commitment</h2>
    <p class="font-body-lg text-body-lg text-on-surface-variant">Verified, not advertised.</p>
  </div>
  <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php foreach ($sec('commitment') as $c): ?>
    <div class="flex gap-4 p-4 items-center">
      <span class="material-symbols-outlined text-active-gold text-[32px]"><?= e($c['icon'] ?? 'verified') ?></span>
      <h4 class="font-label-lg text-label-lg text-text-heading"><?= e(block_val($c,'title')) ?></h4>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Resources/Downloads -->
<section class="bg-surface-container-low py-16 md:py-24 border-y border-border-base">
  <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
    <div class="flex justify-between items-end border-b-2 border-border-base pb-4 mb-8">
      <h2 class="font-headline-lg text-headline-lg text-primary">Resources &amp; Downloads</h2>
      <a class="font-label-md text-label-md text-secondary hover:text-primary-container flex items-center gap-1" href="<?= e_attr(base_url('downloads.php')) ?>">View All <span class="material-symbols-outlined text-[18px]">arrow_forward</span></a>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php if (empty($homeDownloads)): ?>
      <div class="bg-surface-lowest p-5 rounded-xl border border-border-base font-body-md text-on-surface-variant">Documents will be published soon.</div>
      <?php else: foreach ($homeDownloads as $d): ?>
      <a href="<?= e_attr(!empty($d['file_path']) ? base_url($d['file_path']) : base_url('downloads.php')) ?>" class="bg-surface-lowest p-5 rounded-xl border border-border-base flex items-start gap-4 hover:border-primary-container transition-colors" <?= !empty($d['file_path']) ? 'download' : '' ?>>
        <span class="material-symbols-outlined text-secondary text-[32px]"><?= $dlIcon($d['file_type'] ?? null) ?></span>
        <div>
          <h4 class="font-label-lg text-label-lg text-text-heading"><?= e($d['title_en'] ?? '') ?></h4>
          <p class="font-body-sm text-body-sm text-on-surface-variant mt-1"><?= e($d['file_size'] ?? '') ?><?= !empty($d['file_size']) ? ' • ' : '' ?>Updated <?= e(date('Y-m-d', strtotime($d['published_at'] ?? 'now'))) ?></p>
        </div>
      </a>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>

<!-- Head Teacher Quote -->
<?php if ($showQuote): ?>
<section class="bg-primary-container text-white py-16">
  <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
    <div class="flex flex-col md:flex-row items-center gap-8 md:gap-16">
      <div class="w-32 h-32 md:w-48 md:h-48 shrink-0 relative">
        <div class="absolute inset-0 bg-active-gold rounded-full translate-x-2 translate-y-2"></div>
        <img alt="Head Teacher" class="w-full h-full object-cover rounded-full relative z-10 border-4 border-primary-container" src="<?= e_attr(base_url($principalPhoto)) ?>">
      </div>
      <div class="text-center md:text-left flex-1">
        <span class="material-symbols-outlined text-active-gold text-[48px] opacity-50 mb-4 block">format_quote</span>
        <p class="font-headline-sm text-headline-sm font-normal italic mb-6 leading-relaxed">
          "<?= e($principalMsg) ?>"
        </p>
        <h4 class="font-label-lg text-label-lg text-white"><?= e(setting('principal_name')) ?></h4>
        <p class="font-body-sm text-body-sm text-primary-fixed"><?= e(t('Head Teacher','प्रधानाध्यापक')) ?>, Shree Public Secondary School</p>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Gallery (Masonry Grid) -->
<section class="py-16 md:py-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
  <div class="flex justify-between items-end mb-8">
    <h2 class="font-headline-lg text-headline-lg text-primary">Campus Life</h2>
    <a class="font-label-md text-label-md text-secondary hover:text-primary-container flex items-center gap-1" href="<?= e_attr(base_url('gallery.php')) ?>">View Gallery <span class="material-symbols-outlined text-[18px]">arrow_forward</span></a>
  </div>
  <?php if (empty($galleryAlbums)): ?>
    <div class="bg-surface-lowest p-8 rounded-xl border border-border-base text-center font-body-md text-on-surface-variant">Photos coming soon.</div>
  <?php else: ?>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 auto-rows-[200px]">
    <?php foreach ($galleryAlbums as $i=>$alb): $isFirst = $i===0; ?>
    <a href="<?= e_attr(base_url('gallery.php')) ?>" class="<?= $isFirst?'col-span-2 row-span-2':'' ?> rounded-xl overflow-hidden soft-shadow relative group">
      <img alt="<?= e_attr($alb['title_en'] ?? 'Gallery') ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= e_attr($alb['cover'] ?? base_url('uploads/gallery/campus/front-building-entrance.jpg')) ?>">
      <?php if ($isFirst): ?><div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center"><span class="text-white font-label-lg border-2 border-white px-4 py-2 rounded-lg"><?= e($alb['title_en'] ?? 'Campus') ?></span></div><?php endif; ?>
    </a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>

<!-- CTA Banner -->
<section class="bg-masthead-navy py-12 md:py-16">
  <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
    <div>
      <h2 class="font-headline-lg text-headline-lg text-white mb-2"><?= e($cta ? block_val($cta,'title') : 'Admissions Now Open for 2082') ?></h2>
      <p class="font-body-lg text-body-lg text-primary-fixed"><?= e($cta ? block_val($cta,'body') : 'Secure a bright future. Join Shree Public Secondary School today.') ?></p>
    </div>
    <div class="flex flex-col sm:flex-row items-center gap-4">
      <a href="<?= e_attr(base_url('admissions.php')) ?>" class="bg-active-gold text-primary font-label-lg text-label-lg px-8 py-4 rounded-lg hover:bg-tertiary-fixed-dim transition-all min-h-[44px] whitespace-nowrap inline-flex items-center">Start Admission Inquiry</a>
      <?php if (APP_PHONE): ?><a href="tel:<?= e_attr(APP_PHONE) ?>" class="text-white flex items-center gap-2 font-label-md hover:text-active-gold transition-colors">
        <span class="material-symbols-outlined">call</span> <?= e(APP_PHONE) ?>
      </a><?php endif; ?>
    </div>
  </div>
</section>

</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
