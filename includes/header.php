<?php
require_once __DIR__ . '/config.php';
$title = isset($title) ? "$title | " . SITE_NAME : SITE_NAME . ' | Infrastructure & EPC Contractor in Ghaziabad, India';
$desc  = $desc ?? 'OctaPower is an infrastructure and EPC contractor in Ghaziabad (Delhi NCR) for civil, mechanical and electrical works: substations, transmission lines, solar plants and O&M across India.';
$path  = current_path();
$canon = SITE_URL . ($path === '/' ? '/' : $path);
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?></title>
<meta name="description" content="<?= e($desc) ?>">
<link rel="canonical" href="<?= e($canon) ?>">
<meta name="theme-color" content="#ff5a00">
<meta property="og:type" content="website">
<meta property="og:title" content="<?= e($title) ?>">
<meta property="og:description" content="<?= e($desc) ?>">
<meta property="og:url" content="<?= e($canon) ?>">
<meta property="og:image" content="<?= SITE_URL ?>/assets/img/logo.webp">
<?php if ($path === '/'): ?>
<script type="application/ld+json"><?= json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'GeneralContractor',
  'name' => SITE_NAME,
  'url' => SITE_URL . '/',
  'logo' => SITE_URL . '/assets/img/logo.webp',
  'image' => SITE_URL . '/assets/img/photos/hero-cranes.webp',
  'telephone' => PHONE,
  'email' => EMAIL,
  'address' => ['@type' => 'PostalAddress', 'streetAddress' => '2nd Floor, S-12, Aditya City Center, Vaibhav Khand, Indirapuram',
    'addressLocality' => 'Ghaziabad', 'addressRegion' => 'Uttar Pradesh', 'postalCode' => '201014', 'addressCountry' => 'IN'],
  'areaServed' => 'IN',
  'description' => $desc,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
<?php endif; ?>
<link rel="icon" type="image/png" href="/assets/img/favicon.png">
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">
<link rel="preload" href="/assets/img/mark-sm.webp" as="image">
<link rel="stylesheet" href="/assets/css/style.css?v=4">
<script>document.documentElement.classList.add("js")</script>
<script defer src="/assets/js/main.js?v=3"></script>
</head>
<body>
<a class="skip" href="#main">Skip to content</a>
<div class="progress" aria-hidden="true"></div>
<header class="nav" id="nav">
  <div class="wrap nav-in">
    <a href="/" class="brand" aria-label="<?= SITE_NAME ?> home">
      <img src="/assets/img/mark-sm.webp" width="47" height="42" alt="">
      <img src="/assets/img/wordmark.webp" class="brand-word" width="166" height="18" alt="<?= SITE_NAME ?>">
    </a>
    <button class="burger" aria-label="Menu" aria-expanded="false" aria-controls="menu"><span></span><span></span><span></span></button>
    <nav id="menu" class="menu" aria-label="Main">
      <?php foreach (NAV as $href => $label): if ($href === '/contact') continue; ?>
        <a href="<?= $href ?>"<?= $path === $href ? ' aria-current="page"' : '' ?>><?= $label ?></a>
      <?php endforeach; ?>
      <a href="/contact" class="btn btn-sm"<?= $path === '/contact' ? ' aria-current="page"' : '' ?>>Get a Quote</a>
    </nav>
  </div>
</header>
<main id="main">
<?php
// Inner-page banner. Home builds its own hero.
function page_hero(string $eyebrow, string $h1, string $sub, string $img = ''): void { ?>
<section class="phero">
  <?php if ($img): ?><div class="bgphoto" aria-hidden="true"><?= photo($img, strip_tags($eyebrow) . ' - ' . SITE_NAME, '100vw', false) ?></div><?php endif; ?>
  <div class="phero-bg" aria-hidden="true"><span></span><span></span><span></span></div>
  <div class="wrap">
    <p class="eyebrow reveal"><?= $eyebrow ?></p>
    <h1 class="reveal"><?= $h1 ?></h1>
    <p class="lead reveal"><?= $sub ?></p>
  </div>
</section>
<?php }
