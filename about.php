<?php
$page='about';
$title='About — Shree Public Secondary School | Malangwa-2, Sarlahi';
$description='Shree Public Secondary School is a public community institution in Malangwa-2, Sarlahi, Madhesh Province, serving ECD through Grade 12 with +2 Science & Management (NEB). IEMIS 190640003.';
$useTailwind = true;
require_once __DIR__.'/includes/helpers.php';
require_once __DIR__.'/includes/header.php';
$blocks = get_blocks('about');
$sec = function(string $k) use ($blocks): array { return array_values(array_filter($blocks, fn($b) => $b['section_key'] === $k)); };
$first = function(string $k) use ($sec): ?array { return $sec($k)[0] ?? null; };
$staffGroups = get_staff_directory();
$headerBlock = $first('page_header');
$ctaJoin = $first('cta_join');
?>
<div class="bg-bg-surface font-body-md text-on-surface antialiased">

<!-- 1. Breadcrumb & Page Header -->
<section class="bg-surface-lowest border-b border-border-base pt-12 pb-16 px-margin-mobile md:px-margin-desktop">
  <div class="max-w-container-max mx-auto">
    <nav class="flex items-center space-x-2 text-on-surface-variant font-label-sm text-label-sm mb-6">
      <a class="hover:text-primary transition-colors" href="<?= e_attr(base_url()) ?>">Home</a>
      <span class="material-symbols-outlined" style="font-size:16px">chevron_right</span>
      <span class="text-primary font-medium">About</span>
    </nav>
    <h1 class="font-display-lg text-display-lg text-text-heading mb-4 hidden md:block"><?= e($headerBlock ? block_val($headerBlock,'title') : 'About Our School') ?></h1>
    <h1 class="font-headline-lg-mobile text-headline-lg-mobile text-text-heading mb-4 md:hidden"><?= e($headerBlock ? block_val($headerBlock,'title') : 'About Our School') ?></h1>
    <div class="flex items-center text-on-surface-variant font-body-md text-body-md">
      <span class="material-symbols-outlined mr-2 text-primary">location_on</span>
      <?= e(setting('address_'.current_lang(), setting('address_en', APP_ADDRESS))) ?>
    </div>
  </div>
</section>

<!-- 2. School Introduction -->
<section class="py-16 px-margin-mobile md:px-margin-desktop">
  <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-2 gap-gutter items-center">
    <div class="space-y-6">
      <?php foreach ($sec('intro') as $i=>$ip): ?>
        <?php if ($i===0): ?><h2 class="font-headline-lg text-headline-lg text-primary"><?= e(block_val($ip,'title') ?: 'A Pillar of Community Education') ?></h2><?php endif; ?>
        <p class="<?= $i===0?'font-body-lg text-body-lg text-on-surface':'font-body-md text-body-md text-on-surface-variant' ?>">
          <?= e(block_val($ip,'body')) ?>
        </p>
      <?php endforeach; ?>
    </div>
    <div class="rounded-xl overflow-hidden shadow-ambient h-96 relative group">
      <img alt="Shree Public Secondary School building" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= e_attr(base_url('uploads/about/campus-building-aerial.jpg')) ?>">
      <div class="absolute inset-0 bg-gradient-to-t from-masthead-navy/60 to-transparent"></div>
    </div>
  </div>
</section>

<!-- Vision / Mission / Values -->
<section class="py-16 px-margin-mobile md:px-margin-desktop bg-surface-container-low">
  <div class="max-w-container-max mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
      <?php foreach ($sec('value') as $v): ?>
      <div class="bg-surface-lowest p-8 rounded-xl shadow-ambient border border-border-base text-center">
        <span class="material-symbols-outlined text-4xl text-primary mb-4"><?= e($v['icon'] ?? 'verified') ?></span>
        <h3 class="font-headline-sm text-headline-sm text-primary mb-3"><?= e(block_val($v,'title')) ?></h3>
        <p class="font-body-md text-body-md text-on-surface-variant"><?= e(block_val($v,'body')) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 3. School at a Glance (Bento Grid) -->
