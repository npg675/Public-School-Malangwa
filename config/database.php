<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

function db(): ?PDO {
    static $pdo = null;
    static $tried = false;
    if ($tried) return $pdo;
    $tried = true;

    $host = env('DB_HOST', '127.0.0.1');
    $port = env('DB_PORT', '3306');
    $name = env('DB_NAME', 'sps_malangwa');
    $user = env('DB_USER', 'root');
    $pass = env('DB_PASS', '');
    $charset = 'utf8mb4';

    // Allow disabling DB for static demo
    if (env('DB_DISABLED', '0') === '1') return null;

    $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";
    $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $opts);
        return $pdo;
    } catch (Throwable $e) {
        // fail silently for public site, log if possible
        error_log('DB connection failed: ' . $e->getMessage());
        $pdo = null;
        return null;
    }
}

function db_has_table(string $table): bool {
    $pdo = db();
    if (!$pdo) return false;
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE " . $pdo->quote($table));
        return $stmt && $stmt->rowCount() > 0;
    } catch (Throwable $e) { return false; }
}
