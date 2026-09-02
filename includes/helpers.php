<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_name((string)env('SESSION_NAME', 'sps_session'));
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// CSRF
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_field(): string {
    return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">';
}
function csrf_verify(?string $token): bool {
    return hash_equals($_SESSION['csrf'] ?? '', $token ?? '');
}

// escaping
function e(?string $v): string { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function e_attr(?string $v): string { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }

// i18n minimal
function current_lang(): string {
    $lang = $_COOKIE['site_lang'] ?? $_SESSION['site_lang'] ?? DEFAULT_LANG;
    if (!in_array($lang, ['en','np'], true)) $lang = 'en';
    return $lang;
}
function t(string $en, string $np): string {
    return current_lang() === 'np' ? $np : $en;
}
function lang_url(string $lang): string {
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    // set cookie via JS; keep simple
    return $uri;
}

// Admin-panel language (independent of public site_lang)
function admin_lang(): string {
    $lang = $_COOKIE['admin_lang'] ?? $_SESSION['admin_lang'] ?? DEFAULT_LANG;
    if (!in_array($lang, ['en','np'], true)) $lang = 'en';
    return $lang;
}
function ta(string $en, string $np): string {
    return admin_lang() === 'np' ? $np : $en;
}

function all_settings(): array {
    static $cache = null;
    if ($cache !== null) return $cache;

    $cache = [];
    $pdo = db();
    if ($pdo && db_has_table('site_settings')) {
        try {
            $rows = $pdo->query('SELECT `key`,`value` FROM site_settings')->fetchAll();
            foreach ($rows as $r) $cache[$r['key']] = (string)$r['value'];
        } catch (Throwable $e) {
            error_log('Site settings read failed: ' . $e->getMessage());
        }
    }
    return $cache;
}

// Shared site settings are the canonical source for editable school identity.
function setting(string $key, $fallback = '') {
    $settings = all_settings();
    return array_key_exists($key, $settings) ? $settings[$key] : $fallback;
}

// Notices helpers
function get_notices(int $limit = 6, ?string $category = null): array {
    $pdo = db();
    if ($pdo && db_has_table('notices')) {
        try {
            $sql = "SELECT n.*, c.name_en as cat_en, c.name_np as cat_np, c.slug as cat_slug FROM notices n LEFT JOIN notice_categories c ON c.id=n.category_id WHERE n.status='published' AND (n.expires_at IS NULL OR n.expires_at > NOW()) ";
            $params = [];
            if ($category) { $sql .= " AND c.slug=:cat "; $params[':cat']=$category; }
            $sql .= " ORDER BY n.is_pinned DESC, n.published_at DESC LIMIT :lim";
            $stmt = $pdo->prepare($sql);
            foreach($params as $k=>$v) $stmt->bindValue($k,$v);
            $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach ($rows as &$row) {
                $row['summary_en'] = mb_strimwidth(trim(strip_tags((string)($row['description_en'] ?? ''))), 0, 220, '…', 'UTF-8');
                $row['summary_np'] = mb_strimwidth(trim(strip_tags((string)($row['description_np'] ?? ''))), 0, 220, '…', 'UTF-8');
            }
            return $rows;
        } catch (Throwable $e) {
            error_log('Notices read failed: ' . $e->getMessage());
            return [];
        }
    }
    // fallback sample data
    return sample_notices($limit);
}

function get_pinned_notice(): ?array {
    $all = get_notices(1);
    if (!$all) return null;
    // check urgent
    foreach ($all as $n) if (!empty($n['is_urgent']) || !empty($n['is_pinned'])) return $n;
    return $all[0] ?? null;
}

function sample_notices(int $limit): array {
    $samples = [
        ['id'=>1,'title_en'=>'Admission Open for ECD – Grade 12 (2082 BS)','title_np'=>'भर्ना खुला — ईसीडी देखि कक्षा १२ (२०८२)','slug'=>'admission-open-2082','reference_number'=>'SPS/Notice/2082-01','category'=>'Admission','cat_en'=>'Admission','cat_np'=>'भर्ना','cat_slug'=>'admission','published_at'=>'2026-04-15 10:00:00','is_pinned'=>1,'is_urgent'=>0,'attachment_type'=>'pdf','summary_en'=>'Admission forms available at school office. Contact office for fees and documents.','summary_np'=>'भर्ना फारम विद्यालय कार्यालयमा उपलब्ध छ।'],
        ['id'=>2,'title_en'=>'SEE Routine 2082 Published','title_np'=>'एसईई तालिका २०८२ प्रकाशित','slug'=>'see-routine-2082','reference_number'=>'SPS/Exam/2082-04','category'=>'Examination','cat_en'=>'Examination','cat_np'=>'परीक्षा','cat_slug'=>'examination','published_at'=>'2026-03-28 09:00:00','is_pinned'=>0,'is_urgent'=>0,'attachment_type'=>'pdf','summary_en'=>'SEE examination routine for Grade 10. Download PDF.','summary_np'=>'कक्षा १० को एसईई परीक्षा तालिका।'],
        ['id'=>3,'title_en'=>'Vacancy: Secondary Level Science Teacher','title_np'=>'रिक्त पद: माध्यमिक तह विज्ञान शिक्षक','slug'=>'vacancy-science-teacher','reference_number'=>'SPS/Vacancy/2082-03','category'=>'Vacancy','cat_en'=>'Vacancy','cat_np'=>'रिक्त','cat_slug'=>'vacancy','published_at'=>'2026-03-10 11:00:00','is_pinned'=>0,'is_urgent'=>1,'attachment_type'=>'pdf','summary_en'=>'Applications invited for secondary science teacher. Deadline within 15 days.','summary_np'=>'माध्यमिक विज्ञान शिक्षक पदका लागि दरखास्त आह्वान।'],
        ['id'=>4,'title_en'=>'Scholarship Notice for Grade 11','title_np'=>'कक्षा ११ छात्रवृत्ति सूचना','slug'=>'scholarship-grade-11','reference_number'=>'SPS/Scholarship/2082-02','category'=>'Scholarship','cat_en'=>'Scholarship','cat_np'=>'छात्रवृत्ति','cat_slug'=>'scholarship','published_at'=>'2026-02-20 10:30:00','is_pinned'=>0,'is_urgent'=>0,'attachment_type'=>'pdf','summary_en'=>'Scholarship quota for disadvantaged students. See notice for eligibility.','summary_np'=>'विपन्न विद्यार्थीका लागि छात्रवृत्ति कोटा।'],
        ['id'=>5,'title_en'=>'Holiday Notice – Holi','title_np'=>'बिदा सूचना — होली','slug'=>'holiday-holi-2082','reference_number'=>'SPS/Holiday/2082-05','category'=>'Holiday','cat_en'=>'Holiday','cat_np'=>'बिदा','cat_slug'=>'holiday','published_at'=>'2026-03-01 08:00:00','is_pinned'=>0,'is_urgent'=>0,'attachment_type'=>null,'summary_en'=>'School will remain closed on Holi. Classes resume next working day.','summary_np'=>'होलीका दिन विद्यालय बन्द रहनेछ।'],
    ];
    $out = array_slice($samples, 0, $limit);
    foreach ($out as &$s) { $s['is_sample'] = 1; }
    return $out;
}

function get_posts(string $type = '', int $limit = 12, string $sort = 'recent'): array {
    $pdo = db();
    if ($pdo && db_has_table('posts')) {
        try {
            $sql = "SELECT p.*, c.name_en AS cat_en, c.name_np AS cat_np FROM posts p LEFT JOIN news_categories c ON c.id=p.category_id WHERE p.status='published'";
            $params = [];
            if ($type === 'news' || $type === 'event') { $sql .= ' AND p.post_type = :type'; $params[':type'] = $type; }
            $sql .= ($sort === 'upcoming')
                ? " AND p.event_date >= CURDATE() ORDER BY p.event_date ASC, p.published_at DESC LIMIT :lim"
                : " ORDER BY p.published_at DESC, p.id DESC LIMIT :lim";
            $stmt = $pdo->prepare($sql);
            foreach ($params as $k => $v) $stmt->bindValue($k, $v);
            $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Throwable $e) {
            error_log('Posts read failed: ' . $e->getMessage());
            return [];
        }
    }
    return [];
}

function get_events(int $limit = 3): array {
    return get_posts('event', $limit, 'upcoming');
}

function get_news(int $limit = 6): array {
    return array_map(function (array $r): array {
        $r['excerpt_en'] = $r['excerpt_en'] ?? ($r['content_en'] ?? '');
        $r['excerpt_np'] = $r['excerpt_np'] ?? ($r['content_np'] ?? '');
        return $r;
    }, get_posts('news', $limit));
}

function get_downloads(int $limit = 6, ?string $category = null): array {
    $pdo = db();
    if ($pdo && db_has_table('downloads')) {
        try {
            $sql = "SELECT d.*, c.name_en as cat_en, c.slug as cat_slug FROM downloads d LEFT JOIN download_categories c ON c.id=d.category_id WHERE d.status='published' ORDER BY d.published_at DESC LIMIT :lim";
            $params = [];
            if ($category) { $sql = str_replace('WHERE d.status', 'WHERE c.slug = :cat AND d.status', $sql); $params[':cat'] = $category; }
            $stmt = $pdo->prepare($sql);
            foreach ($params as $k=>$v) $stmt->bindValue($k,$v);
            $stmt->bindValue(':lim',$limit,PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return array_values(array_filter($rows, static function (array $row): bool {
                $path = trim((string)($row['file_path'] ?? ''));
                if ($path === '') return false;
                if (preg_match('#^https?://#i', $path)) return true;
                return is_file(__DIR__ . '/../' . ltrim($path, '/'));
            }));
        } catch (Throwable $e) {
            error_log('Downloads read failed: ' . $e->getMessage());
            return [];
        }
    }
    return [
        ['title_en'=>'Admission Form 2082 (Sample)','title_np'=>'भर्ना फारम २०८२','category'=>'Forms','cat_en'=>'Forms','published_at'=>'2026-04-01','file_size'=>'420 KB','file_type'=>'PDF','is_sample'=>1],
        ['title_en'=>'Academic Calendar 2082 (Sample)','title_np'=>'शैक्षिक पात्रो २०८२','category'=>'Academic Calendar','cat_en'=>'Academic Calendar','published_at'=>'2026-04-05','file_size'=>'1.2 MB','file_type'=>'PDF','is_sample'=>1],
        ['title_en'=>'Exam Routine – Grade 10 SEE (Sample)','title_np'=>'परीक्षा तालिका — कक्षा १०','category'=>'Routine','cat_en'=>'Routine','published_at'=>'2026-03-28','file_size'=>'680 KB','file_type'=>'PDF','is_sample'=>1],
        ['title_en'=>'Citizen Charter (नागरिक वडापत्र) (Sample)','title_np'=>'नागरिक वडापत्र','category'=>'Citizen Charter','cat_en'=>'Citizen Charter','published_at'=>'2026-03-15','file_size'=>'890 KB','file_type'=>'PDF','is_sample'=>1],
        ['title_en'=>'Book List 2082 (Sample)','title_np'=>'पाठ्यपुस्तक सूची २०८२','category'=>'Curriculum','cat_en'=>'Curriculum','published_at'=>'2026-04-02','file_size'=>'540 KB','file_type'=>'PDF','is_sample'=>1],
        ['title_en'=>'Scholarship Notice 2082 (Sample)','title_np'=>'छात्रवृत्ति सूचना २०८२','category'=>'Scholarships','cat_en'=>'Scholarships','published_at'=>'2026-02-20','file_size'=>'310 KB','file_type'=>'PDF','is_sample'=>1],
    ];
}

function get_gallery_albums(int $limit = 6): array {
    $pdo = db();
    if ($pdo && db_has_table('gallery_albums')) {
        try {
            $stmt = $pdo->prepare("SELECT a.slug, a.title_en, a.title_np, a.cover_image, a.description_en, (SELECT COUNT(*) FROM gallery_images gi WHERE gi.album_id = a.id) AS count FROM gallery_albums a WHERE a.status='published' ORDER BY a.sort_order, a.title_en LIMIT :lim");
            $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach ($rows as &$r) {
                $r['cover'] = media_url($r['cover_image'] ?? '');
            }
            return $rows;
        } catch (Throwable $e) {
            error_log('Gallery albums read failed: ' . $e->getMessage());
            return [];
        }
    }
    // Fallback: real school photos
    return [
        ['slug'=>'campus','title_en'=>'Campus','title_np'=>'विद्यालय परिसर','cover'=>base_url('uploads/gallery/campus/courtyard-students-formation.jpg'),'count'=>6],
        ['slug'=>'assembly','title_en'=>'Assembly & Events','title_np'=>'सभा र कार्यक्रम','cover'=>base_url('uploads/gallery/assembly/teacher-addressing-assembly.jpg'),'count'=>3],
        ['slug'=>'staff','title_en'=>'Staff & Leadership','title_np'=>'कर्मचारी र नेतृत्व','cover'=>base_url('uploads/gallery/staff/leadership-team-photo.jpg'),'count'=>1],
        ['slug'=>'community','title_en'=>'Community Programs','title_np'=>'समुदाय कार्यक्रम','cover'=>base_url('uploads/gallery/community/complaint-box-life-nepal.jpg'),'count'=>1],
    ];
}

require_once __DIR__ . '/content-seeds.php';

function get_blocks(string $page, ?string $section = null): array {
    $pdo = db();
    if ($pdo && db_has_table('content_blocks')) {
        try {
            $sql = 'SELECT * FROM content_blocks WHERE is_active = 1 AND page_slug = :page';
            $params = [':page' => $page];
            if ($section !== null) { $sql .= ' AND section_key = :sec'; $params[':sec'] = $section; }
            $sql .= ' ORDER BY sort_order, id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll();
            return $rows;
        } catch (Throwable $e) {
            error_log('Content blocks read failed: ' . $e->getMessage());
            return [];
        }
    }
    $out = [];
    foreach (cms_seed_blocks() as $b) {
        if ($b['page_slug'] === $page && ($section === null || $b['section_key'] === $section)) $out[] = $b;
    }
    usort($out, fn($a,$b) => [$a['section_key'],(int)$a['sort_order']] <=> [$b['section_key'],(int)$b['sort_order']]);
    return $out;
}

function block_val(array $b, string $field): string {
    $lang = current_lang();
    $v = (string)($b[$field . '_' . $lang] ?? '');
    if ($v === '') $v = (string)($b[$field . '_en'] ?? '');
    return $v;
}

function get_page_content(string $slug): ?array {
    $pdo = db();
    if ($pdo && db_has_table('pages')) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ? AND status='published' LIMIT 1");
            $stmt->execute([$slug]);
            $row = $stmt->fetch();
            if ($row) return $row;
        } catch (Throwable $e) {
            error_log('Page read failed: ' . $e->getMessage());
        }
    }
    return null;
}

