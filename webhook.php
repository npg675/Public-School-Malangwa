<?php
declare(strict_types=1);
// sps_school — GitHub webhook → cPanel deploy
// Deploy to: ~/repositories/sps_school → ~/public_html via deploy.sh
// Set secret in cPanel File Manager (edit this file) to match GitHub webhook secret.

$secret = getenv('WEBHOOK_SECRET') ?: 'change_me_in_cpanel_file_manager';

// Only POST from GitHub
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'POST required']);
    exit;
}

$sig = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$payload = file_get_contents('php://input');

if ($sig === '' || $payload === false) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'missing signature']);
    exit;
}

[$algo, $hash] = explode('=', $sig, 2) + [null, null];
$expected = hash_hmac('sha256', $payload, $secret);
if ($algo !== 'sha256' || !hash_equals($expected, (string)$hash)) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'bad signature']);
    exit;
}

// Optional: only deploy on push to production branch (uncomment if needed)
// $data = json_decode($payload, true);
// $ref = $data['ref'] ?? '';
// if ($ref !== 'refs/heads/main') {
//     header('Content-Type: application/json');
//     echo json_encode(['ok' => true, 'ignored' => true, 'ref' => $ref]);
//     exit;
// }

// HOME is not set in PHP shell_exec on cPanel — export explicitly.
// Replace /home/USERNAME with real cPanel home if different (check cPanel → File Manager path).
$home = getenv('HOME') ?: ($_SERVER['HOME'] ?? '');
if ($home === '' || $home === '/') {
    // Fallback: derive from this file's path (/home/USER/public_html/webhook.php)
    $home = dirname(dirname(__DIR__));
}
$home = rtrim($home, '/');
if (!is_dir($home)) {
    $home = '/home/' . basename($home);
}

$repo = $home . '/repositories/sps_school';
$cmd = sprintf(
    'export HOME=%s && cd %s && bash deploy.sh 2>&1',
    escapeshellarg($home),
    escapeshellarg($repo)
);

$log = shell_exec($cmd . ' 2>&1');
$ok = $log !== null && str_contains((string)$log, 'Deployed');

header('Content-Type: application/json');
echo json_encode([
    'ok'     => $ok,
    'output' => $log ?? 'no output (check HOME/SSH key)',
    'home'   => $home,
]);
