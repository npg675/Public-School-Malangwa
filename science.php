<?php $page='academics'; $title='+2 Science (NEB) — Shree Public Secondary School | Malangwa-2, Sarlahi'; $description='+2 Science stream at Shree Public Secondary School, Malangwa-2 — program overview, learning focus, who may consider it and general future study pathways under NEB.'; require_once __DIR__.'/includes/helpers.php'; require_once __DIR__.'/includes/header.php';
$blocks = get_blocks('science');
$sec = function(string $k) use ($blocks): array { return array_values(array_filter($blocks, fn($b)=>$b['section_key']===$k)); };
$first = function(string $k) use ($sec): ?array { return $sec($k)[0] ?? null; };
$intro = $first('intro');
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> <?= e(t('Academics • +2 Science • NEB','शैक्षिक • +२ विज्ञान • एनईबी')) ?></span><h1 style="color:#fff;margin:14px 0 10px">+2 Science<br><span style="color:var(--gold)">Grades 11–12 • NEB</span></h1><p class="lead" style="color:#C7D7F0;max-width:680px">Higher secondary science program at Shree Public — preparation for further study in science, technology and health sciences.</p><div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap"><span style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:999px;font-size:.8rem;color:#fff">NEB affiliated</span><span style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:999px;font-size:.8rem;color:#fff">IEMIS 190640003</span><span style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:999px;font-size:.8rem;color:#fff">Malangwa-2, Sarlahi</span></div></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>"><?= e(t('Home','गृह')) ?></a><span class="sep">/</span><a href="<?= e_attr(base_url('academics.php')) ?>"><?= e(t('Academics','शैक्षिक')) ?></a><span class="sep">/</span><span>+2 Science</span></div></nav>

