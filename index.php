</html>                
<?php
session_start();
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
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/produse.css">
</head>
<body>

  <!-- NAVBAR -->
  <header>
    <nav class="navbar">

      <a href="index.php" class="navbar__logo">
        <img src="images/logo.png" alt="Elody Farmacie" class="navbar__logo-img" />
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
           <div class="navbar__dropdown" id="userDropdown">

    <div class="user-box">
        <div class="avatar">
            <?= strtoupper(mb_substr($_SESSION['user'], 0, 1)) ?>
        </div>

        <span class="email">
            <?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>
        </span>
    </div>

    <hr>

    <a href="dashboard.php" class="dropdown-item">
        <i class="fa-solid fa-user"></i>
        Profilul meu
    </a>

    <a href="dashboard.php?tab=edit" class="dropdown-item">
        <i class="fa-solid fa-pen-to-square"></i>
        Schimbă profilul
    </a>

    <a href="gestionare-conturi.php" class="dropdown-item">
        <i class="fa-solid fa-users"></i>
        Gestionare conturi
    </a>

    <div class="dropdown-divider"></div>

    <a href="logout.php" class="dropdown-item dropdown-item--red">
        <i class="fa-solid fa-right-from-bracket"></i>
        Deconectare
    </a>

</div>
        </div>
      <?php else: ?>
        <a href="login.php" class="navbar__user-btn" aria-label="Contul meu">
          <img src="images/user.png" alt="User" class="navbar__user-img" />
        </a>
      <?php endif; ?>

      <nav class="navbar__nav">
        <a href="index.php" class="<?= $active_nav==='acasa'?'active':'' ?>">Acasă</a>
        <a href="despre.php" class="<?= $active_nav==='despre'?'active':'' ?>">Despre noi</a>
        <li class="nav-item dropdown">

    <a class="nav-link dropdown-title">
        Produse
        <i class="fa-solid fa-chevron-down"></i>
    </a>

    <div class="mega-menu">
        <div class="mega-column">
            <a href="produse.php?cat=medicamente">💊 Medicamente</a>
            <a href="produse.php?cat=vitamine">🍊 Vitamine și suplimente</a>
            <a href="produse.php?cat=naturiste">🌿 Produse naturiste</a>
            <a href="produse.php?cat=ingrijire">🧴 Îngrijire personală</a>
            <a href="produse.php?cat=mama-copil">👶 Mama și copilul</a>
        </div>

        <div class="mega-column">
            <a href="produse.php?cat=ortopedice">🩹 Articole ortopedice</a>
            <a href="produse.php?cat=dieta">🥗 Dietă</a>
            <a href="produse.php?cat=plante">🌱 Plante medicinale</a>
            <a href="produse.php?cat=parafarmaceutice">❤️ Parafarmaceutice</a>
            <a href="produse.php?cat=tehnica">🩺 Tehnică medicală</a>
        </div>

        <div class="mega-column">
            <a href="produse.php?cat=vacanta">🏖️ Trusă medicală de vacanță</a>
            <a href="produse.php?cat=acasa">🏠 Trusă medicală de acasă</a>
        </div>

    </div>

</li>
        <a href="servicii.php" class="<?= $active_nav==='servicii'?'active':'' ?>">Servicii</a>
        <a href="contact.php" class="<?= $active_nav==='contact'?'active':'' ?>">Contact</a>
      </nav>

      <div class="navbar__search">
        <input type="text" placeholder="Caută produse..." aria-label="Caută" />
        <button class="navbar__search-btn" aria-label="Caută">
          <img src="images/search.png" alt="Caută" width="18" height="18" />
        </button>
      </div>

      <a href="favorite.php" class="navbar__action-btn" aria-label="Favorite">
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
          <span class="navbar__badge">0</span>
      </a>
      </a>

    </nav>
  </header>

  <main>

    <!-- ══ CONTENT WRAPPER — hero, categories, help, benefits, products ══ -->
    <div class="content-wrapper">

      <!-- HERO -->
      <section class="hero">
        <div class="language-box">RO</div>

        <div class="hero-left">
          <h1>Sănătatea ta ,<br><span>prioritatea noastră</span></h1>
          <p>Alege din gama noastră variată de produse<br>și beneficiază de servicii de calitate.</p>
          <div class="hero-buttons">
           <a href="produse.php" class="hero-btn-primary">
    Vezi produse <i class="fa-solid fa-arrow-right"></i>
