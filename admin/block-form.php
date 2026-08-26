<?php
$adminPage = 'blocks'; $adminTitle = 'Content Block Form';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db();
const BLOCK_SECTIONS = [
  'home' => ['hero','stat','intro','commitment','cta_banner'],
  'about' => ['page_header','intro','value','timeline','facility','cta_join'],
  'academics' => ['intro'],
  'admissions' => ['intro','step'],
  'faq' => ['faq_item','note'],
  'links' => ['link'],
  'publications' => ['intro'],
  'management' => ['intro','highlight'],
  'science' => ['intro','highlight'],
];
$editing = isset($_GET['id']) && is_numeric($_GET['id']);
$row = null;
if ($editing) {
    $stmt = $pdo->prepare('SELECT * FROM content_blocks WHERE id = ?');
    $stmt->execute([(int)$_GET['id']]);
    $row = $stmt->fetch();
    if (!$row) { header('Location: '.base_url('admin/blocks.php')); exit; }
}
$flash = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $page_slug = trim($_POST['page_slug'] ?? '');
    $section_key = trim($_POST['section_key'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $title_en = trim($_POST['title_en'] ?? '');
    $title_np = trim($_POST['title_np'] ?? '');
    $subtitle_en = trim($_POST['subtitle_en'] ?? '');
    $subtitle_np = trim($_POST['subtitle_np'] ?? '');
    $body_en = trim($_POST['body_en'] ?? '');
    $body_np = trim($_POST['body_np'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    $link_url = trim($_POST['link_url'] ?? '');
    $is_active = (int)($_POST['is_active'] ?? 1);
    if ($title_en === '' && $title_np === '') {
        $flash = ['err','Title (English or Nepali) is required.'];
    } elseif ($page_slug === '' || $section_key === '') {
        $flash = ['err','Page and Section are required.'];
    } else {
        $d = [
            'page_slug' => $page_slug,
            'section_key' => $section_key,
            'sort_order' => $sort_order,
            'title_en' => $title_en ?: null,
            'title_np' => $title_np ?: null,
            'subtitle_en' => $subtitle_en ?: null,
            'subtitle_np' => $subtitle_np ?: null,
            'body_en' => $body_en ?: null,
            'body_np' => $body_np ?: null,
            'image_url' => $image_url ?: null,
            'icon' => $icon ?: null,
            'link_url' => $link_url ?: null,
            'is_active' => $is_active,
            'updated_by' => $_SESSION['user_id'] ?? null,
        ];
        try {
            if ($editing) {
                $id = (int)$_GET['id'];
                $set = []; $params = [];
                foreach ($d as $k=>$v) { $set[] = "`$k`=:$k"; $params[":$k"]=$v; }
                $params[':id']=$id;
                $pdo->prepare('UPDATE content_blocks SET '.implode(', ',$set).' WHERE id=:id')->execute($params);
                $logId = (string)$id;
                $flash = ['ok','Block updated.'];
            } else {
                $cols = implode('`, `', array_keys($d));
                $vals = ':'.implode(', :', array_keys($d));
                $pdo->prepare("INSERT INTO content_blocks (`$cols`) VALUES ($vals)")->execute($d);
                $logId = (string)$pdo->lastInsertId();
                $flash = ['ok','Block created.'];
            }
            try { $pdo->prepare('INSERT INTO activity_logs (user_id,action,entity_type,entity_id,detail) VALUES (?,?,?,?,?)')->execute([$_SESSION['user_id']??null, $editing?'block.update':'block.create','content_blocks',$logId,$d['page_slug'].':'.$d['section_key']]); } catch (Throwable $e) { error_log('Content block audit log failed: '.$e->getMessage()); }
            if ($flash[0]==='ok' && !$editing) { header('Location: '.base_url('admin/blocks.php?page='.urlencode($d['page_slug']))); exit; }
            if ($editing) { $stmt=$pdo->prepare('SELECT * FROM content_blocks WHERE id=?'); $stmt->execute([(int)$_GET['id']]); $row=$stmt->fetch(); }
        } catch (Throwable $e) { $flash=['err','Save failed: '.$e->getMessage()]; }
    }
}
$prePage = $row['page_slug'] ?? ($_GET['page'] ?? 'home');
$preSection = $row['section_key'] ?? '';
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/blocks.php')) ?>">Content Blocks</a> <span>/</span> <span><?= $editing?'Edit':'New' ?></span></div>
<div class="top"><h1><?= $editing?'Edit Block':'New Content Block' ?></h1></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0]==='ok'?'ok':'err' ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post"><?= csrf_field() ?>
  <div class="form-card">
    <h3><span class="material-symbols-outlined">tune</span>Placement</h3>
    <div class="form-grid">
      <div class="form-group">
        <label>Page <span class="req">*</span></label>
        <select name="page_slug" id="pageSlug" required>
          <?php foreach (array_keys(BLOCK_SECTIONS) as $pg): ?><option value="<?= e($pg) ?>" <?= $prePage===$pg?'selected':'' ?>><?= e(ucfirst($pg)) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Section <span class="req">*</span></label>
        <select name="section_key" id="sectionKey" required>
          <?php
          $sections = BLOCK_SECTIONS[$prePage] ?? [];
          foreach ($sections as $sk): ?><option value="<?= e($sk) ?>" <?= $preSection===$sk?'selected':'' ?>><?= e($sk) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Sort order</label>
        <input type="number" name="sort_order" value="<?= e((string)($row['sort_order'] ?? 0)) ?>" min="0" max="999">
        <div class="hint">Lower appears first. Use 1,2,3… within the same section.</div>
      </div>
    </div>
  </div>

  <div class="form-card">
    <h3><span class="material-symbols-outlined">article</span>Text — English</h3>
    <div class="form-group"><label>Title (EN)</label><input type="text" name="title_en" value="<?= e($row['title_en'] ?? '') ?>" placeholder="e.g. Vision"></div>
    <div class="form-group"><label>Subtitle (EN)</label><input type="text" name="subtitle_en" value="<?= e($row['subtitle_en'] ?? '') ?>" placeholder="Badge or secondary line"></div>
    <div class="form-group form-full"><label>Body (EN) — HTML allowed</label><textarea name="body_en" rows="4" placeholder="Paragraph, &lt;p&gt; and &lt;a href&gt; allowed"><?= e($row['body_en'] ?? '') ?></textarea></div>
  </div>

  <div class="form-card">
    <h3><span class="material-symbols-outlined">translate</span>Text — नेपाली</h3>
    <div class="form-group"><label>Title (NP)</label><input type="text" name="title_np" value="<?= e($row['title_np'] ?? '') ?>" placeholder="e.g. परिकल्पना"></div>
    <div class="form-group"><label>Subtitle (NP)</label><input type="text" name="subtitle_np" value="<?= e($row['subtitle_np'] ?? '') ?>"></div>
    <div class="form-group form-full"><label>Body (NP) — HTML allowed</label><textarea name="body_np" rows="4" placeholder="नेपाली सामग्री"><?= e($row['body_np'] ?? '') ?></textarea></div>
  </div>

  <div class="form-card">
    <h3><span class="material-symbols-outlined">image</span>Media &amp; link</h3>
    <div class="form-grid">
      <div class="form-group form-full">
        <label>Image URL</label>
        <div style="display:flex;gap:8px">
          <input type="text" name="image_url" id="imageUrl" value="<?= e($row['image_url'] ?? '') ?>" placeholder="uploads/blocks/..." style="flex:1">
          <label class="btn btn-sm" style="cursor:pointer">Upload<input type="file" id="imageFile" accept="image/*,.pdf" hidden></label>
        </div>
        <div id="imagePreview" style="margin-top:8px"><?php if(!empty($row['image_url'])): ?><img src="<?= e_attr(base_url($row['image_url'])) ?>" class="preview-img"><?php endif; ?></div>
        <div class="hint">Images: jpg/png/webp. Upload saves to uploads/blocks/.</div>
      </div>
      <div class="form-group">
        <label>Icon (Material Symbol name)</label>
        <input type="text" name="icon" id="iconInput" value="<?= e($row['icon'] ?? '') ?>" placeholder="e.g. volunteer_activism">
        <div class="hint">Live preview: <span class="material-symbols-outlined" id="iconPreview"><?= e($row['icon'] ?? 'star') ?></span> — find names at fonts.google.com/icons</div>
      </div>
      <div class="form-group">
        <label>Link URL</label>
        <input type="text" name="link_url" value="<?= e($row['link_url'] ?? '') ?>" placeholder="https://... or /contact.php">
      </div>
    </div>
  </div>

  <div class="form-card">
    <h3><span class="material-symbols-outlined">visibility</span>Visibility</h3>
    <div class="status-pills">
      <label class="status-pill"><input type="radio" name="is_active" value="1" <?= ((int)($row['is_active'] ?? 1)===1)?'checked':'' ?>><span><span class="material-symbols-outlined">public</span>Active — visible</span></label>
      <label class="status-pill"><input type="radio" name="is_active" value="0" <?= ((int)($row['is_active'] ?? 1)===0)?'checked':'' ?>><span><span class="material-symbols-outlined">visibility_off</span>Draft — hidden</span></label>
    </div>
  </div>

  <div class="save-bar">
    <button type="submit" class="btn btn-primary" style="padding:12px 26px"><span class="material-symbols-outlined">save</span><?= $editing?'Save changes':'Create block' ?></button>
    <a href="<?= e_attr(base_url('admin/blocks.php')) ?>" class="btn">Cancel</a>
  </div>
</form>
<script>
const sectionsByPage = <?= json_encode(BLOCK_SECTIONS) ?>;
document.getElementById('pageSlug').addEventListener('change', function(){
  const page=this.value; const sel=document.getElementById('sectionKey'); sel.innerHTML='';
  (sectionsByPage[page]||[]).forEach(s=>{ const o=document.createElement('option'); o.value=s; o.textContent=s; sel.appendChild(o); });
});
document.getElementById('iconInput')?.addEventListener('input', function(){ document.getElementById('iconPreview').textContent=this.value||'star'; });
document.getElementById('imageFile')?.addEventListener('change', async function(){
  const f=this.files[0]; if(!f) return;
  const fd=new FormData(); fd.append('file',f); fd.append('_csrf','<?= e_attr(csrf_token()) ?>'); fd.append('subdir','blocks');
  const res=await fetch('<?= e_attr(base_url('admin/upload.php')) ?>',{method:'POST',body:fd});
  const j=await res.json(); if(j.ok){ document.getElementById('imageUrl').value=j.path; const p=document.getElementById('imagePreview'); p.innerHTML='<img src="<?= e_attr(base_url('')) ?>'+j.path+'" class="preview-img"><div class=hint>Uploaded: '+j.path+'</div>'; } else alert(j.error||'Upload failed');
});
</script>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
