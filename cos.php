<?php
session_start();
require_once 'php/lang.php';

$page_title = "Coș de cumpărături";
$active_nav = "";
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elody Farmacie – <?= t('cosul_tau') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/cos.css" />
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
            <a href="dashboard.php" class="dropdown-item"><i class="fa-solid fa-user"></i> <?= t('profil') ?></a>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-item dropdown-item--red"><i class="fa-solid fa-right-from-bracket"></i> <?= t('deconectare') ?></a>
          </div>
        </div>
      <?php else: ?>
        <a href="login.php" class="navbar__user-btn"><img src="images/user.png" alt="User" class="navbar__user-img" /></a>
      <?php endif; ?>
      <nav class="navbar__nav">
        <a href="index.php"><?= t('acasa') ?></a>
        <a href="despre.php"><?= t('despre') ?></a>
        <a href="produse.php"><?= t('produse') ?></a>
        <a href="servicii.php"><?= t('servicii') ?></a>
        <a href="contact.php"><?= t('contact') ?></a>
      </nav>
      <div class="navbar__search">
        <input type="text" placeholder="<?= t('cauta') ?>" />
        <button class="navbar__search-btn"><img src="images/search.png" alt="Caută" width="18" height="18" /></button>
      </div>
      <div class="navbar__actions">
        <a href="favorite.php" class="navbar__action-btn">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </a>
        <a href="cos.php" class="navbar__action-btn active-page">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="navbar__badge" id="cartBadge">0</span>
        </a>
      </div>
    </nav>
  </header>

  <main class="cos-main">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
      <a href="index.php"><i class="fa-solid fa-house"></i> <?= t('acasa') ?></a>
      <i class="fa-solid fa-chevron-right"></i>
      <span><?= t('cosul_tau') ?></span>
    </div>

    <div class="cos-layout" id="cosLayout">

      <!-- PRODUSE COS -->
      <div class="cos-items" id="cosItems">
        <!-- Populat din JS -->
      </div>

      <!-- SUMAR COMANDA -->
      <aside class="cos-summary" id="cosSummary">
        <h2><?= t('total') ?></h2>

        <div class="summary-rows" id="summaryRows"></div>

        <!-- LIVRARE -->
        <div class="summary-section">
          <h3><i class="fa-solid fa-truck"></i> Metoda de livrare</h3>
          <div class="delivery-options">
            <label class="delivery-opt">
              <input type="radio" name="delivery" value="standard" checked onchange="updateDelivery(35)">
              <div class="delivery-opt__info">
                <span>Livrare standard</span>
                <small>2-4 ore · Chișinău</small>
              </div>
              <strong>35 Lei</strong>
            </label>
            <label class="delivery-opt">
              <input type="radio" name="delivery" value="express" onchange="updateDelivery(65)">
              <div class="delivery-opt__info">
                <span>Livrare express</span>
                <small>1-2 ore · Chișinău</small>
              </div>
              <strong>65 Lei</strong>
            </label>
            <label class="delivery-opt">
              <input type="radio" name="delivery" value="pickup" onchange="updateDelivery(0)">
              <div class="delivery-opt__info">
                <span>Ridicare din farmacie</span>
                <small>Disponibil imediat</small>
              </div>
              <strong>Gratuit</strong>
            </label>
          </div>
        </div>

        <!-- CUPON -->
        <div class="summary-section">
          <h3><i class="fa-solid fa-tag"></i> Cod promoțional</h3>
          <div class="coupon-form">
            <input type="text" id="couponInput" placeholder="Introdu codul...">
            <button onclick="applyCoupon()">Aplică</button>
          </div>
          <p class="coupon-msg" id="couponMsg"></p>
        </div>

        <div class="summary-total">
          <div class="summary-line">
            <span>Subtotal</span>
            <strong id="subtotalVal">0.00 Lei</strong>
          </div>
          <div class="summary-line">
            <span>Livrare</span>
            <strong id="deliveryVal">35.00 Lei</strong>
          </div>
          <div class="summary-line summary-line--discount" id="discountLine" style="display:none">
            <span>Reducere</span>
            <strong id="discountVal">0.00 Lei</strong>
          </div>
          <div class="summary-line summary-line--total">
            <span>Total</span>
            <strong id="totalVal">0.00 Lei</strong>
          </div>
        </div>

        <a href="checkout.php" class="btn-checkout" id="btnCheckout">
          <i class="fa-solid fa-credit-card"></i>
          Finalizează comanda
        </a>

        <a href="produse.php" class="btn-continue">
          <i class="fa-solid fa-arrow-left"></i>
          Continuă cumpărăturile
        </a>

      </aside>
    </div>

    <!-- COS GOL -->
    <div class="cos-empty" id="cosEmpty" style="display:none">
      <div class="cos-empty__icon">
        <i class="fa-solid fa-cart-shopping"></i>
      </div>
      <h2><?= t('cos_gol') ?></h2>
      <p>Adaugă produse în coș pentru a continua.</p>
      <a href="produse.php" class="btn-go-shop">
        <i class="fa-solid fa-pills"></i>
        Vezi produsele noastre
      </a>
    </div>

  </main>

  <script src="js/cos.js"></script>
  <script src="js/theme.js"></script>
</body>
</html>