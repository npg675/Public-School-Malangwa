</main>
<footer class="site-footer">
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-brand">
        <span class="brand-mark" aria-hidden="true">श्री</span>
        <span class="brand-name">Shree Public Secondary School</span>
        <span class="brand-name-np" style="color:#93B4D8;font-family:'Noto Sans Devanagari',sans-serif;font-size:.9rem">श्री पब्लिक माध्यमिक विद्यालय</span>
        <p><?= t('A public, co-educational community school in Malangwa-2, Sarlahi — ECD to Grade 12 with +2 Science & Management (NEB).','मलंगवा-२, सर्लाहीको एक सार्वजनिक सहशिक्षा सामुदायिक विद्यालय — ईसीडी देखि कक्षा १२, +२ विज्ञान र व्यवस्थापन।') ?><br><span style="color:#7FA0C7">IEMIS <?= e(APP_IEMIS) ?> · VH24+22W · <?= e(APP_TYPE) ?></span></p>
        <p style="font-size:.82rem;margin-top:10px;font-family:'Noto Sans Devanagari',sans-serif">श्री पब्लिक माध्यमिक विद्यालय, मलंगवा-२, सर्लाही, मधेश प्रदेश ४५८००, नेपाल</p>
      </div>
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
      <div class="foot-col">
        <h4><?= t('Information','जानकारी') ?></h4>
        <ul>
          <li><a href="<?= e_attr(base_url('notices.php')) ?>"><?= t('Notices','सूचनाहरू') ?></a></li>
          <li><a href="<?= e_attr(base_url('citizen-charter.php')) ?>"><?= t('Citizen Charter','नागरिक वडापत्र') ?></a></li>
          <li><a href="<?= e_attr(base_url('publications.php')) ?>"><?= t('Publications','प्रकाशन') ?></a></li>
          <li><a href="<?= e_attr(base_url('scholarships.php')) ?>"><?= t('Scholarships','छात्रवृत्ति') ?></a></li>
          <li><a href="<?= e_attr(base_url('links.php')) ?>"><?= t('Useful Links','उपयोगी लिङ्क') ?></a></li>
        </ul>
      </div>
    </div>
    <div class="foot-bottom">
      <span>© <?= date('Y') ?> Shree Public Secondary School · Malangwa-2 · <?= t('All rights reserved','सर्वाधिकार सुरक्षित') ?></span>
      <span>IEMIS <?= e(APP_IEMIS) ?> · <a href="<?= e_attr(base_url('sitemap.php')) ?>">Sitemap</a> · <a href="<?= e_attr(base_url('admin/')) ?>"><?= t('Website Management','वेबसाइट व्यवस्थापन') ?></a></span>
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

<?php if (!APP_PHONE): ?>
<a class="wa-fab" href="https://wa.me/9779800000000" style="display:none"></a>
<?php endif; ?>

<script src="<?= e_attr(base_url('assets/js/main.js')) ?>"></script>
</body>
</html>
