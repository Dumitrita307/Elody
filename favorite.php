<?php
session_start();
$page_title = "Favorite";
$active_nav = "favorite";
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elody Farmacie – Favorite</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/favorite.css" />
</head>
<body>

  <!-- NAVBAR -->
  <header>
    <nav class="navbar">
      <a href="index.php" class="navbar__logo">
        <img src="images/logo.png" alt="Elody" class="navbar__logo-img" />
      </a>

      <?php if (isset($_SESSION['user'])): ?>
        <div class="navbar__user-wrap">
          <button class="navbar__user-btn" id="userBtn">
            <img src="images/user.png" alt="User" class="navbar__user-img" />
            <span><?= htmlspecialchars(explode(' ', $_SESSION['user'])[0]) ?></span>
            <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i>
          </button>
          <div class="navbar__dropdown" id="userDropdown">
            <div class="dropdown-header">
              <div class="dropdown-avatar"><?= strtoupper(mb_substr($_SESSION['user'], 0, 1)) ?></div>
              <div>
                <strong><?= htmlspecialchars($_SESSION['user']) ?></strong>
                <small><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></small>
              </div>
            </div>
            <a href="dashboard.php" class="dropdown-item"><i class="fa-solid fa-user"></i> Profilul meu</a>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-item dropdown-item--red"><i class="fa-solid fa-right-from-bracket"></i> Deconectare</a>
          </div>
        </div>
      <?php else: ?>
        <a href="login.php" class="navbar__user-btn">
          <img src="images/user.png" alt="User" class="navbar__user-img" />
        </a>
      <?php endif; ?>

      <nav class="navbar__nav">
        <a href="index.php">Acasă</a>
        <a href="despre.php">Despre noi</a>
        <a href="produse.php">Produse</a>
        <a href="servicii.php">Servicii</a>
        <a href="contact.php">Contact</a>
      </nav>

      <div class="navbar__search">
        <input type="text" placeholder="Caută produse..." />
        <button class="navbar__search-btn">
          <img src="images/search.png" alt="Caută" width="18" height="18" />
        </button>
      </div>

      <div class="navbar__actions">
        <a href="favorite.php" class="navbar__action-btn active-page">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
          <span class="navbar__badge" id="wishBadge">0</span>
        </a>
        <a href="cos.php" class="navbar__action-btn">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
          </svg>
          <span class="navbar__badge" id="cartBadge">0</span>
        </a>
      </div>
    </nav>
  </header>

  <main class="fav-main">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
      <a href="index.php"><i class="fa-solid fa-house"></i> Acasă</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Favorite</span>
    </div>

    <!-- HEADER -->
    <div class="fav-page-header">
      <div class="fav-page-header__left">
        <h1><i class="fa-solid fa-heart"></i> Produsele mele favorite</h1>
        <p id="favCount">0 produse salvate</p>
      </div>
      <div class="fav-page-header__right">
        <button class="btn-new-collection" onclick="openNewCollection()">
          <i class="fa-solid fa-folder-plus"></i>
          Colecție nouă
        </button>
        <button class="btn-clear-fav" onclick="clearAllFav()">
          <i class="fa-solid fa-trash"></i>
          Șterge toate
        </button>
      </div>
    </div>

    <!-- COLECTII -->
    <div class="collections-bar" id="collectionsBar">
      <button class="collection-tab active" data-col="toate" onclick="switchCollection(this, 'toate')">
        <i class="fa-solid fa-border-all"></i> Toate
      </button>
      <!-- Colectiile se adauga din JS -->
    </div>

    <!-- GRID FAVORITE -->
    <div class="fav-grid" id="favGrid">
      <!-- Populat din JS -->
    </div>

    <!-- GOL -->
    <div class="fav-empty" id="favEmpty" style="display:none">
      <div class="fav-empty__icon">
        <i class="fa-regular fa-heart"></i>
      </div>
      <h2>Niciun produs favorit</h2>
      <p>Adaugă produse la favorite apăsând iconița ♡ de pe orice produs.</p>
      <a href="produse.php" class="btn-go-shop">
        <i class="fa-solid fa-pills"></i>
        Descoperă produsele noastre
      </a>
    </div>

  </main>

  <!-- MODAL COLECTIE NOUA -->
  <div class="modal-overlay" id="colModal" style="display:none">
    <div class="modal-box">
      <button class="modal-close" onclick="closeModal()">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <h3><i class="fa-solid fa-folder-plus"></i> Colecție nouă</h3>
      <p>Dă un nume colecției tale de produse</p>
      <input type="text" id="colName" placeholder="Ex: Vitamine, Răceală, Copii..." maxlength="30" />
      <div class="modal-colors">
        <span>Culoare:</span>
        <div class="color-opts">
          <button class="color-opt active" data-color="#e91e8c" style="background:#e91e8c" onclick="selectColor(this)"></button>
          <button class="color-opt" data-color="#7b1fa2" style="background:#7b1fa2" onclick="selectColor(this)"></button>
          <button class="color-opt" data-color="#0288d1" style="background:#0288d1" onclick="selectColor(this)"></button>
          <button class="color-opt" data-color="#388e3c" style="background:#388e3c" onclick="selectColor(this)"></button>
          <button class="color-opt" data-color="#f57c00" style="background:#f57c00" onclick="selectColor(this)"></button>
        </div>
      </div>
      <div class="modal-btns">
        <button class="btn-cancel" onclick="closeModal()">Anulează</button>
        <button class="btn-create" onclick="createCollection()">
          <i class="fa-solid fa-check"></i> Creează
        </button>
      </div>
    </div>
  </div>

  <!-- MODAL ADAUGA LA COLECTIE -->
  <div class="modal-overlay" id="addColModal" style="display:none">
    <div class="modal-box">
      <button class="modal-close" onclick="closeAddModal()">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <h3><i class="fa-solid fa-folder"></i> Adaugă la colecție</h3>
      <div class="col-list" id="colList"></div>
      <button class="btn-new-col-link" onclick="closeAddModal(); openNewCollection()">
        <i class="fa-solid fa-plus"></i> Creează colecție nouă
      </button>
    </div>
  </div>

  <!-- TOAST -->
  <div class="toast" id="toast"></div>

  <script>
  // ══════════════════════════════════
  // FAVORITE — JavaScript
  // ══════════════════════════════════

  var selectedColor = '#e91e8c';
  var currentCollection = 'toate';
  var addToColProductId = null;

  // ── Helpers ────────────────────────
  function getFav() {
    try { return JSON.parse(localStorage.getItem('elody_fav')) || []; }
    catch(e) { return []; }
  }
  function saveFav(fav) {
    localStorage.setItem('elody_fav', JSON.stringify(fav));
    updateBadges();
  }
  function getCollections() {
    try { return JSON.parse(localStorage.getItem('elody_collections')) || []; }
    catch(e) { return []; }
  }
  function saveCollections(cols) {
    localStorage.setItem('elody_collections', JSON.stringify(cols));
  }
  function getCart() {
    try { return JSON.parse(localStorage.getItem('elody_cart')) || []; }
    catch(e) { return []; }
  }
  function saveCart(cart) {
    localStorage.setItem('elody_cart', JSON.stringify(cart));
    updateBadges();
  }

  function updateBadges() {
    var fav  = getFav();
    var cart = getCart();
    var wb = document.getElementById('wishBadge');
    var cb = document.getElementById('cartBadge');
    if (wb) wb.textContent = fav.length;
    if (cb) cb.textContent = cart.reduce(function(s,i){ return s+i.qty; }, 0);
  }

  function showToast(msg, type) {
    var t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'toast show ' + (type || '');
    setTimeout(function(){ t.className = 'toast'; }, 2800);
  }

  // ── Sterge din favorite ────────────
  function removeFav(id) {
    var fav = getFav().filter(function(p){ return p.id !== id; });
    saveFav(fav);
    render();
    showToast('Produs eliminat din favorite', 'toast--remove');
  }

  // ── Goleste toate ──────────────────
  function clearAllFav() {
    if (!confirm('Ștergi toate produsele din favorite?')) return;
    localStorage.removeItem('elody_fav');
    render();
    showToast('Toate favoritele au fost șterse', 'toast--remove');
  }

  // ── Adauga in cos ──────────────────
  function addToCart(product) {
    var cart = getCart();
    var existing = cart.find(function(i){ return i.id === product.id; });
    if (existing) {
      existing.qty++;
    } else {
      cart.push({ id:product.id, name:product.name, price:product.price, qty:1, image:product.image, brand:product.brand, unit:product.unit });
    }
    saveCart(cart);
    showToast('✓ ' + product.name + ' adăugat în coș', 'toast--success');
  }

  // ── Switch colectie ────────────────
  function switchCollection(btn, col) {
    document.querySelectorAll('.collection-tab').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    currentCollection = col;
    render();
  }

  // ── Sterge colectie ────────────────
  function deleteCollection(name) {
    if (!confirm('Ștergi colecția "' + name + '"?')) return;
    var cols = getCollections().filter(function(c){ return c.name !== name; });
    saveCollections(cols);
    // Scoate din produse
    var fav = getFav().map(function(p){
      p.collections = (p.collections || []).filter(function(c){ return c !== name; });
      return p;
    });
    saveFav(fav);
    currentCollection = 'toate';
    renderCollections();
    render();
    showToast('Colecție ștearsă', 'toast--remove');
  }

  // ── Deschide modal colectie ────────
  function openNewCollection() {
    document.getElementById('colName').value = '';
    document.getElementById('colModal').style.display = 'flex';
  }
  function closeModal() {
    document.getElementById('colModal').style.display = 'none';
  }
  function selectColor(btn) {
    document.querySelectorAll('.color-opt').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    selectedColor = btn.dataset.color;
  }
  function createCollection() {
    var name = document.getElementById('colName').value.trim();
    if (!name) { alert('Introdu un nume pentru colecție!'); return; }
    var cols = getCollections();
    if (cols.find(function(c){ return c.name === name; })) {
      alert('Colecție cu același nume există deja!'); return;
    }
    cols.push({ name:name, color:selectedColor });
    saveCollections(cols);
    closeModal();
    renderCollections();
    showToast('✓ Colecție "' + name + '" creată!', 'toast--success');
  }

  // ── Adauga la colectie modal ───────
  function openAddToCollection(id) {
    addToColProductId = id;
    var cols = getCollections();
    var list = document.getElementById('colList');
    var fav  = getFav();
    var prod = fav.find(function(p){ return p.id === id; });
    var prodCols = (prod && prod.collections) || [];

    if (cols.length === 0) {
      list.innerHTML = '<p style="color:#888;font-size:13px;text-align:center;padding:16px 0">Nu ai colecții create încă.</p>';
    } else {
      list.innerHTML = cols.map(function(c){
        var inCol = prodCols.indexOf(c.name) !== -1;
        return '<div class="col-list-item ' + (inCol ? 'in-col' : '') + '" onclick="toggleInCollection(\'' + c.name + '\')">' +
          '<div class="col-list-item__dot" style="background:' + c.color + '"></div>' +
          '<span>' + c.name + '</span>' +
          (inCol ? '<i class="fa-solid fa-check"></i>' : '') +
        '</div>';
      }).join('');
    }
    document.getElementById('addColModal').style.display = 'flex';
  }

  function closeAddModal() {
    document.getElementById('addColModal').style.display = 'none';
    addToColProductId = null;
  }

  function toggleInCollection(colName) {
    var fav  = getFav();
    var prod = fav.find(function(p){ return p.id === addToColProductId; });
    if (!prod) return;
    prod.collections = prod.collections || [];
    var idx = prod.collections.indexOf(colName);
    if (idx === -1) {
      prod.collections.push(colName);
      showToast('✓ Adăugat în "' + colName + '"', 'toast--success');
    } else {
      prod.collections.splice(idx, 1);
      showToast('Eliminat din "' + colName + '"', 'toast--remove');
    }
    saveFav(fav);
    closeAddModal();
    render();
  }

  // ── Randeaza colectiile ────────────
  function renderCollections() {
    var bar  = document.getElementById('collectionsBar');
    var cols = getCollections();
    var fav  = getFav();

    // Pastreaza butonul "Toate"
    bar.innerHTML = '<button class="collection-tab ' + (currentCollection === 'toate' ? 'active' : '') + '" data-col="toate" onclick="switchCollection(this, \'toate\')">' +
      '<i class="fa-solid fa-border-all"></i> Toate (' + fav.length + ')' +
    '</button>';

    cols.forEach(function(c){
      var count = fav.filter(function(p){ return (p.collections || []).indexOf(c.name) !== -1; }).length;
      bar.innerHTML +=
        '<div class="collection-tab-wrap">' +
          '<button class="collection-tab ' + (currentCollection === c.name ? 'active' : '') + '" ' +
            'style="--col-color:' + c.color + '" ' +
            'onclick="switchCollection(this, \'' + c.name + '\')">' +
            '<span class="col-dot" style="background:' + c.color + '"></span>' +
            c.name + ' (' + count + ')' +
          '</button>' +
          '<button class="col-delete" onclick="deleteCollection(\'' + c.name + '\')" title="Șterge colecția">' +
            '<i class="fa-solid fa-xmark"></i>' +
          '</button>' +
        '</div>';
    });
  }

  // ── Randeaza produsele ─────────────
  function render() {
    var fav   = getFav();
    var grid  = document.getElementById('favGrid');
    var empty = document.getElementById('favEmpty');
    var cnt   = document.getElementById('favCount');

    // Filtreaza dupa colectie
    var products = fav;
    if (currentCollection !== 'toate') {
      products = fav.filter(function(p){
        return (p.collections || []).indexOf(currentCollection) !== -1;
      });
    }

    if (cnt) cnt.textContent = fav.length + ' produse salvate';

    if (fav.length === 0) {
      grid.innerHTML = '';
      grid.style.display = 'none';
      empty.style.display = 'flex';
      return;
    }

    empty.style.display = 'none';
    grid.style.display  = 'grid';

    if (products.length === 0) {
      grid.innerHTML = '<div class="fav-col-empty"><i class="fa-solid fa-folder-open"></i><p>Niciun produs în această colecție.</p></div>';
      return;
    }

    grid.innerHTML = products.map(function(p){
      var cols = (p.collections || []);
      var colDots = cols.map(function(c){
        var col = getCollections().find(function(x){ return x.name === c; });
        return col ? '<span class="prod-col-dot" style="background:' + col.color + '" title="' + c + '"></span>' : '';
      }).join('');

      return '<div class="fav-card" id="fav-' + p.id + '">' +
        '<div class="fav-card__top">' +
          (cols.length > 0 ? '<div class="fav-card__cols">' + colDots + '</div>' : '') +
          '<button class="fav-card__remove" onclick="removeFav(' + p.id + ')" title="Șterge din favorite">' +
            '<i class="fa-solid fa-heart-crack"></i>' +
          '</button>' +
        '</div>' +
        '<div class="fav-card__img">' +
          '<img src="' + (p.image || 'images/paracetamol.png') + '" alt="' + p.name + '" onerror="this.src=\'images/paracetamol.png\'">' +
        '</div>' +
        '<div class="fav-card__info">' +
          '<span class="fav-card__brand">' + (p.brand || '') + '</span>' +
          '<h3>' + p.name + '</h3>' +
          '<span class="fav-card__unit">' + (p.unit || '') + '</span>' +
          '<div class="fav-card__price">' + p.price.toFixed(2) + ' Lei</div>' +
        '</div>' +
        '<div class="fav-card__actions">' +
          '<button class="btn-add-col" onclick="openAddToCollection(' + p.id + ')" title="Adaugă la colecție">' +
            '<i class="fa-solid fa-folder-plus"></i>' +
          '</button>' +
          '<button class="btn-add-cart" onclick=\'addToCart(' + JSON.stringify(p) + ')\'>' +
            '<i class="fa-solid fa-cart-plus"></i> Adaugă în coș' +
          '</button>' +
        '</div>' +
      '</div>';
    }).join('');

    updateBadges();
  }

  // ── Init ───────────────────────────
  document.addEventListener('DOMContentLoaded', function() {
    renderCollections();
    render();
    updateBadges();

    // Inchide modal la click afara
    document.querySelectorAll('.modal-overlay').forEach(function(m){
      m.addEventListener('click', function(e){
        if (e.target === m) {
          m.style.display = 'none';
          addToColProductId = null;
        }
      });
    });
  });
  </script>

  <script src="js/theme.js"></script>
</body>
</html>