</a>
            <a href="#" class="hero-btn-secondary">Despre noi</a>
          </div>
        </div>

        <div class="hero-mascota">
          <div class="plus-icon">+</div>
          <img src="images/mascotaa.png" alt="Elody Farmacie" class="hero-mascota-img" />
        </div>

        <div class="hero-right">
          <img src="images/elody.png" alt="Elody Farmacie" class="hero-pharmacy-img" />
        </div>

       <!-- DARK MODE TOGGLE -->
<button class="theme-box" id="themeToggle" aria-label="Schimbă tema">
  <div class="theme-icon theme-icon--moon">
    <img src="images/moon-phase.png" alt="Dark" width="20" height="20" />
  </div>
  <div class="theme-icon theme-icon--sun">
    <img src="images/sun.png" alt="Light" width="20" height="20" />
  </div>
  <div class="theme-thumb"></div>
</button>

      </section>

      <!-- CATEGORIES -->
      <section class="categories">
        <div class="category-card">
          <img src="images/medicamente.png" alt="">
          <h3>Medicamente</h3>
          <p>Pentru diverse acțiuni</p>
          <a href="#">→</a>
        </div>
        <div class="category-card">
          <img src="images/vitamine.png" alt="">
          <h3>Vitamine și suplimente</h3>
          <p>Sănătate și imunitate</p>
          <a href="#">→</a>
        </div>
        <div class="category-card">
          <img src="images/ingrijire.png" alt="">
          <h3>Îngrijire personală</h3>
          <p>Frumusețe și îngrijire</p>
          <a href="#">→</a>
        </div>
        <div class="category-card">
          <img src="images/copii.png" alt="">
          <h3>Mama și copilul</h3>
          <p>Grijă pentru cei mici</p>
          <a href="#">→</a>
        </div>
        <div class="category-card">
          <img src="images/naturiste.png" alt="">
          <h3>Produse naturiste</h3>
          <p>Produse pe bază de plante</p>
          <a href="#">→</a>
        </div>
      </section>

      <!-- HELP BANNER -->
      <section class="help-banner">
        <div class="help-icon">
          <img src="images/phone.png" alt="">
        </div>
        <div class="help-text">
          <h2>Ai nevoie de ajutor?</h2>
          <p>Sună-mă acum</p>
          <span>(+373) 22 000 915</span>
        </div>
        <div class="help-image">
          <img src="images/cangur-laptop.png" alt="">
        </div>
      </section>

      <!-- BENEFITS + PRODUCTS -->
      <section class="benefits-section">
        <div class="rabbit-side">
          <img src="images/cangur-mare.png" alt="Elody">
        </div>
        <div class="benefits-content">
          <div class="benefits-bar">
            <div class="benefit-item">
              <img src="images/truck.png" alt="">
              <div><h4>Livrare rapidă</h4><p>Livrăm în toată Moldova</p></div>
            </div>
            <div class="benefit-item">
              <img src="images/shield.png" alt="">
              <div><h4>Plată securizată</h4><p>Metode sigure de plată</p></div>
            </div>
            <div class="benefit-item">
              <img src="images/quality.png" alt="">
              <div><h4>Produse de calitate</h4><p>Doar produse originale</p></div>
            </div>
            <div class="benefit-item">
              <img src="images/support.png" alt="">
              <div><h4>Suport clienți</h4><p>Suntem aici pentru tine</p></div>
            </div>
          </div>

          <section class="popular-products">
            <div class="popular-right">
              <div class="popular-top">
                <h2>Produse populare</h2>
                <a href="#" class="all-products-btn">Vezi toate produsele →</a>
              </div>
              <div class="products-grid">
                <div class="product-card">
                  <span class="heart">♡</span>
                  <img src="images/paracetamol.png" alt="Paracetamol">
                  <h3>Paracetamol</h3>
                  <p>500mg, 20 comprimate</p>
                  <span class="price">22.00 Lei</span>
                </div>
                <div class="product-card">
                  <span class="heart">♡</span>
                  <img src="images/aspirin.png" alt="Aspirin">
                  <h3>Aspirin Plus</h3>
                  <p>240mg, 10 comprimate</p>
                  <span class="price">90.00 Lei</span>
                </div>
                <div class="product-card">
                  <span class="heart">♡</span>
                  <img src="images/florbiotic.png" alt="Flor Biotic">
                  <h3>Flor Biotic</h3>
                  <p>10 comprimate</p>
                  <span class="price">120.35 Lei</span>
                </div>
                <div class="product-card">
                  <span class="heart">♡</span>
                  <img src="images/vitamina-c.png" alt="Vitamina C">
                  <h3>Vitamina C</h3>
                  <p>250mg, 10 comprimate</p>
                  <span class="price">12.30 Lei</span>
                </div>
              </div>
            </div>
          </section>

        </div>
      </section>

    </div>
    <!-- ══ SFARSIT CONTENT WRAPPER ══ -->

    <!-- PHARMACY MAP — IN AFARA content-wrapper -->
    <section class="pharmacy-map-section">
      <div class="pharmacy-list">
        <h2>Farmaciile <span>Elody</span></h2>
        <div class="pharmacy-card">
          <div class="pharmacy-info">
            <h3>Elody Centru</h3>
            <p>Str. Ștefan cel Mare 10</p>
            <small>Program: 08:00 - 22:00</small>
          </div>
          <div class="schedule">08:00 - 22:00</div>
        </div>
        <div class="pharmacy-card">
          <div class="pharmacy-info">
            <h3>Elody Botanica</h3>
            <p>Bd. Dacia 25</p>
            <small>Program: 08:00 - 22:00</small>
          </div>
          <div class="schedule">08:00 - 22:00</div>
        </div>
        <div class="pharmacy-card">
          <div class="pharmacy-info">
            <h3>Elody Râșcani</h3>
            <p>Str. Moscova 15</p>
            <small>Program: 08:00 - 22:00</small>
          </div>
          <div class="schedule">08:00 - 22:00</div>
        </div>
        <a href="#" class="view-products">Vezi toate locațiile →</a>
      </div>
      <div class="map-wrapper">
        <div id="map"></div>
      </div>
    </section>

    <!-- FOOTER — IN AFARA content-wrapper -->
    <footer class="footer">

      <div class="footer-grid">
        <div class="footer-brand">
          <img src="images/logo.png" class="footer-logo" alt="">
          <p>Misiunea noastră este de a satisface necesitățile clienților prin personal profesionist, produse de înaltă calitate, mărci apreciate în toată lumea și servicii la cel mai înalt nivel.</p>
        </div>
        <div class="footer-column">
          <h3>Linkuri Utile</h3>
          <a href="#">Acasă</a>
          <a href="#">Despre noi</a>
          <a href="#">Produse</a>
          <a href="#">Servicii</a>
          <a href="#">Contact</a>
        </div>
        <div class="footer-column">
          <h3>Informații</h3>
          <a href="#">Livrare și plată</a>
          <a href="#">Politica de retur</a>
          <a href="#">Termeni și condiții</a>
          <a href="#">Confidențialitate</a>
        </div>
        <div class="footer-column">
          <h3>Contacte</h3>
          <p>contact@elody.md</p>
          <p>(+373) 22 000 915</p>
          <p>mun. Chișinău</p>
          <p>str. Calea Orheiului</p>
        </div>
        <div class="footer-social">
          <h3>Urmărește-ne</h3>
         <div class="social-row">

 <a
    href="https://www.facebook.com/ElodyFarmacie/?locale=ro_RO"
    target="_blank"
    rel="noopener noreferrer"
