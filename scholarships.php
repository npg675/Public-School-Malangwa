<?php $page='scholarships'; $title='Scholarships — Verified Notices | Shree Public Secondary School'; $description='Scholarship notices for Shree Public Secondary School, Malangwa-2 — eligibility, quota, application documents and deadlines from verified school and government notices.'; require_once __DIR__.'/includes/header.php'; $scholarshipNotices = array_filter(get_notices(8), function($n){ $c=strtolower($n['category']??$n['cat_en']??''); return $c==='scholarship'; }); ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> Scholarships</span><h1 style="color:#fff;margin:14px 0 10px"><?= e(t('Scholarships','छात्रवृत्ति')) ?></h1><p class="lead" style="color:#C7D7F0;max-width:680px"><?= e(t('Verified scholarship notices — eligibility, quota, required documents and deadline — published only from the school office. No list is invented. This page pulls live notices from the Notice Board (category: Scholarship).','प्रमाणित छात्रवृत्ति सूचनाहरू — योग्यता, कोटा, आवश्यक कागजात र अन्तिम मिति — केवल विद्यालय कार्यालयबाट प्रकाशित। कुनै सूची आविष्कार गरिएको छैन। यो पृष्ठले सूचना पाटी (छात्रवृत्ति श्रेणी) बाट प्रत्यक्ष सूचनाहरू तान्दछ।')) ?></p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>Scholarships</span></div></nav>
<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:18px">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)">How scholarships appear here:</strong> When the school or the Government of Nepal issues a scholarship notice applicable to this school, it is published on the <a href="<?= e_attr(base_url('notices.php?category=scholarship')) ?>" style="color:var(--primary);font-weight:700">Notice Board → Scholarship</a> with eligibility, quota and deadline, and surfaced here automatically. Scholarship forms (if any) appear in <a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700">Downloads → Scholarships</a>.</div>
    </div>

    <?php if(empty($scholarshipNotices)): ?>
      <div class="empty"><svg class="ic"><use href="#i-award"/></svg><h4>No scholarship notice at the moment</h4><p>When a scholarship is announced it will appear here with full details. Check the Notice Board (Scholarship) or contact the school office for the current year.</p><div style="margin-top:12px;display:flex;gap:8px;justify-content:center;flex-wrap:wrap"><a href="<?= e_attr(base_url('notices.php?category=scholarship')) ?>" class="btn btn-soft">View Scholarship Notices</a><a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-ghost">Contact office</a></div></div>
    <?php else: ?>
      <div style="display:flex;flex-direction:column;gap:12px">
        <?php foreach($scholarshipNotices as $n): $d=strtotime($n['published_at']); $ttl=(current_lang()==='np'&&!empty($n['title_np']))?$n['title_np']:$n['title_en']; ?>
        <article class="notice-card <?= !empty($n['is_urgent'])?'urgent':'' ?>">
          <div class="notice-date"><span class="d"><?= date('d',$d) ?></span><span class="m"><?= date('M Y',$d) ?></span></div>
          <div class="notice-body">
            <h4><a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>"><?= e($ttl) ?></a></h4>
            <?php if(!empty($n['summary_en'])): ?><p><?= e($n['summary_en']) ?></p><?php endif; ?>
            <div class="notice-meta">
              <span class="tag <?= !empty($n['is_urgent'])?'urgent':'' ?>">Scholarship</span>
              <?php if(!empty($n['is_sample'])): ?><span class="tag" style="background:var(--gold-50);border-color:#FDE68A;color:#6B4F00">Sample</span><?php endif; ?>
              <?php if(!empty($n['reference_number'])): ?><span>Ref: <?= e($n['reference_number']) ?></span><?php endif; ?>
              <a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>" style="margin-left:auto;font-weight:700;color:var(--primary)">View notice →</a>
              <?php if(!empty($n['attachment_type'])): ?><a href="<?= e_attr(base_url('notice.php?slug='.$n['slug'])) ?>" class="btn btn-soft" style="padding:6px 10px;font-size:.78rem"><svg class="ic"><use href="#i-doc"/></svg> PDF</a><?php endif; ?>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div style="margin-top:18px;display:grid;gap:12px;grid-template-columns:1fr 1fr">
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px"><h4 style="font-size:.92rem"><?= e(t('Quota & eligibility','कोटा र योग्यता')) ?></h4><p style="color:var(--muted);font-size:.88rem;margin-top:4px;line-height:1.6"><?= e(t('Quota, eligibility criteria and reservation details are specified in each notice — not summarised as a generic list. Refer to the attached PDF in the notice for authoritative details.','कोटा, योग्यता मापदण्ड र आरक्षण विवरण प्रत्येक सूचनामा तोकिन्छ — सामान्य सूचीको रूपमा सारांश गरिएको छैन। आधिकारिक विवरणका लागि सूचनामा संलग्न PDF हेर्नुहोस्।')) ?></p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px"><h4 style="font-size:.92rem"><?= e(t('How to apply','कसरी आवेदन दिने')) ?></h4><p style="color:var(--muted);font-size:.88rem;margin-top:4px;line-height:1.6"><?= e(t('See the attached notice for required documents, application form and deadline. If a downloadable form exists, it is linked from Downloads → Scholarships. Contact the office for guidance before the deadline.','आवश्यक कागजात, आवेदन फारम र अन्तिम मितिका लागि संलग्न सूचना हेर्नुहोस्। यदि डाउनलोड योग्य फारम छ भने, यो Downloads → Scholarships बाट लिङ्क गरिएको छ। अन्तिम मिति अघि मार्गदर्शनका लागि कार्यालयमा सम्पर्क गर्नुहोस्।')) ?></p></div>
    </div>

    <div class="verify-banner"><svg class="ic"><use href="#i-info"/></svg><span>Managed via CMS — Admin → Resources → Scholarships and Notice Board (category: Scholarship). Attach the official PDF with quota and criteria; do not add unverified scholarship lists.</span></div>

    <div style="margin-top:16px;display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('notices.php?category=scholarship')) ?>" class="btn btn-primary">Scholarship Notices →</a>
      <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-soft">Downloads</a>
      <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-ghost">Admissions</a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