function page_val(?array $row, string $field): string {
    if (!$row) return '';
    $lang = current_lang();
    $v = (string)($row[$field . '_' . $lang] ?? '');
    if ($v === '') $v = (string)($row[$field . '_en'] ?? '');
    return $v;
}

function get_programs(): array {
    $pdo = db();
    if ($pdo && db_has_table('academic_programs')) {
        try {
            $rows = $pdo->query('SELECT * FROM academic_programs WHERE is_active = 1 ORDER BY sort_order')->fetchAll();
            return $rows;
        } catch (Throwable $e) {
            error_log('Academic programs read failed: ' . $e->getMessage());
            return [];
        }
    }
    return [
        ['slug'=>'ecd','title_en'=>'ECD / Nursery','title_np'=>'ईसीडी / नर्सरी','level'=>'ecd','stream'=>null,'description_en'=>'<p>Play-based start to formal schooling.</p>','description_np'=>'<p>खेलमा आधारित प्रारम्भिक शिक्षा।</p>'],
        ['slug'=>'grades-9-10','title_en'=>'Grades 9–10 (SEE)','title_np'=>'कक्षा ९–१० (एसईई)','level'=>'secondary_9_10','stream'=>null,'description_en'=>'<p>SEE pathway.</p>','description_np'=>'<p>एसईई मार्ग।</p>'],
        ['slug'=>'plus2-science','title_en'=>'+2 Science','title_np'=>'+२ विज्ञान','level'=>'higher_secondary','stream'=>'Science','description_en'=>'<p>NEB science stream.</p>','description_np'=>'<p>एनईबी विज्ञान स्ट्रिम।</p>'],
    ];
}

