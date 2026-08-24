<?php
require_once __DIR__ . '/../includes/helpers.php';
require_login();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'POST required']);
    exit;
}

$allowed = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
    'application/pdf' => 'pdf',
    'application/msword' => 'docx',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
    'application/vnd.ms-excel' => 'xlsx',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
];

$maxSize = 10 * 1024 * 1024; // 10MB

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
    echo json_encode(['ok' => false, 'error' => 'File too large (max 10MB)']);
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!isset($allowed[$mime])) {
    echo json_encode(['ok' => false, 'error' => 'File type not allowed: ' . $mime]);
    exit;
}

$ext = $allowed[$mime];
$dir = __DIR__ . '/../uploads';

// Determine subdirectory from POST or default to root
$subdir = trim($_POST['subdir'] ?? '', '/');
if ($subdir) {
    $targetDir = $dir . '/' . $subdir;
} else {
    $targetDir = $dir;
}

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$name = bin2hex(random_bytes(8)) . '.' . $ext;
$target = $targetDir . '/' . $name;

if (!move_uploaded_file($file['tmp_name'], $target)) {
    echo json_encode(['ok' => false, 'error' => 'Failed to save file']);
    exit;
}

$relativePath = 'uploads/' . ($subdir ? $subdir . '/' : '') . $name;

echo json_encode([
    'ok' => true,
    'path' => $relativePath,
    'filename' => $name,
    'original' => $file['name'],
    'size' => $file['size'],
    'type' => $ext,
]);
