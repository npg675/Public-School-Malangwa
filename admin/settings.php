<?php
$adminPage = 'settings'; $adminTitle = 'Site Settings';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $settings = $_POST['setting'] ?? [];
    foreach ($settings as $key => $val) {
        $val = trim($val);
        if ($pdo && db_has_table('site_settings')) {
            $pdo->prepare("INSERT INTO site_settings (`key`,`value`) VALUES (?,?) ON DUPLICATE KEY UPDATE `value`=VALUES(`value`)")->execute([$key, $val]);
        }
    }
    $flash = ['ok', 'Settings saved.'];
}

$settings = [];
if ($pdo && db_has_table('site_settings')) {
    try {
        $rows = $pdo->query("SELECT `key`,`value` FROM site_settings")->fetchAll();
        foreach ($rows as $r) $settings[$r['key']] = $r['value'];
    } catch (Throwable $e) {}
}

$fields = [
    'General' => [
        ['key'=>'site_name_en','label'=>'School Name (English)'],
        ['key'=>'site_name_np','label'=>'School Name (Nepali)'],
        ['key'=>'address_en','label'=>'Address (English)'],
        ['key'=>'address_np','label'=>'Address (Nepali)'],
        ['key'=>'iemis_code','label'=>'IEMIS Code'],
    ],
    'Contact' => [
        ['key'=>'phone','label'=>'Phone Number'],
        ['key'=>'email','label'=>'Email Address'],
        ['key'=>'office_hours','label'=>'Office Hours'],
    ],
    'Location' => [
        ['key'=>'coords_lat','label'=>'Latitude'],
        ['key'=>'coords_lng','label'=>'Longitude'],
        ['key'=>'plus_code','label'=>'Plus Code'],
    ],
    'Stats' => [
        ['key'=>'students_display','label'=>'Students Display (e.g. 1,000+)'],
    ],
    'Principal / Head Teacher' => [
        ['key'=>'show_principal','label'=>'Show Principal Section (0/1)','type'=>'toggle'],
        ['key'=>'principal_name','label'=>'Principal Name'],
        ['key'=>'principal_photo','label'=>'Principal Photo URL'],
        ['key'=>'principal_message_en','label'=>'Message (English)','type'=>'textarea'],
        ['key'=>'principal_message_np','label'=>'Message (Nepali)','type'=>'textarea'],
    ],
];
?>
<div class="top"><div><h1>Site Settings</h1><p>Configure school details, contact info, and homepage sections</p></div></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>

<form method="post" class="section-box"><?= csrf_field() ?>
<?php foreach ($fields as $group => $items): ?>
    <h3 style="margin:16px 0 12px;padding-bottom:8px;border-bottom:1px solid #E2E8F0"><?= e($group) ?></h3>
    <div class="form-grid">
    <?php foreach ($items as $f): ?>
        <?php if (($f['type'] ?? '') === 'textarea'): ?>
            <div class="form-group form-full"><label><?= e($f['label']) ?></label><textarea name="setting[<?= e($f['key']) ?>]" rows="4"><?= e($settings[$f['key']] ?? '') ?></textarea></div>
        <?php elseif (($f['type'] ?? '') === 'toggle'): ?>
            <div class="form-group"><label><?= e($f['label']) ?></label><select name="setting[<?= e($f['key']) ?>]"><option value="0" <?= ($settings[$f['key']] ?? '0') === '0' ? 'selected' : '' ?>>Hidden</option><option value="1" <?= ($settings[$f['key']] ?? '') === '1' ? 'selected' : '' ?>>Visible</option></select></div>
        <?php else: ?>
            <div class="form-group"><label><?= e($f['label']) ?></label><input type="text" name="setting[<?= e($f['key']) ?>]" value="<?= e($settings[$f['key']] ?? '') ?>"></div>
        <?php endif; ?>
    <?php endforeach; ?>
    </div>
<?php endforeach; ?>
<div style="display:flex;gap:8px;margin-top:16px"><button type="submit" class="btn btn-primary">Save Settings</button></div>
</form>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
