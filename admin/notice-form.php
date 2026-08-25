<?php
$adminPage = 'notices'; $adminTitle = 'Notice Form';
require_once __DIR__ . '/includes/admin_header.php';

$pdo = db();
$flash = null;
$editing = isset($_GET['id']) && is_numeric($_GET['id']);
$row = null;
$categories = [];

// Load categories
if ($pdo && db_has_table('notice_categories')) {
    try { $categories = $pdo->query("SELECT * FROM notice_categories ORDER BY sort_order")->fetchAll(); } catch (Throwable $e) {}
}

// Load existing notice
if ($editing) {
    $stmt = $pdo->prepare('SELECT * FROM notices WHERE id = ?');
    $stmt->execute([(int)$_GET['id']]);
    $row = $stmt->fetch();
    if (!$row) { header('Location: ' . base_url('admin/notices.php')); exit; }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['_csrf'] ?? '')) {
        $flash = ['err', 'Invalid session.'];
    } else {
        $data = [
            'title_en' => trim($_POST['title_en'] ?? ''),
            'title_np' => trim($_POST['title_np'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'reference_number' => trim($_POST['reference_number'] ?? ''),
            'category_id' => $_POST['category_id'] ?: null,
            'description_en' => $_POST['description_en'] ?? '',
            'description_np' => $_POST['description_np'] ?? '',
            'summary_en' => trim($_POST['summary_en'] ?? ''),
            'summary_np' => trim($_POST['summary_np'] ?? ''),
            'attachment' => trim($_POST['attachment'] ?? ''),
            'attachment_type' => $_POST['attachment_type'] ?: null,
            'published_at' => $_POST['published_at'] ?? date('Y-m-d H:i:s'),
            'expires_at' => $_POST['expires_at'] ?: null,
            'is_pinned' => isset($_POST['is_pinned']) ? 1 : 0,
            'is_urgent' => isset($_POST['is_urgent']) ? 1 : 0,
            'status' => $_POST['status'] ?? 'draft',
        ];

        if (empty($data['title_en'])) {
            $flash = ['err', 'Title (English) is required.'];
        } else {
            if (empty($data['slug'])) {
                $data['slug'] = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $data['title_en']), '-'));
            }

            if ($editing) {
                $sets = [];
                foreach ($data as $k => $v) $sets[] = "`$k`=:$k";
                $sql = 'UPDATE notices SET ' . implode(', ', $sets) . ' WHERE id=:id';
                $data[':id'] = (int)$_GET['id'];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($data);
                $flash = ['ok', 'Notice updated.'];
            } else {
                $data['created_by'] = $_SESSION['user_id'] ?? null;
                $cols = implode('`, `', array_keys($data));
                $vals = ':' . implode(', :', array_keys($data));
                $pdo->prepare("INSERT INTO notices (`$cols`) VALUES ($vals)")->execute($data);
                $flash = ['ok', 'Notice created.'];
            }
        }
    }
}
?>

<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/notices.php')) ?>">Notices</a> <span>/</span> <span><?= $editing ? 'Edit' : 'New' ?> Notice</span></div>

<div class="top">
    <div><h1><?= $editing ? 'Edit Notice' : 'New Notice' ?></h1></div>
</div>

<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>

