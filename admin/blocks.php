<?php
$adminPage = 'blocks'; $adminTitle = 'Content Blocks';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) { $flash = ['err','Invalid request.']; }
    else { $pdo->prepare('DELETE FROM content_blocks WHERE id = ?')->execute([(int)$_GET['delete']]); $flash = ['ok','Block deleted.']; }
}
$pages = ['home','about','academics','admissions','faq','links','publications','management','science'];
$filter = $_GET['page'] ?? '';
if ($filter !== '' && !in_array($filter, $pages, true)) $filter = '';
$items = [];
if ($pdo && db_has_table('content_blocks')) {
    try {
        if ($filter !== '') {
            $stmt = $pdo->prepare('SELECT * FROM content_blocks WHERE page_slug = :p ORDER BY section_key, sort_order, id LIMIT 200');
            $stmt->execute([':p'=>$filter]);
        } else {
            $stmt = $pdo->query('SELECT * FROM content_blocks ORDER BY page_slug, section_key, sort_order, id LIMIT 200');
        }
        $items = $stmt->fetchAll();
    } catch (Throwable $e) {}
}
?>
<div class="top"><div><h1>Content Blocks</h1><p>Manage CMS page sections — hero, stats, timelines, FAQs, links, etc.</p></div><a href="<?= e_attr(base_url('admin/block-form.php' . ($filter ? '?page='.urlencode($filter) : ''))) ?>" class="btn btn-primary">+ Add Block</a></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0]=='ok'?'ok':'err' ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<div class="section-box" style="margin-bottom:16px">
<form method="get" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
<label style="font-weight:700;font-size:.84rem">Filter by page:</label>
<select name="page" onchange="this.form.submit()" style="padding:8px 12px;border:1.5px solid #E2E8F0;border-radius:8px;background:#F7F9FC">
<option value="">All pages</option>
<?php foreach ($pages as $pg): ?><option value="<?= e($pg) ?>" <?= $filter===$pg?'selected':'' ?>><?= e(ucfirst($pg)) ?></option><?php endforeach; ?>
</select>
<?php if ($filter): ?><a href="<?= e_attr(base_url('admin/blocks.php')) ?>" class="btn btn-sm">Clear</a><?php endif; ?>
</form>
</div>
<div class="section-box">
<table><thead><tr><th>Page</th><th>Section</th><th>Sort</th><th>Title (EN / NP)</th><th>Active</th><th>Actions</th></tr></thead><tbody>
<?php if (empty($items)): ?><tr><td colspan="6" class="empty">No blocks yet. Click “Add Block” to create one.</td></tr>
<?php else: foreach ($items as $b): ?>
<tr>
<td><code style="font-size:.78rem;background:#F7F9FC;padding:2px 8px;border-radius:4px"><?= e($b['page_slug']) ?></code></td>
<td><strong><?= e($b['section_key']) ?></strong></td>
<td><?= e((string)$b['sort_order']) ?></td>
<td><div style="font-weight:600"><?= e($b['title_en'] ?? '') ?></div><?php if(!empty($b['title_np'])):?><div style="color:#667085;font-size:.82rem"><?= e($b['title_np']) ?></div><?php endif; ?><?php if(!empty($b['subtitle_en'])||!empty($b['subtitle_np'])):?><div style="font-size:.78rem;color:#667085"><?= e($b['subtitle_en'] ?? '') ?><?php if(!empty($b['subtitle_np'])):?> / <?= e($b['subtitle_np']) ?><?php endif;?></div><?php endif;?></td>
<td><span class="tag <?= (int)$b['is_active']?'tag-green':'tag-gold' ?>"><?= (int)$b['is_active']?'Active':'Draft' ?></span></td>
<td class="actions"><a href="<?= e_attr(base_url('admin/block-form.php?id='.$b['id'])) ?>" class="btn btn-sm">Edit</a><a href="<?= e_attr(base_url('admin/blocks.php?delete='.$b['id'].'&csrf='.csrf_token() . ($filter?'&page='.urlencode($filter):''))) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this block?')">Delete</a></td>
</tr>
<?php endforeach; endif; ?>
</tbody></table>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
