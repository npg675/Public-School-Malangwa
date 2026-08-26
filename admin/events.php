<?php
$adminPage = 'events'; $adminTitle = 'Manage Events';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) { $flash = ['err','Invalid request.']; }
    else { $pdo->prepare('DELETE FROM events WHERE id = ?')->execute([(int)$_GET['delete']]); $flash = ['ok','Event deleted.']; }
}
$items = [];
if ($pdo && db_has_table('events')) { try { $items = $pdo->query("SELECT * FROM events ORDER BY event_date DESC LIMIT 100")->fetchAll(); } catch (Throwable $e) { error_log('Events list failed: ' . $e->getMessage()); } }
?>
<div class="top"><div><h1>Events</h1><p>School events, programs, and celebrations</p></div><a href="<?= e_attr(base_url('admin/event-form.php')) ?>" class="btn btn-primary">+ New Event</a></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<div class="section-box"><table><thead><tr><th>Event</th><th>Date</th><th>Location</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php if (empty($items)): ?><tr><td colspan="5" class="empty">No events yet.</td></tr>
<?php else: foreach ($items as $e2): ?><tr>
    <td><strong><?= e($e2['title_en']) ?></strong><?php if(!empty($e2['title_np'])):?><br><small style="color:#667085"><?=e($e2['title_np'])?></small><?php endif;?></td>
    <td><small><?= e($e2['event_date']) ?></small></td>
    <td><small><?= e($e2['location_en']??'') ?></small></td>
    <td><span class="tag <?= $e2['status']==='published'?'tag-green':'tag-gold' ?>"><?= e($e2['status']) ?></span></td>
    <td class="actions"><a href="<?= e_attr(base_url('admin/event-form.php?id='.$e2['id'])) ?>" class="btn btn-sm">Edit</a><a href="<?= e_attr(base_url('admin/events.php?delete='.$e2['id'].'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</a></td>
</tr><?php endforeach; endif; ?>
</tbody></table></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
