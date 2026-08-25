<?php
$page='about';
$title='About — Shree Public Secondary School | Malangwa-2, Sarlahi';
$description='Shree Public Secondary School is a public community institution in Malangwa-2, Sarlahi, Madhesh Province, serving ECD through Grade 12 with +2 Science & Management (NEB). IEMIS 190640003.';
$useTailwind = true;
require_once __DIR__.'/includes/header.php';
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
    <h1 class="font-display-lg text-display-lg text-text-heading mb-4 hidden md:block">About Our School</h1>
    <h1 class="font-headline-lg-mobile text-headline-lg-mobile text-text-heading mb-4 md:hidden">About Our School</h1>
    <div class="flex items-center text-on-surface-variant font-body-md text-body-md">
      <span class="material-symbols-outlined mr-2 text-primary">location_on</span>
      Malangwa-2, Sarlahi
    </div>
  </div>
</section>

<!-- 2. School Introduction -->
<section class="py-16 px-margin-mobile md:px-margin-desktop">
  <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-2 gap-gutter items-center">
    <div class="space-y-6">
      <h2 class="font-headline-lg text-headline-lg text-primary">A Pillar of Community Education</h2>
      <p class="font-body-lg text-body-lg text-on-surface">
        Shree Public Secondary School stands at the heart of Malangwa as a cornerstone of government-led education in Madhesh Province. As a public community school, we are dedicated to providing accessible, high-quality education to over <?= e(APP_STUDENTS_DISPLAY) ?> students.
      </p>
      <p class="font-body-md text-body-md text-on-surface-variant">
        Our institution offers a comprehensive educational journey from Early Childhood Development (ECD) through Grade 12. We proudly operate as a co-educational day school, fostering an inclusive environment. In our higher secondary levels (+2), we provide specialized streams in Science and Management, equipping our students with the skills necessary for modern professional landscapes. (IEMIS: <?= e(APP_IEMIS) ?>)
      </p>
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
      <div class="bg-surface-lowest p-8 rounded-xl shadow-ambient border border-border-base text-center">
        <span class="material-symbols-outlined text-4xl text-primary mb-4">visibility</span>
        <h3 class="font-headline-sm text-headline-sm text-primary mb-3">Vision</h3>
        <p class="font-body-md text-body-md text-on-surface-variant">To be a leading center of educational excellence in Madhesh Province, empowering students with knowledge, skills, and values for a global future.</p>
      </div>
      <div class="bg-surface-lowest p-8 rounded-xl shadow-ambient border border-border-base text-center">
        <span class="material-symbols-outlined text-4xl text-primary mb-4">school</span>
        <h3 class="font-headline-sm text-headline-sm text-primary mb-3">Mission</h3>
        <p class="font-body-md text-body-md text-on-surface-variant">Providing accessible, high-quality public education from ECD to Grade 12, fostering an inclusive environment that nurtures intellectual growth and civic responsibility.</p>
      </div>
      <div class="bg-surface-lowest p-8 rounded-xl shadow-ambient border border-border-base text-center">
        <span class="material-symbols-outlined text-4xl text-primary mb-4">workspace_premium</span>
        <h3 class="font-headline-sm text-headline-sm text-primary mb-3">Values</h3>
        <p class="font-body-md text-body-md text-on-surface-variant">Integrity, Inclusivity, Excellence, and Community Trust.</p>
      </div>
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
        <div class="font-headline-md text-headline-md text-primary">Shree Public Secondary School</div>
      </div>
      <div class="bg-surface p-6 rounded-xl shadow-ambient border border-border-base">
        <div class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Type</div>
        <div class="font-headline-sm text-headline-sm text-primary flex items-center">
          <span class="material-symbols-outlined mr-2 text-secondary">public</span> Public / Community
        </div>
      </div>
      <div class="bg-surface p-6 rounded-xl shadow-ambient border border-border-base">
        <div class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Enrollment</div>
        <div class="font-headline-sm text-headline-sm text-primary flex items-center">
          <span class="material-symbols-outlined mr-2 text-secondary">groups</span> <?= e(APP_STUDENTS_DISPLAY) ?> Students
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
        <div class="font-body-md text-body-md text-on-surface">Malangwa-2<br>Sarlahi, Madhesh Province</div>
      </div>
      <div class="bg-surface p-6 rounded-xl shadow-ambient border border-border-base">
        <div class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">IEMIS Code</div>
        <div class="font-headline-sm text-headline-sm text-primary font-mono bg-surface-container-low px-3 py-1 rounded inline-block mt-1"><?= e(APP_IEMIS) ?></div>
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
      <div class="relative z-10 bg-surface-lowest p-6 rounded-xl border border-border-base shadow-sm">
        <div class="text-active-gold font-bold text-xl mb-2">2003 BS</div>
        <div class="text-on-surface-variant text-sm mb-1">(1947 AD)</div>
        <p class="font-body-sm text-body-sm">Establishment of the school as a primary education center.</p>
      </div>
      <div class="relative z-10 bg-surface-lowest p-6 rounded-xl border border-border-base shadow-sm">
        <div class="text-active-gold font-bold text-xl mb-2">2040 BS</div>
        <p class="font-body-sm text-body-sm">Expansion to secondary level (Grade 10).</p>
      </div>
      <div class="relative z-10 bg-surface-lowest p-6 rounded-xl border border-border-base shadow-sm">
        <div class="text-active-gold font-bold text-xl mb-2">2065 BS</div>
        <p class="font-body-sm text-body-sm">Introduction of Higher Secondary (+2) programs.</p>
      </div>
      <div class="relative z-10 bg-surface-lowest p-6 rounded-xl border border-border-base shadow-sm">
        <div class="text-active-gold font-bold text-xl mb-2">2080 BS</div>
        <p class="font-body-sm text-body-sm">Modernization with ICT-integrated Smart Classrooms.</p>
      </div>
    </div>
  </div>
