<?php
// ================================================================
// SNIPPET — Butonul de limbă
// Pune acest cod în index.php (și orice pagină) acolo unde vrei
// să apară butonul RO/EN/RU (ex: în hero sau în navbar)
// ================================================================
// ÎNAINTE de a folosi, asigură-te că ai: require_once 'php/lang.php';
// ================================================================
?>

<!-- ── BUTON LIMBĂ ── -->
<div class="lang-switcher">
  <button class="lang-btn" id="langBtn">
    <?php
      $flags = ['ro' => '🇷🇴', 'en' => '🇬🇧', 'ru' => '🇷🇺'];
      $labels = ['ro' => 'RO', 'en' => 'EN', 'ru' => 'RU'];
      echo $flags[$limba] . ' ' . $labels[$limba];
    ?>
    <svg width="10" height="10" viewBox="0 0 10 10" style="margin-left:3px">
      <path d="M1 3l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/>
    </svg>
  </button>
  <div class="lang-dropdown" id="langDropdown">
    <?php
    $langs = ['ro' => ['flag'=>'🇷🇴','label'=>'Română'],
              'en' => ['flag'=>'🇬🇧','label'=>'English'],
              'ru' => ['flag'=>'🇷🇺','label'=>'Русский']];
    foreach ($langs as $cod => $info):
      $activ = $limba === $cod ? 'activ' : '';
      $url   = '?lang=' . $cod;
    ?>
    <a href="<?= $url ?>" class="lang-opt <?= $activ ?>">
      <span class="lang-flag"><?= $info['flag'] ?></span>
      <span><?= $info['label'] ?></span>
      <?php if ($activ): ?><span class="lang-check">✓</span><?php endif; ?>
    </a>
    <?php endforeach; ?>
  </div>
</div>

<!-- ── CSS BUTON LIMBĂ (pune în style.css sau în <head>) ── -->
<style>
.lang-switcher {
  position: relative;
  display: inline-block;
}
.lang-btn {
  display: flex;
  align-items: center;
  gap: 5px;
  background: rgba(233, 30, 99, 0.1);
  border: 2px solid #e91e63;
  color: #e91e63;
  border-radius: 50px;
  padding: 6px 14px;
  font-size: .85rem;
  font-weight: 800;
  cursor: pointer;
  font-family: 'Nunito', sans-serif;
  transition: background .15s, color .15s;
  letter-spacing: .04em;
}
.lang-btn:hover {
  background: #e91e63;
  color: #fff;
}
/* Butonul din hero (stilul exact ca cel din screenshot — rotunjit roz pal) */
.lang-btn.hero-style {
  background: #f5c6d8;
  border: none;
  color: #c2185b;
  font-size: .9rem;
  padding: 7px 18px;
  box-shadow: 0 2px 10px rgba(233,30,99,.15);
}
.lang-btn.hero-style:hover {
  background: #e91e63;
  color: #fff;
}

.lang-dropdown {
  display: none;
  position: absolute;
  top: calc(100% + 8px);
  left: 50%;
  transform: translateX(-50%);
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 8px 30px rgba(0,0,0,.13);
  min-width: 150px;
  overflow: hidden;
  border: 1.5px solid #fce4ec;
  z-index: 9999;
  animation: ldIn .18s ease;
}
@keyframes ldIn {
  from { opacity:0; transform: translateX(-50%) translateY(-6px); }
  to   { opacity:1; transform: translateX(-50%) translateY(0); }
}
.lang-switcher:hover .lang-dropdown,
.lang-switcher.open .lang-dropdown {
  display: block;
}
.lang-opt {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 16px;
  text-decoration: none;
  color: #333;
  font-size: .88rem;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  transition: background .12s;
}
.lang-opt:hover { background: #fce4ec; color: #e91e63; }
.lang-opt.activ { background: #fff0f5; color: #e91e63; }
.lang-flag { font-size: 1.1rem; }
.lang-check { margin-left: auto; color: #e91e63; font-weight: 900; }
</style>

<script>
// Deschide/închide la click pe mobil
document.getElementById('langBtn')?.addEventListener('click', function(e) {
  e.stopPropagation();
  this.closest('.lang-switcher').classList.toggle('open');
});
document.addEventListener('click', function() {
  document.querySelectorAll('.lang-switcher.open')
    .forEach(el => el.classList.remove('open'));
});
</script>