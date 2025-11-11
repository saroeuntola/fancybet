<?php
// ===========================================
// FancyBet Pages Sitemap (with favicon crawl)
// ===========================================
while (ob_get_level()) ob_end_clean();
ob_start();

header("Content-Type: application/xml; charset=utf-8");

$baseUrl = "https://fancybet.info";
$languages = ['en', 'bn'];
$today = date('Y-m-d');

// Static pages
$pages = [
    ['slug' => '', 'priority' => 1.0, 'freq' => 'daily'],
    ['slug' => '/pages/about', 'priority' => 0.8, 'freq' => 'daily'],
    ['slug' => '/pages/services', 'priority' => 0.8, 'freq' => 'daily'],
    ['slug' => '/pages/contact', 'priority' => 0.8, 'freq' => 'daily'],
    ['slug' => '/pages/community', 'priority' => 0.8, 'freq' => 'daily'],
    ['slug' => '/pages/cricket-news', 'priority' => 1.0, 'freq' => 'daily'],
    ['slug' => '/pages/cricket-betting-guides', 'priority' => 1.0, 'freq' => 'daily'],
  

];

// Start XML
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

echo "  <url>\n";
echo "    <loc>{$baseUrl}/image/favicon.svg</loc>\n";
echo "    <lastmod>{$today}</lastmod>\n";
echo "    <changefreq>daily</changefreq>\n";
echo "    <priority>1.0</priority>\n";
echo "  </url>\n";

echo "  <url>\n";
echo "    <loc>{$baseUrl}/image/favicon-96x96.png</loc>\n";
echo "    <lastmod>{$today}</lastmod>\n";
echo "    <changefreq>daily</changefreq>\n";
echo "    <priority>1.0</priority>\n";
echo "  </url>\n";

// 🔹 Static pages (multilingual)
foreach ($pages as $page) {
    foreach ($languages as $lang) {
        $loc = rtrim($baseUrl, '/') . '/' . ltrim($page['slug'], '/');
        $loc .= (strpos($loc, '?') === false ? '?lang=' . $lang : '&lang=' . $lang);

        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
        echo "    <lastmod>{$today}</lastmod>\n";
        echo "    <changefreq>{$page['freq']}</changefreq>\n";
        echo "    <priority>{$page['priority']}</priority>\n";
        echo "  </url>\n";
    }
}

echo "</urlset>";
ob_end_flush();
