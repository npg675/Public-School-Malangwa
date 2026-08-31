<?php
require_once __DIR__ . '/helpers.php';
if (!headers_sent()) send_security_headers();
$__lang = current_lang();
$__isNp = $__lang === 'np';
$__page = $page ?? 'home';
$__siteNameEn = (string)setting('site_name_en', APP_NAME_EN);
$__siteNameNp = (string)setting('site_name_np', APP_NAME_NP);
$__addressEn = (string)setting('address_en', APP_ADDRESS);
$__phone = (string)setting('phone', APP_PHONE);
$__iemis = (string)setting('iemis_code', APP_IEMIS);
$__lat = (string)setting('coords_lat', APP_COORDS_LAT);
$__lng = (string)setting('coords_lng', APP_COORDS_LNG);
$__mapQuery = $__lat . ',' . $__lng;
$__logoPath = (string)setting('logo_path', 'assets/img/logo.png');
$__logoUrl = stored_file_url($__logoPath);
$__requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$__basePath = rtrim((string)(parse_url(base_url(), PHP_URL_PATH) ?: '/'), '/');
if ($__basePath !== '' && ($__requestPath === $__basePath || str_starts_with($__requestPath, $__basePath . '/'))) {
    $__canonicalPath = ltrim(substr($__requestPath, strlen($__basePath)), '/');
} else {
    $__canonicalPath = ltrim($__requestPath, '/');
}
$__canonicalUrl = base_url($__canonicalPath);
?>
<!DOCTYPE html>
<html lang="<?= $__isNp ? 'ne' : 'en' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($title ?? $__siteNameEn . ' · Malangwa-2, Sarlahi | ' . $__siteNameNp) ?></title>
<meta name="description" content="<?= e_attr($description ?? 'Shree Public Secondary School — public community school ECD to Grade 12, +2 Science & Management (NEB). Malangwa-2, Sarlahi, Madhesh Province. IEMIS 190640003.') ?>">
<link rel="canonical" href="<?= e_attr($__canonicalUrl) ?>">
<meta property="og:title" content="<?= e_attr($title ?? $__siteNameEn) ?>">
<meta property="og:description" content="<?= e_attr($description ?? '') ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= e_attr(base_url()) ?>">
<meta property="og:image" content="<?= e_attr(base_url('assets/img/og-image.jpg')) ?>">
<meta name="theme-color" content="#001e40">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@600;700&family=Inter:wght@400;500;600;700&family=Noto+Sans+Devanagari:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e_attr(base_url('assets/css/style.css')) ?>">
<?php if (!empty($useTailwind)) require_once __DIR__ . '/tailwind_head.php'; ?>
<link rel="icon" href="<?= e_attr(base_url('assets/img/favicon.png')) ?>">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "EducationalOrganization",
  "name": "<?= e($__siteNameEn) ?>",
  "alternateName": "<?= e(setting('site_name_np', APP_NAME_NP)) ?>",
  "url": "<?= e(base_url()) ?>",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "<?= e($__addressEn) ?>",
    "addressLocality": "Malangwa",
    "addressRegion": "Madhesh Province",
    "postalCode": "45800",
    "addressCountry": "NP"
  },
  "geo": { "@type": "GeoCoordinates", "latitude": "<?= e($__lat) ?>", "longitude": "<?= e($__lng) ?>" },
  "identifier": "IEMIS <?= e($__iemis) ?>"
}
</script>
</head>
<body class="page-<?= e_attr($__page) ?>">
<a class="skip-link" href="#main">Skip to content</a>

<!-- Utility header -->
<aside class="utility-bar" aria-label="School contact bar">
  <div class="wrap utility-inner">
    <div class="utility-left">
      <span class="gov-badge"><span class="dot"></span> <?= t('Government / Community School','सरकारी / सामुदायिक विद्यालय') ?></span>
      <span class="utility-sep" aria-hidden="true">|</span>
      <span class="utility-loc"><svg class="ic" aria-hidden="true"><use href="#i-pin"/></svg> <?= e($__addressEn) ?></span>
    </div>
    <div class="utility-right">
      <?php if ($__phone): ?><a href="tel:<?= e_attr($__phone) ?>"><svg class="ic"><use href="#i-phone"/></svg> <?= e($__phone) ?></a><?php endif; ?>
      <button class="lang-toggle" id="langToggle" aria-label="Toggle language"><span class="<?= $__isNp ? '' : 'active' ?>">EN</span><span class="sep">|</span><span class="<?= $__isNp ? 'active' : '' ?>">नेपाली</span></button>
    </div>
  </div>
</aside>

