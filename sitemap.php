<?php
require __DIR__ . '/includes/config.php';
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>', "\n", '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
foreach (array_keys(NAV) as $p) echo '<url><loc>', SITE_URL, $p === '/' ? '/' : $p, '</loc></url>';
echo '</urlset>';
