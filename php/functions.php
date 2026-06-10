<?php
/**
 * functions.php - Funcții utilitare pentru Elody Farmacie
 */

// ─── PRODUSE ────────────────────────────────────────────────────────────────

function getProduse(): array {
    $path = __DIR__ . '/../data/produse.json';
    if (!file_exists($path)) return [];
    $json = file_get_contents($path);
    return json_decode($json, true) ?? [];
}

function getProdusByCategorie(string $categorie): array {
    return array_values(array_filter(getProduse(), fn($p) => $p['categorie'] === $categorie));
}

function getProdusById(int $id): ?array {
    foreach (getProduse() as $p) {
        if ($p['id'] === $id) return $p;
    }
    return null;
}

function cautaProduse(string $query): array {
    $query = mb_strtolower(trim($query));
    return array_values(array_filter(getProduse(), function($p) use ($query) {
        return str_contains(mb_strtolower($p['nume']), $query)
            || str_contains(mb_strtolower($p['descriere']), $query)
            || str_contains(mb_strtolower($p['categorie']), $query);
    }));
}

// ─── UTILIZATORI ─────────────────────────────────────────────────────────────

function getUsers(): array {
    $path = __DIR__ . '/../data/users.json';
    if (!file_exists($path)) return [];
    return json_decode(file_get_contents($path), true) ?? [];
}

