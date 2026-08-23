<?php require_once __DIR__.'/includes/header.php';
$slug = $_GET['slug'] ?? '';
$all = get_notices(50);
$notice = null; foreach($all as $n) if($n['slug']===$slug) { $notice=$n; break; }
if(!$notice){ http_response_code(404); $page='404'; $title='Notice not found'; require_once __DIR__.'/404.php'; exit; }
$page='notices'; $title = $notice['title_en'].' — Notice'; $titleTxt=(current_lang()==='np'&&!empty($notice['title_np']))?$notice['title_np']:$notice['title_en'];
$desc = $notice['summary_en'] ?? '';
require_once __DIR__.'/includes/header.php';
?>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><a href="<?= e_attr(base_url('notices.php')) ?>">Notices</a><span class="sep">/</span><span><?= e($titleTxt) ?></span></div></nav>
<article class="section" style="padding-top:20px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="max-width:800px">
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px">
      <span class="tag <?= !empty($notice['is_urgent'])?'urgent':'' ?>"><?= e($notice['cat_en'] ?? $notice['category'] ?? 'General') ?></span>
      <?php if(!empty($notice['is_pinned'])): ?><span class="tag pinned">Pinned</span><?php endif; ?>
      <?php if(!empty($notice['reference_number'])): ?><span style="font-size:.82rem;color:var(--muted)">Ref: <?= e($notice['reference_number']) ?></span><?php endif; ?>
      <span style="font-size:.82rem;color:var(--muted)">Published: <?= e(date('F j, Y', strtotime($notice['published_at']))) ?></span>
    </div>
    <h1 style="font-size:clamp(1.4rem,3vw,2rem)"><?= e($titleTxt) ?></h1>
    <?php if(!empty($notice['title_np']) && current_lang()==='en'): ?><p style="font-family:var(--font-np);color:var(--muted);margin-top:8px"><?= e($notice['title_np']) ?></p><?php endif; ?>
    <div style="margin-top:18px;color:var(--muted);font-size:1rem;line-height:1.7">
      <p><?= nl2br(e($notice['summary_en'] ?? 'Detailed notice body — admin can add formatted HTML, PDF and image attachments. This is sample content.')) ?></p>
      <?php if(!empty($notice['description_en'])): ?><div style="margin-top:12px"><?= $notice['description_en'] ?></div><?php endif; ?>
    </div>
    <?php if(!empty($notice['attachment_type'])): ?>
    <div style="margin-top:18px;display:flex;gap:10px;flex-wrap:wrap">
      <a href="#" class="btn btn-primary"><svg class="ic"><use href="#i-doc"/></svg> View PDF</a>
      <a href="#" class="btn btn-ghost"><svg class="ic"><use href="#i-download"/></svg> Download PDF</a>
      <button onclick="window.print()" class="btn btn-soft">Print</button>
    </div>
    <?php endif; ?>
    <div style="margin-top:28px;padding-top:18px;border-top:1px solid var(--border)">
      <h3 style="font-size:1rem">Related Notices</h3>
      <div style="display:flex;flex-direction:column;gap:8px;margin-top:12px">
        <?php foreach(array_slice($all,0,3) as $rn): if($rn['slug']===$slug) continue; ?>
        <a href="<?= e_attr(base_url('notice.php?slug='.$rn['slug'])) ?>" style="display:flex;justify-content:space-between;gap:12px;background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:12px"><span><?= e($rn['title_en']) ?></span><span style="color:var(--primary);font-weight:700">→</span></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</article>
<?php require_once __DIR__.'/includes/footer.php'; ?>
