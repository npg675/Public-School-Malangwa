<?php $page='academics'; $title='+2 Management (NEB) — Shree Public Secondary School | Malangwa-2, Sarlahi'; $description='+2 Management stream at Shree Public Secondary School, Malangwa-2 — program overview, learning focus and general further-study examples under NEB.'; require_once __DIR__.'/includes/helpers.php'; require_once __DIR__.'/includes/header.php';
$blocks = get_blocks('management');
$sec = function(string $k) use ($blocks): array { return array_values(array_filter($blocks, fn($b)=>$b['section_key']===$k)); };
$first = function(string $k) use ($sec): ?array { return $sec($k)[0] ?? null; };
$intro = $first('intro');
$groups = get_staff_directory();
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> <?= e(t('Academics • +2 Management • NEB','शैक्षिक • +२ व्यवस्थापन • एनईबी')) ?></span><h1 style="color:#fff;margin:14px 0 10px">+2 Management<br><span style="color:var(--gold)">Grades 11–12 • NEB</span></h1><p class="lead" style="color:#C7D7F0;max-width:680px">Higher secondary management program — preparation for further study in business, commerce and related fields.</p><div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap"><span style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:999px;font-size:.8rem;color:#fff">NEB affiliated</span><span style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:999px;font-size:.8rem;color:#fff">IEMIS 190640003</span><span style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:999px;font-size:.8rem;color:#fff">Malangwa-2, Sarlahi</span></div></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>"><?= e(t('Home','गृह')) ?></a><span class="sep">/</span><a href="<?= e_attr(base_url('academics.php')) ?>"><?= e(t('Academics','शैक्षिक')) ?></a><span class="sep">/</span><span>+2 Management</span></div></nav>

