<?php $page='faq'; $title='FAQ — Frequently Asked Questions | Shree Public Secondary School'; $description='Frequently asked questions about Shree Public Secondary School, Malangwa-2 — location, levels, +2 programs, notices, downloads, admission, results and directions.'; require_once __DIR__.'/includes/helpers.php'; require_once __DIR__.'/includes/header.php';
$blocks = get_blocks('faq');
$sec = function(string $k) use ($blocks): array { return array_values(array_filter($blocks, fn($b)=>$b['section_key']===$k)); };
$faqs = $sec('faq_item');
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> FAQ</span><h1 style="color:#fff;margin:14px 0 10px"><?= e(t('Frequently Asked Questions','बारम्बार सोधिने प्रश्नहरू')) ?></h1><p class="lead" style="color:#C7D7F0;max-width:680px">Safe, verifiable answers — drawn only from information confirmed for Shree Public Secondary School. Policies are not invented; official notices and the school office take precedence.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>"><?= e(t('Home','गृह')) ?></a><span class="sep">/</span><span>FAQ</span></div></nav>
<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="max-width:760px;display:grid;gap:14px">
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <p style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)"><?= e(t('Note:','नोट:')) ?></strong> <?= e(t('Answers below use only verified school identity (name, location, IEMIS, levels, +2 streams). For dates, fees, procedures and personal matters, the Notice Board and school office are authoritative. No policy is invented to fill space.','तलका उत्तरहरूले केवल प्रमाणित विद्यालय पहिचान (नाम, स्थान, IEMIS, तह, +२ स्ट्रिम) प्रयोग गर्दछन्। मिति, शुल्क, प्रक्रिया र व्यक्तिगत मामिलाका लागि सूचना पाटी र विद्यालय कार्यालय आधिकारिक छन्।')) ?> <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700"><?= e(t('Notice Board','सूचना पाटी')) ?></a> <?= e(t('and','र')) ?> <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--primary);font-weight:700"><?= e(t('school office','विद्यालय कार्यालय')) ?></a> <?= e(t('are authoritative.','आधिकारिक हुन्।')) ?></p>
    </div>

    <?php if (empty($faqs)): ?>
      <div class="empty"><svg class="ic"><use href="#i-info"/></svg><h4><?= e(t('No FAQs published yet','अहिलेसम्म कुनै जिज्ञासा प्रकाशित छैन')) ?></h4><p><?= e(t('FAQs will be published soon.','जिज्ञासाहरू छिट्टै प्रकाशित हुनेछन्।')) ?></p></div>
    <?php else: foreach ($faqs as $i=>$f): ?>
    <details style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px" <?= $i===0?'open':'' ?>>
      <summary style="font-weight:700;cursor:pointer;font-size:1rem"><?= e(block_val($f,'title')) ?></summary>
      <div style="color:var(--muted);font-size:.92rem;margin-top:10px;line-height:1.7"><?= block_val($f,'body') ?></div>
    </details>
    <?php endforeach; endif; ?>

    <div style="background:var(--primary-dark);color:#C7D7F0;border-radius:12px;padding:18px;display:flex;gap:12px;align-items:flex-start">
      <svg class="ic" style="color:var(--gold);width:22px;height:22px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;line-height:1.6"><strong style="color:#fff"><?= e(t('Still have a question?','अझै प्रश्न छ?')) ?></strong> <?= e(t('Visit','भ्रमण गर्नुहोस्')) ?> <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--gold);text-decoration:underline"><?= e(t('Contact','सम्पर्क')) ?></a> <?= e(t('or the','वा')) ?> <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--gold);text-decoration:underline"><?= e(t('Notice Board','सूचना पाटी')) ?></a>. <?= e(t('For general school structure, start with','सामान्य विद्यालय संरचनाका लागि,')) ?> <a href="<?= e_attr(base_url('academics.php')) ?>" style="color:var(--gold);text-decoration:underline"><?= e(t('Academics','शैक्षिक')) ?></a> <?= e(t('and','र')) ?> <a href="<?= e_attr(base_url('admissions.php')) ?>" style="color:var(--gold);text-decoration:underline"><?= e(t('Admissions','भर्ना')) ?></a>.</div>
    </div>

    <div style="display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-primary"><?= e(t('Contact School →','विद्यालयमा सम्पर्क →')) ?></a>
      <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-soft"><?= e(t('Admissions','भर्ना')) ?></a>
      <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-ghost"><?= e(t('Notice Board','सूचना पाटी')) ?></a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
