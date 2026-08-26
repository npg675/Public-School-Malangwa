<?php
$adminPage = 'pages'; $adminTitle = 'Page Form';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null; $editing = isset($_GET['id']) && is_numeric($_GET['id']); $row = null;
if ($editing) { $stmt = $pdo->prepare('SELECT * FROM pages WHERE id = ?'); $stmt->execute([(int)$_GET['id']]); $row = $stmt->fetch(); if (!$row) { header('Location: '.base_url('admin/pages.php')); exit; } }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $d = ['slug'=>trim($_POST['slug']??''),'title_en'=>trim($_POST['title_en']??''),'title_np'=>trim($_POST['title_np']??''),'content_en'=>$_POST['content_en']??'','content_np'=>$_POST['content_np']??'','meta_description'=>trim($_POST['meta_description']??''),'status'=>$_POST['status']??'draft'];
    if (empty($d['title_en']) || empty($d['slug'])) { $flash = ['err','Title and Slug required.']; }
    else {
        $d['updated_by'] = $_SESSION['user_id'] ?? null;
        if ($editing) { $s=[]; foreach($d as $k=>$v) $s[]="`$k`=:$k"; $d[':id']=(int)$_GET['id']; $pdo->prepare('UPDATE pages SET '.implode(', ',$s).' WHERE id=:id')->execute($d); $flash=['ok','Page updated.']; }
        else { $c=implode('`, `',array_keys($d)); $v=':'.implode(', :',array_keys($d)); $pdo->prepare("INSERT INTO pages (`$c`) VALUES ($v)")->execute($d); $flash=['ok','Page created.']; }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/pages.php')) ?>">Pages</a> <span>/</span> <span><?= $editing?'Edit':'New' ?></span></div>
<div class="top">
  <h1><?= $editing?'Edit Page':'New Page' ?></h1>
<?php if ($editing): ?><a class="btn" href="<?= e_attr(base_url('page/' . rawurlencode($row['slug']))) ?>" target="_blank"><span class="material-symbols-outlined">visibility</span>Preview on website</a><?php endif; ?>
</div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>

<form method="post"><?= csrf_field() ?>

  <!-- 1. Page details -->
  <div class="form-card">
    <h3><span class="material-symbols-outlined">edit_note</span>Page details</h3>
    <div class="form-grid">
      <div class="form-group">
        <label>Page title (English) <span class="req">*</span></label>
        <input type="text" name="title_en" required value="<?= e($row['title_en']??'') ?>" placeholder="e.g. About Our School">
      </div>
      <div class="form-group">
        <label>Page title (Nepali)</label>
        <input type="text" name="title_np" value="<?= e($row['title_np']??'') ?>" placeholder="e.g. हाम्रो विद्यालयबारे">
      </div>
      <div class="form-group form-full">
        <label>Web address (slug) <span class="req">*</span></label>
        <div class="slug-row">
          <input type="text" name="slug" id="pageSlug" required value="<?= e($row['slug']??'') ?>" placeholder="about" data-slug-from="input[name=title_en]">
        </div>
        <div class="hint">This becomes the page link. It fills in automatically from the English title — you normally don't need to touch it.</div>
      </div>
      <div class="form-group form-full">
        <label>Search description (optional)</label>
        <input type="text" name="meta_description" value="<?= e($row['meta_description']??'') ?>" maxlength="255" placeholder="One line that appears in Google results">
        <div class="hint">Short summary for Google &amp; social sharing. Keep it under 160 characters.</div>
      </div>
    </div>
  </div>

  <!-- 2. Content (English) -->
  <div class="form-card">
    <h3><span class="material-symbols-outlined">article</span>Content — English</h3>
    <div class="rte" id="rte-en">
      <div class="rte-toolbar">
        <button type="button" data-cmd="formatBlock" data-val="H2" title="Section heading"><span class="material-symbols-outlined">format_h2</span></button>
        <button type="button" data-cmd="formatBlock" data-val="H3" title="Sub-heading"><span class="material-symbols-outlined">format_h3</span></button>
        <span class="sep"></span>
        <button type="button" data-cmd="bold" title="Bold"><span class="material-symbols-outlined">format_bold</span></button>
        <button type="button" data-cmd="italic" title="Italic"><span class="material-symbols-outlined">format_italic</span></button>
        <button type="button" data-cmd="underline" title="Underline"><span class="material-symbols-outlined">format_underlined</span></button>
        <span class="sep"></span>
        <button type="button" data-cmd="insertUnorderedList" title="Bullet list"><span class="material-symbols-outlined">format_list_bulleted</span></button>
        <button type="button" data-cmd="insertOrderedList" title="Numbered list"><span class="material-symbols-outlined">format_list_numbered</span></button>
        <span class="sep"></span>
        <button type="button" data-cmd="createLink" title="Add link"><span class="material-symbols-outlined">link</span></button>
        <button type="button" data-cmd="removeFormat" title="Clear formatting"><span class="material-symbols-outlined">format_clear</span></button>
        <span class="sep"></span>
        <button type="button" data-cmd="undo" title="Undo"><span class="material-symbols-outlined">undo</span></button>
        <button type="button" data-cmd="redo" title="Redo"><span class="material-symbols-outlined">redo</span></button>
      </div>
      <div class="rte-area" contenteditable="true" data-placeholder="Write the English page content here…"></div>
      <input type="hidden" name="content_en" value="<?= e($row['content_en']??'') ?>">
      <div class="rte-foot"><span class="rte-count"></span><span class="hint" style="margin:0">Just type — formatting buttons work like Word.</span></div>
    </div>
  </div>

  <!-- 3. Content (Nepali) -->
  <div class="form-card">
    <h3><span class="material-symbols-outlined">translate</span>Content — नेपाली</h3>
    <div class="rte" id="rte-np">
      <div class="rte-toolbar">
        <button type="button" data-cmd="formatBlock" data-val="H2" title="Section heading"><span class="material-symbols-outlined">format_h2</span></button>
        <button type="button" data-cmd="formatBlock" data-val="H3" title="Sub-heading"><span class="material-symbols-outlined">format_h3</span></button>
        <span class="sep"></span>
        <button type="button" data-cmd="bold" title="Bold"><span class="material-symbols-outlined">format_bold</span></button>
        <button type="button" data-cmd="italic" title="Italic"><span class="material-symbols-outlined">format_italic</span></button>
        <button type="button" data-cmd="underline" title="Underline"><span class="material-symbols-outlined">format_underlined</span></button>
        <span class="sep"></span>
        <button type="button" data-cmd="insertUnorderedList" title="Bullet list"><span class="material-symbols-outlined">format_list_bulleted</span></button>
        <button type="button" data-cmd="insertOrderedList" title="Numbered list"><span class="material-symbols-outlined">format_list_numbered</span></button>
        <span class="sep"></span>
        <button type="button" data-cmd="createLink" title="Add link"><span class="material-symbols-outlined">link</span></button>
        <button type="button" data-cmd="removeFormat" title="Clear formatting"><span class="material-symbols-outlined">format_clear</span></button>
        <span class="sep"></span>
        <button type="button" data-cmd="undo" title="Undo"><span class="material-symbols-outlined">undo</span></button>
        <button type="button" data-cmd="redo" title="Redo"><span class="material-symbols-outlined">redo</span></button>
      </div>
      <div class="rte-area" contenteditable="true" data-placeholder="यहाँ नेपालीमा पृष्ठ सामग्री लेख्नुहोस्…"></div>
      <input type="hidden" name="content_np" value="<?= e($row['content_np']??'') ?>">
      <div class="rte-foot"><span class="rte-count"></span><span class="hint" style="margin:0">Leave empty if the page is English-only.</span></div>
    </div>
  </div>

  <!-- 4. Publishing -->
  <div class="form-card">
    <h3><span class="material-symbols-outlined">visibility</span>Visibility</h3>
    <div class="status-pills">
      <label class="status-pill">
        <input type="radio" name="status" value="draft" <?= ($row['status']??'draft')==='draft'?'checked':'' ?>>
        <span><span class="material-symbols-outlined">lock</span>Draft — hidden from website</span>
      </label>
      <label class="status-pill">
        <input type="radio" name="status" value="published" <?= ($row['status']??'')==='published'?'checked':'' ?>>
        <span><span class="material-symbols-outlined">public</span>Published — visible on website</span>
      </label>
    </div>
    <div class="hint">Use Draft while writing. Switch to Published when the page is ready for everyone to see.</div>
  </div>

  <!-- Sticky save bar -->
  <div class="save-bar">
    <button type="submit" class="btn btn-primary" style="padding:12px 26px"><span class="material-symbols-outlined">save</span><?= $editing?'Save changes':'Create page' ?></button>
    <a href="<?= e_attr(base_url('admin/pages.php')) ?>" class="btn">Cancel</a>
    <span class="meta"><?= $editing ? 'Last updated: '.e(date('M j, Y g:i A', strtotime($row['updated_at'] ?? 'now'))) : 'Nothing saved yet' ?></span>
  </div>
</form>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
