<?php $page='publications'; $title='Publications — Annual Reports & Documents | Shree Public Secondary School'; $description='Publications from Shree Public Secondary School, Malangwa-2 — annual reports, prospectus, school improvement plans and transparency documents.'; require_once __DIR__.'/includes/helpers.php'; require_once __DIR__.'/includes/header.php';
$blocks = get_blocks('publications');
$pubPage = get_page_content('publications');
$sec = function(string $k) use ($blocks): array { return array_values(array_filter($blocks, fn($b)=>$b['section_key']===$k)); };
$intro = $sec('intro')[0] ?? null;
$pubs = get_downloads(12, 'publications');
?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> <?= e(t('Publications','प्रकाशनहरू')) ?></span><h1 style="color:#fff;margin:14px 0 10px"><?= e(t('Publications','प्रकाशनहरू')) ?></h1><p class="lead" style="color:#C7D7F0;max-width:680px">Annual reports, school improvement plans, prospectus and other transparency documents — published here when available from the school administration.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>"><?= e(t('Home','गृह')) ?></a><span class="sep">/</span><span><?= e(t('Publications','प्रकाशनहरू')) ?></span></div></nav>
<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap">
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:18px">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;color:var(--muted);line-height:1.7">
        <?php if ($pubPage && trim(page_val($pubPage, 'content')) !== ''): ?>
          <?= page_val($pubPage, 'content') ?>
        <?php else: ?>
          <strong style="color:var(--text)"><?= e(t('What is published:','के प्रकाशित हुन्छ:')) ?></strong> <?= e($intro ? block_val($intro,'body') : t('School annual reports, financial summaries (as approved for disclosure), School Improvement Plan (SIP) summaries, prospectus and similar institutional publications. Documents are shown with title, category, publish date and file type. No placeholder documents are linked.','विद्यालय वार्षिक प्रतिवेदन, वित्तीय सारांश (प्रकाशनका लागि स्वीकृत), विद्यालय सुधार योजना (SIP) सारांश, prospectus र यस्तै संस्थागत प्रकाशनहरू। कागजातहरू शीर्षक, श्रेणी, प्रकाशन मिति र फाइल प्रकार सहित देखाइन्छ।')) ?>
        <?php endif; ?>
      </div>
    </div>

    <div style="display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));margin-bottom:18px">
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem"><?= e(t('Annual Reports','वार्षिक प्रतिवेदनहरू')) ?></h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6"><?= e(t('Yearly activity and accountability summaries.','वार्षिक गतिविधि र जवाफदेहिता सारांश।')) ?></p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem"><?= e(t('School Improvement Plan','विद्यालय सुधार योजना')) ?></h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6"><?= e(t('Improvement priorities and actions.','सुधार प्राथमिकता र कार्यहरू।')) ?></p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem"><?= e(t('Prospectus / Information Booklet','विवरण पुस्तिका / जानकारी पुस्तिका')) ?></h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6"><?= e(t('Overview for parents and students.','अभिभावक र विद्यार्थीका लागि अवलोकन।')) ?></p></div>
      <div style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:14px"><h4 style="font-size:.88rem"><?= e(t('Financial / Transparency','वित्तीय / पारदर्शिता')) ?></h4><p style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.6"><?= e(t('Published summaries as approved for disclosure.','प्रकाशनका लागि स्वीकृत सारांशहरू।')) ?></p></div>
    </div>

    <?php if (empty($pubs)): ?>
    <div class="empty"><svg class="ic"><use href="#i-book"/></svg><h4><?= e(t('No publications yet','अहिलेसम्म कुनै प्रकाशन छैन')) ?></h4><p><?= e(t('When publications are available they will appear here as cards with PDF preview and download links, and also in Downloads → Publications. Managed via Admin → Resources → Publications.','जब प्रकाशनहरू उपलब्ध हुन्छन् तिनीहरू यहाँ PDF पूर्वावलोकन र डाउनलोड लिङ्क सहित कार्डको रूपमा देखा पर्नेछन्।')) ?></p>
      <div style="margin-top:12px;display:flex;gap:8px;justify-content:center;flex-wrap:wrap"><a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-soft"><?= e(t('Browse Downloads','डाउनलोडहरू हेर्नुहोस्')) ?></a><a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-ghost"><?= e(t('Contact office','कार्यालयमा सम्पर्क गर्नुहोस्')) ?></a></div>
    </div>
    <?php else: ?>
    <div style="display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(280px,1fr))">
      <?php foreach ($pubs as $d): ?>
      <a href="<?= e_attr(base_url($d['file_path'])) ?>" class="bg-surface-lowest p-5 rounded-xl border border-border-base flex items-start gap-4 hover:border-primary-container transition-colors" download>
        <span class="material-symbols-outlined text-secondary text-[32px]">picture_as_pdf</span>
        <div>
          <h4 class="font-label-lg text-label-lg text-text-heading"><?= e(current_lang()==='np' && !empty($d['title_np']) ? $d['title_np'] : $d['title_en']) ?></h4>
          <p class="font-body-sm text-body-sm text-on-surface-variant mt-1"><?= e($d['file_type'] ?? 'PDF') ?> • <?= e(date('Y-m-d', strtotime($d['published_at'] ?? 'now'))) ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div style="margin-top:16px;display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-soft"><?= e(t('Downloads Centre →','डाउनलोड केन्द्र →')) ?></a>
      <a href="<?= e_attr(base_url('citizen-charter.php')) ?>" class="btn btn-ghost"><?= e(t('Citizen Charter','नागरिक वडापत्र')) ?></a>
      <a href="<?= e_attr(base_url('about.php')) ?>" class="btn btn-ghost"><?= e(t('About School','विद्यालयबारे')) ?></a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
