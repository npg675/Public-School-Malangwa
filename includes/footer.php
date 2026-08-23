</main>
<footer class="site-footer">
  <div class="wrap">
    <div class="foot-grid">
      <!-- Brand + identity -->
      <div class="foot-brand">
        <div class="foot-brand-top">
          <span class="brand-mark" aria-hidden="true"><img src="<?= e_attr(base_url('assets/img/logo.png')) ?>" alt="" width="44" height="44" loading="lazy" onerror="this.style.display='none'"><span class="brand-mark-fallback">श्री</span></span>
          <div class="foot-brand-text">
            <span class="foot-brand-name">Shree Public Secondary School</span>
            <span class="foot-brand-name-np">श्री पब्लिक माध्यमिक विद्यालय</span>
            <span class="foot-brand-sub">Malangwa-2, Sarlahi • <?= e(APP_TYPE) ?> • ECD–12</span>
          </div>
        </div>
        <p class="foot-desc"><?= t('A public, co-educational community school in Malangwa-2, Sarlahi — ECD to Grade 12 with +2 Science & Management (NEB).','मलंगवा-२, सर्लाहीको एक सार्वजनिक सहशिक्षा सामुदायिक विद्यालय — ईसीडी देखि कक्षा १२, +२ विज्ञान र व्यवस्थापन (NEB)।') ?></p>
        <div class="foot-badges">
          <span class="chip chip-gold">IEMIS <?= e(APP_IEMIS) ?></span>
          <span class="chip chip-outline-light">VH24+22W</span>
          <span class="chip chip-navy-light"><?= e(APP_STUDENTS_DISPLAY) ?> Students</span>
        </div>
        <p class="foot-address-np">श्री पब्लिक माध्यमिक विद्यालय, मलंगवा-२, सर्लाही, मधेश प्रदेश ४५८००, नेपाल</p>
      </div>

      <!-- School -->
      <div class="foot-col">
        <h4><?= t('School','विद्यालय') ?></h4>
        <ul>
          <li><a href="<?= e_attr(base_url('about.php')) ?>"><?= t('About','बारेमा') ?></a></li>
          <li><a href="<?= e_attr(base_url('about.php#leadership')) ?>"><?= t('Leadership','नेतृत्व') ?></a></li>
          <li><a href="<?= e_attr(base_url('about.php#staff')) ?>"><?= t('Staff','कर्मचारी') ?></a></li>
          <li><a href="<?= e_attr(base_url('gallery.php')) ?>"><?= t('Gallery','ग्यालेरी') ?></a></li>
          <li><a href="<?= e_attr(base_url('contact.php')) ?>"><?= t('Contact','सम्पर्क') ?></a></li>
        </ul>
      </div>

      <!-- Academic -->
      <div class="foot-col">
        <h4><?= t('Academic','शैक्षिक') ?></h4>
        <ul>
          <li><a href="<?= e_attr(base_url('academics.php')) ?>"><?= t('Programs','कार्यक्रमहरू') ?></a></li>
          <li><a href="<?= e_attr(base_url('admissions.php')) ?>"><?= t('Admissions','भर्ना') ?></a></li>
          <li><a href="<?= e_attr(base_url('results.php')) ?>"><?= t('Results','नतिजा') ?></a></li>
          <li><a href="<?= e_attr(base_url('academic-calendar.php')) ?>"><?= t('Calendar','पात्रो') ?></a></li>
          <li><a href="<?= e_attr(base_url('downloads.php')) ?>"><?= t('Downloads','डाउनलोड') ?></a></li>
        </ul>
      </div>

      <!-- Contact — real data, responsive -->
      <div class="foot-col foot-col--contact">
        <h4><?= t('Visit & Contact','भेटघाट र सम्पर्क') ?></h4>
        <ul class="foot-contact-list">
          <li class="foot-contact-item">
            <svg class="ic" aria-hidden="true"><use href="#i-pin"/></svg>
            <span>Shree Public Secondary School<br>Malangwa-2, Sarlahi, Madhesh Province 45800<br><a href="https://www.google.com/maps/search/?api=1&query=<?= e_attr(APP_MAP_QUERY) ?>" target="_blank" rel="noopener" class="foot-link-inline">VH24+22W · <?= e(APP_COORDS_LAT) ?>, <?= e(APP_COORDS_LNG) ?> ↗</a></span>
          </li>
          <li class="foot-contact-item">
            <svg class="ic" aria-hidden="true"><use href="#i-phone"/></svg>
            <span>
              <?php if (APP_PHONE): ?><a href="tel:<?= e_attr(APP_PHONE) ?>" class="foot-link-inline"><?= e(APP_PHONE) ?></a><?php else: ?><em class="foot-muted"><?= t('Phone — to be verified by school','फोन — विद्यालयद्वारा पुष्टि हुन बाँकी') ?></em><br><a href="<?= e_attr(base_url('contact.php')) ?>" class="foot-link-inline"><?= t('Message school →','विद्यालयलाई सन्देश →') ?></a><?php endif; ?>
              <?php if (APP_OFFICE_HOURS): ?><br><span class="foot-meta"><?= e(APP_OFFICE_HOURS) ?></span><?php endif; ?>
            </span>
          </li>
          <li class="foot-contact-item">
            <svg class="ic" aria-hidden="true"><use href="#i-mail"/></svg>
            <span><?php if (APP_EMAIL): ?><a href="mailto:<?= e_attr(APP_EMAIL) ?>" class="foot-link-inline"><?= e(APP_EMAIL) ?></a><?php else: ?><em class="foot-muted"><?= t('Email — to be confirmed','इमेल — पुष्टि हुन बाँकी') ?></em><?php endif; ?></span>
          </li>
        </ul>
        <div class="foot-cta">
          <a href="https://www.google.com/maps/search/?api=1&query=<?= e_attr(APP_MAP_QUERY) ?>" target="_blank" rel="noopener" class="btn btn-gold btn-sm foot-btn"><?= t('Get Directions','दिशा प्राप्त गर्नुहोस्') ?> <svg class="ic"><use href="#i-arrow"/></svg></a>
          <a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-ghost btn-sm foot-btn foot-btn--dark"><?= t('Contact','सम्पर्क') ?></a>
        </div>
      </div>
    </div>

    <div class="foot-bottom">
      <span class="foot-copy">© <?= date('Y') ?> Shree Public Secondary School · Malangwa-2 · <?= t('All rights reserved','सर्वाधिकार सुरक्षित') ?></span>
        <nav class="foot-bottom-links" aria-label="Footer legal">
          <span>IEMIS <?= e(APP_IEMIS) ?></span>
          <span class="sep" aria-hidden="true">·</span>
          <a href="<?= e_attr(base_url('faq.php')) ?>">FAQ</a>
          <span class="sep" aria-hidden="true">·</span>
          <a href="<?= e_attr(base_url('sitemap.php')) ?>">Sitemap</a>
          <span class="sep" aria-hidden="true">·</span>
          <a href="<?= e_attr(base_url('admin/')) ?>"><?= t('Website Management','वेबसाइट व्यवस्थापन') ?></a>
        </nav>
    </div>
    <div class="foot-credit"><?= t('Website for community information — not affiliated with any private advertisement. For official notices, contact school office.','समुदायको जानकारीका लागि वेबसाइट — कुनै निजी विज्ञापनसँग सम्बन्धित छैन। आधिकारिक सूचनाका लागि विद्यालय कार्यालयमा सम्पर्क गर्नुहोस्।') ?></div>
  </div>
</footer>

<!-- Mobile sticky quick bar -->
<div class="mobile-quickbar" aria-label="Quick actions">
  <a href="<?= e_attr(base_url('notices.php')) ?>"><svg class="ic"><use href="#i-bell"/></svg> <?= t('Notices','सूचना') ?></a>
  <a href="<?= e_attr(base_url('results.php')) ?>"><svg class="ic"><use href="#i-doc"/></svg> <?= t('Results','नतिजा') ?></a>
  <?php if (APP_PHONE): ?><a href="tel:<?= e_attr(APP_PHONE) ?>"><svg class="ic"><use href="#i-phone"/></svg> <?= t('Call','कल') ?></a><?php else: ?><a href="<?= e_attr(base_url('contact.php')) ?>"><svg class="ic"><use href="#i-phone"/></svg> <?= t('Contact','सम्पर्क') ?></a><?php endif; ?>
  <a href="https://www.google.com/maps/search/?api=1&query=<?= e_attr(APP_MAP_QUERY) ?>" target="_blank" rel="noopener"><svg class="ic"><use href="#i-pin"/></svg> <?= t('Directions','दिशा') ?></a>
</div>

<script src="<?= e_attr(base_url('assets/js/main.js')) ?>"></script>
</body>
</html>