<!-- Main header -->
<header class="site-header" id="siteHeader">
  <div class="wrap masthead-inner">
    <a class="brand" href="<?= e_attr(base_url()) ?>" aria-label="Shree Public Secondary School home">
      <span class="brand-mark" aria-hidden="true"><img src="<?= e_attr($__logoUrl) ?>" alt="<?= e_attr($__siteNameEn) ?> logo" width="48" height="48" style="width:100%;height:100%;object-fit:contain;border-radius:50%" onerror="this.style.display='none'; this.nextElementSibling.style.display='grid'"><span style="display:none;width:48px;height:48px;place-items:center">श्री</span></span>
      <span class="brand-text">
        <span class="brand-name"><?= e($__isNp ? $__siteNameNp : $__siteNameEn) ?></span>
        <span class="brand-name-np"><?= e($__isNp ? $__siteNameEn : $__siteNameNp) ?></span>
        <span class="brand-sub"><?= e($__addressEn) ?> • <?= t('Community School','सामुदायिक विद्यालय') ?> • IEMIS <?= e($__iemis) ?></span>
      </span>
    </a>
    <nav class="legacy-main-nav" aria-label="Primary">
      <a href="<?= e_attr(base_url()) ?>" class="<?= $__page==='home'?'active':'' ?>"><?= t('Home','गृह') ?></a>
      <a href="<?= e_attr(base_url('about.php')) ?>" class="<?= $__page==='about'?'active':'' ?>"><?= t('About','बारेमा') ?></a>
      <a href="<?= e_attr(base_url('academics.php')) ?>" class="<?= $__page==='academics'?'active':'' ?>"><?= t('Academics','शैक्षिक') ?></a>
      <a href="<?= e_attr(base_url('admissions.php')) ?>" class="<?= $__page==='admissions'?'active':'' ?>"><?= t('Admissions','भर्ना') ?></a>
      <a href="<?= e_attr(base_url('notices.php')) ?>" class="<?= $__page==='notices'?'active':'' ?>"><?= t('Notice Board','सूचना पाटी') ?></a>
      <a href="<?= e_attr(base_url('results.php')) ?>" class="<?= $__page==='results'?'active':'' ?>"><?= t('Results','नतिजा') ?></a>
      <div class="nav-dropdown">
        <button class="nav-drop-btn" aria-expanded="false" aria-haspopup="true"><?= t('Resources','स्रोत') ?> <svg class="ic"><use href="#i-chevron"/></svg></button>
        <div class="nav-drop-menu">
          <a href="<?= e_attr(base_url('downloads.php')) ?>"><?= t('Downloads','डाउनलोड') ?></a>
          <a href="<?= e_attr(base_url('publications.php')) ?>"><?= t('Publications','प्रकाशन') ?></a>
          <a href="<?= e_attr(base_url('academic-calendar.php')) ?>"><?= t('Academic Calendar','शैक्षिक पात्रो') ?></a>
          <a href="<?= e_attr(base_url('citizen-charter.php')) ?>"><?= t('Citizen Charter','नागरिक वडापत्र') ?></a>
          <a href="<?= e_attr(base_url('scholarships.php')) ?>"><?= t('Scholarships','छात्रवृत्ति') ?></a>
          <a href="<?= e_attr(base_url('faq.php')) ?>"><?= t('FAQ','जिज्ञासा') ?></a>
          <a href="<?= e_attr(base_url('links.php')) ?>"><?= t('Useful Links','उपयोगी लिङ्क') ?></a>
        </div>
      </div>
      <a href="<?= e_attr(base_url('gallery.php')) ?>" class="<?= $__page==='gallery'?'active':'' ?>"><?= t('Gallery','ग्यालेरी') ?></a>
      <a href="<?= e_attr(base_url('contact.php')) ?>" class="<?= $__page==='contact'?'active':'' ?>"><?= t('Contact','सम्पर्क') ?></a>
    </nav>
    <div class="header-cta">
      <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-primary btn-sm"><?= t('Admission Inquiry','भर्ना सोधपुछ') ?></a>
    </div>
    <button class="nav-toggle" id="navToggle" aria-label="Open menu" aria-expanded="false"><svg class="ic"><use href="#i-menu"/></svg></button>
  </div>
</header>

