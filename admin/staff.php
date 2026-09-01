<?php
$adminPage = 'staff'; $adminTitle = 'Manage Staff';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) { $flash = ['err','Invalid request.']; }
    else { $pdo->prepare('DELETE FROM staff WHERE id = ?')->execute([(int)$_GET['delete']]); $flash = ['ok','Staff deleted.']; }
}
if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    if (!csrf_verify($_GET['csrf'] ?? '')) { $flash = ['err','Invalid request.']; }
    else {
        try { $pdo->prepare('UPDATE staff SET is_active = 1 - is_active WHERE id = ?')->execute([(int)$_GET['toggle']]); $flash = ['ok','Visibility updated.']; } catch (Throwable $e) { error_log('Staff toggle failed: '.$e->getMessage()); }
    }
}
$cat = (int)($_GET['cat'] ?? 0);
$show = ($_GET['status'] ?? 'all') === 'active' ? 'active' : (($_GET['status'] ?? 'all') === 'inactive' ? 'inactive' : 'all');
$filterQs = ($cat > 0 ? '&cat='.$cat : '') . ($show !== 'all' ? '&status='.$show : '');
$items = [];
if ($pdo && db_has_table('staff')) {
    try {
        $sql = "SELECT s.*, c.name_en as cat_en FROM staff s LEFT JOIN staff_categories c ON c.id=s.category_id";
        $where = []; $params = [];
        if ($cat > 0) { $where[] = "s.category_id = ?"; $params[] = $cat; }
        if ($show === 'active') { $where[] = "s.is_active = 1"; }
        elseif ($show === 'inactive') { $where[] = "s.is_active = 0"; }
        if (!empty($where)) $sql .= " WHERE " . implode(' AND ', $where);
        $sql .= " ORDER BY c.sort_order, s.display_order, s.name_en";
        $stmt = $pdo->prepare($sql); $stmt->execute($params); $items = $stmt->fetchAll();
    } catch (Throwable $e) { error_log('Staff list failed: ' . $e->getMessage()); }
}
$categories = [];
if ($pdo && db_has_table('staff_categories')) { try { $categories = $pdo->query("SELECT * FROM staff_categories ORDER BY sort_order, name_en")->fetchAll(); } catch (Throwable $e) { error_log('Staff categories load failed: ' . $e->getMessage()); } }
?>
<div class="top"><div><h1>Staff</h1><p>Leadership, teaching, and non-teaching staff</p></div><a href="<?= e_attr(base_url('admin/staff-form.php')) ?>" class="btn btn-primary">+ Add Staff</a></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<div class="section-box">
<form method="get" style="display:flex;gap:10px;align-items:center;margin-bottom:14px;flex-wrap:wrap">
    <label style="font-weight:600;font-size:.85rem">Filter</label>
    <select name="cat" onchange="this.form.submit()" style="min-width:180px">
        <option value="0">All categories</option>
        <?php foreach ($categories as $c): ?><option value="<?= (int)$c['id'] ?>" <?= $cat === (int)$c['id'] ? 'selected' : '' ?>><?= e($c['name_en']) ?></option><?php endforeach; ?>
    </select>
    <select name="status" onchange="this.form.submit()" style="min-width:140px">
        <option value="all" <?= $show==='all'?'selected':'' ?>>All visibility</option>
        <option value="active" <?= $show==='active'?'selected':'' ?>>Visible on site</option>
        <option value="inactive" <?= $show==='inactive'?'selected':'' ?>>Hidden from site</option>
    </select>
    <?php if ($cat > 0 || $show !== 'all'): ?><a href="<?= e_attr(base_url('admin/staff.php')) ?>" class="btn btn-sm">Clear</a><?php endif; ?>
</form>
<table><thead><tr><th>Photo</th><th>Name</th><th>Designation</th><th>Category</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php if (empty($items)): ?><tr><td colspan="6" class="empty">No staff members yet.</td></tr>
<?php else: foreach ($items as $s): ?><tr>
    <td><?php if(!empty($s['photo'])): ?><img src="<?= e_attr(staff_photo_url($s['photo'])) ?>" style="width:40px;height:40px;border-radius:50%;object-fit:cover" onerror="this.style.display='none'"><?php else: ?><div style="width:40px;height:40px;border-radius:50%;background:#E2E8F0;display:grid;place-items:center;font-weight:700;color:#667085;font-size:.8rem"><?= strtoupper(substr($s['name_en'],0,1)) ?></div><?php endif; ?></td>
    <td><strong><?= e($s['name_en']) ?></strong><?php if(!empty($s['name_np'])):?><br><small style="color:#667085"><?=e($s['name_np'])?></small><?php endif;?></td>
    <td><small><?= e($s['designation_en']) ?></small></td>
    <td><span class="tag tag-blue"><?= e($s['cat_en']??'') ?></span></td>
    <td><span class="tag <?= $s['is_active']?'tag-green':'tag-red' ?>"><?= $s['is_active']?'On site':'Hidden' ?></span><br><a href="<?= e_attr(base_url('admin/staff.php?toggle='.$s['id'].'&csrf='.csrf_token()).$filterQs) ?>" class="btn btn-sm" style="margin-top:6px;font-size:.72rem" onclick="return confirmDelete('Toggle visibility on the public website?')"><?= $s['is_active']?'Hide from site':'Show on site' ?></a></td>
    <td class="actions"><a href="<?= e_attr(base_url('admin/staff-form.php?id='.$s['id'])) ?>" class="btn btn-sm">Edit</a><a href="<?= e_attr(base_url('admin/staff.php?delete='.$s['id'].'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</a></td>
</tr><?php endforeach; endif; ?>
</tbody></table></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
