<?php
$adminPage = 'settings'; $adminTitle = 'Site Settings';
$adminRequiredPerm = 'system';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;

$settings = [];
if ($pdo && db_has_table('site_settings')) {
    try {
        $rows = $pdo->query("SELECT `key`,`value` FROM site_settings")->fetchAll();
        foreach ($rows as $r) $settings[$r['key']] = $r['value'];
    } catch (Throwable $e) { error_log('Settings load failed: ' . $e->getMessage()); }
}

$fields = [
    'General' => [
        ['key'=>'site_name_en','label'=>'School Name (English)'],
        ['key'=>'site_name_np','label'=>'School Name (Nepali)'],
        ['key'=>'logo_path','label'=>'Logo','type'=>'upload'],
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
        ['key'=>'principal_photo','label'=>'Principal Photo','type'=>'upload'],
        ['key'=>'principal_message_en','label'=>'Message (English)','type'=>'textarea'],
        ['key'=>'principal_message_np','label'=>'Message (Nepali)','type'=>'textarea'],
    ],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $allowed = [];
    foreach ($fields as $items) foreach ($items as $field) $allowed[$field['key']] = true;
    $posted = $_POST['setting'] ?? [];
    if (!$pdo || !db_has_table('site_settings')) {
        $flash = ['err', 'Settings cannot be saved until the database is connected.'];
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO site_settings (`key`,`value`) VALUES (?,?) ON DUPLICATE KEY UPDATE `value`=VALUES(`value`)");
            foreach ($posted as $key => $val) {
                if (!isset($allowed[$key])) continue;
                $value = trim((string)$val);
                $stmt->execute([$key, $value]);
                $settings[$key] = $value;
            }
            $flash = ['ok', 'Settings saved.'];
        } catch (Throwable $e) {
            error_log('Settings save failed: ' . $e->getMessage());
            $flash = ['err', 'Settings could not be saved. Check the database connection and try again.'];
        }
    }
}
?>
<div class="top"><div><h1>Site Settings</h1><p>Configure school details, contact info, and homepage sections</p></div></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>

<form method="post" class="section-box"><?= csrf_field() ?>
<?php foreach ($fields as $group => $items): ?>
    <h3 style="margin:16px 0 12px;padding-bottom:8px;border-bottom:1px solid #E2E8F0"><?= e($group) ?></h3>
    <div class="form-grid">
    <?php foreach ($items as $f): ?>
        <?php if (($f['type'] ?? '') === 'upload'): ?>
            <div class="form-group"><label><?= e($f['label']) ?></label><input type="text" name="setting[<?= e($f['key']) ?>]" id="setting-<?= e($f['key']) ?>" value="<?= e($settings[$f['key']] ?? '') ?>" placeholder="uploads/settings/..."><div class="upload-zone" style="margin-top:8px;padding:18px" onclick="this.querySelector('input[type=file]').click()"><input type="file" accept="image/jpeg,image/png,image/webp" style="display:none" onchange="var input=document.getElementById('setting-<?= e($f['key']) ?>');var preview=document.getElementById('preview-<?= e($f['key']) ?>');uploadFile(this.files[0],function(err,res){if(err){alert(err);return}input.value=res.path;preview.src='<?= e_attr(base_url('')) ?>'+res.path;preview.style.display='block'},'settings')"><small>Upload a JPG, PNG or WebP image</small><img id="preview-<?= e($f['key']) ?>" class="preview-img" src="<?= e_attr(!empty($settings[$f['key']]) ? stored_file_url($settings[$f['key']]) : '') ?>" alt="Current <?= e_attr(strtolower($f['label'])) ?>" style="<?= !empty($settings[$f['key']]) ? '' : 'display:none' ?>"></div></div>
        <?php elseif (($f['type'] ?? '') === 'textarea'): ?>
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