<section class="py-16 px-margin-mobile md:px-margin-desktop bg-surface-container-lowest border-y border-border-base">
  <div class="max-w-container-max mx-auto">
    <div class="flex items-center mb-8">
      <span class="material-symbols-outlined text-active-gold mr-3 text-3xl" style="font-variation-settings:'FILL' 1">verified</span>
      <h2 class="font-headline-lg text-headline-lg text-primary">School at a Glance</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-surface p-6 rounded-xl shadow-ambient border border-border-base col-span-1 md:col-span-2 flex flex-col justify-center">
        <div class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Institution Name</div>
        <div class="font-headline-md text-headline-md text-primary"><?= e(t(setting('site_name_en','Shree Public Secondary School'), setting('site_name_np','श्री पब्लिक माध्यमिक विद्यालय'))) ?></div>
      </div>
      <div class="bg-surface p-6 rounded-xl shadow-ambient border border-border-base">
        <div class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Type</div>
        <div class="font-headline-sm text-headline-sm text-primary flex items-center">
          <span class="material-symbols-outlined mr-2 text-secondary">public</span> <?= e(t('Public / Community','सरकारी / सामुदायिक')) ?>
        </div>
      </div>
      <div class="bg-surface p-6 rounded-xl shadow-ambient border border-border-base">
        <div class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Enrollment</div>
        <div class="font-headline-sm text-headline-sm text-primary flex items-center">
          <span class="material-symbols-outlined mr-2 text-secondary">groups</span> <?= e(setting('students_display','1,000+')) ?> <?= e(t('Students','विद्यार्थीहरू')) ?>
        </div>
      </div>
      <div class="bg-primary-container p-6 rounded-xl shadow-ambient col-span-1 md:col-span-2">
        <div class="font-label-md text-label-md uppercase tracking-wider mb-2 opacity-80 text-primary-fixed">Academic Coverage</div>
        <div class="font-headline-md text-headline-md text-on-primary mb-2">ECD to Grade 12</div>
        <div class="flex gap-2 mt-4">
          <span class="bg-active-gold/20 text-active-gold px-3 py-1 rounded-full font-label-sm text-label-sm">+2 Science</span>
          <span class="bg-active-gold/20 text-active-gold px-3 py-1 rounded-full font-label-sm text-label-sm">+2 Management</span>
        </div>
      </div>
      <div class="bg-surface p-6 rounded-xl shadow-ambient border border-border-base">
        <div class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Location</div>
        <div class="font-body-md text-body-md text-on-surface"><?= e(setting('address_'.current_lang(), setting('address_en','Malangwa-2, Sarlahi, Madhesh Province'))) ?></div>
      </div>
      <div class="bg-surface p-6 rounded-xl shadow-ambient border border-border-base">
        <div class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">IEMIS Code</div>
        <div class="font-headline-sm text-headline-sm text-primary font-mono bg-surface-container-low px-3 py-1 rounded inline-block mt-1"><?= e(setting('iemis_code', APP_IEMIS)) ?></div>
      </div>
    </div>
  </div>
</section>

<!-- 5. Timeline -->
<section class="py-16 px-margin-mobile md:px-margin-desktop">
  <div class="max-w-container-max mx-auto">
    <h2 class="font-headline-lg text-headline-lg text-primary mb-12 text-center">Our Journey Through Time</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
      <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-outline-variant -translate-y-1/2 z-0"></div>
      <?php foreach ($sec('timeline') as $tl): ?>
      <div class="relative z-10 bg-surface-lowest p-6 rounded-xl border border-border-base shadow-sm">
        <div class="text-active-gold font-bold text-xl mb-2"><?= e(block_val($tl,'title')) ?></div>
        <?php if (trim(block_val($tl,'subtitle'))!==''): ?><div class="text-on-surface-variant text-sm mb-1">(<?= e(block_val($tl,'subtitle')) ?>)</div><?php endif; ?>
        <p class="font-body-sm text-body-sm"><?= e(block_val($tl,'body')) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 6. Campus Facilities -->
