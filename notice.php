<?php
require_once __DIR__.'/includes/helpers.php';
$slug = $_GET['slug'] ?? '';
$all = get_notices(50);
$notice = null; foreach($all as $n) if($n['slug']===$slug) { $notice=$n; break; }
if(!$notice){ http_response_code(404); $page='404'; $title='Notice not found'; require_once __DIR__.'/404.php'; exit; }
$page='notices';
$titleTxt=(current_lang()==='np'&&!empty($notice['title_np']))?$notice['title_np']:$notice['title_en'];
$title = $titleTxt.' — Notice';
$desc = $notice['summary_en'] ?? '';
$catLabel = $notice['cat_en'] ?? $notice['category'] ?? 'General';
$catSlug = $notice['cat_slug'] ?? null;
require_once __DIR__.'/includes/header.php';
// related: same category first, then latest others
$related = []; foreach($all as $rn){ if($rn['slug']!==$slug && ($rn['cat_slug']??null)===($notice['cat_slug']??null) && ($rn['cat_slug']??null)!==null) $related[]=$rn; }
foreach($all as $rn){ if($rn['slug']!==$slug && !in_array($rn,$related,true)) $related[]=$rn; }
$related = array_slice($related,0,4);
?>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><a href="<?= e_attr(base_url('notices.php')) ?>">Notices</a><?php if($catSlug): ?><span class="sep">/</span><a href="<?= e_attr(base_url('notices.php?category='.e_attr($catSlug))) ?>"><?= e($catLabel) ?></a><?php endif; ?><span class="sep">/</span><span><?= e(mb_strimwidth($titleTxt,0,60,'…')) ?></span></div></nav>
<article class="section" style="padding-top:20px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="max-width:800px">
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;align-items:center">
      <?php if($catSlug): ?><a class="tag <?= !empty($notice['is_urgent'])?'urgent':'' ?>" href="<?= e_attr(base_url('notices.php?category='.e_attr($catSlug))) ?>"><?= e($catLabel) ?></a>
  <?php else: ?><span class="tag <?= !empty($notice['is_urgent'])?'urgent':'' ?>"><?= e($catLabel) ?></span><?php endif; ?>
      <?php if(!empty($notice['is_pinned'])): ?><span class="tag pinned">Pinned</span><?php endif; ?>
      <?php if(!empty($notice['is_sample'])): ?><span class="tag" style="background:var(--gold-50);border-color:#FDE68A;color:#6B4F00">Sample</span><?php endif; ?>
      <?php if(!empty($notice['reference_number'])): ?><span style="font-size:.82rem;color:var(--muted)">Ref: <?= e($notice['reference_number']) ?></span><?php endif; ?>
      <span style="font-size:.82rem;color:var(--muted)">Published: <?= e(date('F j, Y', strtotime($notice['published_at']))) ?></span>
      <span style="margin-left:auto"><button onclick="window.print()" class="btn btn-soft" style="padding:8px 14px;font-size:.8rem"><svg class="ic"><use href="#i-doc"/></svg> Print</button></span>
    </div>
    <h1 style="font-size:clamp(1.4rem,3vw,2rem)"><?= e($titleTxt) ?></h1>
    <?php if(!empty($notice['title_np']) && current_lang()==='en'): ?><p style="font-family:var(--font-np);color:var(--muted);margin-top:8px"><?= e($notice['title_np']) ?></p><?php endif; ?>
    <div style="margin-top:18px;color:var(--muted);font-size:1rem;line-height:1.75">
      <?php $noticeBody = current_lang()==='np' && !empty($notice['description_np']) ? $notice['description_np'] : ($notice['description_en'] ?? ''); ?>
      <?php if($noticeBody !== ''): ?><div><?= $noticeBody ?></div><?php endif; ?>
      <?php if($noticeBody === ''): ?><p><em><?= t('The full text of this notice is available from the school office.','यस सूचनाको पूर्ण पाठ विद्यालय कार्यालयबाट उपलब्ध हुनेछ।') ?></em></p><?php endif; ?>
    </div>
    <?php if(!empty($notice['attachment_type'])): ?>
    <div style="margin-top:18px;padding:14px;border:1px solid var(--border);border-radius:12px;background:var(--surface-low);display:flex;gap:12px;align-items:center;flex-wrap:wrap">
       <span class="dl-icon" style="width:38px;height:38px"><svg class="ic"><use href="#i-doc"/></svg></span>
       <div style="flex:1;min-width:200px"><strong style="font-size:.9rem">Official attachment — <?= strtoupper(e($notice['attachment_type'])) ?></strong><div style="font-size:.82rem;color:var(--muted);margin-top:2px"><?= t('Download the official file supplied with this notice.','यस सूचनासँग सम्बन्धित आधिकारिक फाइल डाउनलोड गर्नुहोस्।') ?></div></div>
       <?php if (!empty($notice['attachment'])): ?><a href="<?= e_attr(media_url($notice['attachment'])) ?>" class="btn btn-primary" target="_blank" rel="noopener">Download</a><?php else: ?><button onclick="window.print()" class="btn btn-ghost" style="padding:8px 14px;font-size:.8rem">Print this page</button><?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Contact CTA -->
    <div style="margin-top:22px;padding:16px;border-radius:12px;background:var(--primary-dark);color:#C7D7F0;display:flex;gap:12px;align-items:flex-start;flex-wrap:wrap">
      <svg class="ic" style="color:var(--gold);width:22px;height:22px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;line-height:1.6;flex:1;min-width:220px"><strong style="color:#fff">Questions about this notice?</strong> Contact the school office at Malangwa-2 (VH24+22W) or send a message online.</div>
      <a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-gold" style="padding:10px 18px;font-size:.84rem">Contact School →</a>
    </div>

    <div style="margin-top:28px;padding-top:18px;border-top:1px solid var(--border)">
      <h3 style="font-size:1rem">Related notices</h3>
      <div style="display:flex;flex-direction:column;gap:8px;margin-top:12px">
        <?php foreach($related as $rn): $rd=strtotime($rn['published_at']); $rttl=(current_lang()==='np'&&!empty($rn['title_np']))?$rn['title_np']:$rn['title_en']; ?>
        <a href="<?= e_attr(base_url('notice.php?slug='.$rn['slug'])) ?>" style="display:flex;justify-content:space-between;gap:12px;background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:12px;align-items:center"><span><strong><?= e($rttl) ?></strong><br><span style="font-size:.76rem;color:var(--muted-2)"><?= e($rn['cat_en'] ?? $rn['category'] ?? 'General') ?> • <?= e(date('M j, Y',$rd)) ?></span></span><span style="color:var(--primary);font-weight:700">→</span></a>
        <?php endforeach; ?>
      </div>
      <div style="margin-top:14px;display:flex;gap:8px;flex-wrap:wrap">
        <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-primary">All Notices</a>
        <?php if($catSlug): ?><a href="<?= e_attr(base_url('notices.php?category='.e_attr($catSlug))) ?>" class="btn btn-soft">More in <?= e($catLabel) ?> →</a><?php endif; ?>
        <a href="<?= e_attr(base_url('downloads.php')) ?>" class="btn btn-ghost">Downloads</a>
      </div>
    </div>
  </div>
</article>
<?php require_once __DIR__.'/includes/footer.php'; ?>
