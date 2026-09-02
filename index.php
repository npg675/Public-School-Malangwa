<?php
$page = 'home';
$title = 'Shree Public Secondary School — Malangwa-2, Sarlahi | श्री पब्लिक माध्यमिक विद्यालय';
$description = 'Shree Public Secondary School — government community school in Malangwa-2, Sarlahi, Madhesh Province. ECD to Grade 12 with +2 Science & Management (NEB). IEMIS 190640003.';
$useTailwind = false;
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/header.php';

$homeNotices = get_notices(4);
$blocks = get_blocks('home');
$sections = function (string $key) use ($blocks): array {
    return array_values(array_filter($blocks, static fn(array $block): bool => ($block['section_key'] ?? '') === $key));
};
$first = function (string $key) use ($sections): ?array {
    return $sections($key)[0] ?? null;
};
$hero = $first('hero');
$heroTitle = trim((string)($hero ? block_val($hero, 'title') : t('Shree Public Secondary School', 'श्री पब्लिक माध्यमिक विद्यालय')));
$heroTitle = preg_replace('/\s*[—–-]\s*(?:Malangwa[-–—]?2|मलंगवा[-–—]?२)\s*$/u', '', $heroTitle) ?: $heroTitle;
$intro = $first('intro');
$commitments = $sections('commitment');
$galleryAlbums = get_gallery_albums(6);
$heroImage = (string)($hero['image_url'] ?? '');
if ($heroImage === '' || $heroImage === 'uploads/hero/hero-main-gate-jubilee.jpg') {
    $heroImage = 'uploads/hero/hero-courtyard-assembly.jpg';
}
$galleryFallbacks = [
    ['title_en' => 'Campus life', 'title_np' => 'विद्यालय जीवन', 'cover' => base_url('uploads/gallery/campus/front-building-entrance.jpg')],
    ['title_en' => 'Assembly and events', 'title_np' => 'सभा तथा कार्यक्रम', 'cover' => base_url('uploads/gallery/assembly/teacher-addressing-assembly.jpg')],
    ['title_en' => 'Student community', 'title_np' => 'विद्यार्थी समुदाय', 'cover' => base_url('uploads/gallery/campus/courtyard-students-formation.jpg')],
    ['title_en' => 'School grounds', 'title_np' => 'विद्यालय परिसर', 'cover' => base_url('uploads/about/campus-building-aerial.jpg')],
];
$galleryTiles = array_values(array_filter($galleryAlbums, static fn(array $album): bool => !empty($album['cover'])));
foreach ($galleryFallbacks as $fallback) {
    if (count($galleryTiles) >= 6) break;
    $galleryTiles[] = $fallback;
}
$noticeTitle = static fn(array $notice): string => t((string)($notice['title_en'] ?? ''), (string)($notice['title_np'] ?? $notice['title_en'] ?? ''));
$noticeSummary = static function (array $notice): string {
    $key = current_lang() === 'np' ? 'summary_np' : 'summary_en';
    return trim((string)($notice[$key] ?? $notice['summary_en'] ?? ''));
};
$dateLabel = static function (string $date): string {
    return date('M j', strtotime($date) ?: time());
};
?>
<div class="home-page">
  <section class="home-hero">
    <img class="home-hero-image" src="<?= e_attr(media_url($heroImage)) ?>" alt="<?= e_attr(t('Students and staff at Shree Public Secondary School', 'श्री पब्लिक माध्यमिक विद्यालयका विद्यार्थी र शिक्षकहरू')) ?>">
    <div class="home-hero-shade"></div>
    <div class="home-shell home-hero-content">
      <div class="home-hero-copy reveal">
        <p class="home-kicker"><?= e(t('Education · Discipline · Opportunity', 'शिक्षा · अनुशासन · अवसर')) ?></p>
        <h1><?= e($heroTitle) ?></h1>
        <p class="home-hero-location"><?= e(t('Malangwa-2, Sarlahi, Nepal', 'मलंगवा-२, सर्लाही, नेपाल')) ?></p>
        <p class="home-hero-description"><?= e($hero ? block_val($hero, 'body') : t('A supportive public school where students learn with confidence, develop strong values, and prepare for a better future.', 'विद्यार्थीहरूले आत्मविश्वासका साथ सिक्ने, असल मूल्य विकास गर्ने र उज्ज्वल भविष्यका लागि तयार हुने सार्वजनिक विद्यालय।')) ?></p>
        <div class="home-actions">
          <a class="home-button home-button-primary" href="<?= e_attr(base_url('notices.php')) ?>"><?= e(t('View latest notices', 'ताजा सूचना हेर्नुहोस्')) ?> <span aria-hidden="true">↗</span></a>
          <a class="home-button home-button-outline" href="<?= e_attr(base_url('about.php')) ?>"><?= e(t('Explore our school', 'हाम्रो विद्यालय हेर्नुहोस्')) ?> <span aria-hidden="true">→</span></a>
        </div>
      </div>
    </div>
  </section>

  <section class="home-quick home-shell" aria-labelledby="quick-access-title">
    <div class="home-section-intro home-section-intro-left">
      <p class="home-overline"><?= e(t('Quick access', 'छिटो पहुँच')) ?></p>
      <h2 id="quick-access-title"><?= e(t('Everything you need, just a click away.', 'आवश्यक जानकारी एकै क्लिकमा।')) ?></h2>
    </div>
    <div class="home-quick-grid">
      <?php
      $quickLinks = [
          ['icon' => 'campaign', 'title' => t('Latest notices', 'ताजा सूचना'), 'body' => t('Stay updated with school announcements, exams, holidays and essential notices.', 'विद्यालयका सूचना, परीक्षा, बिदा र आवश्यक जानकारी हेर्नुहोस्।'), 'href' => 'notices.php', 'label' => t('View all notices', 'सबै सूचना हेर्नुहोस्')],
          ['icon' => 'menu_book', 'title' => t('Academic information', 'शैक्षिक जानकारी'), 'body' => t('Explore learning, examinations, school activities and academic resources.', 'पठनपाठन, परीक्षा, गतिविधि र शैक्षिक स्रोतबारे जान्नुहोस्।'), 'href' => 'academics.php', 'label' => t('Explore academics', 'शैक्षिक जानकारी')],
          ['icon' => 'photo_library', 'title' => t('School gallery', 'विद्यालय ग्यालेरी'), 'body' => t('See moments from school programs, classroom activities and community events.', 'विद्यालयका कार्यक्रम, कक्षा गतिविधि र सामुदायिक कार्यक्रमका तस्बिरहरू हेर्नुहोस्।'), 'href' => 'gallery.php', 'label' => t('View gallery', 'ग्यालेरी हेर्नुहोस्')],
          ['icon' => 'call', 'title' => t('Contact school', 'विद्यालय सम्पर्क'), 'body' => t('Need information about admissions or school administration? Contact us directly.', 'भर्ना वा विद्यालय प्रशासनबारे जानकारी चाहिन्छ? हामीलाई सम्पर्क गर्नुहोस्।'), 'href' => 'contact.php', 'label' => t('Contact us', 'सम्पर्क गर्नुहोस्')],
      ];
      foreach ($quickLinks as $quick):
      ?>
      <a class="home-quick-card reveal" href="<?= e_attr(base_url($quick['href'])) ?>">
        <span class="home-icon-circle"><span class="material-symbols-outlined" aria-hidden="true"><?= e($quick['icon']) ?></span></span>
        <span class="home-quick-copy"><strong><?= e($quick['title']) ?></strong><span><?= e($quick['body']) ?></span><em><?= e($quick['label']) ?> <b aria-hidden="true">→</b></em></span>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="home-about home-shell">
    <div class="home-about-image reveal"><img src="<?= e_attr(base_url('uploads/gallery/campus/front-building-entrance.jpg')) ?>" alt="<?= e_attr(t('School building and students', 'विद्यालय भवन र विद्यार्थीहरू')) ?>" loading="lazy"></div>
    <div class="home-about-copy reveal">
      <p class="home-overline"><?= e($intro ? block_val($intro, 'title') : t('About our school', 'हाम्रो विद्यालयको बारेमा')) ?></p>
      <h2><?= e(t('Learning today. Building tomorrow.', 'आज सिक्दै, भोलि बनाउँदै।')) ?></h2>
      <p><?= e($intro ? block_val($intro, 'body') : t('Shree Public Secondary School is a public educational institution serving students and families in Malangwa-2, Sarlahi.', 'श्री पब्लिक माध्यमिक विद्यालय मलंगवा-२, सर्लाहीका विद्यार्थी र परिवारलाई सेवा दिने सार्वजनिक शैक्षिक संस्था हो।')) ?></p>
      <p><?= e(t('Our focus is simple: create an environment where students have access to meaningful education, responsible guidance, discipline and opportunities to grow.', 'हाम्रो लक्ष्य स्पष्ट छ: विद्यार्थीलाई अर्थपूर्ण शिक्षा, जिम्मेवार मार्गदर्शन, अनुशासन र विकासका अवसर दिने वातावरण बनाउनु।')) ?></p>
      <a class="home-text-link" href="<?= e_attr(base_url('about.php')) ?>"><?= e(t('Learn more about us', 'हाम्रो बारेमा थप जान्नुहोस्')) ?> <span aria-hidden="true">→</span></a>
    </div>
  </section>

  <section class="home-focus" aria-labelledby="focus-title">
    <div class="home-shell">
      <div class="home-section-intro home-section-intro-center">
        <p class="home-overline"><?= e(t('Our focus', 'हाम्रो ध्यान')) ?></p>
        <h2 id="focus-title"><?= e(t('Education that supports every student', 'हरेक विद्यार्थीलाई साथ दिने शिक्षा')) ?></h2>
      </div>
      <div class="home-focus-grid">
        <?php
        $focusFallbacks = [
            ['icon' => 'school', 'title' => t('Quality learning', 'गुणस्तरीय सिकाइ'), 'body' => t('Classroom learning that is clear, practical and meaningful.', 'स्पष्ट, व्यावहारिक र अर्थपूर्ण कक्षा सिकाइ।')],
            ['icon' => 'verified_user', 'title' => t('Discipline and responsibility', 'अनुशासन र जिम्मेवारी'), 'body' => t('Students learn punctuality, responsibility, respect and good character.', 'समयपालन, जिम्मेवारी, सम्मान र असल चरित्रको विकास।')],
            ['icon' => 'groups', 'title' => t('Student development', 'विद्यार्थी विकास'), 'body' => t('Academic, cultural, sporting and community activities help students discover their strengths.', 'शैक्षिक, सांस्कृतिक, खेलकुद र सामुदायिक गतिविधिले विद्यार्थीको क्षमता विकास गर्छ।')],
            ['icon' => 'star', 'title' => t('Equal opportunity', 'समान अवसर'), 'body' => t('Every student should have the opportunity to learn, participate and grow.', 'हरेक विद्यार्थीले सिक्ने, सहभागी हुने र अघि बढ्ने अवसर पाउनुपर्छ।')],
        ];
        for ($i = 0; $i < 4; $i++):
            $focus = $commitments[$i] ?? null;
            $fallback = $focusFallbacks[$i];
        ?>
        <article class="home-focus-item reveal">
          <span class="material-symbols-outlined home-focus-icon" aria-hidden="true"><?= e($focus['icon'] ?? $fallback['icon']) ?></span>
          <h3><?= e($focus ? block_val($focus, 'title') : $fallback['title']) ?></h3>
          <p><?= e($focus ? block_val($focus, 'body') : $fallback['body']) ?></p>
        </article>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <section class="home-academics home-shell">
    <div class="home-academics-copy reveal">
      <p class="home-overline"><?= e(t('Academics', 'शैक्षिक कार्यक्रम')) ?></p>
      <h2><?= e(t('Supporting students through every stage of learning', 'सिकाइका हरेक चरणमा विद्यार्थीलाई साथ')) ?></h2>
      <p><?= e(t('Our academic environment is built around regular classroom teaching, assessment, examinations, teacher guidance and student participation.', 'हाम्रो शैक्षिक वातावरण नियमित कक्षा शिक्षण, मूल्याङ्कन, परीक्षा, शिक्षकको मार्गदर्शन र विद्यार्थी सहभागितामा आधारित छ।')) ?></p>
      <div class="home-academic-cards">
        <article><span class="material-symbols-outlined" aria-hidden="true">menu_book</span><h3><?= e(t('Classroom learning', 'कक्षा सिकाइ')) ?></h3><p><?= e(t('Structured lessons and teacher guidance focused on understanding.', 'बुझाइमा केन्द्रित व्यवस्थित पाठ र शिक्षकको मार्गदर्शन।')) ?></p></article>
        <article><span class="material-symbols-outlined" aria-hidden="true">description</span><h3><?= e(t('Examination and assessment', 'परीक्षा र मूल्याङ्कन')) ?></h3><p><?= e(t('Regular assessment helps students and teachers plan for improvement.', 'नियमित मूल्याङ्कनले सुधारका लागि योजना बनाउन सहयोग गर्छ।')) ?></p></article>
        <article><span class="material-symbols-outlined" aria-hidden="true">groups</span><h3><?= e(t('Activities and participation', 'गतिविधि र सहभागिता')) ?></h3><p><?= e(t('Students take part in academic, cultural, sports and community activities.', 'विद्यार्थी शैक्षिक, सांस्कृतिक, खेलकुद र सामुदायिक गतिविधिमा सहभागी हुन्छन्।')) ?></p></article>
      </div>
      <a class="home-text-link" href="<?= e_attr(base_url('academics.php')) ?>"><?= e(t('Explore academics', 'शैक्षिक कार्यक्रम हेर्नुहोस्')) ?> <span aria-hidden="true">→</span></a>
    </div>
    <div class="home-academics-image reveal"><img src="<?= e_attr(base_url('uploads/gallery/campus/courtyard-students-formation.jpg')) ?>" alt="<?= e_attr(t('Students gathered in the school courtyard', 'विद्यालयको प्राङ्गणमा भेला भएका विद्यार्थीहरू')) ?>" loading="lazy"></div>
  </section>

  <section class="home-updates">
    <div class="home-shell home-updates-grid">
      <div class="home-notices reveal">
        <div class="home-section-heading"><div><p class="home-overline"><?= e(t('Latest notices and updates', 'ताजा सूचना तथा जानकारी')) ?></p><h2><?= e(t('Stay informed', 'जानकारीमा रहनुहोस्')) ?></h2></div><a class="home-arrow-link" href="<?= e_attr(base_url('notices.php')) ?>"><?= e(t('All notices', 'सबै सूचना')) ?> →</a></div>
        <p class="home-muted"><?= e(t('Important information from the school administration should always be easy for students and families to find.', 'विद्यालय प्रशासनका महत्वपूर्ण सूचना विद्यार्थी र परिवारले सजिलै भेट्न सक्ने हुनुपर्छ।')) ?></p>
        <div class="home-notice-list">
          <?php if (!$homeNotices): ?>
            <div class="home-empty"><?= e(t('New notices will be published soon.', 'नयाँ सूचना चाँडै प्रकाशित हुनेछ।')) ?></div>
          <?php else: foreach ($homeNotices as $notice): ?>
            <a class="home-notice-row" href="<?= e_attr(base_url('notice.php?slug=' . urlencode((string)($notice['slug'] ?? '')))) ?>">
              <span class="home-notice-date"><?= e($dateLabel((string)($notice['published_at'] ?? ''))) ?></span>
              <span class="home-notice-content"><strong><?= e($noticeTitle($notice)) ?></strong><small><?= e($noticeSummary($notice)) ?></small></span>
              <span class="home-notice-arrow" aria-hidden="true">→</span>
            </a>
          <?php endforeach; endif; ?>
        </div>
        <a class="home-button home-button-small" href="<?= e_attr(base_url('notices.php')) ?>"><?= e(t('View all notices', 'सबै सूचना हेर्नुहोस्')) ?> <span aria-hidden="true">→</span></a>
      </div>
      <div class="home-life reveal">
        <div class="home-section-heading"><div><p class="home-overline"><?= e(t('School life', 'विद्यालय जीवन')) ?></p><h2><?= e(t('More than a classroom', 'कक्षाभन्दा बाहिर पनि')) ?></h2></div><a class="home-arrow-link" href="<?= e_attr(base_url('gallery.php')) ?>"><?= e(t('Gallery', 'ग्यालेरी')) ?> →</a></div>
        <p class="home-muted"><?= e(t('Our students learn, create, celebrate, collaborate and build lasting experiences.', 'हाम्रा विद्यार्थी सिक्छन्, सिर्जना गर्छन्, उत्सव मनाउँछन्, सहकार्य गर्छन् र अनुभव बटुल्छन्।')) ?></p>
        <?php if (!$galleryTiles): ?>
          <div class="home-empty"><?= e(t('Photos will be published soon.', 'तस्बिरहरू चाँडै प्रकाशित हुनेछ।')) ?></div>
        <?php else: ?>
          <div class="home-gallery-grid">
            <?php foreach (array_slice($galleryTiles, 0, 6) as $index => $tile): ?>
            <a href="<?= e_attr(base_url('gallery.php')) ?>" class="home-gallery-tile <?= $index === 0 ? 'home-gallery-featured' : '' ?>"><img src="<?= e_attr($tile['cover']) ?>" alt="<?= e_attr(t((string)($tile['title_en'] ?? 'School gallery'), (string)($tile['title_np'] ?? 'विद्यालय ग्यालेरी'))) ?>" loading="lazy"></a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <a class="home-button home-button-small" href="<?= e_attr(base_url('gallery.php')) ?>"><?= e(t('Explore gallery', 'ग्यालेरी हेर्नुहोस्')) ?> <span aria-hidden="true">→</span></a>
      </div>
    </div>
  </section>

  <section class="home-exam-band">
    <div class="home-shell home-exam-inner">
      <span class="home-exam-icon material-symbols-outlined" aria-hidden="true">fact_check</span>
      <div><p class="home-overline"><?= e(t('Official examination centre', 'आधिकारिक परीक्षा केन्द्र')) ?></p><h2><?= e(t('Supporting educational activities in Sarlahi', 'सर्लाहीमा शैक्षिक गतिविधिलाई साथ')) ?></h2><p><?= e(t('Shree Public Secondary School has also appeared in official examination-centre allocation for Sarlahi, reflecting the school’s role in supporting examinations and educational activities in the district.', 'श्री पब्लिक माध्यमिक विद्यालय सर्लाहीका आधिकारिक परीक्षा केन्द्रको सूचीमा पनि परेको छ।')) ?></p></div>
      <div class="home-exam-mark"><span class="material-symbols-outlined" aria-hidden="true">account_balance</span><strong>CTEVT</strong><small><?= e(t('Examination Centre', 'परीक्षा केन्द्र')) ?></small></div>
    </div>
  </section>

  <section class="home-contact home-shell">
    <div class="home-contact-copy reveal">
      <p class="home-overline"><?= e(t('Visit our school', 'हाम्रो विद्यालयमा आउनुहोस्')) ?></p>
      <h2><?= e(setting('site_name_en', APP_NAME_EN)) ?></h2>
      <p class="home-contact-np"><?= e(setting('site_name_np', APP_NAME_NP)) ?></p>
      <p><span class="material-symbols-outlined" aria-hidden="true">location_on</span> <?= e(setting('address_en', APP_ADDRESS)) ?></p>
      <?php if (setting('phone', APP_PHONE) !== ''): ?><p><span class="material-symbols-outlined" aria-hidden="true">call</span> <?= e(setting('phone', APP_PHONE)) ?></p><?php endif; ?>
      <div class="home-contact-actions"><a class="home-button home-button-primary" href="https://www.google.com/maps/search/?api=1&amp;query=<?= e_attr(setting('coords_lat', APP_COORDS_LAT) . ',' . setting('coords_lng', APP_COORDS_LNG)) ?>" target="_blank" rel="noopener"><?= e(t('Get directions', 'दिशा प्राप्त गर्नुहोस्')) ?> →</a><a class="home-button home-button-green" href="<?= e_attr(base_url('contact.php')) ?>"><?= e(t('Contact school', 'विद्यालय सम्पर्क')) ?></a></div>
    </div>
    <div class="map-wrap reveal" style="min-height:340px">
      <iframe src="https://www.google.com/maps?q=<?= e_attr(setting('coords_lat', APP_COORDS_LAT) . ',' . setting('coords_lng', APP_COORDS_LNG)) ?>&amp;z=16&amp;output=embed&amp;hl=en" title="Map — <?= e_attr(APP_NAME_EN) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      <a class="map-fab" href="https://www.google.com/maps/search/?api=1&amp;query=<?= e_attr(setting('coords_lat', APP_COORDS_LAT) . ',' . setting('coords_lng', APP_COORDS_LNG)) ?>" target="_blank" rel="noopener"><svg class="ic"><use href="#i-pin"/></svg> <?= e(t('Get Directions','दिशा प्राप्त गर्नुहोस्')) ?></a>
    </div>
  </section>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