<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="display:grid;gap:24px">
    <!-- Overview -->
    <div>
      <span class="eyebrow"><span class="dot"></span> <?= e(t('Program Overview','कार्यक्रम अवलोकन')) ?></span>
      <h2 style="margin:12px 0 12px;font-size:1.35rem"><?= e(t('What the Management stream is for','व्यवस्थापन स्ट्रिम केका लागि हो')) ?></h2>
      <div style="color:var(--muted);line-height:1.75;display:flex;flex-direction:column;gap:12px;font-size:.94rem;max-width:760px">
        <?php if ($intro && trim(block_val($intro,'body'))!==''): ?><?= block_val($intro,'body') ?><?php else: ?>
        <p>The <strong style="color:var(--text)">+2 Management</strong> program is a two-year higher secondary course (Grades 11 and 12) under the <strong>National Examinations Board (NEB)</strong> — the second NEB stream currently operated at Shree Public alongside <strong>+2 Science</strong>.</p>
        <p>Students who have completed Grade 10 (SEE) from Shree Public or any other recognised institution may apply to Grade 11 in this stream, subject to the eligibility criteria and seats confirmed each year by the school office. The programme is intended as preparation for further study after Grade 12 in areas such as <strong style="color:var(--text)">business, commerce, management, finance and related fields</strong>, depending on subject combination and results.</p>
        <p>Study runs over two academic years with internal assessments and board examinations as required by NEB. No employment or placement outcome is promised — progression depends on academic performance and the admission criteria of the receiving institution.</p>
        <?php endif; ?>
      </div>
      <div class="verify-banner"><svg class="ic"><use href="#i-info"/></svg><span><?= e(t('NEB programs, registration and examination dates are managed nationally (see neb.gov.np). Official subject combinations and timetables are confirmed by the school office each year.','एनईबी कार्यक्रम, दर्ता र परीक्षा मितिहरू राष्ट्रिय रूपमा व्यवस्थित हुन्छन् (neb.gov.np हेर्नुहोस्)। आधिकारिक विषय संयोजन र तालिकाहरू विद्यालय कार्यालयले प्रत्येक वर्ष पुष्टि गर्दछ।')) ?></span></div>
    </div>

    <!-- Learning focus -->
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:22px">
      <h3 style="font-size:1.1rem"><?= e(t('Learning focus','सिकाइ केन्द्र')) ?></h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px"><?= e(t('General topics associated with the Management stream — not an official subject list. Exact combination is confirmed by the school and NEB registration.','व्यवस्थापन स्ट्रिमसँग सम्बन्धित सामान्य विषयहरू — आधिकारिक विषय सूची होइन। सही संयोजन विद्यालय र एनईबी दर्ताले पुष्टि गर्दछ।')) ?></p>
      <div style="display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));margin-top:16px">
        <?php foreach ($sec('highlight') as $h): ?>
        <div style="background:#fff;border:1px solid var(--border);border-radius:10px;padding:14px"><h4 style="font-size:.9rem;display:flex;gap:8px;align-items:center"><span style="width:32px;height:32px;border-radius:8px;background:var(--primary);color:#fff;display:grid;place-items:center;flex:none"><span class="material-symbols-outlined" style="font-size:18px"><?= e($h['icon'] ?? 'business_center') ?></span></span> <?= e(block_val($h,'title')) ?></h4><p style="color:var(--muted);font-size:.84rem;margin-top:6px;line-height:1.6"><?= e(block_val($h,'body')) ?></p></div>
        <?php endforeach; ?>
      </div>
      <p style="font-size:.78rem;color:var(--muted-2);margin-top:12px"><em><?= e(t('Do not treat this list as an official course list. Subjects are confirmed annually via notices and the academic office.','यो सूची आधिकारिक पाठ्यक्रम सूची होइन। विषयहरू वार्षिक रूपमा सूचनाहरू र शैक्षिक कार्यालय मार्फत पुष्टि गरिन्छ।')) ?></em></p>
    </div>

    <?php if (!empty($groups['committee'])): ?>
    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:20px">
      <h3 style="font-size:1.1rem"><?= e(t('School Management Committee','विद्यालय व्यवस्थापन समिति')) ?></h3>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4" style="margin-top:14px">
        <?php foreach ($groups['committee'] as $person): ?>
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

    <!-- Who / Future -->
    <div style="display:grid;gap:16px;grid-template-columns:1fr 1fr">
      <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:20px">
        <h3 style="font-size:1.05rem"><?= e(t('Who may consider Management?','व्यवस्थापन कसले विचार गर्न सक्छ?')) ?></h3>
        <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.7"><?= e(t('General guidance — not an entry rule. Discuss with teachers and guardians before choosing.','सामान्य मार्गदर्शन — प्रवेश नियम होइन। छनौट गर्नु अघि शिक्षक र अभिभावकसँग छलफल गर्नुहोस्।')) ?></p>
        <ul style="margin-top:12px;display:flex;flex-direction:column;gap:8px;color:var(--muted);font-size:.88rem;line-height:1.6;list-style:none">
          <li style="display:flex;gap:10px"><span style="color:var(--success);margin-top:2px"><svg class="ic"><use href="#i-check"/></svg></span><span><?= e(t('Students interested in how businesses, markets and organisations work.','व्यवसाय, बजार र संगठनहरू कसरी काम गर्छन् भन्नेमा रुचि राख्ने विद्यार्थी।')) ?></span></li>
          <li style="display:flex;gap:10px"><span style="color:var(--success);margin-top:2px"><svg class="ic"><use href="#i-check"/></svg></span><span><?= e(t('Students who enjoy working with numbers, records and ideas about trade and finance.','संख्या, रेकर्ड र व्यापार र वित्त सम्बन्धी विचारहरूसँग काम गर्न मन पराउने विद्यार्थी।')) ?></span></li>
          <li style="display:flex;gap:10px"><span style="color:var(--success);margin-top:2px"><svg class="ic"><use href="#i-check"/></svg></span><span><?= e(t('Students who may wish to pursue business or commerce-related further study.','व्यापार वा वाणिज्य सम्बन्धी थप अध्ययन गर्न चाहने विद्यार्थी।')) ?></span></li>
        </ul>
      </div>
      <div style="background:var(--primary-dark);color:#C7D7F0;border-radius:12px;padding:20px">
        <h3 style="color:#fff;font-size:1.05rem"><?= e(t('Possible further-study examples','सम्भावित थप अध्ययनका उदाहरणहरू')) ?></h3>
        <p style="color:#93B4D8;font-size:.84rem;margin-top:6px;line-height:1.6"><?= e(t('Listed only as general examples. Each institution sets its own requirements.','केवल सामान्य उदाहरणको रूपमा सूचीबद्ध। प्रत्येक संस्थाले आफ्नै आवश्यकताहरू तय गर्दछ।')) ?></p>
        <ul style="margin-top:12px;display:flex;flex-direction:column;gap:6px;color:#C7D7F0;font-size:.88rem;line-height:1.6;list-style:none">
          <li>• BBA — Bachelor of Business Administration</li>
          <li>• BBS — Bachelor of Business Studies</li>
          <li>• <?= e(t('Management, finance and accounting programmes','व्यवस्थापन, वित्त र लेखा कार्यक्रमहरू')) ?></li>
          <li>• <?= e(t('Economics and business economics','अर्थशास्त्र र व्यवसाय अर्थशास्त्र')) ?></li>
          <li>• <?= e(t('Entrepreneurship','उद्यमशीलता')) ?></li>
          <li>• <?= e(t('Hospitality and business-related studies','आतिथ्य र व्यवसाय सम्बन्धी अध्ययन')) ?></li>
        </ul>
        <div style="margin-top:16px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:12px;font-size:.82rem;color:#93B4D8;line-height:1.6"><?= e(t('Satisfying any one example\'s requirements does not guarantee admission. Confirm entry criteria with the admitting college or university.','कुनै एक उदाहरणको आवश्यकताहरू पूरा गर्नुले प्रवेश ग्यारेन्टी गर्दैन। प्रवेश दिने कलेज वा विश्वविद्यालयसँग प्रवेश मापदण्ड पुष्टि गर्नुहोस्।')) ?></div>
      </div>
    </div>

    <div style="background:var(--gold-50);border:1px dashed #E9C35E;border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;flex:none;margin-top:2px"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:#6B4F00;line-height:1.6"><strong><?= e(t('Not an official course catalogue.','आधिकारिक पाठ्यक्रम सूची होइन।')) ?></strong> <?= e(t('Exact +2 Management subject combinations, class capacity and fees are confirmed by the school and NEB each year. Check the latest admission notice or contact the school before applying.','सही +२ व्यवस्थापन विषय संयोजन, कक्षा क्षमता र शुल्क विद्यालय र एनईबीद्वारा प्रत्येक वर्ष पुष्टि गरिन्छ। आवेदन दिनु अघि नवीनतम भर्ना सूचना जाँच गर्नुहोस् वा विद्यालयमा सम्पर्क गर्नुहोस्।')) ?></div>
    </div>

    <div style="display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('academics.php')) ?>" class="btn btn-ghost">← <?= e(t('Back to Academics','शैक्षिकमा फर्कनुहोस्')) ?></a>
      <a href="<?= e_attr(base_url('science.php')) ?>" class="btn btn-soft"><?= e(t('Compare: +2 Science →','तुलना: +२ विज्ञान →')) ?></a>
      <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-primary"><?= e(t('Admission Inquiry →','भर्ना सोधपुछ →')) ?></a>
      <a href="<?= e_attr(base_url('scholarships.php')) ?>" class="btn btn-ghost"><?= e(t('Scholarships','छात्रवृत्ति')) ?></a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
