<?php
$adminPage = 'dashboard'; $adminTitle = 'Dashboard';
require_once __DIR__ . '/includes/admin_header.php';

$pdo = db();
$counts = ['notices'=>0,'draft_notices'=>0,'posts'=>0,'events'=>0,'downloads'=>0,'gallery'=>0,'messages'=>0,'unread'=>0,'staff'=>0,'users'=>0];

if ($pdo) {
    try {
        if (db_has_table('notices')) { $counts['notices'] = (int)$pdo->query("SELECT COUNT(*) FROM notices WHERE status='published'")->fetchColumn(); $counts['draft_notices'] = (int)$pdo->query("SELECT COUNT(*) FROM notices WHERE status='draft'")->fetchColumn(); }
        if (db_has_table('posts')) { $counts['posts'] = (int)$pdo->query("SELECT COUNT(*) FROM posts WHERE status='published'")->fetchColumn(); $counts['events'] = (int)$pdo->query("SELECT COUNT(*) FROM posts WHERE status='published' AND post_type='event' AND event_date >= CURDATE()")->fetchColumn(); }
        if (db_has_table('downloads')) { $counts['downloads'] = (int)$pdo->query("SELECT COUNT(*) FROM downloads WHERE status='published'")->fetchColumn(); }
        if (db_has_table('gallery_images')) { $counts['gallery'] = (int)$pdo->query("SELECT COUNT(*) FROM gallery_images")->fetchColumn(); }
        if (db_has_table('contact_messages')) { $counts['messages'] = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn(); $counts['unread'] = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read=0")->fetchColumn(); }
        if (db_has_table('staff')) { $counts['staff'] = (int)$pdo->query("SELECT COUNT(*) FROM staff WHERE is_active=1")->fetchColumn(); }
        if (db_has_table('users')) { $counts['users'] = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE is_active=1")->fetchColumn(); }
    } catch (Throwable $e) { error_log('Admin dashboard counts failed: '.$e->getMessage()); }
}

$recentNotices = [];
if ($pdo && db_has_table('notices')) { try { $recentNotices = $pdo->query("SELECT title_en, published_at, is_pinned FROM notices ORDER BY published_at DESC LIMIT 5")->fetchAll(); } catch (Throwable $e) { error_log('Recent notices load failed: '.$e->getMessage()); } }
?>

<div class="top">
    <div><h1 style="font-size:1.4rem"><?= ta('Dashboard','ड्यासबोर्ड') ?></h1><p style="color:#667085;font-size:.88rem">Shree Public Secondary School — Malangwa-2 • IEMIS 190640003</p></div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="<?= e_attr(base_url('admin/notice-form.php')) ?>" class="btn btn-primary">+ <?= ta('New Notice','नयाँ सूचना') ?></a>
        <a href="<?= e_attr(base_url('admin/post-form.php')) ?>" class="btn">+ <?= ta('New Post','नयाँ समाचार') ?></a>
        <a href="<?= e_attr(base_url('admin/download-form.php')) ?>" class="btn"><?= ta('Upload Document','दस्तावेज अपलोड') ?></a>
        <a href="<?= e_attr(base_url('admin/album-form.php')) ?>" class="btn"><?= ta('Add Gallery','ग्यालरी थप्नुहोस्') ?></a>
    </div>
</div>

<div class="cards">
    <a href="<?= e_attr(base_url('admin/notices.php')) ?>" class="card" style="text-decoration:none"><div class="num"><?= $counts['notices'] ?></div><div class="lbl"><?= ta('Published Notices','प्रकाशित सूचनाहरू') ?></div><?php if($counts['draft_notices']):?><div style="font-size:.78rem;color:#667085;margin-top:4px"><?= $counts['draft_notices'] ?> <?= ta('draft(s)','मस्यौदा') ?></div><?php endif;?></a>
    <a href="<?= e_attr(base_url('admin/posts.php')) ?>" class="card" style="text-decoration:none"><div class="num"><?= $counts['posts'] ?></div><div class="lbl"><?= ta('News &amp; Events','समाचार र कार्यक्रम') ?></div></a>
    <a href="<?= e_attr(base_url('admin/posts.php?type=event')) ?>" class="card" style="text-decoration:none"><div class="num"><?= $counts['events'] ?></div><div class="lbl"><?= ta('Upcoming Events','आगामी कार्यक्रम') ?></div></a>
    <a href="<?= e_attr(base_url('admin/downloads.php')) ?>" class="card" style="text-decoration:none"><div class="num"><?= $counts['downloads'] ?></div><div class="lbl"><?= ta('Downloads','डाउनलोड') ?></div></a>
    <a href="<?= e_attr(base_url('admin/gallery.php')) ?>" class="card" style="text-decoration:none"><div class="num"><?= $counts['gallery'] ?></div><div class="lbl"><?= ta('Gallery Images','ग्यालरी तस्बिरहरू') ?></div></a>
    <a href="<?= e_attr(base_url('admin/staff.php')) ?>" class="card" style="text-decoration:none"><div class="num"><?= $counts['staff'] ?></div><div class="lbl"><?= ta('Staff Members','कर्मचारीहरू') ?></div></a>
    <a href="<?= e_attr(base_url('admin/messages.php')) ?>" class="card" style="text-decoration:none"><div class="num"><?= $counts['messages'] ?></div><div class="lbl"><?= ta('Messages','सन्देशहरू') ?></div><?php if($counts['unread']):?><div style="font-size:.78rem;color:#C1272D;margin-top:4px"><?= $counts['unread'] ?> <?= ta('unread','नपढेको') ?></div><?php endif;?></a>
    <a href="<?= e_attr(base_url('admin/users.php')) ?>" class="card" style="text-decoration:none"><div class="num"><?= $counts['users'] ?></div><div class="lbl"><?= ta('Users','प्रयोगकर्ताहरू') ?></div></a>
</div>

<div class="grid2">
    <div class="section-box">
        <h3><?= ta('Recent Notices','हालैका सूचनाहरू') ?></h3>
        <?php if (empty($recentNotices)): ?>
            <p style="color:#667085;font-size:.88rem"><?= ta('No notices yet.','अहिलेसम्म कुनै सूचना छैन।') ?> <a href="<?= e_attr(base_url('admin/notice-form.php')) ?>" style="color:#2364AA"><?= ta('Create one →','एउटा बनाउनुहोस् →') ?></a></p>
        <?php else: ?>
            <ul style="font-size:.88rem;color:#667085;display:flex;flex-direction:column;gap:8px;list-style:none">
            <?php foreach ($recentNotices as $n): ?>
                <li><?= $n['is_pinned']?'<span class="material-symbols-outlined" style="font-size:15px;color:#D29A32;vertical-align:-3px">push_pin</span> ':'' ?><?= e($n['title_en']) ?> — <small><?= e(date('M j, Y', strtotime($n['published_at']))) ?></small></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="section-box">
        <h3><?= ta('Quick Actions','द्रुत कार्यहरू') ?></h3>
        <div style="display:flex;flex-direction:column;gap:8px">
            <a href="<?= e_attr(base_url('admin/notice-form.php')) ?>" class="btn" style="justify-content:flex-start"><span class="material-symbols-outlined">notifications</span><?= ta('Create Notice','सूचना सिर्जना') ?></a>
            <a href="<?= e_attr(base_url('admin/post-form.php')) ?>" class="btn" style="justify-content:flex-start"><span class="material-symbols-outlined">newspaper</span><?= ta('Write News / Add Event','समाचार लेख्नुहोस् / कार्यक्रम थप्नुहोस्') ?></a>
            <a href="<?= e_attr(base_url('admin/album-form.php')) ?>" class="btn" style="justify-content:flex-start"><span class="material-symbols-outlined">photo_library</span><?= ta('New Gallery Album','नयाँ ग्यालरी एल्बम') ?></a>
            <a href="<?= e_attr(base_url('admin/settings.php')) ?>" class="btn" style="justify-content:flex-start"><span class="material-symbols-outlined">settings</span><?= ta('Site Settings','साइट सेटिङ') ?></a>
            <a href="<?= e_attr(base_url('admin/staff-form.php')) ?>" class="btn" style="justify-content:flex-start"><span class="material-symbols-outlined">person_add</span><?= ta('Add Staff','कर्मचारी थप्नुहोस्') ?></a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
