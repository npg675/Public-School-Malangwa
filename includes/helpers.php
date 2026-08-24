<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

session_start();

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

// settings fallback - reads site_settings table if exists else defaults
function setting(string $key, $fallback = '') {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        $pdo = db();
        if ($pdo && db_has_table('site_settings')) {
            try {
                $rows = $pdo->query('SELECT `key`,`value` FROM site_settings')->fetchAll();
                foreach ($rows as $r) $cache[$r['key']] = $r['value'];
            } catch (Throwable $e) {}
        }
    }
    return $cache[$key] ?? $fallback;
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
            if ($rows) return $rows;
        } catch (Throwable $e) {}
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

function get_events(int $limit = 3): array {
    $pdo = db();
    if ($pdo && db_has_table('events')) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM events WHERE status='published' AND event_date >= CURDATE() ORDER BY event_date ASC LIMIT :lim");
            $stmt->bindValue(':lim',$limit,PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if ($rows) return $rows;
        } catch (Throwable $e) {}
    }
    return [
        ['title_en'=>'16-Day Campaign Against Gender-Based Violence','title_np'=>'लैङ्गिक हिंसा विरुद्ध १६ दिने अभियान','event_date'=>'2025-11-25','location_en'=>'Shree Public Secondary School, Malangwa-2','category'=>'Community','summary_en'=>'Inaugurated with Malangwa Municipality, INSEC and local groups.'],
        ['title_en'=>'Annual Sports Meet 2082','title_np'=>'वार्षिक खेलकुद प्रतियोगिता २०८२','event_date'=>'2026-02-15','location_en'=>'School Ground','category'=>'Sports','summary_en'=>'Inter-house competitions — athletics, volleyball, cultural programs. (Sample)'],
        ['title_en'=>'Science Exhibition','title_np'=>'विज्ञान प्रदर्शनी','event_date'=>'2026-01-20','location_en'=>'School Hall','category'=>'Academic','summary_en'=>'Students present science models and experiments. (Sample)'],
    ];
}

function get_downloads(int $limit = 6): array {
    $pdo = db();
    if ($pdo && db_has_table('downloads')) {
        try {
            $stmt = $pdo->prepare("SELECT d.*, c.name_en as cat_en FROM downloads d LEFT JOIN download_categories c ON c.id=d.category_id WHERE d.status='published' ORDER BY d.published_at DESC LIMIT :lim");
            $stmt->bindValue(':lim',$limit,PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if ($rows) return $rows;
        } catch (Throwable $e) {}
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

function get_news(int $limit = 6): array {
    $pdo = db();
    if ($pdo && db_has_table('news')) {
        try {
            $stmt = $pdo->prepare("SELECT n.*, c.name_en AS cat_en, c.name_np AS cat_np FROM news n LEFT JOIN news_categories c ON c.id=n.category_id WHERE n.status='published' ORDER BY n.published_at DESC LIMIT :lim");
            $stmt->bindValue(':lim',$limit,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Throwable $e) {}
    }
    return [];
}

function get_gallery_albums(int $limit = 6): array {
    $pdo = db();
    if ($pdo && db_has_table('gallery_albums')) {
        try {
            $stmt = $pdo->prepare("SELECT slug, title_en, title_np, cover_image, description_en FROM gallery_albums WHERE status='published' ORDER BY sort_order, title_en LIMIT :lim");
            $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if ($rows) {
                foreach ($rows as &$r) {
                    $r['cover'] = $r['cover_image'] ? base_url($r['cover_image']) : '';
                }
                return $rows;
            }
        } catch (Throwable $e) {}
    }
    // Fallback: real school photos
    return [
        ['slug'=>'campus','title_en'=>'Campus','title_np'=>'विद्यालय परिसर','cover'=>base_url('uploads/gallery/campus/courtyard-students-formation.jpg'),'count'=>6],
        ['slug'=>'assembly','title_en'=>'Assembly & Events','title_np'=>'सभा र कार्यक्रम','cover'=>base_url('uploads/gallery/assembly/teacher-addressing-assembly.jpg'),'count'=>3],
        ['slug'=>'staff','title_en'=>'Staff & Leadership','title_np'=>'कर्मचारी र नेतृत्व','cover'=>base_url('uploads/gallery/staff/leadership-team-photo.jpg'),'count'=>1],
        ['slug'=>'community','title_en'=>'Community Programs','title_np'=>'समुदाय कार्यक्रम','cover'=>base_url('uploads/gallery/community/complaint-box-life-nepal.jpg'),'count'=>1],
    ];
}

// Security headers helper
function send_security_headers(): void {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}

// Rate limiting (simple file-based)
function rate_limit(string $key, int $max = 5, int $window = 60): bool {
    $dir = sys_get_temp_dir();
    $file = $dir . '/sps_rate_' . md5($key);
    $now = time();
    $data = @json_decode(@file_get_contents($file), true) ?: ['count'=>0,'start'=>$now];
    if ($now - $data['start'] > $window) { $data = ['count'=>0,'start'=>$now]; }
    $data['count']++;
    @file_put_contents($file, json_encode($data));
    return $data['count'] <= $max;
}

function is_logged_in(): bool { return !empty($_SESSION['user_id']); }
function require_login(): void {
    if (!is_logged_in()) { header('Location: ' . base_url('admin/login.php')); exit; }
}
function current_user_role(): string { return $_SESSION['user_role'] ?? 'guest'; }
function has_role(array $roles): bool { return in_array(current_user_role(), $roles, true); }
