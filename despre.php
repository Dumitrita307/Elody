<?php
session_start();
$page_title = "Despre noi";
$active_nav = "despre";
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elody Farmacie – Despre noi</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/despre.css" />
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

  <main class="despre-main">

    <!-- HERO -->
    <section class="despre-hero">
      <div class="despre-hero__content">
        <span class="despre-tag">Povestea noastră</span>
        <h1>Sănătatea ta,<br><span>misiunea noastră</span></h1>
        <p>Elody Farmacie este o rețea de farmacii moderne din Republica Moldova, dedicată sănătății și bunăstării fiecărui client. De peste 10 ani oferim produse de calitate și servicii farmaceutice profesioniste.</p>
        <div class="despre-hero__btns">
          <a href="servicii.php" class="btn-pink">
            <i class="fa-solid fa-star"></i> Serviciile noastre
          </a>
          <a href="contact.php" class="btn-outline-pink">
            Contactează-ne →
          </a>
        </div>
      </div>
      <div class="despre-hero__img">
        <img src="images/elody.png" alt="Elody Farmacie" />
        <div class="despre-hero__mascot">
          <img src="images/mascota.png" alt="Mascota Elody" />
        </div>
      </div>
    </section>

    <div class="despre-wrapper">

      <!-- STATS -->
      <section class="despre-stats">
        <div class="dstat">
          <i class="fa-solid fa-calendar-days"></i>
          <span class="dstat__num">10+</span>
          <span class="dstat__lbl">Ani de activitate</span>
        </div>
        <div class="dstat">
          <i class="fa-solid fa-location-dot"></i>
          <span class="dstat__num">3</span>
          <span class="dstat__lbl">Farmacii în Chișinău</span>
        </div>
        <div class="dstat">
          <i class="fa-solid fa-users"></i>
          <span class="dstat__num">50K+</span>
          <span class="dstat__lbl">Clienți mulțumiți</span>
        </div>
        <div class="dstat">
          <i class="fa-solid fa-box-open"></i>
          <span class="dstat__num">500+</span>
          <span class="dstat__lbl">Produse disponibile</span>
        </div>
        <div class="dstat">
          <i class="fa-solid fa-user-nurse"></i>
          <span class="dstat__num">30+</span>
          <span class="dstat__lbl">Farmaciști certificați</span>
        </div>
      </section>

      <!-- POVESTEA -->
      <section class="despre-story">
        <div class="despre-story__img">
          <img src="images/elody.png" alt="Farmacia Elody" />
          <div class="story-badge">
            <i class="fa-solid fa-award"></i>
            <span>Fondată în 2014</span>
          </div>
        </div>
        <div class="despre-story__text">
          <span class="despre-tag">Cine suntem</span>
          <h2>O farmacie construită<br>pe <span>încredere</span></h2>
          <p>Elody Farmacie a fost fondată cu un singur scop: să aducă servicii farmaceutice de calitate mai aproape de oameni. Am pornit cu o singură farmacie în centrul Chișinăului și am crescut constant, deschizând noi locații în Botanica și Râșcani.</p>
          <p>Astăzi suntem una dintre cele mai apreciate rețele de farmacii din Moldova, recunoscută pentru profesionalism, gamă largă de produse și servicii centrate pe client.</p>
          <div class="story-highlights">
            <div class="story-hl">
              <i class="fa-solid fa-check-circle"></i>
              <span>Produse 100% originale</span>
            </div>
            <div class="story-hl">
              <i class="fa-solid fa-check-circle"></i>
              <span>Personal licențiat</span>
            </div>
            <div class="story-hl">
              <i class="fa-solid fa-check-circle"></i>
              <span>Prețuri transparente</span>
            </div>
            <div class="story-hl">
              <i class="fa-solid fa-check-circle"></i>
              <span>Livrare rapidă</span>
            </div>
          </div>
        </div>
      </section>

      <!-- VALORI -->
      <section class="despre-values">
        <div class="section-hdr">
          <h2>Valorile noastre</h2>
          <p>Principiile care ne ghidează în fiecare zi</p>
        </div>
        <div class="values-grid">
          <div class="value-card">
            <div class="value-card__icon" style="background:#fce8f3; color:#e91e8c;">
              <i class="fa-solid fa-heart"></i>
            </div>
            <h3>Grijă față de client</h3>
            <p>Fiecare client este unic. Oferim atenție personalizată și soluții adaptate nevoilor individuale.</p>
          </div>
          <div class="value-card">
            <div class="value-card__icon" style="background:#e8f5e9; color:#2e7d32;">
              <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3>Calitate garantată</h3>
            <p>Toate produsele sunt achiziționate direct de la distribuitori autorizați și verificați.</p>
          </div>
          <div class="value-card">
            <div class="value-card__icon" style="background:#e3f2fd; color:#1565c0;">
              <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h3>Profesionalism</h3>
            <p>Echipa noastră este în continuă formare pentru a oferi cele mai actualizate informații medicale.</p>
          </div>
          <div class="value-card">
            <div class="value-card__icon" style="background:#fff3e0; color:#e65100;">
              <i class="fa-solid fa-lightbulb"></i>
            </div>
            <h3>Inovație continuă</h3>
            <p>Adoptăm tehnologii moderne pentru a îmbunătăți experiența clienților noștri.</p>
          </div>
        </div>
      </section>

      <!-- ECHIPA -->
      <section class="despre-team">
        <div class="section-hdr">
          <h2>Echipa noastră</h2>
          <p>Oamenii care fac Elody Farmacie specială</p>
        </div>
        <div class="team-grid">
          <div class="team-card">
            <div class="team-card__avatar" style="background:linear-gradient(135deg,#e91e8c,#f72685);">E</div>
            <h3>Elena Popescu</h3>
            <span>Farmacist șef — Centru</span>
            <p>15 ani experiență în farmacie clinică și consultanță.</p>
          </div>
          <div class="team-card">
            <div class="team-card__avatar" style="background:linear-gradient(135deg,#7b1fa2,#ab47bc);">A</div>
            <h3>Andrei Munteanu</h3>
            <span>Farmacist — Botanica</span>
            <p>Specializat în produse naturiste și suplimente.</p>
          </div>
          <div class="team-card">
            <div class="team-card__avatar" style="background:linear-gradient(135deg,#0288d1,#29b6f6);">M</div>
            <h3>Maria Cojocaru</h3>
            <span>Farmacist — Râșcani</span>
            <p>Expert în dermatologie și cosmetică farmaceutică.</p>
          </div>
          <div class="team-card">
            <div class="team-card__avatar" style="background:linear-gradient(135deg,#388e3c,#66bb6a);">I</div>
            <h3>Ion Rusu</h3>
            <span>Manager operațional</span>
            <p>Coordonează toate cele 3 locații Elody.</p>
          </div>
        </div>
      </section>

      <!-- LOCATII -->
      <section class="despre-locations">
        <div class="section-hdr">
          <h2>Locațiile noastre</h2>
          <p>Găsește farmacia Elody cea mai apropiată de tine</p>
        </div>
        <div class="locations-grid">
          <div class="location-card">
            <div class="location-card__img">
              <img src="images/ELODY.F.png" alt="Elody Centru" />
            </div>
            <div class="location-card__info">
              <h3><i class="fa-solid fa-location-dot"></i> Elody Centru</h3>
              <p>Str. Ștefan cel Mare 10, Chișinău</p>
              <span class="loc-hours"><i class="fa-regular fa-clock"></i> 08:00 – 22:00</span>
              <a href="contact.php" class="loc-btn">Obține indicații →</a>
            </div>
          </div>
          <div class="location-card">
            <div class="location-card__img">
              <img src="images/elody.png" alt="Elody Botanica" />
            </div>
            <div class="location-card__info">
              <h3><i class="fa-solid fa-location-dot"></i> Elody Botanica</h3>
              <p>Bd. Dacia 25, Chișinău</p>
              <span class="loc-hours"><i class="fa-regular fa-clock"></i> 08:00 – 22:00</span>
              <a href="contact.php" class="loc-btn">Obține indicații →</a>
            </div>
          </div>
          <div class="location-card">
            <div class="location-card__img">
              <img src="images/elody.png" alt="Elody Râșcani" />
            </div>
            <div class="location-card__info">
              <h3><i class="fa-solid fa-location-dot"></i> Elody Râșcani</h3>
              <p>Str. Moscova 15, Chișinău</p>
              <span class="loc-hours"><i class="fa-regular fa-clock"></i> 08:00 – 22:00</span>
              <a href="contact.php" class="loc-btn">Obține indicații →</a>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA -->
      <section class="despre-cta">
        <div class="despre-cta__content">
          <h2>Vino să ne cunoști!</h2>
          <p>Vizitează una din farmaciile noastre sau comandă online. Suntem aici pentru tine în fiecare zi.</p>
          <div class="despre-cta__btns">
            <a href="index.php" class="btn-white-pink">
              <i class="fa-solid fa-house"></i> Înapoi acasă
            </a>
            <a href="contact.php" class="btn-outline-white-pink">
              <i class="fa-solid fa-phone"></i> Contactează-ne
            </a>
          </div>
        </div>
        <img src="images/mascota.png" alt="Elody" class="despre-cta__mascot" />
      </section>

    </div>
  </main>

  <script src="js/theme.js"></script>
</body>
</html>