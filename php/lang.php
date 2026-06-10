<?php
// ══════════════════════════════════
// SISTEM DE TRADUCERE — lang.php
// Include acest fisier in fiecare pagina
// ══════════════════════════════════

session_start_if_not_started();

function session_start_if_not_started() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Seteaza limba
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ro', 'ru', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang = $_SESSION['lang'] ?? 'ro';

// ══ TRADUCERI ══
$translations = [

  'ro' => [
    // NAVBAR
    'acasa'        => 'Acasă',
    'despre'       => 'Despre noi',
    'produse'      => 'Produse',
    'servicii'     => 'Servicii',
    'contact'      => 'Contact',
    'cauta'        => 'Caută produse...',
    'contul_meu'   => 'Contul meu',
    'profil'       => 'Profilul meu',
    'schimba'      => 'Schimbă profilul',
    'deconectare'  => 'Deconectare',
    'conectare'    => 'Conectare',

    // HERO
    'hero_title1'  => 'Sănătatea ta ,',
    'hero_title2'  => 'prioritatea noastră',
    'hero_desc'    => 'Alege din gama noastră variată de produse și beneficiază de servicii de calitate.',
    'vezi_produse' => 'Vezi produse',
    'despre_noi'   => 'Despre noi',

    // CATEGORIES
    'medicamente'  => 'Medicamente',
    'vitamine'     => 'Vitamine și suplimente',
    'ingrijire'    => 'Îngrijire personală',
    'mama_copilul' => 'Mama și copilul',
    'naturiste'    => 'Produse naturiste',

    // HELP
    'ajutor_titlu' => 'Ai nevoie de ajutor?',
    'suna_acum'    => 'Sună-mă acum',

    // BENEFITS
    'livrare'      => 'Livrare rapidă',
    'livrare_desc' => 'Livrăm în toată Moldova',
    'plata'        => 'Plată securizată',
    'plata_desc'   => 'Metode sigure de plată',
    'calitate'     => 'Produse de calitate',
    'calitate_desc'=> 'Doar produse originale',
    'suport'       => 'Suport clienți',
    'suport_desc'  => 'Suntem aici pentru tine',

    // PRODUCTS
    'prod_populare'=> 'Produse populare',
    'vezi_toate'   => 'Vezi toate produsele →',
    'adauga_cos'   => 'Adaugă în coș',
    'in_stoc'      => 'În stoc',
    'stoc_epuizat' => 'Stoc epuizat',

    // CART
    'cosul_tau'    => 'Coșul tău',
    'cos_gol'      => 'Coșul este gol',
    'total'        => 'Total',
    'finalizeaza'  => 'Finalizează comanda',
    'sterge'       => 'Șterge',

    // WISHLIST
    'favorite'     => 'Favorite',
    'fara_favorite'=> 'Nu ai produse favorite',
    'colectii'     => 'Colecțiile mele',

    // SEARCH
    'cauta_rezultate' => 'Rezultate pentru',
    'fara_rezultate'  => 'Niciun rezultat găsit',

    // FOOTER
    'misiune'      => 'Misiunea noastră este de a satisface necesitățile clienților prin personal profesionist.',
    'linkuri'      => 'LINKURI UTILE',
    'informatii'   => 'INFORMAȚII',
    'contacte'     => 'CONTACTE',
    'urmareste'    => 'URMĂREȘTE-NE',
    'aboneaza'     => 'Abonează-te la noutăți',
    'email_pl'     => 'Adresa ta de e-mail',
    'drepturi'     => '© ELODY.MD | All Rights reserved',
  ],

  'ru' => [
    'acasa'        => 'Главная',
    'despre'       => 'О нас',
    'produse'      => 'Продукты',
    'servicii'     => 'Услуги',
    'contact'      => 'Контакты',
    'cauta'        => 'Поиск продуктов...',
    'contul_meu'   => 'Мой аккаунт',
    'profil'       => 'Мой профиль',
    'schimba'      => 'Изменить профиль',
    'deconectare'  => 'Выйти',
    'conectare'    => 'Войти',
    'hero_title1'  => 'Ваше здоровье,',
    'hero_title2'  => 'наш приоритет',
    'hero_desc'    => 'Выбирайте из нашего широкого ассортимента продуктов и пользуйтесь качественными услугами.',
    'vezi_produse' => 'Смотреть продукты',
    'despre_noi'   => 'О нас',
    'medicamente'  => 'Медикаменты',
    'vitamine'     => 'Витамины и добавки',
    'ingrijire'    => 'Уход за собой',
    'mama_copilul' => 'Мама и ребёнок',
    'naturiste'    => 'Натуральные продукты',
    'ajutor_titlu' => 'Нужна помощь?',
    'suna_acum'    => 'Позвоните нам',
    'livrare'      => 'Быстрая доставка',
    'livrare_desc' => 'Доставка по всей Молдове',
    'plata'        => 'Безопасная оплата',
    'plata_desc'   => 'Надёжные способы оплаты',
    'calitate'     => 'Качественные продукты',
    'calitate_desc'=> 'Только оригинальная продукция',
    'suport'       => 'Поддержка клиентов',
    'suport_desc'  => 'Мы здесь для вас',
    'prod_populare'=> 'Популярные продукты',
    'vezi_toate'   => 'Смотреть все продукты →',
    'adauga_cos'   => 'В корзину',
    'in_stoc'      => 'В наличии',
    'stoc_epuizat' => 'Нет в наличии',
    'cosul_tau'    => 'Ваша корзина',
    'cos_gol'      => 'Корзина пуста',
    'total'        => 'Итого',
    'finalizeaza'  => 'Оформить заказ',
    'sterge'       => 'Удалить',
    'favorite'     => 'Избранное',
    'fara_favorite'=> 'Нет избранных товаров',
    'colectii'     => 'Мои коллекции',
    'cauta_rezultate' => 'Результаты для',
    'fara_rezultate'  => 'Ничего не найдено',
    'misiune'      => 'Наша миссия — удовлетворять потребности клиентов через профессиональный персонал.',
    'linkuri'      => 'ПОЛЕЗНЫЕ ССЫЛКИ',
    'informatii'   => 'ИНФОРМАЦИЯ',
    'contacte'     => 'КОНТАКТЫ',
    'urmareste'    => 'СЛЕДИТЕ ЗА НАМИ',
    'aboneaza'     => 'Подпишитесь на новости',
    'email_pl'     => 'Ваш e-mail',
    'drepturi'     => '© ELODY.MD | Все права защищены',
  ],

  'en' => [
    'acasa'        => 'Home',
    'despre'       => 'About us',
    'produse'      => 'Products',
    'servicii'     => 'Services',
    'contact'      => 'Contact',
    'cauta'        => 'Search products...',
    'contul_meu'   => 'My account',
    'profil'       => 'My profile',
    'schimba'      => 'Edit profile',
    'deconectare'  => 'Log out',
    'conectare'    => 'Log in',
    'hero_title1'  => 'Your health,',
    'hero_title2'  => 'our priority',
    'hero_desc'    => 'Choose from our wide range of products and benefit from quality services.',
    'vezi_produse' => 'View products',
    'despre_noi'   => 'About us',
    'medicamente'  => 'Medicines',
    'vitamine'     => 'Vitamins & Supplements',
    'ingrijire'    => 'Personal care',
    'mama_copilul' => 'Mom & Baby',
    'naturiste'    => 'Natural products',
    'ajutor_titlu' => 'Need help?',
    'suna_acum'    => 'Call us now',
    'livrare'      => 'Fast delivery',
    'livrare_desc' => 'Delivery across Moldova',
    'plata'        => 'Secure payment',
    'plata_desc'   => 'Safe payment methods',
    'calitate'     => 'Quality products',
    'calitate_desc'=> 'Only original products',
    'suport'       => 'Customer support',
    'suport_desc'  => 'We are here for you',
    'prod_populare'=> 'Popular products',
    'vezi_toate'   => 'View all products →',
    'adauga_cos'   => 'Add to cart',
    'in_stoc'      => 'In stock',
    'stoc_epuizat' => 'Out of stock',
    'cosul_tau'    => 'Your cart',
    'cos_gol'      => 'Cart is empty',
    'total'        => 'Total',
    'finalizeaza'  => 'Checkout',
    'sterge'       => 'Remove',
    'favorite'     => 'Favorites',
    'fara_favorite'=> 'No favorite products yet',
    'colectii'     => 'My collections',
    'cauta_rezultate' => 'Results for',
    'fara_rezultate'  => 'No results found',
    'misiune'      => 'Our mission is to meet customers needs through professional staff.',
    'linkuri'      => 'USEFUL LINKS',
    'informatii'   => 'INFORMATION',
    'contacte'     => 'CONTACTS',
    'urmareste'    => 'FOLLOW US',
    'aboneaza'     => 'Subscribe to news',
    'email_pl'     => 'Your e-mail address',
    'drepturi'     => '© ELODY.MD | All Rights reserved',
  ],
];

$t = $translations[$lang];

// Functie helper
function t(string $key): string {
    global $t;
    return htmlspecialchars($t[$key] ?? $key);
}