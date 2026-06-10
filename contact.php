<?php
session_start();
$page_title = "Contact";
$active_nav = "contact";
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elody Farmacie – Contact</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/contact.css" />
  <link rel="stylesheet" href="css/produse.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
  <main class="contact-main">

    <!-- HERO BANNER -->
    <section class="contact-hero">
      <div class="contact-hero__content">
        <span class="contact-hero__tag">Contactează-ne</span>
        <h1>Suntem aici <span>pentru tine</span></h1>
        <p>Ai întrebări, sugestii sau ai nevoie de ajutor? Echipa Elody Farmacie îți stă la dispoziție oricând.</p>
        <div class="contact-hero__actions">
          <a href="tel:+37322000915" class="btn-call">
            <i class="fa-solid fa-phone"></i>
            Sună acum
          </a>
          <a href="mailto:contact@elody.md" class="btn-email">
            <i class="fa-solid fa-envelope"></i>
            Trimite email
          </a>
        </div>
      </div>
      <div class="contact-hero__image">
        <img src="images/mascotaa.png" alt="Elody" />
      </div>
    </section>

    <div class="contact-wrapper">

      <!-- INFO CARDS -->
      <section class="contact-info-grid">

        <div class="info-card">
          <div class="info-card__icon">
            <i class="fa-solid fa-location-dot"></i>
          </div>
          <h3>Adresă</h3>
          <p>mun. Chișinău</p>
          <p>str. Calea Orheiului</p>
        </div>

        <div class="info-card">
          <div class="info-card__icon">
            <i class="fa-solid fa-phone"></i>
          </div>
          <h3>Telefon</h3>
          <a href="tel:+37322000915">(+373) 22 000 915</a>
          <a href="tel:+37369000915">(+373) 69 000 915</a>
        </div>

        <div class="info-card">
          <div class="info-card__icon">
            <i class="fa-solid fa-envelope"></i>
          </div>
          <h3>Email</h3>
          <a href="mailto:contact@elody.md">contact@elody.md</a>
          <a href="mailto:info@elody.md">info@elody.md</a>
        </div>

        <div class="info-card">
          <div class="info-card__icon">
            <i class="fa-solid fa-clock"></i>
          </div>
          <h3>Program</h3>
          <p>Luni – Vineri: 08:00 – 22:00</p>
          <p>Sâmbătă – Duminică: 09:00 – 21:00</p>
        </div>

      </section>

      <!-- FORM + MAP -->
      <section class="contact-bottom">

        <!-- FORM -->
        <div class="contact-form-card">
          <div class="contact-form-card__header">
            <h2>Trimite un mesaj</h2>
            <p>Completează formularul și îți răspundem în cel mai scurt timp.</p>
          </div>

          <?php if (isset($_GET['sent'])): ?>
            <div class="form-success">
              <i class="fa-solid fa-circle-check"></i>
              Mesajul tău a fost trimis! Te contactăm în curând.
            </div>
          <?php endif; ?>

          <form class="contact-form" action="php/save_date.php" method="POST">
            <input type="hidden" name="action" value="contact">

            <div class="form-row">
              <div class="form-group">
                <label><i class="fa-solid fa-user"></i> Nume</label>
                <input type="text" name="name" placeholder="Popescu Ion" required />
              </div>
              <div class="form-group">
                <label><i class="fa-solid fa-envelope"></i> Email</label>
                <input type="email" name="email" placeholder="exemplu@email.com" required />
              </div>
            </div>

            <div class="form-group">
              <label><i class="fa-solid fa-phone"></i> Telefon (opțional)</label>
              <input type="tel" name="phone" placeholder="(+373) 69 000 000" />
            </div>

            <div class="form-group">
              <label><i class="fa-solid fa-tag"></i> Subiect</label>
              <select name="subject">
                <option value="">Selectează subiectul</option>
                <option value="informatie">Informații despre produse</option>
                <option value="comanda">Comandă / Livrare</option>
                <option value="retur">Retur produs</option>
                <option value="reclamatie">Reclamație</option>
                <option value="altele">Altele</option>
              </select>
            </div>

            <div class="form-group">
              <label><i class="fa-solid fa-message"></i> Mesaj</label>
              <textarea name="message" rows="5" placeholder="Scrie mesajul tău aici..." required></textarea>
            </div>

            <button type="submit" class="btn-submit-contact">
              <i class="fa-solid fa-paper-plane"></i>
              Trimite mesajul
            </button>
          </form>
        </div>

        <!-- HARTA + SOCIAL -->
        <div class="contact-right">

          <!-- HARTA -->
          <div class="contact-map-card">
            <h3><i class="fa-solid fa-map-location-dot"></i> Locație</h3>
            <div id="contactMap"></div>
          </div>

          <!-- SOCIAL MEDIA -->
          <div class="contact-social-card">
            <h3>Urmărește-ne</h3>
            <p>Fii la curent cu noutățile și ofertele Elody Farmacie.</p>
            <div class="social-links">
              <a href="#" class="social-link social-link--fb">
                <i class="fa-brands fa-facebook-f"></i>
                <span>Facebook</span>
              </a>
              <a href="#" class="social-link social-link--ig">
                <i class="fa-brands fa-instagram"></i>
                <span>Instagram</span>
              </a>
              <a href="#" class="social-link social-link--yt">
                <i class="fa-brands fa-youtube"></i>
                <span>YouTube</span>
              </a>
            </div>
          </div>

          <!-- DATE JURIDICE -->
          <div class="contact-legal-card">
            <h3><i class="fa-solid fa-building"></i> Date juridice</h3>
            <div class="legal-grid">
              <div>
                <span>Companie</span>
                <p>SRL Elody Farmacie</p>
              </div>
              <div>
                <span>Cod fiscal</span>
                <p>1234567890123</p>
              </div>
              <div>
                <span>IBAN</span>
                <p>MD00XX0000000000000000</p>
              </div>
              <div>
                <span>Bancă</span>
                <p>BC Moldova-Agroindbank SA</p>
              </div>
            </div>
          </div>

        </div>
      </section>

    </div>
  </main>

  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    var map = L.map('contactMap').setView([47.0245, 28.8320], 14);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom:19 }).addTo(map);
    L.marker([47.0245, 28.8320]).addTo(map).bindPopup("<b>Elody Centru</b><br>Str. Ștefan cel Mare 10").openPopup();
  </script>
  <script src="js/theme.js"></script>
</body>
</html>