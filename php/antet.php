<?php
// includes/header.php
require_once __DIR__ . '/../php/functions.php';
startSession();
$user        = getCurrentUser();
$numarCos    = numarProduseCos();
$numarFav    = numarFavorite();
$paginaCurenta = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titluPagina ?? 'Elody Farmacie' ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/produse.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #fff; color: #222; }
        :root {
            --pink: #e91e63;
            --pink-light: #fce4ec;
            --pink-mid: #f48fb1;
            --dark: #222;
            --gray: #888;
            --border: #f0f0f0;
            --radius: 16px;
        }

        /* NAVBAR */
        .navbar {
            position: sticky; top: 0; z-index: 1000;
            background: #fff;
            box-shadow: 0 2px 16px rgba(0,0,0,.07);
            padding: .9rem 2rem;
            display: flex; align-items: center; gap: 2rem;
        }
        .navbar-brand {
            font-size: 1.6rem; font-weight: 800;
            color: var(--pink); text-decoration: none;
            letter-spacing: -1px;
        }
        .navbar-brand span { color: var(--dark); }
        .navbar-nav {
            display: flex; align-items: center; gap: .5rem;
            list-style: none; margin: 0; flex: 1;
        }
        .navbar-nav a {
            padding: .5rem .9rem;
            border-radius: 10px;
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            font-size: .95rem;
            transition: background .15s, color .15s;
        }
        .navbar-nav a:hover, .navbar-nav a.activ {
            background: var(--pink-light);
            color: var(--pink);
        }
        .navbar-actions {
            display: flex; align-items: center; gap: .75rem;
        }
        .search-wrap {
            position: relative;
        }
        .search-wrap input {
            padding: .55rem 2.5rem .55rem 1rem;
            border: 2px solid var(--border);
            border-radius: 50px;
            font-size: .9rem;
            width: 220px;
            transition: border-color .2s, width .3s;
            background: #fafafa;
        }
        .search-wrap input:focus {
            outline: none; border-color: var(--pink);
            width: 280px; background: #fff;
        }
        .search-wrap .search-icon {
            position: absolute; right: .75rem; top: 50%;
            transform: translateY(-50%);
            color: var(--gray); font-size: 1rem; pointer-events: none;
        }
        .search-results {
            position: absolute; top: calc(100% + 6px); left: 0;
            background: #fff; border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0,0,0,.12);
            width: 100%; min-width: 280px;
            display: none; z-index: 9999;
            overflow: hidden;
        }
        .search-result-item {
            display: flex; align-items: center; gap: .75rem;
            padding: .8rem 1rem; text-decoration: none; color: var(--dark);
            transition: background .15s;
            border-bottom: 1px solid var(--border);
        }
        .search-result-item:hover { background: var(--pink-light); }
        .search-result-item .icon { font-size: 1.5rem; }
        .search-result-item .info .name { font-weight: 600; font-size: .9rem; }
        .search-result-item .info .price { color: var(--pink); font-size: .82rem; }
        .btn-icon {
            position: relative;
            background: var(--pink-light);
            border: none; border-radius: 12px;
            width: 42px; height: 42px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 1.2rem;
            text-decoration: none; color: var(--dark);
            transition: background .15s, transform .15s;
        }
        .btn-icon:hover { background: #f8bbd9; transform: scale(1.05); }
        .badge {
            position: absolute; top: -6px; right: -6px;
            background: var(--pink); color: #fff;
            border-radius: 50%; width: 18px; height: 18px;
            font-size: .65rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .btn-user {
            background: var(--pink);
            color: #fff; border: none; border-radius: 50px;
            padding: .5rem 1.2rem; cursor: pointer;
            font-weight: 600; font-size: .9rem;
            text-decoration: none;
            display: flex; align-items: center; gap: .4rem;
        }
        .btn-user:hover { background: #c2185b; }

        /* TOAST */
        .toast-container {
            position: fixed; bottom: 2rem; right: 2rem;
            z-index: 9999; display: flex; flex-direction: column; gap: .5rem;
        }
        .toast {
            background: #222; color: #fff;
            padding: .85rem 1.4rem; border-radius: 12px;
            font-size: .9rem; font-weight: 500;
            animation: slideIn .3s ease;
            display: flex; align-items: center; gap: .6rem;
        }
        .toast.succes { background: #2e7d32; }
        .toast.eroare { background: #c62828; }
        @keyframes slideIn {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>
<nav class="navbar">
    <a href="/index.php" class="navbar-brand">El<span>ody</span> 🌸</a>
    <ul class="navbar-nav">
        <li><a href="/index.php" class="<?= $paginaCurenta==='index.php'?'activ':'' ?>">Acasă</a></li>
        <li><a href="/despre.php" class="<?= $paginaCurenta==='despre.php'?'activ':'' ?>">Despre noi</a></li>
        <li class="dropdown" style="position:relative">
            <a href="#" style="display:flex;align-items:center;gap:.3rem"
               onclick="this.parentElement.querySelector('.dropdown-menu').classList.toggle('open');return false">
                Produse ▾
            </a>
            <div class="dropdown-menu" style="
                display:none; position:absolute; top:100%; left:0;
                background:#fff; border-radius:14px; min-width:220px;
                box-shadow:0 8px 30px rgba(0,0,0,.12); padding:.5rem;
                z-index:999;
            ">
                <a href="/php/medicamente.php" style="display:block;padding:.65rem 1rem;border-radius:10px;text-decoration:none;color:#222;font-size:.9rem" onmouseover="this.style.background='#fce4ec'" onmouseout="this.style.background=''">💊 Medicamente</a>
                <a href="/php/vitamine.php" style="display:block;padding:.65rem 1rem;border-radius:10px;text-decoration:none;color:#222;font-size:.9rem" onmouseover="this.style.background='#fce4ec'" onmouseout="this.style.background=''">🍊 Vitamine & Suplimente</a>
                <a href="/php/ingrijire.php" style="display:block;padding:.65rem 1rem;border-radius:10px;text-decoration:none;color:#222;font-size:.9rem" onmouseover="this.style.background='#fce4ec'" onmouseout="this.style.background=''">🧴 Îngrijire Personală</a>
                <a href="/php/mama.php" style="display:block;padding:.65rem 1rem;border-radius:10px;text-decoration:none;color:#222;font-size:.9rem" onmouseover="this.style.background='#fce4ec'" onmouseout="this.style.background=''">👶 Mama și Copilul</a>
                <a href="/php/naturiste.php" style="display:block;padding:.65rem 1rem;border-radius:10px;text-decoration:none;color:#222;font-size:.9rem" onmouseover="this.style.background='#fce4ec'" onmouseout="this.style.background=''">🌿 Produse Naturiste</a>
            </div>
        </li>
        <li><a href="/servicii.php">Servicii</a></li>
        <li><a href="/contact.php">Contact</a></li>
    </ul>
    <div class="navbar-actions">
        <div class="search-wrap">
            <input type="text" id="searchInput" placeholder="Caută produse..." autocomplete="off">
            <span class="search-icon">🔍</span>
            <div class="search-results" id="searchResults"></div>
        </div>
        <a href="/php/favorite.php" class="btn-icon" title="Favorite">
            ❤️
            <span class="badge" id="badgeFav"><?= $numarFav > 0 ? $numarFav : '' ?></span>
        </a>
        <a href="/php/cos.php" class="btn-icon" title="Coș">
            🛒
            <span class="badge" id="badgeCos"><?= $numarCos > 0 ? $numarCos : '' ?></span>
        </a>
        <?php if ($user): ?>
            <a href="/php/dashboard.php" class="btn-user">👤 <?= htmlspecialchars(explode(' ', $user['nume'])[0]) ?></a>
        <?php else: ?>
            <a href="/login.php" class="btn-user">Autentificare</a>
        <?php endif; ?>
    </div>
</nav>
<div class="toast-container" id="toastContainer"></div>
<script>
// Search live
const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');
let searchTimer;
searchInput?.addEventListener('input', function() {
    clearTimeout(searchTimer);
    if (this.value.length < 2) { searchResults.style.display='none'; return; }
    searchTimer = setTimeout(async () => {
        const r = await fetch('/php/save_date.php?actiune=cauta_produse&q='+encodeURIComponent(this.value));
        const d = await r.json();
        if (!d.produse.length) { searchResults.style.display='none'; return; }
        searchResults.innerHTML = d.produse.map(p =>
            `<a href="${p.url}" class="search-result-item">
                <span class="icon">${p.icon}</span>
                <span class="info"><span class="name">${p.nume}</span><br><span class="price">${p.pret}</span></span>
            </a>`
        ).join('');
        searchResults.style.display='block';
    }, 300);
});
document.addEventListener('click', e => {
    if (!e.target.closest('.search-wrap')) searchResults.style.display='none';
});

// Toast helper
function toast(msg, tip='succes') {
    const t = document.createElement('div');
    t.className = `toast ${tip}`;
    t.innerHTML = (tip==='succes'?'✅':'❌') + ' ' + msg;
    document.getElementById('toastContainer').appendChild(t);
    setTimeout(() => t.remove(), 3500);
}

// Update badge
function updateBadge(id, nr) {
    const el = document.getElementById(id);
    if (el) el.textContent = nr > 0 ? nr : '';
}

// Adaugă în coș (global)
async function adaugaInCos(id, cantitate=1) {
    const fd = new FormData();
    fd.append('actiune','cos_adauga');
    fd.append('produs_id', id);
    fd.append('cantitate', cantitate);
    const r = await fetch('/php/save_date.php', {method:'POST', body:fd});
    const d = await r.json();
    if (d.succes) {
        updateBadge('badgeCos', d.numar_cos);
        toast(d.mesaj);
    } else toast(d.mesaj, 'eroare');
}

// Toggle favorit (global)
async function toggleFavorit(id, btn) {
    const fd = new FormData();
    fd.append('actiune','favorit_toggle');
    fd.append('produs_id', id);
    const r = await fetch('/php/save_date.php', {method:'POST', body:fd});
    const d = await r.json();
    if (d.succes) {
        updateBadge('badgeFav', d.numar_favorite);
        if (btn) btn.classList.toggle('activ', d.in_favorite);
        toast(d.mesaj, d.in_favorite ? 'succes' : '');
    }
}
</script>