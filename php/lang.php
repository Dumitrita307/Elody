<?php
// php/lang.php — versiune corectata pentru XAMPP Windows
// Include cu: require_once 'php/lang.php';   (din radacina proiectului)
// SAU:        require_once '../php/lang.php'; (din subfoldere)

// Porneste sesiunea DOAR daca nu e deja activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Seteaza limba daca vine din URL: ?lang=en / ?lang=ru / ?lang=ro
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ro', 'en', 'ru'])) {
    $_SESSION['limba'] = $_GET['lang'];
    $url = strtok($_SERVER['REQUEST_URI'], '?');
    $params = $_GET;
    unset($params['lang']);
    if (!empty($params)) $url .= '?' . http_build_query($params);
    header('Location: ' . $url);
    exit;
}

// Limba curenta (default: ro)
$limba = $_SESSION['limba'] ?? 'ro';

// Calea catre folderul lang/ — functioneaza indiferent de unde e inclus fisierul
$langDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR;
$langFile = $langDir . $limba . '.php';
$fallback  = $langDir . 'ro.php';

if (file_exists($langFile)) {
    $t = require $langFile;
} elseif (file_exists($fallback)) {
    $t = require $fallback;
} else {
    $t = [];
}

// __t('cheie') — cu escape HTML
function __t(string $key, string $default = ''): string {
    global $t;
    return htmlspecialchars($t[$key] ?? ($default ?: $key), ENT_QUOTES, 'UTF-8');
}

// _t('cheie') — fara escape (pentru placeholder, value etc.)
function _t(string $key, string $default = ''): string {
    global $t;
    return $t[$key] ?? ($default ?: $key);
}// Alias-uri pentru cos.php
function t(string $key, string $default = ''): string {
    global $t;
    // Mapeaza cheile vechi la cele noi
    $map = [
        'cosul_tau'    => 'cos_titlu',
        'acasa'        => 'nav_acasa',
        'despre'       => 'nav_despre',
        'produse'      => 'nav_produse',
        'servicii'     => 'nav_servicii',
        'contact'      => 'nav_contact',
        'cauta'        => 'nav_cauta',
        'profil'       => 'nav_profil',
        'deconectare'  => 'nav_logout',
        'total'        => 'cos_total',
        'cos_gol'      => 'cos_gol',
    ];
    $realKey = $map[$key] ?? $key;
    return htmlspecialchars($t[$realKey] ?? ($default ?: $key), ENT_QUOTES, 'UTF-8');
}