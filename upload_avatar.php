<?php
// php/upload_avatar.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['avatar'])) {
    header('Location: ../profil.php?error=Niciun fișier selectat.');
    exit;
}

$file    = $_FILES['avatar'];
$maxSize = 3 * 1024 * 1024; // 3MB
$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// Validări
if ($file['error'] !== UPLOAD_ERR_OK) {
    header('Location: ../profil.php?error=Eroare la upload.');
    exit;
}
if ($file['size'] > $maxSize) {
    header('Location: ../profil.php?error=Poza nu trebuie să depășească 3MB.');
    exit;
}

$finfo    = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowed)) {
    header('Location: ../profil.php?error=Format acceptat: JPG, PNG, GIF, WEBP.');
    exit;
}

// Crează folderul uploads dacă nu există
$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Șterge avatarul vechi
$dbFile = __DIR__ . '/../data/users.json';
$users  = file_exists($dbFile) ? json_decode(file_get_contents($dbFile), true) : [];
foreach ($users as $u) {
    if ($u['id'] === $_SESSION['user_id'] && !empty($u['avatar'])) {
        $oldFile = $uploadDir . $u['avatar'];
        if (file_exists($oldFile)) unlink($oldFile);
        break;
    }
}

// Salvează fișierul nou
$ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . strtolower($ext);
$destPath = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    header('Location: ../profil.php?error=Nu s-a putut salva fișierul.');
    exit;
}

// Actualizează users.json
foreach ($users as &$u) {
    if ($u['id'] === $_SESSION['user_id']) {
        $u['avatar'] = $filename;
        break;
    }
}
file_put_contents($dbFile, json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Location: ../profil.php?success=Poza de profil a fost actualizată!');
exit;