<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="display:grid;gap:24px">
    <!-- Overview -->
    <div>
      <span class="eyebrow"><span class="dot"></span> <?= e(t('Program Overview','कार्यक्रम अवलोकन')) ?></span>
      <h2 style="margin:12px 0 12px;font-size:1.35rem"><?= e(t('What the Science stream is for','विज्ञान स्ट्रिम केका लागि हो')) ?></h2>
      <div style="color:var(--muted);line-height:1.75;display:flex;flex-direction:column;gap:12px;font-size:.94rem;max-width:760px">
        <?php if ($intro && trim(block_val($intro,'body'))!==''): ?><?= block_val($intro,'body') ?><?php else: ?>
        <p>The <strong style="color:var(--text)">+2 Science</strong> program at Shree Public Secondary School is a two-year higher secondary course (Grades 11 and 12) under the <strong>National Examinations Board (NEB)</strong>. It is one of two NEB streams currently offered at the school — the other being <strong>+2 Management</strong>.</p>
        <p>Students who have completed Grade 10 (SEE) from Shree Public or any other recognised institution may apply to Grade 11 in this stream, subject to eligibility criteria and available seats as confirmed each year by the school office. The programme is intended to prepare students for further study after Grade 12 in areas such as <strong style="color:var(--text)">science, technology, health sciences, engineering and natural sciences</strong>, depending on subject combination and results.</p>
        <p>Study extends over two academic years with internal assessments and board examinations as required by NEB. No career or placement outcome is promised or guaranteed — progression depends on academic performance and the admission requirements of the receiving university or institution.</p>
        <?php endif; ?>
      </div>
      <div class="verify-banner"><svg class="ic"><use href="#i-info"/></svg><span><?= e(t('NEB programs, registration and examination dates are managed nationally (see neb.gov.np). This page describes the stream in general terms; official subject combinations and timetables are confirmed by the school office.','एनईबी कार्यक्रम, दर्ता र परीक्षा मितिहरू राष्ट्रिय रूपमा व्यवस्थित हुन्छन् (neb.gov.np हेर्नुहोस्)। यो पृष्ठले स्ट्रिमलाई सामान्य रूपमा वर्णन गर्दछ; आधिकारिक विषय संयोजन र तालिकाहरू विद्यालय कार्यालयले पुष्टि गर्दछ।')) ?></span></div>
    </div>

    <!-- Learning Focus -->
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:22px">
      <h3 style="font-size:1.1rem"><?= e(t('Learning focus','सिकाइ केन्द्र')) ?></h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px"><?= e(t('General areas of study associated with the Science stream — not an official subject list. Exact combination is confirmed by the school and NEB registration.','विज्ञान स्ट्रिमसँग सम्बन्धित अध्ययनका सामान्य क्षेत्रहरू — आधिकारिक विषय सूची होइन। सही संयोजन विद्यालय र एनईबी दर्ताले पुष्टि गर्दछ।')) ?></p>
      <div style="display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));margin-top:16px">
        <?php foreach ($sec('highlight') as $h): ?>
        <div style="background:#fff;border:1px solid var(--border);border-radius:10px;padding:14px"><h4 style="font-size:.9rem;display:flex;gap:8px;align-items:center"><span style="width:32px;height:32px;border-radius:8px;background:var(--primary);color:#fff;display:grid;place-items:center;flex:none"><span class="material-symbols-outlined" style="font-size:18px"><?= e($h['icon'] ?? 'science') ?></span></span> <?= e(block_val($h,'title')) ?></h4><p style="color:var(--muted);font-size:.84rem;margin-top:6px;line-height:1.6"><?= e(block_val($h,'body')) ?></p></div>
        <?php endforeach; ?>
      </div>
      <p style="font-size:.78rem;color:var(--muted-2);margin-top:12px"><em><?= e(t('Do not treat this list as an official course list for Shree Public. Subjects and practical requirements are confirmed annually via notices and the academic office.','यो सूची श्री पब्लिकको आधिकारिक पाठ्यक्रम सूची होइन। विषय र व्यावहारिक आवश्यकताहरू वार्षिक रूपमा सूचनाहरू र शैक्षिक कार्यालय मार्फत पुष्टि गरिन्छ।')) ?></em></p>
    </div>

    <!-- Who may consider -->
    <div class="stream-who-grid">
      <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:20px">
        <h3 style="font-size:1.05rem"><?= e(t('Who may consider Science?','विज्ञान कसले विचार गर्न सक्छ?')) ?></h3>
        <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.7"><?= e(t('General guidance — not an entry rule. Suitability depends on interest, prior performance and advice from teachers and guardians.','सामान्य मार्गदर्शन — प्रवेश नियम होइन। उपयुक्तता रुचि, अघिल्लो प्रदर्शन र शिक्षक तथा अभिभावकको सल्लाहमा निर्भर गर्दछ।')) ?></p>
        <ul style="margin-top:12px;display:flex;flex-direction:column;gap:8px;color:var(--muted);font-size:.88rem;line-height:1.6;list-style:none">
          <li style="display:flex;gap:10px"><span style="color:var(--success);margin-top:2px"><svg class="ic"><use href="#i-check"/></svg></span><span><?= e(t('Students who enjoy mathematics and science and are curious about how things work — from natural phenomena to technical systems.','गणित र विज्ञान मन पराउने र प्राकृतिक घटना देखि प्राविधिक प्रणाली सम्म चीजहरू कसरी काम गर्छन् भन्ने जिज्ञासु विद्यार्थी।')) ?></span></li>
          <li style="display:flex;gap:10px"><span style="color:var(--success);margin-top:2px"><svg class="ic"><use href="#i-check"/></svg></span><span><?= e(t('Students who are comfortable with regular study, problem sets and careful preparation — the stream is academically demanding.','नियमित अध्ययन, समस्या सेट र सावधानीपूर्वक तयारीमा सहज विद्यार्थी — स्ट्रिम शैक्षिक रूपमा मागपूर्ण छ।')) ?></span></li>
          <li style="display:flex;gap:10px"><span style="color:var(--success);margin-top:2px"><svg class="ic"><use href="#i-check"/></svg></span><span><?= e(t('Students who may wish to pursue technical or scientific higher education after Grade 12 (see pathways below).','कक्षा १२ पछि प्राविधिक वा वैज्ञानिक उच्च शिक्षा हासिल गर्न चाहने विद्यार्थी।')) ?></span></li>
        </ul>
      </div>
      <div style="background:var(--primary-dark);color:#C7D7F0;border-radius:12px;padding:20px">
        <h3 style="color:#fff;font-size:1.05rem"><?= e(t('Future study pathways','भविष्य अध्ययन मार्गहरू')) ?></h3>
        <p style="color:#93B4D8;font-size:.84rem;margin-top:6px;line-height:1.6"><?= e(t('Examples of areas students of a Science background sometimes pursue — listed only as general examples. Admission requirements vary by institution.','विज्ञान पृष्ठभूमिका विद्यार्थीहरूले कहिलेकाहीँ पछ्याउने क्षेत्रका उदाहरणहरू — केवल सामान्य उदाहरणको रूपमा सूचीबद्ध। प्रवेश आवश्यकताहरू संस्थाअनुसार फरक हुन्छन्।')) ?></p>
        <ul style="margin-top:12px;display:flex;flex-direction:column;gap:6px;color:#C7D7F0;font-size:.88rem;line-height:1.6;list-style:none">
          <li>• <?= e(t('Engineering and technology','इन्जिनियरिङ र प्रविधि')) ?></li>
          <li>• <?= e(t('Medicine and health sciences','चिकित्सा र स्वास्थ्य विज्ञान')) ?></li>
          <li>• <?= e(t('Computer science and information technology','कम्प्युटर विज्ञान र सूचना प्रविधि')) ?></li>
          <li>• <?= e(t('Natural sciences (physics, chemistry, biology)','प्राकृतिक विज्ञान (भौतिक, रसायन, जीव)')) ?></li>
          <li>• <?= e(t('Agriculture and forestry sciences','कृषि र वन विज्ञान')) ?></li>
          <li>• <?= e(t('Other technical and bachelor-level studies','अन्य प्राविधिक र स्नातक तह अध्ययन')) ?></li>
        </ul>
        <div style="margin-top:16px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:12px;font-size:.82rem;color:#93B4D8;line-height:1.6"><?= e(t('Each university or college sets its own entry requirements (subjects, grades, entrance test). Satisfying any one programme\'s prior example does not guarantee admission. Confirm with the admitting institution.','प्रत्येक विश्वविद्यालय वा कलेजले आफ्नै प्रवेश आवश्यकताहरू (विषय, ग्रेड, प्रवेश परीक्षा) तय गर्दछ। कुनै एक कार्यक्रमको पूर्व उदाहरण पूरा गर्नुले प्रवेश ग्यारेन्टी गर्दैन। प्रवेश दिने संस्थासँग पुष्टि गर्नुहोस्।')) ?></div>
      </div>
    </div>

    <!-- Practical note -->
    <div style="background:var(--gold-50);border:1px dashed #E9C35E;border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;flex:none;margin-top:2px"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:#6B4F00;line-height:1.6"><strong><?= e(t('Not an official course catalogue.','आधिकारिक पाठ्यक्रम सूची होइन।')) ?></strong> <?= e(t('Shree Public\'s exact +2 Science subject combinations, lab access, class capacity and fees are confirmed by the school and NEB each year. Check the latest admission notice or contact the school before applying.','श्री पब्लिकको सही +२ विज्ञान विषय संयोजन, प्रयोगशाला पहुँच, कक्षा क्षमता र शुल्क विद्यालय र एनईबीद्वारा प्रत्येक वर्ष पुष्टि गरिन्छ। आवेदन दिनु अघि नवीनतम भर्ना सूचना जाँच गर्नुहोस् वा विद्यालयमा सम्पर्क गर्नुहोस्।')) ?></div>
    </div>

    <!-- Related -->
    <div style="display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('academics.php')) ?>" class="btn btn-ghost">← <?= e(t('Back to Academics','शैक्षिकमा फर्कनुहोस्')) ?></a>
      <a href="<?= e_attr(base_url('management.php')) ?>" class="btn btn-soft"><?= e(t('Compare: +2 Management →','तुलना: +२ व्यवस्थापन →')) ?></a>
      <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-primary"><?= e(t('Admission Inquiry →','भर्ना सोधपुछ →')) ?></a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