function saveUsers(array $users): void {
    $path = __DIR__ . '/../data/users.json';
    file_put_contents($path, json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getUserByEmail(string $email): ?array {
    foreach (getUsers() as $u) {
        if ($u['email'] === $email) return $u;
    }
    return null;
}

function getUserById(int $id): ?array {
    foreach (getUsers() as $u) {
        if ($u['id'] === $id) return $u;
    }
    return null;
}

function createUser(string $nume, string $email, string $parola): array|string {
    if (getUserByEmail($email)) return 'Adresa de email este deja înregistrată.';
    $users = getUsers();
    $newId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;
    $user = [
        'id'           => $newId,
        'nume'         => trim($nume),
        'email'        => trim($email),
        'parola_hash'  => password_hash($parola, PASSWORD_BCRYPT),
        'creat_la'     => date('Y-m-d H:i:s'),
        'cos'          => [],
        'favorite'     => [],
        'comenzi'      => []
    ];
    $users[] = $user;
    saveUsers($users);
    return $user;
}

function updateUser(int $id, array $data): bool {
    $users = getUsers();
    foreach ($users as &$u) {
        if ($u['id'] === $id) {
            foreach ($data as $k => $v) {
                if ($k !== 'id') $u[$k] = $v;
            }
            saveUsers($users);
            return true;
        }
    }
    return false;
}

function loginUser(string $email, string $parola): array|string {
    $user = getUserByEmail($email);
    if (!$user) return 'Email sau parolă incorectă.';
    if (!password_verify($parola, $user['parola_hash'])) return 'Email sau parolă incorectă.';
    return $user;
}

// ─── SESIUNE ─────────────────────────────────────────────────────────────────

function startSession(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
}

function isLoggedIn(): bool {
    startSession();
    return isset($_SESSION['user_id']);
}

function getCurrentUser(): ?array {
    if (!isLoggedIn()) return null;
    return getUserById($_SESSION['user_id']);
}

function sessionLogin(array $user): void {
    startSession();
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_nume'] = $user['nume'];
    $_SESSION['user_email']= $user['email'];
}

function sessionLogout(): void {
    startSession();
    session_destroy();
}

// ─── COȘ ─────────────────────────────────────────────────────────────────────

function getCos(): array {
    startSession();
    return $_SESSION['cos'] ?? [];
}

function adaugaInCos(int $produsId, int $cantitate = 1): void {
    startSession();
    $cos = getCos();
    if (isset($cos[$produsId])) {
        $cos[$produsId]['cantitate'] += $cantitate;
    } else {
        $produs = getProdusById($produsId);
        if ($produs) {
            $cos[$produsId] = [
                'id'        => $produsId,
                'cantitate' => $cantitate,
                'produs'    => $produs
            ];
        }
    }
    $_SESSION['cos'] = $cos;
    // Dacă utilizatorul e logat, salvăm și în JSON
    if (isLoggedIn()) {
        updateUser($_SESSION['user_id'], ['cos' => $cos]);
    }
}

function stergedinCos(int $produsId): void {
    startSession();
    $cos = getCos();
    unset($cos[$produsId]);
    $_SESSION['cos'] = $cos;
    if (isLoggedIn()) {
        updateUser($_SESSION['user_id'], ['cos' => $cos]);
    }
}

function updateCantitateCos(int $produsId, int $cantitate): void {
    startSession();
    if ($cantitate <= 0) { stergedinCos($produsId); return; }
    $cos = getCos();
    if (isset($cos[$produsId])) {
        $cos[$produsId]['cantitate'] = $cantitate;
        $_SESSION['cos'] = $cos;
        if (isLoggedIn()) {
            updateUser($_SESSION['user_id'], ['cos' => $cos]);
        }
    }
}

function totalCos(): float {
    $total = 0;
    foreach (getCos() as $item) {
        $total += $item['produs']['pret'] * $item['cantitate'];
    }
    return $total;
}

function numarProduseCos(): int {
    return array_sum(array_column(getCos(), 'cantitate'));
}

// ─── FAVORITE ─────────────────────────────────────────────────────────────────

function getFavorite(): array {
    startSession();
    return $_SESSION['favorite'] ?? [];
}

function adaugaLaFavorite(int $produsId): void {
    startSession();
    $fav = getFavorite();
    if (!in_array($produsId, $fav)) {
        $fav[] = $produsId;
        $_SESSION['favorite'] = $fav;
        if (isLoggedIn()) {
            updateUser($_SESSION['user_id'], ['favorite' => $fav]);
        }
    }
}

function stergedinFavorite(int $produsId): void {
    startSession();
    $fav = array_filter(getFavorite(), fn($id) => $id !== $produsId);
    $_SESSION['favorite'] = array_values($fav);
    if (isLoggedIn()) {
        updateUser($_SESSION['user_id'], ['favorite' => array_values($fav)]);
    }
}

function esteInFavorite(int $produsId): bool {
    return in_array($produsId, getFavorite());
}

function numarFavorite(): int {
    return count(getFavorite());
}

// ─── UTILITARE ────────────────────────────────────────────────────────────────

function redirect(string $url): never {
    header("Location: $url");
    exit;
}

function sanitize(string $val): string {
    return htmlspecialchars(strip_tags(trim($val)));
}

function formatPret(float $pret): string {
    return number_format($pret, 2, '.', ',') . ' lei';
}

function setCategorieLabel(string $slug): string {
    return match($slug) {
        'medicamente' => 'Medicamente',
        'vitamine'    => 'Vitamine și suplimente',
        'ingrijire'   => 'Îngrijire personală',
        'mama'        => 'Mama și copilul',
        'naturiste'   => 'Produse naturiste',
        default       => ucfirst($slug)
    };
}

function setCategorieDescriere(string $slug): string {
    return match($slug) {
        'medicamente' => 'Medicamente pentru diverse afecțiuni',
        'vitamine'    => 'Vitamine și suplimente pentru sănătate și imunitate',
        'ingrijire'   => 'Produse de frumusețe și îngrijire personală',
        'mama'        => 'Produse de grijă pentru mame și copii',
        'naturiste'   => 'Produse naturale pe bază de plante',
        default       => ''
    };
}

function setCategorieIcon(string $slug): string {
    return match($slug) {
        'medicamente' => '💊',
        'vitamine'    => '🍊',
        'ingrijire'   => '🧴',
        'mama'        => '👶',
        'naturiste'   => '🌿',
        default       => '📦'
    };
}