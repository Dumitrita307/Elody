<?php
/**
 * save_date.php - Procesează toate acțiunile POST/AJAX pentru Elody
 * Acțiuni: cos_adauga, cos_sterge, cos_update, favorit_toggle, comanda_plaseaza
 */

session_start();
require_once __DIR__ . '/functions.php';

header('Content-Type: application/json; charset=utf-8');

$actiune = $_POST['actiune'] ?? $_GET['actiune'] ?? '';

switch ($actiune) {

    // ── COȘ ──────────────────────────────────────────────────────────────────

    case 'cos_adauga':
        $id        = (int)($_POST['produs_id'] ?? 0);
        $cantitate = max(1, (int)($_POST['cantitate'] ?? 1));
        if (!$id) { echo json_encode(['succes' => false, 'mesaj' => 'ID produs invalid.']); exit; }
        $produs = getProdusById($id);
        if (!$produs) { echo json_encode(['succes' => false, 'mesaj' => 'Produsul nu există.']); exit; }
        adaugaInCos($id, $cantitate);
        echo json_encode([
            'succes'      => true,
            'mesaj'       => 'Produs adăugat în coș!',
            'numar_cos'   => numarProduseCos(),
            'total_cos'   => formatPret(totalCos())
        ]);
        break;

    case 'cos_sterge':
        $id = (int)($_POST['produs_id'] ?? 0);
        if (!$id) { echo json_encode(['succes' => false, 'mesaj' => 'ID invalid.']); exit; }
        stergedinCos($id);
        echo json_encode([
            'succes'    => true,
            'mesaj'     => 'Produs eliminat din coș.',
            'numar_cos' => numarProduseCos(),
            'total_cos' => formatPret(totalCos())
        ]);
        break;

    case 'cos_update':
        $id        = (int)($_POST['produs_id'] ?? 0);
        $cantitate = (int)($_POST['cantitate'] ?? 0);
        if (!$id) { echo json_encode(['succes' => false, 'mesaj' => 'ID invalid.']); exit; }
        updateCantitateCos($id, $cantitate);
        $cos   = getCos();
        $item  = $cos[$id] ?? null;
        $subtotal = $item ? formatPret($item['produs']['pret'] * $item['cantitate']) : '0.00 lei';
        echo json_encode([
            'succes'    => true,
            'subtotal'  => $subtotal,
            'numar_cos' => numarProduseCos(),
            'total_cos' => formatPret(totalCos())
        ]);
        break;

    case 'cos_golire':
        startSession();
        $_SESSION['cos'] = [];
        if (isLoggedIn()) updateUser($_SESSION['user_id'], ['cos' => []]);
        echo json_encode(['succes' => true, 'mesaj' => 'Coșul a fost golit.']);
        break;

    // ── FAVORITE ─────────────────────────────────────────────────────────────

    case 'favorit_toggle':
        $id = (int)($_POST['produs_id'] ?? 0);
        if (!$id) { echo json_encode(['succes' => false, 'mesaj' => 'ID invalid.']); exit; }
        if (esteInFavorite($id)) {
            stergedinFavorite($id);
            $status = false;
            $mesaj  = 'Eliminat din favorite.';
        } else {
            adaugaLaFavorite($id);
            $status = true;
            $mesaj  = 'Adăugat la favorite!';
        }
        echo json_encode([
            'succes'         => true,
            'in_favorite'    => $status,
            'mesaj'          => $mesaj,
            'numar_favorite' => numarFavorite()
        ]);
        break;

    // ── COMANDĂ ──────────────────────────────────────────────────────────────

    case 'comanda_plaseaza':
        if (!isLoggedIn()) {
            echo json_encode(['succes' => false, 'mesaj' => 'Trebuie să fii autentificat pentru a plasa o comandă.']);
            exit;
        }
        $cos = getCos();
        if (empty($cos)) {
            echo json_encode(['succes' => false, 'mesaj' => 'Coșul tău este gol.']);
            exit;
        }
        $user = getCurrentUser();
        $comanda = [
            'id'         => uniqid('CMD_', true),
            'data'       => date('Y-m-d H:i:s'),
            'produse'    => $cos,
            'total'      => totalCos(),
            'status'     => 'În procesare',
            'adresa'     => sanitize($_POST['adresa'] ?? ''),
            'telefon'    => sanitize($_POST['telefon'] ?? '')
        ];
        $comenzi = $user['comenzi'] ?? [];
        $comenzi[] = $comanda;
        updateUser($user['id'], ['comenzi' => $comenzi, 'cos' => []]);
        $_SESSION['cos'] = [];
        echo json_encode([
            'succes'     => true,
            'mesaj'      => 'Comanda a fost plasată cu succes! ID: ' . $comanda['id'],
            'comanda_id' => $comanda['id']
        ]);
        break;

    // ── PRODUSE CAUTARE ───────────────────────────────────────────────────────

    case 'cauta_produse':
        $query = sanitize($_GET['q'] ?? '');
        if (strlen($query) < 2) {
            echo json_encode(['succes' => true, 'produse' => []]);
            exit;
        }
        $produse = cautaProduse($query);
        $rezultat = array_slice(array_map(fn($p) => [
            'id'    => $p['id'],
            'nume'  => $p['nume'],
            'pret'  => formatPret($p['pret']),
            'icon'  => $p['imagine'],
            'url'   => '/php/produs.php?id=' . $p['id']
        ], $produse), 0, 8);
        echo json_encode(['succes' => true, 'produse' => $rezultat]);
        break;

    // ── GET STATUS ────────────────────────────────────────────────────────────

    case 'get_status':
        echo json_encode([
            'succes'         => true,
            'logat'          => isLoggedIn(),
            'numar_cos'      => numarProduseCos(),
            'numar_favorite' => numarFavorite(),
            'total_cos'      => formatPret(totalCos())
        ]);
        break;

    default:
        echo json_encode(['succes' => false, 'mesaj' => 'Acțiune necunoscută: ' . htmlspecialchars($actiune)]);
}