<form method="post" class="section-box">
    <?= csrf_field() ?>
    <div class="form-grid">
        <div class="form-group"><label>Title (English) *</label><input type="text" name="title_en" required value="<?= e($row['title_en'] ?? '') ?>"></div>
        <div class="form-group"><label>Title (Nepali)</label><input type="text" name="title_np" value="<?= e($row['title_np'] ?? '') ?>"></div>
        <div class="form-group"><label>Slug</label><input type="text" name="slug" value="<?= e($row['slug'] ?? '') ?>" placeholder="auto-generated from title"></div>
        <div class="form-group"><label>Reference Number</label><input type="text" name="reference_number" value="<?= e($row['reference_number'] ?? '') ?>"></div>
        <div class="form-group"><label>Category</label>
            <select name="category_id"><option value="">— Select —</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($row['category_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= e($c['name_en']) ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group"><label>Status</label>
            <select name="status">
                <option value="draft" <?= ($row['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draft</option>
                <option value="published" <?= ($row['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                <option value="archived" <?= ($row['status'] ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
            </select>
        </div>
        <div class="form-group"><label>Published At</label><input type="datetime-local" name="published_at" value="<?= e($row['published_at'] ? date('Y-m-d\TH:i', strtotime($row['published_at'])) : date('Y-m-d\TH:i')) ?>"></div>
        <div class="form-group"><label>Expires At</label><input type="datetime-local" name="expires_at" value="<?= e($row['expires_at'] ? date('Y-m-d\TH:i', strtotime($row['expires_at'])) : '') ?>"></div>
        <div class="form-group form-full"><label>Summary (English)</label><input type="text" name="summary_en" value="<?= e($row['summary_en'] ?? '') ?>" maxlength="400" placeholder="One-line summary shown in lists"></div>
        <div class="form-group form-full"><label>Summary (Nepali)</label><input type="text" name="summary_np" value="<?= e($row['summary_np'] ?? '') ?>" maxlength="400"></div>
    </div>
    <div class="form-group form-full" style="margin-bottom:16px">
        <label style="display:block;font-weight:700;font-size:.82rem;margin-bottom:6px">Details (English)</label>
        <div class="rte" id="rte-notice-en">
            <div class="rte-toolbar">
                <button type="button" data-cmd="formatBlock" data-val="H2" title="Section heading"><span class="material-symbols-outlined">format_h2</span></button>
                <button type="button" data-cmd="bold" title="Bold"><span class="material-symbols-outlined">format_bold</span></button>
                <button type="button" data-cmd="italic" title="Italic"><span class="material-symbols-outlined">format_italic</span></button>
                <span class="sep"></span>
                <button type="button" data-cmd="insertUnorderedList" title="Bullet list"><span class="material-symbols-outlined">format_list_bulleted</span></button>
                <button type="button" data-cmd="insertOrderedList" title="Numbered list"><span class="material-symbols-outlined">format_list_numbered</span></button>
                <span class="sep"></span>
                <button type="button" data-cmd="createLink" title="Add link"><span class="material-symbols-outlined">link</span></button>
                <button type="button" data-cmd="removeFormat" title="Clear formatting"><span class="material-symbols-outlined">format_clear</span></button>
            </div>
            <div class="rte-area" style="min-height:140px" contenteditable="true" data-placeholder="Write the notice details here…"></div>
            <input type="hidden" name="description_en" value="<?= e($row['description_en'] ?? '') ?>">
            <div class="rte-foot"><span class="rte-count"></span></div>
        </div>
    </div>
    <div class="form-group form-full" style="margin-bottom:16px">
        <label style="display:block;font-weight:700;font-size:.82rem;margin-bottom:6px">Details (Nepali)</label>
        <div class="rte" id="rte-notice-np">
            <div class="rte-toolbar">
                <button type="button" data-cmd="formatBlock" data-val="H2" title="Section heading"><span class="material-symbols-outlined">format_h2</span></button>
                <button type="button" data-cmd="bold" title="Bold"><span class="material-symbols-outlined">format_bold</span></button>
                <button type="button" data-cmd="italic" title="Italic"><span class="material-symbols-outlined">format_italic</span></button>
                <span class="sep"></span>
                <button type="button" data-cmd="insertUnorderedList" title="Bullet list"><span class="material-symbols-outlined">format_list_bulleted</span></button>
                <button type="button" data-cmd="insertOrderedList" title="Numbered list"><span class="material-symbols-outlined">format_list_numbered</span></button>
                <span class="sep"></span>
                <button type="button" data-cmd="createLink" title="Add link"><span class="material-symbols-outlined">link</span></button>
                <button type="button" data-cmd="removeFormat" title="Clear formatting"><span class="material-symbols-outlined">format_clear</span></button>
            </div>
            <div class="rte-area" style="min-height:140px" contenteditable="true" data-placeholder="यहाँ सूचना विवरण लेख्नुहोस्…"></div>
            <input type="hidden" name="description_np" value="<?= e($row['description_np'] ?? '') ?>">
            <div class="rte-foot"><span class="rte-count"></span></div>
        </div>
    </div>
    <div class="form-grid">
        <div class="form-group"><label>Attachment URL</label><input type="text" name="attachment" value="<?= e($row['attachment'] ?? '') ?>" placeholder="uploads/... or URL"></div>
        <div class="form-group"><label>Attachment Type</label>
            <select name="attachment_type"><option value="">— None —</option>
                <option value="pdf" <?= ($row['attachment_type'] ?? '') === 'pdf' ? 'selected' : '' ?>>PDF</option>
                <option value="docx" <?= ($row['attachment_type'] ?? '') === 'docx' ? 'selected' : '' ?>>DOCX</option>
                <option value="xlsx" <?= ($row['attachment_type'] ?? '') === 'xlsx' ? 'selected' : '' ?>>XLSX</option>
                <option value="jpg" <?= ($row['attachment_type'] ?? '') === 'jpg' ? 'selected' : '' ?>>JPG</option>
                <option value="png" <?= ($row['attachment_type'] ?? '') === 'png' ? 'selected' : '' ?>>PNG</option>
            </select>
        </div>
        <div class="form-group form-full">
            <label style="display:block;font-weight:700;font-size:.82rem;margin-bottom:6px">Options</label>
            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <label class="checkbox-chip"><input type="checkbox" name="is_pinned" <?= ($row['is_pinned'] ?? 0) ? 'checked' : '' ?>><span class="material-symbols-outlined" style="font-size:18px;color:#D29A32">push_pin</span>Pin to top of Notice Board</label>
                <label class="checkbox-chip"><input type="checkbox" name="is_urgent" <?= ($row['is_urgent'] ?? 0) ? 'checked' : '' ?>><span class="material-symbols-outlined" style="font-size:18px;color:#C1272D">priority_high</span>Mark as urgent (red highlight)</label>
            </div>
        </div>
    </div>
    <div style="display:flex;gap:8px;margin-top:16px">
        <button type="submit" class="btn btn-primary"><?= $editing ? 'Update Notice' : 'Create Notice' ?></button>
        <a href="<?= e_attr(base_url('admin/notices.php')) ?>" class="btn">Cancel</a>
    </div>
</form>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
