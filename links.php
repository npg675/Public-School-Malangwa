<?php $page='links'; $title='Useful Links — Government & Education Portals | Shree Public Secondary School'; $description='Government and education links — Ministry of Education, CEHRD, NEB, CDC, SEE, Malangwa Municipality and Madhesh Province.'; require_once __DIR__.'/includes/helpers.php'; require_once __DIR__.'/includes/header.php';
$blocks = get_blocks('links');
$sec = function(string $k) use ($blocks): array { return array_values(array_filter($blocks, fn($b)=>$b['section_key']===$k)); };
$links = $sec('link');
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> <?= e(t('Useful Links','उपयोगी लिङ्कहरू')) ?></span><h1 style="color:#fff;margin:14px 0 10px"><?= e(t('Government & Educational Links','सरकारी तथा शैक्षिक लिङ्कहरू')) ?></h1><p class="lead" style="color:#C7D7F0;max-width:680px">Direct links to MOEST, CEHRD, NEB, Curriculum Development Centre, SEE and Malangwa Municipality — all external, open in a new tab, clearly marked.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>"><?= e(t('Home','गृह')) ?></a><span class="sep">/</span><span><?= e(t('Useful Links','उपयोगी लिङ्कहरू')) ?></span></div></nav>
<section class="section" style="padding-top:28px">
  <div class="wrap">
    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:18px">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)"><?= e(t('External portals:','बाह्य पोर्टलहरू:')) ?></strong> <?= e(t('All links below open in a new tab. They are independent government or board websites — not part of this school site.','तलका सबै लिङ्कहरू नयाँ ट्याबमा खुल्छन्। तिनीहरू स्वतन्त्र सरकारी वा बोर्ड वेबसाइटहरू हुन् — यस विद्यालय साइटको भाग होइनन्।')) ?></div>
    </div>
    <div class="gov-grid">
      <?php if (empty($links)): ?><div class="empty">No links published yet.</div>
      <?php else: foreach ($links as $lnk): ?>
      <a class="gov-link" href="<?= e_attr($lnk['link_url'] ?? '#') ?>" target="_blank" rel="noopener"><span style="flex:1"><?= e(block_val($lnk,'title')) ?><br><span style="font-weight:400;font-size:.78rem;color:var(--muted)"><?= e(block_val($lnk,'body')) ?></span></span><span class="ext">external ↗</span></a>
      <?php endforeach; endif; ?>
    </div>
    <div style="margin-top:18px;background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:16px">
      <h3 style="font-size:1rem"><?= e(t('Related on this site','यस साइटमा सम्बन्धित')) ?></h3>
      <p style="color:var(--muted);font-size:.88rem;margin-top:6px;line-height:1.6"><?= e(t('School-curated information lives on','विद्यालयद्वारा संकलित जानकारी')) ?> <a href="<?= e_attr(base_url('academics.php')) ?>" style="color:var(--primary);font-weight:700"><?= e(t('Academics','शैक्षिक')) ?></a>, <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700"><?= e(t('Notice Board','सूचना पाटी')) ?></a> <?= e(t('and','र')) ?> <a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700"><?= e(t('Downloads','डाउनलोड')) ?></a>.</p>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
