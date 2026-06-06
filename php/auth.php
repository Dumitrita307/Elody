<?php
session_start();

$action = $_POST['action'] ?? '';
$DB     = __DIR__ . '/../data/users.json';

function load_users(string $file): array {
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?? [];
}

function save_users(string $file, array $users): bool {
    return file_put_contents(
        $file,
        json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    ) !== false;
}

function err(string $msg, string $tab = 'login'): void {
    header('Location: ../login.php?tab=' . $tab . '&error=' . urlencode($msg));
    exit;
}

function ok(string $msg = ''): void {
    $q = $msg ? '?success=' . urlencode($msg) : '';
    header('Location: ../index.php' . $q);
    exit;
}

// ════════════════════════════════════════
// LOGIN
// ════════════════════════════════════════

if ($action === 'login') {
    $email    = trim(strtolower($_POST['email']    ?? ''));
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) err('Completează toate câmpurile.', 'login');

    $users = load_users($DB);
    $found = null;
    foreach ($users as $u) {
        if ($u['email'] === $email) { $found = $u; break; }
    }

    if (!$found || !password_verify($password, $found['password'])) {
        err('Email sau parolă incorecte.', 'login');
    }

    $_SESSION['user']       = $found['first_name'] . ' ' . $found['last_name'];
    $_SESSION['user_id']    = $found['id'];
    $_SESSION['user_email'] = $found['email'];
    ok();
}

// ════════════════════════════════════════
// REGISTER
// ════════════════════════════════════════

if ($action === 'register') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name']  ?? '');
    $email      = trim(strtolower($_POST['email'] ?? ''));
    $phone      = trim($_POST['phone']      ?? '');
    $password   = $_POST['password']        ?? '';
    $confirm    = $_POST['password_confirm'] ?? '';

    if (!$first_name || !$last_name)
        err('Completează numele și prenumele.', 'register');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        err('Adresa de email nu este validă.', 'register');
    if (!preg_match('/^[0-9\s]{7,12}$/', $phone))
        err('Numărul de telefon nu este valid.', 'register');
    if (strlen($password) < 6)
        err('Parola trebuie să aibă cel puțin 6 caractere.', 'register');
    if ($password !== $confirm)
        err('Parolele nu coincid.', 'register');

    $users = load_users($DB);
    foreach ($users as $u) {
        if ($u['email'] === $email)
            err('Acest email este deja înregistrat.', 'register');
    }

    $new = [
        'id'         => uniqid('usr_', true),
        'first_name' => $first_name,
        'last_name'  => $last_name,
        'email'      => $email,
        'phone'      => '+373 ' . $phone,
        'password'   => password_hash($password, PASSWORD_BCRYPT),
        'created_at' => date('Y-m-d H:i:s'),
    ];

    $users[] = $new;
    if (!save_users($DB, $users))
        err('Eroare la salvare. Încearcă din nou.', 'register');

    $_SESSION['user']       = $first_name . ' ' . $last_name;
    $_SESSION['user_id']    = $new['id'];
    $_SESSION['user_email'] = $email;

    ok('Cont creat cu succes! Bine ai venit, ' . $first_name . '!');
}

header('Location: ../login.php');
exit;