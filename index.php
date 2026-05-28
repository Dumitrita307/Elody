<?php
// index.php — Elody Farmacie
$page_title = "Acasă";
$active_nav = "acasa";
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elody Farmacie – <?= htmlspecialchars($page_title) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
 
  <!-- ══════════════════════════════════
       NAVBAR
  ══════════════════════════════════ -->
  <header>
    <nav class="navbar">
 
      <!-- Logo -->
      <a href="index.php" class="navbar__logo">
        <img src="images/logo.png" alt="Elody Farmacie" class="navbar__logo-img" />
      </a>
 
      <!-- User icon -->
      <button class="navbar__user" aria-label="Contul meu">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="12" cy="8" r="4"/>
          <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
        </svg>
      </button>
 
      <!-- Navigation links -->
      <nav class="navbar__nav">
        <a href="index.php"
           class="<?= $active_nav === 'acasa' ? 'active' : '' ?>">
          Acasă
        </a>
 
        <a href="despre.php"
           class="<?= $active_nav === 'despre' ? 'active' : '' ?>">
          Despre noi
        </a>
 
        <span class="has-dropdown
              <?= $active_nav === 'produse' ? 'active' : '' ?>">
          Produse
        </span>
 
        <a href="servicii.php"
           class="<?= $active_nav === 'servicii' ? 'active' : '' ?>">
          Servicii
        </a>
 
        <a href="contact.php"
           class="<?= $active_nav === 'contact' ? 'active' : '' ?>">
          Contact
        </a>
      </nav>
 
      <!-- Search -->
      <div class="navbar__search">
        <input type="text" placeholder="Caută produse..." aria-label="Caută" />
        <button class="navbar__search-btn" aria-label="Caută">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
          </svg>
        </button>
      </div>
 
      <!-- Wishlist + Cart -->
      <div class="navbar__actions">
        <!-- Wishlist -->
        <button class="navbar__action-btn" aria-label="Lista de dorințe">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
          <span class="navbar__badge">0</span>
        </button>
 
        <!-- Cart -->
        <button class="navbar__action-btn" aria-label="Coș de cumpărături">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
          </svg>
          <span class="navbar__badge">0</span>
        </button>
      </div>
 
    </nav>
  </header>
 
  <!-- ══════════════════════════════════
       FUNDAL / BODY (gol momentan)
  ══════════════════════════════════ -->
  <main class="page-bg">
    <!-- Conținut urmează -->
  </main>
 
</body>
</html>