</section>

<!-- 6. Campus Facilities -->
<section class="py-16 px-margin-mobile md:px-margin-desktop bg-surface-container-low">
  <div class="max-w-container-max mx-auto">
    <h2 class="font-headline-lg text-headline-lg text-primary mb-12 text-center">Campus Facilities</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
      <div class="space-y-4">
        <div class="h-48 bg-surface-container-high rounded-xl overflow-hidden">
          <img alt="Science room" class="w-full h-full object-cover" src="<?= e_attr(base_url('uploads/gallery/campus/staff-room-interior.jpg')) ?>">
        </div>
        <h3 class="font-headline-sm text-headline-sm text-primary">Science Laboratory</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant">Well-equipped for Physics, Chemistry, and Biology experiments.</p>
      </div>
      <div class="space-y-4">
        <div class="h-48 bg-surface-container-high rounded-xl overflow-hidden">
          <img alt="ICT lab" class="w-full h-full object-cover" src="<?= e_attr(base_url('uploads/gallery/campus/staff-room-computer.jpg')) ?>">
        </div>
        <h3 class="font-headline-sm text-headline-sm text-primary">ICT Lab</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant">Modern computer lab with internet access for smart learning.</p>
      </div>
      <div class="space-y-4">
        <div class="h-48 bg-surface-container-high rounded-xl overflow-hidden">
          <img alt="Library and reading room" class="w-full h-full object-cover" src="<?= e_attr(base_url('uploads/gallery/campus/headmaster-office.jpg')) ?>">
        </div>
        <h3 class="font-headline-sm text-headline-sm text-primary">Library</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant">A collection of academic and reference books for all levels.</p>
      </div>
      <div class="space-y-4">
        <div class="h-48 bg-surface-container-high rounded-xl overflow-hidden">
          <img alt="School courtyard and ground" class="w-full h-full object-cover" src="<?= e_attr(base_url('uploads/gallery/campus/courtyard-students-formation.jpg')) ?>">
        </div>
        <h3 class="font-headline-sm text-headline-sm text-primary">Sports Ground</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant">Space for athletics, football, and community events.</p>
      </div>
    </div>
  </div>
</section>

