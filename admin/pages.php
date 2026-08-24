<?php
$adminPage = 'pages'; $adminTitle = 'Manage Pages';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) { $flash = ['err','Invalid request.']; }
    else { $pdo->prepare('DELETE FROM pages WHERE id = ?')->execute([(int)$_GET['delete']]); $flash = ['ok','Page deleted.']; }
}
$items = [];
if ($pdo && db_has_table('pages')) { try { $items = $pdo->query("SELECT * FROM pages ORDER BY slug LIMIT 50")->fetchAll(); } catch (Throwable $e) {} }
?>
<div class="top"><div><h1>Pages</h1><p>Edit static page content (About, Admissions, etc.)</p></div><a href="<?= e_attr(base_url('admin/page-form.php')) ?>" class="btn btn-primary">+ New Page</a></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<div class="section-box"><table><thead><tr><th>Page</th><th>Slug</th><th>Status</th><th>Updated</th><th>Actions</th></tr></thead><tbody>
<?php if (empty($items)): ?><tr><td colspan="5" class="empty">No pages yet.</td></tr>
<?php else: foreach ($items as $p): ?><tr>
    <td><strong><?= e($p['title_en']) ?></strong><?php if(!empty($p['title_np'])):?><br><small style="color:#667085"><?=e($p['title_np'])?></small><?php endif;?></td>
    <td><code style="font-size:.78rem;background:#F7F9FC;padding:2px 8px;border-radius:4px"><?= e($p['slug']) ?></code></td>
    <td><span class="tag <?= $p['status']==='published'?'tag-green':'tag-gold' ?>"><?= e($p['status']) ?></span></td>
    <td><small><?= e(date('M j, Y', strtotime($p['updated_at']))) ?></small></td>
    <td class="actions"><a href="<?= e_attr(base_url('admin/page-form.php?id='.$p['id'])) ?>" class="btn btn-sm">Edit</a><a href="<?= e_attr(base_url('admin/pages.php?delete='.$p['id'].'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</a></td>
</tr><?php endforeach; endif; ?>
</tbody></table></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
