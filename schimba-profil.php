<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect=schimba-profil.php');
    exit;
}

$dbFile = __DIR__ . '/data/users.json';
$users  = file_exists($dbFile) ? json_decode(file_get_contents($dbFile), true) : [];
$user   = null;
foreach ($users as $u) {
    if ($u['id'] === $_SESSION['user_id']) { $user = $u; break; }
}

$success = $_GET['success'] ?? '';
$error   = $_GET['error']   ?? '';

$avatar   = $user['avatar'] ?? '';
$initials = strtoupper(mb_substr($user['first_name'] ?? 'U', 0, 1));
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Elody – Editează profilul</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/dashboard.css">
  <style>
  /* ── Layout ── */
  .dash-main   { min-height:100vh; background:#f8f8fb; padding:2rem 1.5rem; }
  .dash-wrapper{ max-width:1100px; margin:0 auto; display:grid; grid-template-columns:260px 1fr; gap:2rem; align-items:start; }

  /* ── Sidebar ── */
  .dash-sidebar{ background:#fff; border-radius:20px; box-shadow:0 4px 20px rgba(0,0,0,.06); padding:2rem 1.2rem; position:sticky; top:90px; }
  .dash-avatar-wrap{ text-align:center; padding-bottom:1.5rem; border-bottom:2px solid #f5f5f5; margin-bottom:1rem; }
  .dash-avatar-img{ width:80px; height:80px; border-radius:50%; object-fit:cover; border:3px solid #e91e63; }
  .dash-avatar-placeholder{ width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg,#e91e63,#f48fb1); color:#fff; font-size:2rem; font-weight:800; display:flex; align-items:center; justify-content:center; margin:0 auto 0.75rem; }
  .dash-avatar-wrap h3{ font-size:1rem; font-weight:800; margin:.5rem 0 .2rem; }
  .dash-avatar-wrap span{ font-size:.8rem; color:#aaa; }
  .dash-nav{ display:flex; flex-direction:column; gap:.3rem; }
  .dash-nav__item{ display:flex; align-items:center; gap:.7rem; padding:.7rem 1rem; border-radius:12px; text-decoration:none; color:#444; font-size:.9rem; font-weight:600; transition:background .15s,color .15s; }
  .dash-nav__item:hover{ background:#fce4ec; color:#e91e63; }
  .dash-nav__item.active{ background:#fce4ec; color:#e91e63; }
  .dash-nav__item--red{ color:#e57373; }
  .dash-nav__item--red:hover{ background:#fff5f5; color:#c62828; }
  .dash-nav__divider{ height:1px; background:#f0f0f0; margin:.5rem 0; }

  /* ── Content ── */
  .dash-content{ display:flex; flex-direction:column; gap:1.5rem; }
  .alert{ padding:1rem 1.3rem; border-radius:12px; font-size:.9rem; font-weight:600; display:flex; align-items:center; gap:.6rem; }
  .alert--success{ background:#f0fdf4; color:#15803d; border:1.5px solid #bbf7d0; }
  .alert--error  { background:#fff5f5; color:#c62828; border:1.5px solid #fecaca; }

  /* ── Card secțiuni ── */
  .edit-card{ background:#fff; border-radius:20px; box-shadow:0 4px 20px rgba(0,0,0,.06); overflow:hidden; }
  .edit-card-header{ padding:1.3rem 1.8rem; border-bottom:2px solid #f5f5f5; display:flex; align-items:center; gap:.7rem; }
  .edit-card-header h2{ font-size:1.05rem; font-weight:800; font-family:'Nunito',sans-serif; }
  .edit-card-header i{ color:#e91e63; font-size:1.1rem; }
  .edit-card-body{ padding:1.8rem; }

  /* ── Avatar upload ── */
  .avatar-edit-wrap{ display:flex; align-items:center; gap:2rem; flex-wrap:wrap; }
  .avatar-preview-big{ width:110px; height:110px; border-radius:50%; object-fit:cover; border:4px solid #fce4ec; flex-shrink:0; }
  .avatar-placeholder-big{ width:110px; height:110px; border-radius:50%; background:linear-gradient(135deg,#e91e63,#f48fb1); color:#fff; font-size:2.5rem; font-weight:900; display:flex; align-items:center; justify-content:center; flex-shrink:0; border:4px solid #fce4ec; }
  .avatar-upload-zone{ display:flex; flex-direction:column; gap:.75rem; }
  .avatar-upload-zone p{ font-size:.85rem; color:#aaa; margin:0; }
  .btn-upload-avatar{ display:inline-flex; align-items:center; gap:.5rem; padding:.7rem 1.4rem; background:#e91e63; color:#fff; border:none; border-radius:12px; font-weight:700; font-size:.88rem; cursor:pointer; transition:background .15s; font-family:'Poppins',sans-serif; }
  .btn-upload-avatar:hover{ background:#c2185b; }
  #avatarPreviewImg{ display:none; }

  /* ── Form grid ── */
  .form-grid{ display:grid; grid-template-columns:1fr 1fr; gap:1.2rem; }
  .form-grid.full{ grid-template-columns:1fr; }
  .fg{ display:flex; flex-direction:column; gap:.4rem; }
  .fg.span2{ grid-column:1/-1; }
  .fg label{ font-size:.82rem; font-weight:700; color:#555; }
  .fg input, .fg select, .fg textarea{
    padding:.8rem 1rem; border:2px solid #f0f0f0; border-radius:12px;
    font-size:.92rem; font-family:'Poppins',sans-serif;
    background:#fafafa; transition:border-color .2s, background .2s;
    color:#222;
  }
  .fg input:focus, .fg select:focus, .fg textarea:focus{
    outline:none; border-color:#e91e63; background:#fff;
  }
  .fg textarea{ resize:vertical; min-height:90px; }
  .fg .hint{ font-size:.75rem; color:#bbb; margin-top:.2rem; }

  /* ── Parola strength ── */
  .pass-wrap{ position:relative; }
  .pass-wrap input{ padding-right:3rem; width:100%; }
  .pass-toggle{ position:absolute; right:.9rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#bbb; font-size:1rem; }
  .pass-strength{ height:4px; border-radius:2px; margin-top:.4rem; background:#f0f0f0; overflow:hidden; }
  .pass-strength-bar{ height:100%; border-radius:2px; width:0; transition:width .3s,background .3s; }

  /* ── Butoane ── */
  .form-actions{ display:flex; gap:1rem; margin-top:.5rem; flex-wrap:wrap; }
  .btn-save{ padding:.9rem 2rem; background:#e91e63; color:#fff; border:none; border-radius:14px; font-weight:800; font-size:.95rem; cursor:pointer; font-family:'Nunito',sans-serif; transition:background .15s,transform .1s; display:flex; align-items:center; gap:.5rem; }
  .btn-save:hover{ background:#c2185b; transform:translateY(-1px); }
  .btn-cancel{ padding:.9rem 1.6rem; background:#fff; color:#888; border:2px solid #f0f0f0; border-radius:14px; font-weight:600; font-size:.92rem; cursor:pointer; font-family:'Poppins',sans-serif; text-decoration:none; display:flex; align-items:center; gap:.5rem; }
  .btn-cancel:hover{ border-color:#e91e63; color:#e91e63; }

  /* ── Separatoare secțiuni ── */
  .section-divider{ display:flex; align-items:center; gap:1rem; color:#ddd; font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; }
  .section-divider::before,.section-divider::after{ content:''; flex:1; height:1px; background:#f0f0f0; }

  @media(max-width:768px){
    .dash-wrapper{ grid-template-columns:1fr; }
    .dash-sidebar{ position:static; }
    .form-grid{ grid-template-columns:1fr; }
    .fg.span2{ grid-column:1; }
    .avatar-edit-wrap{ flex-direction:column; align-items:flex-start; gap:1rem; }
  }
  </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<main class="dash-main">
  <div class="dash-wrapper">

    <!-- SIDEBAR -->
    <aside class="dash-sidebar">
      <div class="dash-avatar-wrap">
        <?php if ($avatar && file_exists('uploads/' . $avatar)): ?>
          <img src="uploads/<?= htmlspecialchars($avatar) ?>" class="dash-avatar-img" alt="Avatar" id="sidebarAvatar"/>
        <?php else: ?>
          <div class="dash-avatar-placeholder"><?= $initials ?></div>
        <?php endif; ?>
        <h3><?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?></h3>
        <span><?= htmlspecialchars($user['email'] ?? '') ?></span>
      </div>
      <nav class="dash-nav">
        <a href="profil.php"        class="dash-nav__item"><i class="fa-solid fa-user"></i> Profilul meu</a>
        <a href="schimba-profil.php"class="dash-nav__item active"><i class="fa-solid fa-pen-to-square"></i> Editează profilul</a>
        <a href="cupoane.php"       class="dash-nav__item"><i class="fa-solid fa-ticket"></i> Cupoanele mele</a>
        <a href="favorite.php"      class="dash-nav__item"><i class="fa-solid fa-heart"></i> Favorite</a>
        <a href="cos.php"           class="dash-nav__item"><i class="fa-solid fa-cart-shopping"></i> Coșul meu</a>
        <div class="dash-nav__divider"></div>
        <a href="logout.php" class="dash-nav__item dash-nav__item--red"><i class="fa-solid fa-right-from-bracket"></i> Deconectare</a>
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

      <!-- ═══ POZA DE PROFIL ═══════════════════════════════════════ -->
      <div class="edit-card">
        <div class="edit-card-header">
          <i class="fa-solid fa-camera"></i>
          <h2>Poza de profil</h2>
        </div>
        <div class="edit-card-body">
          <div class="avatar-edit-wrap">
            <!-- Preview -->
            <div id="avatarPreviewWrap">
              <?php if ($avatar && file_exists('uploads/' . $avatar)): ?>
                <img src="uploads/<?= htmlspecialchars($avatar) ?>" class="avatar-preview-big" id="avatarPreviewImg" style="display:block"/>
              <?php else: ?>
                <div class="avatar-placeholder-big" id="avatarInitials"><?= $initials ?></div>
                <img src="" class="avatar-preview-big" id="avatarPreviewImg" style="display:none"/>
              <?php endif; ?>
            </div>
            <!-- Upload -->
            <div class="avatar-upload-zone">
              <p>Format acceptat: JPG, PNG, WEBP · Max 3MB</p>
              <form action="php/upload_avatar.php" method="POST" enctype="multipart/form-data" id="avatarForm">
                <label class="btn-upload-avatar">
                  <i class="fa-solid fa-arrow-up-from-bracket"></i>
                  Alege o poză nouă
                  <input type="file" name="avatar" accept="image/*" id="avatarInput" style="display:none" onchange="previewAvatar(this)">
                </label>
              </form>
              <p id="avatarFileName" style="font-size:.8rem;color:#e91e63;display:none"></p>
              <button class="btn-save" id="btnUploadConfirm" onclick="document.getElementById('avatarForm').submit()" style="display:none;padding:.65rem 1.3rem;font-size:.85rem">
                <i class="fa-solid fa-check"></i> Salvează poza
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══ DATE PERSONALE ════════════════════════════════════════ -->
      <form action="php/save_profil.php" method="POST" id="profilForm">

        <div class="edit-card">
          <div class="edit-card-header">
            <i class="fa-solid fa-id-card"></i>
            <h2>Date personale</h2>
          </div>
          <div class="edit-card-body">
            <div class="form-grid">
              <div class="fg">
                <label>Prenume</label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" placeholder="Ex: Maria">
              </div>
              <div class="fg">
                <label>Nume de familie</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" placeholder="Ex: Popescu">
              </div>
              <div class="fg">
                <label>Email</label>
                <input type="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled style="opacity:.6;cursor:not-allowed">
                <span class="hint">Emailul nu poate fi schimbat</span>
              </div>
              <div class="fg">
                <label>Număr de telefon</label>
                <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="+373 69 000 000">
              </div>
              <div class="fg">
                <label>Data nașterii</label>
                <input type="date" name="birthday" value="<?= htmlspecialchars($user['birthday'] ?? '') ?>">
              </div>
              <div class="fg">
                <label>Gen</label>
                <select name="gender">
                  <option value="">— Selectează —</option>
                  <option value="masculin"  <?= ($user['gender']??'')==='masculin' ?'selected':'' ?>>Masculin</option>
                  <option value="feminin"   <?= ($user['gender']??'')==='feminin'  ?'selected':'' ?>>Feminin</option>
                  <option value="altul"     <?= ($user['gender']??'')==='altul'    ?'selected':'' ?>>Prefer să nu spun</option>
                </select>
              </div>
              <div class="fg span2">
                <label>Despre mine <span style="color:#bbb;font-weight:400">(opțional)</span></label>
                <textarea name="bio" placeholder="Scrie câteva cuvinte despre tine..."><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- ═══ ADRESĂ ════════════════════════════════════════════════ -->
        <div class="edit-card" style="margin-top:1.5rem" id="address">
          <div class="edit-card-header">
            <i class="fa-solid fa-location-dot"></i>
            <h2>Adresă de livrare</h2>
          </div>
          <div class="edit-card-body">
            <div class="form-grid">
              <div class="fg span2">
                <label>Stradă și număr</label>
                <input type="text" name="street" value="<?= htmlspecialchars($user['address']['street'] ?? '') ?>" placeholder="Ex: Str. Ștefan cel Mare 10, ap. 5">
              </div>
              <div class="fg">
                <label>Oraș</label>
                <input type="text" name="city" value="<?= htmlspecialchars($user['address']['city'] ?? '') ?>" placeholder="Ex: Chișinău">
              </div>
              <div class="fg">
                <label>Cod poștal</label>
                <input type="text" name="zip" value="<?= htmlspecialchars($user['address']['zip'] ?? '') ?>" placeholder="Ex: MD-2001">
              </div>
            </div>
          </div>
        </div>

        <!-- ═══ SCHIMBĂ PAROLA ════════════════════════════════════════ -->
        <div class="edit-card" style="margin-top:1.5rem">
          <div class="edit-card-header">
            <i class="fa-solid fa-lock"></i>
            <h2>Schimbă parola</h2>
          </div>
          <div class="edit-card-body">
            <p style="font-size:.85rem;color:#aaa;margin-bottom:1.2rem">
              Lasă câmpurile goale dacă nu dorești să schimbi parola.
            </p>
            <div class="form-grid">
              <div class="fg span2">
                <label>Parola actuală</label>
                <div class="pass-wrap">
                  <input type="password" name="parola_veche" id="parolaVeche" placeholder="Introdu parola actuală">
                  <button type="button" class="pass-toggle" onclick="togglePass('parolaVeche',this)"><i class="fa-solid fa-eye"></i></button>
                </div>
              </div>
              <div class="fg">
                <label>Parola nouă</label>
                <div class="pass-wrap">
                  <input type="password" name="parola_noua" id="parolaNoua" placeholder="Minim 6 caractere" oninput="checkStrength(this.value)">
                  <button type="button" class="pass-toggle" onclick="togglePass('parolaNoua',this)"><i class="fa-solid fa-eye"></i></button>
                </div>
                <div class="pass-strength"><div class="pass-strength-bar" id="strengthBar"></div></div>
                <span class="hint" id="strengthLabel"></span>
              </div>
              <div class="fg">
                <label>Confirmă parola nouă</label>
                <div class="pass-wrap">
                  <input type="password" name="parola_confirm" id="parolaConfirm" placeholder="Repetă parola nouă">
                  <button type="button" class="pass-toggle" onclick="togglePass('parolaConfirm',this)"><i class="fa-solid fa-eye"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ═══ BUTOANE ══════════════════════════════════════════════ -->
        <div class="form-actions" style="margin-top:1.5rem">
          <button type="submit" class="btn-save">
            <i class="fa-solid fa-floppy-disk"></i> Salvează modificările
          </button>
          <a href="profil.php" class="btn-cancel">
            <i class="fa-solid fa-xmark"></i> Anulează
          </a>
        </div>

      </form>

    </div><!-- end dash-content -->
  </div><!-- end dash-wrapper -->
</main>

<script>
// Preview poză înainte de upload
function previewAvatar(input) {
  if (!input.files || !input.files[0]) return;
  const file = input.files[0];
  const reader = new FileReader();
  reader.onload = function(e) {
    const img = document.getElementById('avatarPreviewImg');
    const ph  = document.getElementById('avatarInitials');
    img.src = e.target.result;
    img.style.display = 'block';
    if (ph) ph.style.display = 'none';
  };
  reader.readAsDataURL(file);
  document.getElementById('avatarFileName').textContent  = '📎 ' + file.name;
  document.getElementById('avatarFileName').style.display = 'block';
  document.getElementById('btnUploadConfirm').style.display = 'flex';
}

// Toggle vizibilitate parolă
function togglePass(id, btn) {
  const inp = document.getElementById(id);
  if (inp.type === 'password') {
    inp.type = 'text';
    btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
  } else {
    inp.type = 'password';
    btn.innerHTML = '<i class="fa-solid fa-eye"></i>';
  }
}

// Putere parolă
function checkStrength(val) {
  const bar   = document.getElementById('strengthBar');
  const label = document.getElementById('strengthLabel');
  if (!bar) return;
  let score = 0;
  if (val.length >= 6)  score++;
  if (val.length >= 10) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const levels = [
    { w:'0%',   bg:'#f0f0f0', txt:'' },
    { w:'25%',  bg:'#ef5350', txt:'Slabă' },
    { w:'50%',  bg:'#ff9800', txt:'Medie' },
    { w:'75%',  bg:'#29b6f6', txt:'Bună' },
    { w:'100%', bg:'#66bb6a', txt:'Excelentă' },
  ];
  const lv = levels[Math.min(score, 4)];
  bar.style.width      = lv.w;
  bar.style.background = lv.bg;
  label.textContent    = lv.txt;
  label.style.color    = lv.bg;
}

// Validare client-side la submit
document.getElementById('profilForm')?.addEventListener('submit', function(e) {
  const noua    = document.getElementById('parolaNoua').value;
  const confirm = document.getElementById('parolaConfirm').value;
  if (noua && noua !== confirm) {
    e.preventDefault();
    alert('Parolele noi nu coincid!');
    document.getElementById('parolaConfirm').focus();
  }
});
</script>

<script src="js/theme.js"></script>
</body>
</html>