<nav class="main-nav-bar" aria-label="Primary navigation">
  <div class="wrap nav-inner">
    <nav class="main-nav" aria-label="Primary">
      <a href="<?= e_attr(base_url()) ?>" class="<?= $__page==='home'?'active':'' ?>"><?= t('Home','गृह') ?></a>
      <a href="<?= e_attr(base_url('about.php')) ?>" class="<?= $__page==='about'||$__page==='management'?'active':'' ?>"><?= t('Our school','हाम्रो विद्यालय') ?></a>
      <div class="nav-dropdown">
        <button class="nav-drop-btn <?= $__page==='academics' || $__page==='results' || $__page==='academic-calendar' ? 'active' : '' ?>" type="button" aria-expanded="false" aria-haspopup="true">
          <?= t('Academics','शैक्षिक') ?> <svg class="ic"><use href="#i-chevron"/></svg>
        </button>
        <div class="nav-drop-menu">
          <a href="<?= e_attr(base_url('academics.php')) ?>"><?= t('Programs and classes','कार्यक्रम तथा कक्षा') ?></a>
          <a href="<?= e_attr(base_url('academic-calendar.php')) ?>"><?= t('Academic calendar','शैक्षिक पात्रो') ?></a>
          <a href="<?= e_attr(base_url('results.php')) ?>"><?= t('Results','नतिजा') ?></a>
        </div>
      </div>
      <a href="<?= e_attr(base_url('admissions.php')) ?>" class="<?= $__page==='admissions'?'active':'' ?>"><?= t('Admissions','भर्ना') ?></a>
      <a href="<?= e_attr(base_url('notices.php')) ?>" class="<?= $__page==='notices' || $__page==='notice' ? 'active' : '' ?>"><?= t('Notices','सूचना') ?></a>
      <a href="<?= e_attr(base_url('gallery.php')) ?>" class="<?= $__page==='gallery'?'active':'' ?>"><?= t('Gallery','ग्यालरी') ?></a>
      <div class="nav-dropdown nav-more">
        <button class="nav-drop-btn <?= in_array($__page, ['events','downloads','publications','scholarships','faq','links','citizen-charter'], true) ? 'active' : '' ?>" type="button" aria-expanded="false" aria-haspopup="true">
          <?= t('More','थप') ?> <svg class="ic"><use href="#i-chevron"/></svg>
        </button>
        <div class="nav-drop-menu">
          <a href="<?= e_attr(base_url('events.php')) ?>"><?= t('Events','कार्यक्रम') ?></a>
          <a href="<?= e_attr(base_url('downloads.php')) ?>"><?= t('Downloads','डाउनलोड') ?></a>
          <a href="<?= e_attr(base_url('publications.php')) ?>"><?= t('Publications','प्रकाशन') ?></a>
          <a href="<?= e_attr(base_url('scholarships.php')) ?>"><?= t('Scholarships','छात्रवृत्ति') ?></a>
          <a href="<?= e_attr(base_url('faq.php')) ?>">FAQ</a>
          <a href="<?= e_attr(base_url('links.php')) ?>"><?= t('Useful links','उपयोगी लिङ्क') ?></a>
        </div>
      </div>
    </nav>
    <a href="<?= e_attr(base_url('contact.php')) ?>" class="nav-login <?= $__page==='contact'?'active':'' ?>"><?= t('Contact','सम्पर्क') ?></a>
  </div>
</nav>

<nav class="mobile-nav" id="mobileNav" aria-label="Mobile">
  <div class="mn-head">
    <span class="brand-text"><span class="brand-name" style="color:#fff"><?= e($__isNp ? $__siteNameNp : $__siteNameEn) ?></span><span class="brand-sub" style="color:#93B4D8"><?= e($__addressEn) ?> • IEMIS <?= e($__iemis) ?></span></span>
    <button class="mn-close" id="navClose" aria-label="Close menu"><svg class="ic"><use href="#i-close"/></svg></button>
  </div>
  <div class="mn-links">
    <a href="<?= e_attr(base_url()) ?>"><?= t('Home','गृह') ?> <svg class="ic"><use href="#i-arrow"/></svg></a>
    <a href="<?= e_attr(base_url('about.php')) ?>"><?= t('About','बारेमा') ?> <svg class="ic"><use href="#i-arrow"/></svg></a>
    <a href="<?= e_attr(base_url('academics.php')) ?>"><?= t('Academics','शैक्षिक') ?> <svg class="ic"><use href="#i-arrow"/></svg></a>
    <a href="<?= e_attr(base_url('admissions.php')) ?>"><?= t('Admissions','भर्ना') ?> <svg class="ic"><use href="#i-arrow"/></svg></a>
    <a href="<?= e_attr(base_url('notices.php')) ?>"><?= t('Notice Board','सूचना पाटी') ?> <svg class="ic"><use href="#i-arrow"/></svg></a>
    <a href="<?= e_attr(base_url('results.php')) ?>"><?= t('Results','नतिजा') ?> <svg class="ic"><use href="#i-arrow"/></svg></a>
    <a href="<?= e_attr(base_url('downloads.php')) ?>"><?= t('Downloads','डाउनलोड') ?> <svg class="ic"><use href="#i-arrow"/></svg></a>
    <a href="<?= e_attr(base_url('gallery.php')) ?>"><?= t('Gallery','ग्यालेरी') ?> <svg class="ic"><use href="#i-arrow"/></svg></a>
    <a href="<?= e_attr(base_url('contact.php')) ?>"><?= t('Contact','सम्पर्क') ?> <svg class="ic"><use href="#i-arrow"/></svg></a>
  </div>
  <div class="mn-foot">
    <?php if ($__phone): ?><a href="tel:<?= e_attr($__phone) ?>"><svg class="ic"><use href="#i-phone"/></svg> <?= e($__phone) ?></a><?php endif; ?>
    <a href="https://www.google.com/maps/search/?api=1&amp;query=<?= e_attr($__mapQuery) ?>" target="_blank" rel="noopener"><svg class="ic"><use href="#i-pin"/></svg> <?= e($__addressEn) ?></a>
    <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-gold" style="justify-content:center"><?= t('Admission Inquiry','भर्ना सोधपुछ') ?></a>
    <div class="mn-lang"><button onclick="setLang('en')" class="<?= $__lang==='en'?'active':'' ?>">EN</button><button onclick="setLang('np')" class="<?= $__lang==='np'?'active':'' ?>">नेपाली</button></div>
  </div>