<section class="py-16 px-margin-mobile md:px-margin-desktop bg-surface-container-low">
  <div class="max-w-container-max mx-auto">
    <h2 class="font-headline-lg text-headline-lg text-primary mb-12 text-center">Campus Facilities</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
      <?php foreach ($sec('facility') as $fac): ?>
      <div class="space-y-4">
        <div class="h-48 bg-surface-container-high rounded-xl overflow-hidden">
          <img alt="<?= e_attr(block_val($fac,'title')) ?>" class="w-full h-full object-cover" src="<?= e_attr(base_url($fac['image_url'] ?? 'uploads/gallery/campus/staff-room-interior.jpg')) ?>">
        </div>
        <h3 class="font-headline-sm text-headline-sm text-primary"><?= e(block_val($fac,'title')) ?></h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant"><?= e(block_val($fac,'body')) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 7. Leadership & Team -->
<section class="py-16 md:py-24 px-margin-mobile md:px-margin-desktop">
  <div class="max-w-container-max mx-auto">
    <div class="text-center max-w-2xl mx-auto mb-16">
      <h2 class="font-headline-lg text-headline-lg text-primary mb-4"><?= e(t('Our Leadership & Team','हाम्रो नेतृत्व र टोली')) ?></h2>
      <p class="font-body-md text-body-md text-on-surface-variant">Guided by experienced educators and dedicated administrative staff committed to academic excellence.</p>
    </div>
    <h3 class="font-headline-md text-headline-md text-primary mb-6 border-b border-border-base pb-2"><?= e(t('Leadership','नेतृत्व')) ?></h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-16">
      <?php if (!empty($staffGroups['leadership'])): foreach ($staffGroups['leadership'] as $person): ?>
      <div class="bg-surface rounded-xl p-6 shadow-ambient border border-border-base hover:shadow-ambient-focus transition-shadow">
        <div class="w-24 h-24 rounded-full bg-surface-container-high mb-4 mx-auto overflow-hidden border-2 border-primary-container flex items-center justify-center">
          <?php if (!empty($person['photo_url'])): ?><img class="w-full h-full object-cover" alt="<?= e_attr($person['name_en']) ?>" src="<?= e_attr($person['photo_url']) ?>"><?php else: ?><span class="font-headline-md text-primary"><?= e(staff_initials($person['name_en'] ?? '')) ?></span><?php endif; ?>
        </div>
        <div class="text-center">
          <h4 class="font-label-lg text-label-lg text-text-heading"><?= e(current_lang()==='np' && !empty($person['name_np']) ? $person['name_np'] : $person['name_en']) ?></h4>
          <p class="font-body-sm text-body-sm text-active-gold font-medium mt-1"><?= e(current_lang()==='np' && !empty($person['designation_np']) ? $person['designation_np'] : $person['designation_en']) ?></p>
        </div>
      </div>
      <?php endforeach; else: ?>
      <div class="bg-surface rounded-xl p-6 shadow-ambient border border-dashed border-outline-variant flex flex-col items-center justify-center min-h-[200px] opacity-70">
        <span class="material-symbols-outlined text-4xl text-outline mb-2">person_add</span>
        <span class="font-label-sm text-label-sm text-on-surface-variant">Profile coming soon</span>
      </div>
      <?php endif; ?>
    </div>

    <div class="space-y-12">
      <?php if (!empty($staffGroups['committee'])): ?>
      <div>
        <h3 class="font-headline-md text-headline-md text-primary mb-6 border-b border-border-base pb-2"><?= e(t('School Management Committee','विद्यालय व्यवस्थापन समिति')) ?></h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
          <?php foreach ($staffGroups['committee'] as $person): ?>
          <div class="text-center">
            <div class="w-20 h-20 rounded-full bg-surface-container-high mx-auto mb-3 overflow-hidden flex items-center justify-center">
              <?php if (!empty($person['photo_url'])): ?><img src="<?= e_attr($person['photo_url']) ?>" alt="<?= e_attr($person['name_en']) ?>" class="w-full h-full object-cover"><?php else: ?><span class="material-symbols-outlined text-outline">person</span><?php endif; ?>
            </div>
            <div class="font-label-md text-label-md"><?= e(current_lang()==='np' && !empty($person['name_np']) ? $person['name_np'] : $person['name_en']) ?></div>
            <div class="text-body-sm text-on-surface-variant"><?= e(current_lang()==='np' && !empty($person['designation_np']) ? $person['designation_np'] : $person['designation_en']) ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <?php if (!empty($staffGroups['teaching'])): ?>
      <div>
        <h3 class="font-headline-md text-headline-md text-primary mb-6 border-b border-border-base pb-2"><?= e(t('Teaching Staff','शिक्षक कर्मचारी')) ?></h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
          <?php foreach ($staffGroups['teaching'] as $person): ?>
          <div class="text-center">
            <div class="w-20 h-20 rounded-full bg-surface-container-high mx-auto mb-3 overflow-hidden flex items-center justify-center">
              <?php if (!empty($person['photo_url'])): ?><img src="<?= e_attr($person['photo_url']) ?>" alt="<?= e_attr($person['name_en']) ?>" class="w-full h-full object-cover"><?php else: ?><span class="material-symbols-outlined text-outline">person</span><?php endif; ?>
            </div>
            <div class="font-label-md text-label-md"><?= e(current_lang()==='np' && !empty($person['name_np']) ? $person['name_np'] : $person['name_en']) ?></div>
            <div class="text-body-sm text-on-surface-variant"><?= e(current_lang()==='np' && !empty($person['designation_np']) ? $person['designation_np'] : $person['designation_en']) ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <?php
      $adminStaff = array_merge($staffGroups['administration'] ?? [], $staffGroups['non_teaching'] ?? []);
      if (!empty($adminStaff)): ?>
      <div>
        <h3 class="font-headline-md text-headline-md text-primary mb-6 border-b border-border-base pb-2"><?= e(t('Administration & Support','प्रशासन र सहयोगी कर्मचारी')) ?></h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
          <?php foreach ($adminStaff as $person): ?>
          <div class="text-center">
            <div class="w-20 h-20 rounded-full bg-surface-container-high mx-auto mb-3 overflow-hidden flex items-center justify-center">
              <?php if (!empty($person['photo_url'])): ?><img src="<?= e_attr($person['photo_url']) ?>" alt="<?= e_attr($person['name_en']) ?>" class="w-full h-full object-cover"><?php else: ?><span class="material-symbols-outlined text-outline">person</span><?php endif; ?>
            </div>
            <div class="font-label-md text-label-md"><?= e(current_lang()==='np' && !empty($person['name_np']) ? $person['name_np'] : $person['name_en']) ?></div>
            <div class="text-body-sm text-on-surface-variant"><?= e(current_lang()==='np' && !empty($person['designation_np']) ? $person['designation_np'] : $person['designation_en']) ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <!-- CTA -->
    <div class="mt-24 bg-masthead-navy rounded-2xl p-10 md:p-16 text-center shadow-xl relative overflow-hidden">
      <div class="absolute top-0 right-0 w-64 h-64 bg-active-gold rounded-full opacity-10 -translate-y-1/2 translate-x-1/3 blur-2xl"></div>
      <div class="relative z-10">
        <h2 class="font-headline-lg text-headline-lg text-on-primary mb-4"><?= e($ctaJoin ? block_val($ctaJoin,'title') : 'Join Our Community') ?></h2>
        <p class="font-body-lg text-body-lg text-primary-fixed mb-8 max-w-2xl mx-auto"><?= e($ctaJoin ? block_val($ctaJoin,'body') : 'Explore our academic programs or start the admission process today to become part of Shree Public Secondary School.') ?></p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <a class="bg-active-gold text-primary font-label-lg text-label-lg px-8 py-3 rounded h-12 flex items-center justify-center hover:bg-tertiary-fixed-dim transition-colors" href="<?= e_attr(base_url('admissions.php')) ?>">Admissions Info</a>
          <a class="bg-transparent border border-on-primary text-on-primary font-label-lg text-label-lg px-8 py-3 rounded h-12 flex items-center justify-center hover:bg-white/10 transition-colors" href="<?= e_attr(base_url('academics.php')) ?>">View Academics</a>
        </div>
      </div>
    </div>
  </div>
</section>

</div>
<?php require_once __DIR__.'/includes/footer.php'; ?>
