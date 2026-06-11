<?php
session_start();

// Redirect daca nu e logat
if (!isset($_SESSION['user'])) {
    header('Location: login.php?redirect=profil.php');
    exit;
}

// Incarca datele userului
$db_file = __DIR__ . '/data/users.json';
$users   = file_exists($db_file) ? json_decode(file_get_contents($db_file), true) : [];
$user    = null;
foreach ($users as $u) {
    if ($u['id'] === $_SESSION['user_id']) { $user = $u; break; }
}

$success = $_GET['success'] ?? '';
$error   = $_GET['error']   ?? '';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elody – Profilul meu</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/produse.css">
<link rel="stylesheet" href="css/profil_fix.css">
</head>
<body>

  <?php include 'includes/navbar.php'; ?>

  <main class="dash-main">
    <div class="dash-wrapper">

      <!-- SIDEBAR -->
      <aside class="dash-sidebar">
        <div class="dash-avatar-wrap">
          <?php
            $avatar = $user['avatar'] ?? '';
            $initials = strtoupper(mb_substr($user['first_name'] ?? 'U', 0, 1));
          ?>
          <?php if ($avatar && file_exists('uploads/' . $avatar)): ?>
            <img src="uploads/<?= htmlspecialchars($avatar) ?>" class="dash-avatar-img" alt="Avatar" />
          <?php else: ?>
            <div class="dash-avatar-placeholder"><?= $initials ?></div>
          <?php endif; ?>
          <h3><?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?></h3>
          <span><?= htmlspecialchars($user['email'] ?? '') ?></span>
        </div>
        <nav class="dash-nav">
          <a href="profil.php" class="dash-nav__item active">
            <i class="fa-solid fa-user"></i> Profilul meu
          </a>
          <a href="schimba-profil.php" class="dash-nav__item">
            <i class="fa-solid fa-pen-to-square"></i> Editează profilul
          </a>
          <a href="cupoane.php" class="dash-nav__item">
            <i class="fa-solid fa-ticket"></i> Cupoanele mele
          </a>
          <a href="favorite.php" class="dash-nav__item">
            <i class="fa-solid fa-heart"></i> Favorite
          </a>
          <a href="cos.php" class="dash-nav__item">
            <i class="fa-solid fa-cart-shopping"></i> Coșul meu
          </a>
          <div class="dash-nav__divider"></div>
          <a href="logout.php" class="dash-nav__item dash-nav__item--red">
            <i class="fa-solid fa-right-from-bracket"></i> Deconectare
          </a>
        </nav>
      </aside>

      <!-- CONTENT -->
      <div class="dash-content">

        <?php if ($success): ?>
          <div class="alert alert--success"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
          <div class="alert alert--error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- HEADER -->
        <div class="dash-section-header">
          <h1><i class="fa-solid fa-user"></i> Profilul meu</h1>
          <a href="schimba-profil.php" class="btn-edit-profile">
            <i class="fa-solid fa-pen"></i> Editează
          </a>
        </div>

        <!-- AVATAR + INFO -->
        <div class="profile-card">
          <div class="profile-card__avatar">
            <?php if ($avatar && file_exists('uploads/' . $avatar)): ?>
              <img src="uploads/<?= htmlspecialchars($avatar) ?>" alt="Avatar" />
            <?php else: ?>
              <div class="profile-avatar-big"><?= $initials ?></div>
            <?php endif; ?>
            <form action="php/upload_avatar.php" method="POST" enctype="multipart/form-data" class="avatar-upload-form">
              <label class="avatar-upload-btn" title="Schimbă poza">
                <i class="fa-solid fa-camera"></i>
                <input type="file" name="avatar" accept="image/*" onchange="this.form.submit()" style="display:none">
              </label>
            </form>
          </div>
          <div class="profile-card__info">
            <h2><?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?></h2>
            <span class="profile-member-since">
              <i class="fa-solid fa-calendar"></i>
              Membru din <?= date('M Y', strtotime($user['created_at'] ?? 'now')) ?>
            </span>
          </div>
        </div>

        <!-- DATE PERSONALE -->
        <div class="dash-section">
          <h3 class="dash-section__title"><i class="fa-solid fa-id-card"></i> Date personale</h3>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-item__label">Nume</span>
              <span class="info-item__val"><?= htmlspecialchars($user['last_name'] ?? '—') ?></span>
            </div>
            <div class="info-item">
              <span class="info-item__label">Prenume</span>
              <span class="info-item__val"><?= htmlspecialchars($user['first_name'] ?? '—') ?></span>
            </div>
            <div class="info-item">
              <span class="info-item__label">Email</span>
              <span class="info-item__val"><?= htmlspecialchars($user['email'] ?? '—') ?></span>
            </div>
            <div class="info-item">
              <span class="info-item__label">Telefon</span>
              <span class="info-item__val"><?= htmlspecialchars($user['phone'] ?? '—') ?></span>
            </div>
            <div class="info-item">
              <span class="info-item__label">Data nașterii</span>
              <span class="info-item__val"><?= htmlspecialchars($user['birthday'] ?? '—') ?></span>
            </div>
            <div class="info-item">
              <span class="info-item__label">Gen</span>
              <span class="info-item__val"><?= htmlspecialchars($user['gender'] ?? '—') ?></span>
            </div>
          </div>
        </div>

        <!-- ADRESA -->
        <div class="dash-section">
          <h3 class="dash-section__title"><i class="fa-solid fa-location-dot"></i> Adresă de livrare</h3>
          <?php if (!empty($user['address'])): ?>
            <div class="address-card">
              <i class="fa-solid fa-house"></i>
              <div>
                <strong><?= htmlspecialchars($user['address']['street'] ?? '') ?></strong>
                <span><?= htmlspecialchars(($user['address']['city'] ?? '') . ', ' . ($user['address']['zip'] ?? '')) ?></span>
              </div>
              <a href="schimba-profil.php#address" class="btn-edit-small">
                <i class="fa-solid fa-pen"></i>
              </a>
            </div>
          <?php else: ?>
            <div class="no-address">
              <i class="fa-solid fa-location-dot"></i>
              <p>Nu ai adăugat o adresă de livrare.</p>
              <a href="schimba-profil.php#address" class="btn-add-address">
                <i class="fa-solid fa-plus"></i> Adaugă adresă
              </a>
            </div>
          <?php endif; ?>
        </div>

        <!-- STATISTICI -->
        <div class="dash-section">
          <h3 class="dash-section__title"><i class="fa-solid fa-chart-simple"></i> Activitatea mea</h3>
          <div class="stats-grid">
            <div class="stat-box">
              <i class="fa-solid fa-heart"></i>
              <span id="favStatCount">0</span>
              <p>Produse favorite</p>
            </div>
            <div class="stat-box">
              <i class="fa-solid fa-cart-shopping"></i>
              <span id="cartStatCount">0</span>
              <p>Produse în coș</p>
            </div>
            <div class="stat-box">
              <i class="fa-solid fa-ticket"></i>
              <span><?= count($user['coupons'] ?? []) ?></span>
              <p>Cupoane active</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    try {
      var fav  = JSON.parse(localStorage.getItem('elody_fav'))  || [];
      var cart = JSON.parse(localStorage.getItem('elody_cart')) || [];
      var fc = document.getElementById('favStatCount');
      var cc = document.getElementById('cartStatCount');
      if (fc) fc.textContent = fav.length;
      if (cc) cc.textContent = cart.reduce(function(s,i){return s+i.qty;},0);
    } catch(e) {}
  });
  </script>
  <script src="js/theme.js"></script>
</body>
</html>