</nav>

<!-- Emergency / Latest Notice Bar (only on home, but component available globally) -->
<?php $pinnedNotice = $pinnedNotice ?? get_pinned_notice(); ?>
<?php if (!empty($pinnedNotice) && ($__page==='home')): ?>
<div class="notice-bar <?= !empty($pinnedNotice['is_urgent'])?'urgent':'' ?>" role="status" aria-live="polite">
  <div class="wrap notice-bar-inner">
    <span class="notice-bar-label"><svg class="ic"><use href="#i-bell"/></svg> <?= t('Latest Notice','ताजा सूचना') ?></span>
    <a class="notice-bar-title" href="<?= e_attr(base_url('notice.php?slug=' . $pinnedNotice['slug'])) ?>"><?= e($__isNp && !empty($pinnedNotice['title_np']) ? $pinnedNotice['title_np'] : $pinnedNotice['title_en']) ?></a>
    <span class="notice-bar-date"><?= e(date('M j, Y', strtotime($pinnedNotice['published_at']))) ?></span>
    <a class="notice-bar-cta" href="<?= e_attr(base_url('notice.php?slug=' . $pinnedNotice['slug'])) ?>"><?= t('View Notice','सूचना हेर्नुहोस्') ?> →</a>
  </div>
</div>
<?php endif; ?>

<svg xmlns="http://www.w3.org/2000/svg" style="display:none" aria-hidden="true">
  <symbol id="i-phone" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></symbol>
  <symbol id="i-wa" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></symbol>
  <symbol id="i-mail" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></symbol>
  <symbol id="i-pin" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></symbol>
  <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></symbol>
  <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></symbol>
  <symbol id="i-chevron" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"/></symbol>
  <symbol id="i-check" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></symbol>
  <symbol id="i-menu" viewBox="0 0 24 24"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></symbol>
  <symbol id="i-close" viewBox="0 0 24 24"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></symbol>
  <symbol id="i-grad" viewBox="0 0 24 24"><path d="m22 10-10-5L2 10l10 5 10-5z"/><path d="M6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"/><path d="M22 10v6"/></symbol>
  <symbol id="i-book" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></symbol>
  <symbol id="i-flask" viewBox="0 0 24 24"><path d="M10 2v6L4.5 18a2 2 0 0 0 1.77 3h11.46a2 2 0 0 0 1.77-3L14 8V2"/><path d="M8.5 2h7"/><path d="M7 15h10"/></symbol>
  <symbol id="i-bell" viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></symbol>
  <symbol id="i-calendar" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></symbol>
  <symbol id="i-camera" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></symbol>
  <symbol id="i-user" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
  <symbol id="i-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></symbol>
  <symbol id="i-doc" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/></symbol>
  <symbol id="i-pen" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"/></symbol>
  <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></symbol>
  <symbol id="i-download" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></symbol>
  <symbol id="i-award" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.5 13 17 22l-5-3-5 3 1.5-9"/></symbol>
  <symbol id="i-star" viewBox="0 0 24 24"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></symbol>
</svg>
<main id="main">
