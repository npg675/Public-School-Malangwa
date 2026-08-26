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

$allowed = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
    'application/pdf' => 'pdf',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
];

$maxSize = 8 * 1024 * 1024;

if (empty($_FILES['file'])) {
    echo json_encode(['ok' => false, 'error' => 'No file uploaded']);
    exit;
}

$file = $_FILES['file'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['ok' => false, 'error' => 'Upload error: ' . $file['error']]);
    exit;
}

if ($file['size'] > $maxSize) {
    echo json_encode(['ok' => false, 'error' => 'File too large (max 8MB)']);
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = $finfo ? finfo_file($finfo, $file['tmp_name']) : false;
if ($finfo) finfo_close($finfo);

if (!$mime || !isset($allowed[$mime])) {
    echo json_encode(['ok' => false, 'error' => 'File type not allowed: ' . $mime]);
    exit;
}

$ext = $allowed[$mime];
$dir = __DIR__ . '/../uploads';

// Determine subdirectory from POST or default to root
$subdir = trim($_POST['subdir'] ?? '', '/');
if ($subdir !== '' && !preg_match('/^[A-Za-z0-9_-]+(?:\/[A-Za-z0-9_-]+)*$/', $subdir)) {
    echo json_encode(['ok' => false, 'error' => 'Invalid upload folder']);
    exit;
}
if ($subdir) {
    $targetDir = $dir . '/' . $subdir;
} else {
    $targetDir = $dir;
}

if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
    echo json_encode(['ok' => false, 'error' => 'Upload folder is not writable']);
    exit;
}

$name = bin2hex(random_bytes(8)) . '.' . $ext;
$target = $targetDir . '/' . $name;

if (!move_uploaded_file($file['tmp_name'], $target)) {
    echo json_encode(['ok' => false, 'error' => 'Failed to save file']);
    exit;
}

@chmod($target, 0644);

$relativePath = 'uploads/' . ($subdir ? $subdir . '/' : '') . $name;

echo json_encode([
    'ok' => true,
    'path' => $relativePath,
    'filename' => $name,
    'original' => $file['name'],
    'size' => $file['size'],
    'type' => $ext,
]);
