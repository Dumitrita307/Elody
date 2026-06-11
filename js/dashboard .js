/**
 * dashboard.js — JS pentru profil.php + schimba-profil.php
 * Include la finalul paginii: <script src="js/dashboard.js"></script>
 */

document.addEventListener('DOMContentLoaded', function () {

  // ══════════════════════════════════════════════════════════
  // 1. STATISTICI (profil.php) — citește din localStorage
  // ══════════════════════════════════════════════════════════
  function updateStats() {
    try {
      var fav  = JSON.parse(localStorage.getItem('elody_fav'))  || [];
      var cart = JSON.parse(localStorage.getItem('elody_cart')) || [];
      var fc = document.getElementById('favStatCount');
      var cc = document.getElementById('cartStatCount');
      if (fc) {
        fc.textContent = fav.length;
        animateNumber(fc, 0, fav.length, 600);
      }
      if (cc) {
        var total = cart.reduce(function(s, i) { return s + (i.qty || 1); }, 0);
        cc.textContent = total;
        animateNumber(cc, 0, total, 600);
      }
    } catch(e) {}
  }

  // Animație număr (0 → valoare)
  function animateNumber(el, from, to, duration) {
    if (!el || from === to) return;
    var start = null;
    function step(ts) {
      if (!start) start = ts;
      var progress = Math.min((ts - start) / duration, 1);
      el.textContent = Math.round(from + (to - from) * easeOut(progress));
      if (progress < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }
  function easeOut(t) { return 1 - Math.pow(1 - t, 3); }

  updateStats();

  // ══════════════════════════════════════════════════════════
  // 2. PREVIEW POZĂ (schimba-profil.php)
  // ══════════════════════════════════════════════════════════
  var avatarInput = document.getElementById('avatarInput');
  if (avatarInput) {
    avatarInput.addEventListener('change', function () {
      previewAvatar(this);
    });
  }

  window.previewAvatar = function(input) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];

    // Validare client-side
    var maxSize = 3 * 1024 * 1024;
    var allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (file.size > maxSize) {
      showToast('Poza trebuie să fie mai mică de 3MB!', 'err');
      input.value = '';
      return;
    }
    if (!allowed.includes(file.type)) {
      showToast('Format acceptat: JPG, PNG, GIF, WEBP', 'err');
      input.value = '';
      return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
      var img = document.getElementById('avatarPreviewImg');
      var ph  = document.getElementById('avatarInitials');
      if (img) {
        img.src = e.target.result;
        img.style.display = 'block';
        img.style.animation = 'avatarIn .3s ease';
      }
      if (ph) ph.style.display = 'none';
    };
    reader.readAsDataURL(file);

    // Arată nume fișier + buton salvare
    var fnEl = document.getElementById('avatarFileName');
    var btnEl = document.getElementById('btnUploadConfirm');
    if (fnEl) {
      fnEl.textContent = '📎 ' + file.name + ' (' + formatBytes(file.size) + ')';
      fnEl.style.display = 'block';
    }
    if (btnEl) btnEl.style.display = 'flex';
  };

  function formatBytes(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
  }

  // ══════════════════════════════════════════════════════════
  // 3. TOGGLE VIZIBILITATE PAROLĂ
  // ══════════════════════════════════════════════════════════
  window.togglePass = function(id, btn) {
    var inp = document.getElementById(id);
    if (!inp) return;
    if (inp.type === 'password') {
      inp.type = 'text';
      btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
    } else {
      inp.type = 'password';
      btn.innerHTML = '<i class="fa-solid fa-eye"></i>';
    }
  };

  // ══════════════════════════════════════════════════════════
  // 4. PUTERE PAROLĂ
  // ══════════════════════════════════════════════════════════
  window.checkStrength = function(val) {
    var bar   = document.getElementById('strengthBar');
    var label = document.getElementById('strengthLabel');
    if (!bar) return;

    var score = 0;
    if (val.length >= 6)              score++;
    if (val.length >= 10)             score++;
    if (/[A-Z]/.test(val))            score++;
    if (/[0-9]/.test(val))            score++;
    if (/[^A-Za-z0-9]/.test(val))     score++;

    var levels = [
      { w: '0%',   bg: '#f0f0f0', txt: '' },
      { w: '25%',  bg: '#ef5350', txt: '🔴 Slabă' },
      { w: '50%',  bg: '#ff9800', txt: '🟠 Medie' },
      { w: '75%',  bg: '#29b6f6', txt: '🔵 Bună' },
      { w: '100%', bg: '#66bb6a', txt: '🟢 Excelentă' },
    ];
    var lv = levels[Math.min(score, 4)];
    bar.style.width      = lv.w;
    bar.style.background = lv.bg;
    if (label) {
      label.textContent = lv.txt;
      label.style.color = lv.bg;
    }
  };

  // ══════════════════════════════════════════════════════════
  // 5. VALIDARE FORMULAR la submit
  // ══════════════════════════════════════════════════════════
  var profilForm = document.getElementById('profilForm');
  if (profilForm) {
    profilForm.addEventListener('submit', function(e) {
      var noua    = document.getElementById('parolaNoua');
      var confirm = document.getElementById('parolaConfirm');
      var veche   = document.getElementById('parolaVeche');

      if (noua && noua.value) {
        // Dacă a introdus parolă nouă, trebuie să completeze și pe cea veche
        if (veche && !veche.value) {
          e.preventDefault();
          highlightField(veche, 'Introdu parola actuală!');
          return;
        }
        if (noua.value.length < 6) {
          e.preventDefault();
          highlightField(noua, 'Parola trebuie să aibă minim 6 caractere!');
          return;
        }
        if (confirm && noua.value !== confirm.value) {
          e.preventDefault();
          highlightField(confirm, 'Parolele nu coincid!');
          return;
        }
      }

      // Arată loading pe buton
      var btn = profilForm.querySelector('.btn-save');
      if (btn) {
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Se salvează...';
        btn.disabled = true;
      }
    });
  }

  function highlightField(input, msg) {
    input.style.borderColor = '#ef5350';
    input.focus();
    showToast(msg, 'err');
    input.addEventListener('input', function() {
      input.style.borderColor = '';
    }, { once: true });
  }

  // ══════════════════════════════════════════════════════════
  // 6. TOAST NOTIFICĂRI
  // ══════════════════════════════════════════════════════════
  function showToast(msg, tip) {
    tip = tip || 'ok';
    var container = document.getElementById('dashToasts');
    if (!container) {
      container = document.createElement('div');
      container.id = 'dashToasts';
      container.style.cssText = [
        'position:fixed', 'bottom:2rem', 'right:2rem',
        'z-index:99999', 'display:flex', 'flex-direction:column',
        'gap:.5rem', 'pointer-events:none'
      ].join(';');
      document.body.appendChild(container);
    }

    var t = document.createElement('div');
    t.style.cssText = [
      'background:' + (tip === 'ok' ? '#2e7d32' : '#c62828'),
      'color:#fff', 'padding:.8rem 1.3rem', 'border-radius:12px',
      'font-size:.88rem', 'font-weight:600', 'font-family:Poppins,sans-serif',
      'display:flex', 'align-items:center', 'gap:.5rem',
      'animation:toastIn .28s ease', 'pointer-events:auto',
      'box-shadow:0 4px 16px rgba(0,0,0,.2)'
    ].join(';');
    t.innerHTML = (tip === 'ok' ? '✅' : '❌') + ' ' + msg;

    // Adaugă keyframes dacă nu există
    if (!document.getElementById('toastStyle')) {
      var s = document.createElement('style');
      s.id = 'toastStyle';
      s.textContent = '@keyframes toastIn{from{transform:translateX(70px);opacity:0}to{transform:none;opacity:1}}';
      document.head.appendChild(s);
    }

    container.appendChild(t);
    setTimeout(function() {
      t.style.transition = 'opacity .3s';
      t.style.opacity = '0';
      setTimeout(function() { t.remove(); }, 300);
    }, 3500);
  }

  // Expune global pentru folosire din PHP (mesaje success/error din URL)
  window.dashToast = showToast;

  // Arată automat mesajele din URL (success/error din GET)
  var urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('success')) {
    setTimeout(function() {
      showToast(decodeURIComponent(urlParams.get('success')), 'ok');
    }, 400);
  }
  if (urlParams.get('error')) {
    setTimeout(function() {
      showToast(decodeURIComponent(urlParams.get('error')), 'err');
    }, 400);
  }

  // ══════════════════════════════════════════════════════════
  // 7. ANIMAȚIE AVATAR la hover
  // ══════════════════════════════════════════════════════════
  var style = document.createElement('style');
  style.textContent = '@keyframes avatarIn{from{transform:scale(.8);opacity:0}to{transform:none;opacity:1}}';
  document.head.appendChild(style);

  // ══════════════════════════════════════════════════════════
  // 8. HIGHLIGHT tab activ în sidebar pe baza URL-ului curent
  // ══════════════════════════════════════════════════════════
  var currentPage = window.location.pathname.split('/').pop();
  document.querySelectorAll('.dash-nav__item').forEach(function(link) {
    var href = link.getAttribute('href');
    if (href && href === currentPage) {
      link.classList.add('active');
    }
  });

  // ══════════════════════════════════════════════════════════
  // 9. SMOOTH SCROLL la #address (din profil.php → editează adresă)
  // ══════════════════════════════════════════════════════════
  if (window.location.hash === '#address') {
    var target = document.getElementById('address');
    if (target) {
      setTimeout(function() {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        target.style.outline = '2px solid #e91e63';
        target.style.borderRadius = '20px';
        setTimeout(function() { target.style.outline = ''; }, 2000);
      }, 400);
    }
  }

});