/**
 * Return active people for the public About page, grouped by the CMS hierarchy.
 * The committee fallback also supports older installations that still classify
 * committee members under Administration by designation.
 */
function get_staff_directory(): array {
    $groups = [
        'leadership' => [],
        'committee' => [],
        'teaching' => [],
        'administration' => [],
        'non_teaching' => [],
    ];

    $pdo = db();
    if (!$pdo || !db_has_table('staff')) return $groups;

    try {
        $stmt = $pdo->query("SELECT s.*, c.slug AS category_slug, c.name_en AS category_name_en, c.name_np AS category_name_np
            FROM staff s
            LEFT JOIN staff_categories c ON c.id = s.category_id
            WHERE s.is_active = 1
            ORDER BY COALESCE(c.sort_order, 99), s.display_order, s.name_en");
        $rows = $stmt->fetchAll();
    } catch (Throwable $e) {
        error_log('Staff directory read failed: ' . $e->getMessage());
        return $groups;
    }

    foreach ($rows as $person) {
        if (in_array(trim((string)($person['name_en'] ?? '')), ['', '—', '-'], true)
            || in_array(trim((string)($person['name_np'] ?? '')), ['', '—', '-'], true)) {
            continue;
        }
        $slug = (string)($person['category_slug'] ?? '');
        $designation = strtolower(trim((string)($person['designation_en'] ?? '')));
        $isCommittee = $slug === 'committee' || ($slug === 'administration' && preg_match('/committee|smc|chairperson|chairman|member/', $designation));

        if ($slug === 'leadership') $group = 'leadership';
        elseif ($isCommittee) $group = 'committee';
        elseif ($slug === 'teaching') $group = 'teaching';
        elseif ($slug === 'non_teaching') $group = 'non_teaching';
        else $group = 'administration';

        $person['photo_url'] = staff_photo_url($person['photo'] ?? '');
        $groups[$group][] = $person;
    }

    return $groups;
}

function staff_photo_url(?string $photo): string {
    $photo = trim((string)$photo);
    if ($photo === '') return '';
    if (preg_match('#^https?://#i', $photo)) return $photo;
    return media_url($photo);
}

function media_url(?string $path): string {
    $path = trim((string)$path);
    if ($path === '') return '';
    if (preg_match('#^https?://#i', $path)) return $path;
    $path = ltrim($path, '/');
    return base_url(str_starts_with($path, 'uploads/') ? $path : 'uploads/' . $path);
}

function stored_file_url(?string $path): string {
    $path = trim((string)$path);
    if ($path === '') return '';
    if (preg_match('#^https?://#i', $path)) return $path;
    return base_url(ltrim($path, '/'));
}

function format_file_size($bytes): string {
    if ($bytes === null || $bytes === '') return '';
    if (!is_numeric($bytes)) return (string)$bytes;
    $bytes = (float)$bytes;
    if ($bytes < 1024) return (string)(int)$bytes . ' B';
    $units = ['KB', 'MB', 'GB'];
    $value = $bytes;
    foreach ($units as $unit) {
        $value /= 1024;
        if ($value < 1024 || $unit === 'GB') return rtrim(rtrim(number_format($value, 1, '.', ''), '0'), '.') . ' ' . $unit;
    }
    return (string)$bytes . ' B';
}

function staff_initials(?string $name): string {
    $parts = preg_split('/\s+/', trim((string)$name), -1, PREG_SPLIT_NO_EMPTY);
    if (!$parts) return '?';
    $initials = strtoupper(substr($parts[0], 0, 1));
    if (count($parts) > 1) $initials .= strtoupper(substr($parts[count($parts) - 1], 0, 1));
    return $initials;
}

// Security headers helper
function send_security_headers(): void {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}

// Shared-file rate limiting with an exclusive lock so concurrent PHP-FPM workers cannot overwrite counts.
function rate_limit(string $key, int $max = 5, int $window = 60, ?int &$retryAfter = null): bool {
    $retryAfter = 0;
    $dir = (string)env('RATE_LIMIT_DIR', sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sps-rate-limit');
    if (!is_dir($dir) && !@mkdir($dir, 0700, true) && !is_dir($dir)) {
        error_log('Rate limit storage unavailable: ' . $dir);
        return false;
    }

    $file = $dir . DIRECTORY_SEPARATOR . 'sps_rate_' . hash('sha256', $key) . '.json';
    $handle = @fopen($file, 'c+');
    if (!$handle || !@flock($handle, LOCK_EX)) {
        if (is_resource($handle)) @fclose($handle);
        error_log('Rate limit lock unavailable: ' . $file);
        return false;
    }

    $now = time();
    $raw = stream_get_contents($handle);
    $data = json_decode($raw ?: '', true);
    if (!is_array($data) || !isset($data['count'], $data['start']) || $now - (int)$data['start'] >= $window) {
        $data = ['count' => 0, 'start' => $now];
    }
    $data['count']++;
    $allowed = $data['count'] <= $max;
    if (!$allowed) $retryAfter = max(1, $window - ($now - (int)$data['start']));
    rewind($handle);
    ftruncate($handle, 0);
    fwrite($handle, json_encode($data, JSON_THROW_ON_ERROR));
    fflush($handle);
    flock($handle, LOCK_UN);
    fclose($handle);
    return $allowed;
}

function is_logged_in(): bool { return !empty($_SESSION['user_id']); }
function require_login(): void {
    if (!is_logged_in()) { header('Location: ' . base_url('admin/login.php')); exit; }
}
function current_user_role(): string { return $_SESSION['user_role'] ?? 'guest'; }
function has_role(array $roles): bool { return in_array(current_user_role(), $roles, true); }

function can(string $perm): bool {
    $r = current_user_role();
    $map = [
        'super_admin' => ['content', 'staff', 'gallery', 'system', 'users'],
        'school_admin' => ['content', 'staff', 'gallery', 'system'],
        'editor' => ['content', 'staff', 'gallery'],
        'exam_officer' => ['content'],
    ];
    $perms = $map[$r] ?? [];
    return in_array($perm, $perms, true);
}
function require_permission(string $perm): void {
    if (!can($perm)) { http_response_code(403); exit('You do not have permission to access this page.'); }
}