>
    <img src="images/facebook.png" alt="Facebook" width="20" height="20">

  </a>

  <a
    href="https://www.instagram.com/elody_farmacia/"
    target="_blank"
    rel="noopener noreferrer"
>
    <img src="images/instagram.png" alt="Instagram" width="20" height="20">
</a>
  <a
    href="https://www.tiktok.com/@elody.tatiana"
    target="_blank"
    rel="noopener noreferrer"
>
    <img src="images/tiktok.png" alt="tiktok" width="20" height="20">
  </a>
</div>
          <div class="newsletter">
            <h4>Abonează-te la noutăți</h4>
            <p>Fii la curent cu cele mai noi oferte și produse</p>
          <div class="newsletter-form">
  <input type="email" placeholder="Adresa ta de e-mail">
  <button type="submit" aria-label="Abonează-te">
    <img src="images/paper-plane.png" alt="Trimite" width="20" height="20">
  </button>
</div>
          </div>
        </div>
      </div>

      <div class="footer-copy">© ELODY.MD | All Rights reserved</div>
    </footer>

  </main>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    var map = L.map('map').setView([47.0105, 28.8638], 12);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom:19 }).addTo(map);
    L.marker([47.0245, 28.8320]).addTo(map).bindPopup("Elody Centru");
    L.marker([46.9880, 28.8570]).addTo(map).bindPopup("Elody Botanica");
    L.marker([47.0450, 28.8700]).addTo(map).bindPopup("Elody Râșcani");
  </script>
  <script src="js/theme.js"></script>
</body>
</html>