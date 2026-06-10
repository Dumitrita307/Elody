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

    <a href="produse.php" class="nav-link">
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