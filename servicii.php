<?php
session_start();
$page_title = "Servicii";
$active_nav = "servicii";
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elody Farmacie – Servicii</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/servicii.css" />
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
            <a href="dashboard.php" class="dropdown-item"><i class="fa-solid fa-user"></i> Profilul meu</a>
            <a href="dashboard.php?tab=edit" class="dropdown-item"><i class="fa-solid fa-pen-to-square"></i> Schimbă profilul</a>
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
        <input type="text" placeholder="Caută produse..." />
        <button class="navbar__search-btn">
          <img src="images/search.png" alt="Caută" width="18" height="18" />
        </button>
      </div>

      <div class="navbar__actions">
        <button class="navbar__action-btn">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
          <span class="navbar__badge">0</span>
        </button>
        <button class="navbar__action-btn">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
          </svg>
          <span class="navbar__badge">0</span>
        </button>
      </div>
    </nav>
  </header>

  <main class="servicii-main">

    <!-- HERO -->
    <section class="servicii-hero">
      <div class="servicii-hero__content">
        <span class="servicii-hero__tag">Serviciile noastre</span>
        <h1>Tot ce ai nevoie<br><span>într-un singur loc</span></h1>
        <p>Elody Farmacie oferă o gamă completă de servicii farmaceutice profesioniste, disponibile în toate locațiile noastre din Chișinău.</p>
        <a href="contact.php" class="btn-primary-pink">
          <i class="fa-solid fa-calendar-check"></i>
          Programează o consultație
        </a>
      </div>
      <div class="servicii-hero__stats">
        <div class="stat-card">
          <span class="stat-card__number">10+</span>
          <span class="stat-card__label">Ani de experiență</span>
        </div>
        <div class="stat-card">
          <span class="stat-card__number">3</span>
          <span class="stat-card__label">Locații în Chișinău</span>
        </div>
        <div class="stat-card">
          <span class="stat-card__number">50K+</span>
          <span class="stat-card__label">Clienți mulțumiți</span>
        </div>
        <div class="stat-card">
          <span class="stat-card__number">500+</span>
          <span class="stat-card__label">Produse disponibile</span>
        </div>
      </div>
    </section>

    <div class="servicii-wrapper">

      <!-- SERVICII PRINCIPALE -->
      <section class="servicii-section">
        <div class="section-header">
          <h2>Servicii farmaceutice</h2>
          <p>Descoperă gama noastră completă de servicii profesioniste</p>
        </div>

        <div class="servicii-grid">

          <div class="servicii-card servicii-card--featured">
            <div class="servicii-card__icon">
              <i class="fa-solid fa-pills"></i>
            </div>
            <h3>Consultanță farmaceutică</h3>
            <p>Farmaciștii noștri certificați îți oferă consultanță profesionistă pentru orice întrebare legată de medicamente, interacțiuni și dozaje.</p>
            <ul class="servicii-card__list">
              <li><i class="fa-solid fa-check"></i> Consultanță gratuită</li>
              <li><i class="fa-solid fa-check"></i> Farmaciști certificați</li>
              <li><i class="fa-solid fa-check"></i> Disponibil zilnic</li>
            </ul>
            <a href="contact.php" class="servicii-card__btn">Află mai mult →</a>
          </div>

          <div class="servicii-card">
            <div class="servicii-card__icon">
              <i class="fa-solid fa-truck-fast"></i>
            </div>
            <h3>Livrare la domiciliu</h3>
            <p>Comandă online și primești produsele direct acasă, rapid și în siguranță în toată Moldova.</p>
            <ul class="servicii-card__list">
              <li><i class="fa-solid fa-check"></i> Livrare în 2-4 ore</li>
              <li><i class="fa-solid fa-check"></i> Toată Moldova</li>
              <li><i class="fa-solid fa-check"></i> Ambalaj securizat</li>
            </ul>
            <a href="contact.php" class="servicii-card__btn">Află mai mult →</a>
          </div>

          <div class="servicii-card">
            <div class="servicii-card__icon">
              <i class="fa-solid fa-file-prescription"></i>
            </div>
            <h3>Rețete electronice</h3>
            <p>Acceptăm rețete electronice și oferim servicii complete de eliberare a medicamentelor compensate.</p>
            <ul class="servicii-card__list">
              <li><i class="fa-solid fa-check"></i> Medicamente compensate</li>
              <li><i class="fa-solid fa-check"></i> Procesare rapidă</li>
              <li><i class="fa-solid fa-check"></i> Sistem e-Rețetă</li>
            </ul>
            <a href="contact.php" class="servicii-card__btn">Află mai mult →</a>
          </div>

          <div class="servicii-card">
            <div class="servicii-card__icon">
              <i class="fa-solid fa-heart-pulse"></i>
            </div>
            <h3>Măsurarea tensiunii</h3>
            <p>Serviciu gratuit de măsurare a tensiunii arteriale și monitorizare a glicemiei disponibil în toate farmaciile.</p>
            <ul class="servicii-card__list">
              <li><i class="fa-solid fa-check"></i> Complet gratuit</li>
              <li><i class="fa-solid fa-check"></i> Aparatură modernă</li>
              <li><i class="fa-solid fa-check"></i> Fără programare</li>
            </ul>
            <a href="contact.php" class="servicii-card__btn">Află mai mult →</a>
          </div>

          <div class="servicii-card">
            <div class="servicii-card__icon">
              <i class="fa-solid fa-baby"></i>
            </div>
            <h3>Consultanță mamă și copil</h3>
            <p>Sfaturi specializate pentru mame și produse recomandate pentru îngrijirea bebelușilor și copiilor mici.</p>
            <ul class="servicii-card__list">
              <li><i class="fa-solid fa-check"></i> Produse certificate</li>
              <li><i class="fa-solid fa-check"></i> Farmaciști specializați</li>
              <li><i class="fa-solid fa-check"></i> Gamă completă</li>
            </ul>
            <a href="contact.php" class="servicii-card__btn">Află mai mult →</a>
          </div>

          <div class="servicii-card">
            <div class="servicii-card__icon">
              <i class="fa-solid fa-leaf"></i>
            </div>
            <h3>Produse naturiste</h3>
            <p>Gamă extinsă de suplimente naturale, plante medicinale și produse bio pentru un stil de viață sănătos.</p>
            <ul class="servicii-card__list">
              <li><i class="fa-solid fa-check"></i> Produse certificate bio</li>
              <li><i class="fa-solid fa-check"></i> Plante medicinale</li>
              <li><i class="fa-solid fa-check"></i> Consultanță naturistă</li>
            </ul>
            <a href="contact.php" class="servicii-card__btn">Află mai mult →</a>
          </div>

        </div>
      </section>

      <!-- DE CE NOI -->
      <section class="why-us">
        <div class="why-us__text">
          <span class="servicii-hero__tag">De ce Elody?</span>
          <h2>Calitate și profesionalism<br><span>în fiecare detaliu</span></h2>
          <p>Ne dedicăm să oferim cele mai bune servicii farmaceutice clienților noștri, combinând experiența profesională cu tehnologia modernă.</p>
          <div class="why-us__features">
            <div class="why-feature">
              <div class="why-feature__icon"><i class="fa-solid fa-shield-halved"></i></div>
              <div>
                <h4>Produse originale garantate</h4>
                <p>Toate produsele sunt achiziționate direct de la distribuitori autorizați.</p>
              </div>
            </div>
            <div class="why-feature">
              <div class="why-feature__icon"><i class="fa-solid fa-clock"></i></div>
              <div>
                <h4>Program extins</h4>
                <p>Deschis 7 zile din 7, de la 08:00 până la 22:00.</p>
              </div>
            </div>
            <div class="why-feature">
              <div class="why-feature__icon"><i class="fa-solid fa-award"></i></div>
              <div>
                <h4>Personal calificat</h4>
                <p>Toți farmaciștii noștri sunt licențiați și în continuă formare.</p>
              </div>
            </div>
            <div class="why-feature">
              <div class="why-feature__icon"><i class="fa-solid fa-credit-card"></i></div>
              <div>
                <h4>Plată flexibilă</h4>
                <p>Acceptăm numerar, card bancar și plată online.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="why-us__image">
          <img src="images/elody.png" alt="Elody Farmacie" />
          <div class="why-us__badge">
            <i class="fa-solid fa-star"></i>
            <span>4.9 / 5 — Rating clienți</span>
          </div>
        </div>
      </section>

      <!-- POSTURI LIBERE -->
      <section class="jobs-section">
        <div class="section-header">
          <h2>Posturi libere</h2>
          <p>Alătură-te echipei Elody Farmacie și construiește o carieră în sănătate</p>
        </div>

        <div class="jobs-grid">

          <div class="job-card">
            <div class="job-card__header">
              <div class="job-card__icon"><i class="fa-solid fa-user-nurse"></i></div>
              <span class="job-badge job-badge--full">Full-time</span>
            </div>
            <h3>Farmacist</h3>
            <p class="job-location"><i class="fa-solid fa-location-dot"></i> Chișinău, Centru</p>
            <p class="job-desc">Căutăm farmacist licențiat pentru a se alătura echipei noastre. Experiență de minim 1 an.</p>
            <div class="job-tags">
              <span>Licență farmacie</span>
              <span>Experiență 1+ ani</span>
              <span>Comunicare</span>
            </div>
            <a href="contact.php" class="job-btn">Aplică acum →</a>
          </div>

          <div class="job-card">
            <div class="job-card__header">
              <div class="job-card__icon"><i class="fa-solid fa-computer"></i></div>
              <span class="job-badge job-badge--part">Part-time</span>
            </div>
            <h3>Asistent farmacist</h3>
            <p class="job-location"><i class="fa-solid fa-location-dot"></i> Chișinău, Botanica</p>
            <p class="job-desc">Post disponibil pentru absolvenți sau studenți în ultimul an la farmacie.</p>
            <div class="job-tags">
              <span>Studenți acceptați</span>
              <span>Program flexibil</span>
              <span>Training inclus</span>
            </div>
            <a href="contact.php" class="job-btn">Aplică acum →</a>
          </div>

          <div class="job-card">
            <div class="job-card__header">
              <div class="job-card__icon"><i class="fa-solid fa-truck"></i></div>
              <span class="job-badge job-badge--full">Full-time</span>
            </div>
            <h3>Curier livrări</h3>
            <p class="job-location"><i class="fa-solid fa-location-dot"></i> Chișinău</p>
            <p class="job-desc">Livrarea comenzilor online către clienți. Permis de conducere categoria B obligatoriu.</p>
            <div class="job-tags">
              <span>Permis categoria B</span>
              <span>Cunoaștere oraș</span>
              <span>Responsabilitate</span>
            </div>
            <a href="contact.php" class="job-btn">Aplică acum →</a>
          </div>

        </div>

        <div class="jobs-cta">
          <p>Nu ai găsit postul potrivit? Trimite-ne CV-ul tău și te contactăm când apare o oportunitate.</p>
          <a href="contact.php" class="btn-primary-pink">
            <i class="fa-solid fa-paper-plane"></i>
            Trimite CV-ul
          </a>
        </div>
      </section>

      <!-- CTA BANNER -->
      <section class="cta-banner">
        <div class="cta-banner__content">
          <h2>Ai nevoie de o consultație?</h2>
          <p>Echipa noastră este disponibilă zilnic pentru a te ajuta cu orice întrebare medicală.</p>
          <div class="cta-banner__actions">
            <a href="tel:+37322000915" class="btn-white">
              <i class="fa-solid fa-phone"></i>
              (+373) 22 000 915
            </a>
            <a href="contact.php" class="btn-outline-white">
              Formular contact →
            </a>
          </div>
        </div>
        <div class="cta-banner__mascot">
          <img src="images/mascotaa.png" alt="Elody" />
        </div>
      </section>

    </div>
  </main>

  <script src="js/theme.js"></script>
</body>
</html>