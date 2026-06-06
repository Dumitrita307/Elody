<?php
session_start();

// Daca e deja logat, redirect la home
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error   = $_GET['error']   ?? '';
$success = $_GET['success'] ?? '';
$tab     = $_GET['tab']     ?? 'login';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elody Farmacie – Contul meu</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/auth.css">
</head>
<body class="auth-page">

  <!-- BACKGROUND BLOBS -->
  <div class="blob blob--1"></div>
  <div class="blob blob--2"></div>
  <div class="blob blob--3"></div>

  <!-- BACK -->
  <a href="index.php" class="back-btn">
    <i class="fa-solid fa-arrow-left"></i> Înapoi acasă
  </a>

  <!-- MASCOTA -->
  <img src="images/mascota.png" alt="Elody" class="auth-mascota" />

  <!-- CARD -->
  <div class="auth-card">

    <!-- LOGO -->
    <a href="index.php" class="auth-logo">
      <img src="images/logo.png" alt="Elody Farmacie" />
    </a>

    <!-- TABS -->
    <div class="auth-tabs">
      <button class="auth-tab <?= $tab === 'login'    ? 'active' : '' ?>" data-tab="login">
        <i class="fa-solid fa-right-to-bracket"></i> Conectare
      </button>
      <button class="auth-tab <?= $tab === 'register' ? 'active' : '' ?>" data-tab="register">
        <i class="fa-solid fa-user-plus"></i> Cont nou
      </button>
    </div>

    <!-- MESAJE -->
    <?php if ($error): ?>
      <div class="auth-alert auth-alert--error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="auth-alert auth-alert--success">
        <i class="fa-solid fa-circle-check"></i>
        <?= htmlspecialchars($success) ?>
      </div>
    <?php endif; ?>

    <!-- ════════════════════
         FORM LOGIN
    ════════════════════ -->
    <form class="auth-form <?= $tab === 'login' ? 'active' : '' ?>"
          id="form-login" action="php/auth.php" method="POST">

      <input type="hidden" name="action" value="login">

      <h2>Bine ai revenit! 👋</h2>
      <p class="auth-subtitle">Conectează-te la contul tău Elody</p>

      <div class="field">
        <label><i class="fa-solid fa-envelope"></i> Email</label>
        <input type="email" name="email" placeholder="exemplu@email.com" required autocomplete="email" />
      </div>

      <div class="field">
        <label><i class="fa-solid fa-lock"></i> Parolă</label>
        <div class="field-pass">
          <input type="password" name="password" id="lpass" placeholder="Parola ta" required />
          <button type="button" class="eye-btn" data-t="lpass"><i class="fa-solid fa-eye"></i></button>
        </div>
      </div>

      <button type="submit" class="btn-primary">
        <i class="fa-solid fa-right-to-bracket"></i> Conectare
      </button>

      <p class="auth-switch">
        Nu ai cont?
        <button type="button" class="link-btn" data-tab="register">Creează unul acum</button>
      </p>

    </form>

    <!-- ════════════════════
         FORM REGISTER
    ════════════════════ -->
    <form class="auth-form <?= $tab === 'register' ? 'active' : '' ?>"
          id="form-register" action="php/auth.php" method="POST"
          onsubmit="return validateRegister()">

      <input type="hidden" name="action" value="register">

      <h2>Creează cont 🌸</h2>
      <p class="auth-subtitle">Alătură-te comunității Elody Farmacie</p>

      <!-- Nume + Prenume -->
      <div class="field-row">
        <div class="field">
          <label><i class="fa-solid fa-user"></i> Nume</label>
          <input type="text" name="last_name" placeholder="Popescu" required minlength="2" />
        </div>
        <div class="field">
          <label><i class="fa-solid fa-user"></i> Prenume</label>
          <input type="text" name="first_name" placeholder="Ion" required minlength="2" />
        </div>
      </div>

      <!-- Email -->
      <div class="field">
        <label><i class="fa-solid fa-envelope"></i> Email</label>
        <input type="email" name="email" placeholder="exemplu@email.com" required autocomplete="email" />
      </div>

      <!-- Telefon -->
      <div class="field">
        <label><i class="fa-solid fa-phone"></i> Nr. telefon</label>
        <div class="field-phone">
          <span class="prefix">+373</span>
          <input type="tel" name="phone" placeholder="69 000 000" required pattern="[0-9\s]{7,12}" />
        </div>
      </div>

      <!-- Parola -->
      <div class="field">
        <label><i class="fa-solid fa-lock"></i> Parolă</label>
        <div class="field-pass">
          <input type="password" name="password" id="rpass" placeholder="Minim 6 caractere" required minlength="6" />
          <button type="button" class="eye-btn" data-t="rpass"><i class="fa-solid fa-eye"></i></button>
        </div>
        <div class="strength-bar"><div class="strength-fill" id="sfill"></div></div>
        <span class="strength-label" id="slabel"></span>
      </div>

      <!-- Confirma parola -->
      <div class="field">
        <label><i class="fa-solid fa-lock"></i> Confirmă parola</label>
        <div class="field-pass">
          <input type="password" name="password_confirm" id="rpass2" placeholder="Repetă parola" required />
          <button type="button" class="eye-btn" data-t="rpass2"><i class="fa-solid fa-eye"></i></button>
        </div>
        <span class="match-label" id="mlabel"></span>
      </div>

      <!-- Terms -->
      <label class="check-label">
        <input type="checkbox" name="terms" required />
        <span class="check-box"></span>
        Sunt de acord cu <a href="#" class="pink-link">Termenii și condițiile</a>
      </label>

      <button type="submit" class="btn-primary">
        <i class="fa-solid fa-user-plus"></i> Creează cont
      </button>

      <p class="auth-switch">
        Ai deja cont?
        <button type="button" class="link-btn" data-tab="login">Conectează-te</button>
      </p>

    </form>

  </div><!-- /auth-card -->

  <script>
  // ── TABS ──────────────────────────────────────
  function switchTab(name) {
    document.querySelectorAll('.auth-tab').forEach(b =>
      b.classList.toggle('active', b.dataset.tab === name));
    document.querySelectorAll('.auth-form').forEach(f =>
      f.classList.remove('active'));
    document.getElementById('form-' + name).classList.add('active');
  }
  document.querySelectorAll('[data-tab]').forEach(el =>
    el.addEventListener('click', () => switchTab(el.dataset.tab)));

  // ── SHOW/HIDE PASSWORD ────────────────────────
  document.querySelectorAll('.eye-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const inp  = document.getElementById(btn.dataset.t);
      const icon = btn.querySelector('i');
      inp.type = inp.type === 'password' ? 'text' : 'password';
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    });
  });

  // ── PASSWORD STRENGTH ─────────────────────────
  const rpass  = document.getElementById('rpass');
  const sfill  = document.getElementById('sfill');
  const slabel = document.getElementById('slabel');

  rpass && rpass.addEventListener('input', () => {
    const v = rpass.value;
    let s = 0;
    if (v.length >= 6)          s++;
    if (v.length >= 10)         s++;
    if (/[A-Z]/.test(v))        s++;
    if (/[0-9]/.test(v))        s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;
    const lvl = [
      {w:'0%',   c:'#eee',    l:''},
      {w:'25%',  c:'#f87171', l:'Slabă'},
      {w:'50%',  c:'#fb923c', l:'Medie'},
      {w:'75%',  c:'#facc15', l:'Bună'},
      {w:'90%',  c:'#4ade80', l:'Puternică'},
      {w:'100%', c:'#22c55e', l:'Excelentă!'},
    ][s];
    sfill.style.width      = lvl.w;
    sfill.style.background = lvl.c;
    slabel.textContent     = lvl.l;
    slabel.style.color     = s >= 4 ? '#16a34a' : s >= 2 ? '#ca8a04' : '#dc2626';
    checkMatch();
  });

  // ── PASSWORD MATCH ────────────────────────────
  const rpass2  = document.getElementById('rpass2');
  const mlabel  = document.getElementById('mlabel');

  function checkMatch() {
    if (!rpass2 || !rpass2.value) { mlabel.textContent = ''; return; }
    const ok = rpass.value === rpass2.value;
    mlabel.textContent = ok ? '✓ Parolele coincid' : '✗ Parolele nu coincid';
    mlabel.style.color = ok ? '#16a34a' : '#dc2626';
  }
  rpass2 && rpass2.addEventListener('input', checkMatch);

  // ── VALIDATE BEFORE SUBMIT ────────────────────
  function validateRegister() {
    if (rpass.value !== rpass2.value) {
      mlabel.textContent = '✗ Parolele nu coincid';
      mlabel.style.color = '#dc2626';
      rpass2.focus();
      return false;
    }
    return true;
  }
  </script>

</body>
</html>