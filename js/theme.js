document.addEventListener('DOMContentLoaded', function() {

  // DARK MODE
  var btn  = document.getElementById('themeToggle');
  var html = document.documentElement;

  var saved = localStorage.getItem('elody-theme') || 'light';
  html.setAttribute('data-theme', saved);

  if (btn) {
    btn.addEventListener('click', function() {
      var isDark = html.getAttribute('data-theme') === 'dark';
      var next   = isDark ? 'light' : 'dark';
      html.setAttribute('data-theme', next);
      localStorage.setItem('elody-theme', next);
    });
  }

  // USER DROPDOWN
  var userBtn      = document.getElementById('userBtn');
  var userDropdown = document.getElementById('userDropdown');
  if (userBtn && userDropdown) {
    userBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      userDropdown.classList.toggle('open');
    });
    document.addEventListener('click', function() {
      userDropdown.classList.remove('open');
    });
    userDropdown.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  }

  // MODAL
  var modal    = document.getElementById('authModal');
  var openBtn  = document.getElementById('openModal');
  var closeBtn = document.querySelector('.close-modal');

  if (modal && openBtn) {
    openBtn.addEventListener('click', function() {
      modal.style.display = 'flex';
    });
  }
  if (modal && closeBtn) {
    closeBtn.addEventListener('click', function() {
      modal.style.display = 'none';
    });
  }
  if (modal) {
    window.addEventListener('click', function(e) {
      if (e.target === modal) modal.style.display = 'none';
    });
  }

});