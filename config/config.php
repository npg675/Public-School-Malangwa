<?php
// Shree Public Secondary School - Central Config
// Malangwa-2, Sarlahi | IEMIS 190640003
declare(strict_types=1);

define('APP_NAME_EN', 'Shree Public Secondary School');
define('APP_NAME_NP', 'श्री पब्लिक माध्यमिक विद्यालय');
define('APP_SUBTITLE', 'Malangwa-2, Sarlahi • Community School');
define('APP_ADDRESS', 'Malangwa-2, Sarlahi, Madhesh Province, Nepal');
define('APP_ADDRESS_NP', 'मलंगवा-२, सर्लाही, मधेश प्रदेश, नेपाल');
define('APP_POSTAL', '45800');
define('APP_IEMIS', '190640003');
define('APP_COORDS_LAT', '26.8501032');
define('APP_COORDS_LNG', '85.555064');
define('APP_PLUS_CODE', 'VH24+22W');
define('APP_MAP_QUERY', APP_COORDS_LAT . ',' . APP_COORDS_LNG);
define('APP_TYPE', 'Public / Community School');
define('APP_LEVEL', 'ECD – Grade 12');
define('APP_PROGRAMS', ['+2 Science', '+2 Management']);

// Placeholders - must be verified by school before publishing
define('APP_PHONE', ''); // e.g. +977-9844032297 pending verification
define('APP_PHONE_DISPLAY', '—'); // shown when empty
define('APP_EMAIL', '');
define('APP_FACEBOOK', '');
define('APP_OFFICE_HOURS', '');

// Display helpers
define('APP_STUDENTS_DISPLAY', '1,000+'); // editable CMS, do not hardcode 1085
define('APP_STUDENTS_EXACT', 1085); // IEMIS 2081/82 exact, internal

// Site
define('BASE_URL', ''); // auto-detect
define('DEFAULT_LANG', 'en'); // en | np
define('TIMEZONE', 'Asia/Kathmandu');

date_default_timezone_set(TIMEZONE);

// Environment
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        if (!str_contains($line, '=')) continue;
        [$k,$v] = explode('=', $line, 2);
        $k = trim($k); $v = trim(trim($v), '"\'');
        if (!getenv($k)) putenv("$k=$v");
        $_ENV[$k] = $v;
    }
}

function env(string $key, $default = null) {
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

function base_url(string $path = ''): string {
    $base = rtrim(env('APP_URL', ''), '/');
    if ($base === '') {
        $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $base = $proto . '://' . $host;
        // if project in subfolder
        $script = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
        if ($script !== '/' && $script !== '\\') $base .= $script;
    }
    // Upgrade to HTTPS if current request is HTTPS (fix mixed content)
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' && str_starts_with($base, 'http://')) {
        $base = 'https://' . substr($base, 7);
    }
    return $base . '/' . ltrim($path, '/');
}

function asset(string $path): string {
    return base_url($path);
}
