<?php
// php/save_profil.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../schimba-profil.php');
    exit;
}

$dbFile = __DIR__ . '/../data/users.json';
$users  = file_exists($dbFile) ? json_decode(file_get_contents($dbFile), true) : [];

// Sanitizare input
function san($v) { return htmlspecialchars(strip_tags(trim($v ?? '')), ENT_QUOTES, 'UTF-8'); }

$firstName = san($_POST['first_name'] ?? '');
$lastName  = san($_POST['last_name']  ?? '');
$phone     = san($_POST['phone']      ?? '');
$birthday  = san($_POST['birthday']   ?? '');
$gender    = in_array($_POST['gender'] ?? '', ['masculin','feminin','altul']) ? $_POST['gender'] : '';
$bio       = san($_POST['bio']        ?? '');

// Adresă
$street = san($_POST['street'] ?? '');
$city   = san($_POST['city']   ?? '');
$zip    = san($_POST['zip']    ?? '');

// Schimbare parolă (opțional)
$parolaVeche  = $_POST['parola_veche']  ?? '';
$parolaNoua   = $_POST['parola_noua']   ?? '';
$parolaConfirm= $_POST['parola_confirm']?? '';

$errors = [];

// Validare parolă dacă s-a completat
if (!empty($parolaNoua)) {
    if (strlen($parolaNoua) < 6) {
        $errors[] = 'Parola nouă trebuie să aibă minim 6 caractere.';
    }
    if ($parolaNoua !== $parolaConfirm) {
        $errors[] = 'Parolele noi nu coincid.';
    }
}

if (!empty($errors)) {
    header('Location: ../schimba-profil.php?error=' . urlencode(implode(' ', $errors)));
    exit;
}

// Actualizează datele
foreach ($users as &$u) {
    if ($u['id'] === $_SESSION['user_id']) {
        $u['first_name'] = $firstName;
        $u['last_name']  = $lastName;
        $u['phone']      = $phone;
        $u['birthday']   = $birthday;
        $u['gender']     = $gender;
        $u['bio']        = $bio;
        $u['address']    = [
            'street' => $street,
            'city'   => $city,
            'zip'    => $zip,
        ];
        // Schimbă parola dacă s-a cerut
        if (!empty($parolaNoua)) {
            // Verifică parola veche
            if (!password_verify($parolaVeche, $u['parola_hash'] ?? '')) {
                header('Location: ../schimba-profil.php?error=' . urlencode('Parola actuală este incorectă.'));
                exit;
            }
            $u['parola_hash'] = password_hash($parolaNoua, PASSWORD_BCRYPT);
        }
        // Actualizează sesiunea
        $_SESSION['user']       = $firstName . ' ' . $lastName;
        $_SESSION['user_email'] = $u['email'];
        break;
    }
}

file_put_contents($dbFile, json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
header('Location: ../profil.php?success=' . urlencode('Profilul a fost actualizat cu succes!'));
exit;
