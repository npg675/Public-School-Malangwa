<?php
require_once __DIR__ . '/../includes/helpers.php';
require_login();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'POST required']);
    exit;
}

if (!csrf_verify($_POST['_csrf'] ?? '')) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'Invalid session']);
    exit;
}

$raw = $_POST['ids'] ?? '';
$ids = array_values(array_filter(array_map('intval', explode(',', $raw)), fn($v) => $v > 0));
if (empty($ids)) {
    echo json_encode(['ok' => false, 'error' => 'No album ids provided']);
    exit;
}

try {
    $pdo = db();
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('UPDATE gallery_albums SET sort_order = ? WHERE id = ?');
    foreach ($ids as $i => $id) {
        $stmt->execute([$i + 1, $id]);
    }
    $pdo->commit();
    echo json_encode(['ok' => true, 'count' => count($ids)]);
} catch (Throwable $e) {
    error_log('Album reorder failed: ' . $e->getMessage());
    echo json_encode(['ok' => false, 'error' => 'Reorder failed']);
    exit;
}