<!-- 7. Leadership & Team -->
<section class="py-16 md:py-24 px-margin-mobile md:px-margin-desktop">
  <div class="max-w-container-max mx-auto">
    <div class="text-center max-w-2xl mx-auto mb-16">
      <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Our Leadership &amp; Team</h2>
      <p class="font-body-md text-body-md text-on-surface-variant">Guided by experienced educators and dedicated administrative staff committed to academic excellence.</p>
    </div>
    <h3 class="font-headline-md text-headline-md text-primary mb-6 border-b border-border-base pb-2">Leadership</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-16">
      <div class="bg-surface rounded-xl p-6 shadow-ambient border border-border-base hover:shadow-ambient-focus transition-shadow">
        <div class="w-24 h-24 rounded-full bg-surface-container-high mb-4 mx-auto overflow-hidden border-2 border-primary-container">
          <img class="w-full h-full object-cover" alt="School leadership" src="<?= e_attr(base_url('uploads/gallery/staff/leadership-team-photo.jpg')) ?>">
        </div>
        <div class="text-center">
          <h4 class="font-label-lg text-label-lg text-text-heading">Devbarat Prasad Patel</h4>
          <p class="font-body-sm text-body-sm text-active-gold font-medium mt-1">Chairman / Head</p>
        </div>
      </div>
      <div class="bg-surface rounded-xl p-6 shadow-ambient border border-dashed border-outline-variant flex flex-col items-center justify-center min-h-[200px] opacity-70">
        <span class="material-symbols-outlined text-4xl text-outline mb-2">person_add</span>
        <span class="font-label-sm text-label-sm text-on-surface-variant">Principal Profile</span>
      </div>
      <div class="bg-surface rounded-xl p-6 shadow-ambient border border-dashed border-outline-variant flex flex-col items-center justify-center min-h-[200px] opacity-70">
        <span class="material-symbols-outlined text-4xl text-outline mb-2">person_add</span>
        <span class="font-label-sm text-label-sm text-on-surface-variant">Vice-Principal Profile</span>
      </div>
    </div>

    <div class="space-y-12">
      <div>
        <h3 class="font-headline-md text-headline-md text-primary mb-6 border-b border-border-base pb-2">Teaching Staff</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
          <div class="text-center">
            <div class="w-20 h-20 rounded-full bg-surface-container-high mx-auto mb-3 flex items-center justify-center"><span class="material-symbols-outlined text-outline">person</span></div>
            <div class="font-label-md text-label-md">ECD Level</div>
            <div class="text-body-sm text-on-surface-variant">3 Educators</div>
          </div>
          <div class="text-center">
            <div class="w-20 h-20 rounded-full bg-surface-container-high mx-auto mb-3 flex items-center justify-center"><span class="material-symbols-outlined text-outline">person</span></div>
            <div class="font-label-md text-label-md">Basic Level</div>
            <div class="text-body-sm text-on-surface-variant">12 Educators</div>
          </div>
          <div class="text-center">
            <div class="w-20 h-20 rounded-full bg-surface-container-high mx-auto mb-3 flex items-center justify-center"><span class="material-symbols-outlined text-outline">person</span></div>
            <div class="font-label-md text-label-md">Secondary Level</div>
            <div class="text-body-sm text-on-surface-variant">8 Educators</div>
          </div>
          <div class="text-center">
            <div class="w-20 h-20 rounded-full bg-surface-container-high mx-auto mb-3 flex items-center justify-center"><span class="material-symbols-outlined text-outline">person</span></div>
            <div class="font-label-md text-label-md">Higher Secondary</div>
            <div class="text-body-sm text-on-surface-variant">6 Educators</div>
          </div>
        </div>
      </div>
      <div>
        <h3 class="font-headline-md text-headline-md text-primary mb-6 border-b border-border-base pb-2">Non-Teaching &amp; Support</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
          <div class="text-center">
            <div class="w-20 h-20 rounded-full bg-surface-container-high mx-auto mb-3 flex items-center justify-center"><span class="material-symbols-outlined text-outline">admin_panel_settings</span></div>
            <div class="font-label-md text-label-md">Administration</div>
          </div>
          <div class="text-center">
            <div class="w-20 h-20 rounded-full bg-surface-container-high mx-auto mb-3 flex items-center justify-center"><span class="material-symbols-outlined text-outline">cleaning_services</span></div>
            <div class="font-label-md text-label-md">Facility Staff</div>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA -->
    <div class="mt-24 bg-masthead-navy rounded-2xl p-10 md:p-16 text-center shadow-xl relative overflow-hidden">
      <div class="absolute top-0 right-0 w-64 h-64 bg-active-gold rounded-full opacity-10 -translate-y-1/2 translate-x-1/3 blur-2xl"></div>
      <div class="relative z-10">
        <h2 class="font-headline-lg text-headline-lg text-on-primary mb-4">Join Our Community</h2>
        <p class="font-body-lg text-body-lg text-primary-fixed mb-8 max-w-2xl mx-auto">Explore our academic programs or start the admission process today to become part of Shree Public Secondary School.</p>
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
