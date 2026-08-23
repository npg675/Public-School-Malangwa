<?php
require_once __DIR__ . '/config/config.php';
header('Content-Type: application/xml; charset=utf-8');
$base = rtrim(base_url(), '/');
$pages = ['','about.php','academics.php','science.php','management.php','admissions.php','notices.php','news.php','events.php','results.php','downloads.php','publications.php','citizen-charter.php','scholarships.php','academic-calendar.php','links.php','gallery.php','contact.php','faq.php'];
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $p): $url = $base . '/' . $p; if($p==='') $url=$base.'/'; ?>
  <url><loc><?= htmlspecialchars($url) ?></loc><changefreq>weekly</changefreq><priority><?= $p===''?'1.0':'0.8' ?></priority></url>
<?php endforeach; ?>
<?php
// dynamic notices if DB available
require_once __DIR__ . '/includes/helpers.php';
try {
  $notices = get_notices(50);
  foreach ($notices as $n) {
    $url = $base . '/notice.php?slug=' . urlencode($n['slug']);
    echo "  <url><loc>" . htmlspecialchars($url) . "</loc><lastmod>" . date('Y-m-d', strtotime($n['published_at'])) . "</lastmod></url>\n";
  }
} catch (Throwable $e) {}
?>
</urlset>
