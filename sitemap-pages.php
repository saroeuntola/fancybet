<?php
while (ob_get_level()) ob_end_clean();
ob_start();

header("Content-Type: application/xml; charset=utf-8");

$baseUrl = "https://fancybet.info";
$languages = ['bn', 'en']; // BN first
$today = date('Y-m-d');

$pages = [
    ['slug' => '', 'freq' => 'daily'],
    ['slug' => '/pages/about', 'freq' => 'weekly'],
    ['slug' => '/pages/services', 'freq' => 'weekly'],
    ['slug' => '/pages/contact', 'freq' => 'monthly'],
    ['slug' => '/pages/community', 'freq' => 'daily'],
    ['slug' => '/pages/cricket-news', 'freq' => 'daily'],
    ['slug' => '/pages/cricket-betting-guides', 'freq' => 'daily'],
];

// Start XML
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($pages as $page) {
    foreach ($languages as $lang) {

        $priority = ($lang === 'bn') ? '1.0' : '0.8';

        $loc = rtrim($baseUrl, '/') . '/' . ltrim($page['slug'], '/');
        $loc .= '?lang=' . $lang;

        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
        echo "    <lastmod>{$today}</lastmod>\n";
        echo "    <changefreq>{$page['freq']}</changefreq>\n";
        echo "    <priority>{$priority}</priority>\n";
        echo "  </url>\n";
    }
}

echo "</urlset>";
ob_end_flush();
