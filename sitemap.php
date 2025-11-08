<?php
// =======================================================
// FancyBet Sitemap - Multilingual (en & bn)
// =======================================================

// --------------------
// Disable all output buffering and clean
// --------------------
while (ob_get_level()) ob_end_clean();
ob_start();

// --------------------
// Headers
// --------------------
http_response_code(200);
header("Content-Type: application/xml; charset=utf-8");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// --------------------
// Base URL
// --------------------
$baseUrl = "https://fancybet.info";

// --------------------
// Include required files
// --------------------
require_once __DIR__ . '/admin/page/library/db.php';
require_once __DIR__ . '/admin/page/library/post_lib.php';

// --------------------
// Get dynamic posts
// --------------------
$postLib = new Post();
try {
    $posts = $postLib->getPost(); // returns array of posts
} catch (Exception $e) {
    $posts = [];
}

// --------------------
// Define static pages
// --------------------
$pages = [
    ['slug' => '', 'priority' => 1.0],
    ['slug' => '/pages/about', 'priority' => 0.8],
    ['slug' => '/pages/services', 'priority' => 0.8],
    ['slug' => '/pages/cricket-news', 'priority' => 0.8],
    ['slug' => '/pages/cricket-betting-guides', 'priority' => 0.8],
    ['slug' => '/pages/match-previews', 'priority' => 0.8],
];

// --------------------
// Languages
// --------------------
$languages = ['en', 'bn'];
$today = date('Y-m-d');
ob_clean();
// --------------------
// Output XML
// --------------------
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// --------------------
// Static pages in both languages
// --------------------
foreach ($pages as $page) {
    foreach ($languages as $lang) {
        $loc = rtrim($baseUrl, '/') . '/' . ltrim($page['slug'], '/');
        $loc .= (strpos($loc, '?') === false ? '?lang=' . $lang : '&lang=' . $lang);

        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
        echo "    <lastmod>$today</lastmod>\n";
        echo "    <changefreq>weekly</changefreq>\n";
        echo "    <priority>{$page['priority']}</priority>\n";
        echo "  </url>\n";
    }
}


// --------------------
// Dynamic posts in both languages
// --------------------
foreach ($posts as $post) {
    if (empty($post['slug'])) continue;
    $slug = urlencode($post['slug']);
    foreach ($languages as $lang) {
        $loc = "$baseUrl/pages/detail?slug=$slug&lang=$lang";
        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
        echo "    <lastmod>$today</lastmod>\n";
        echo "    <changefreq>weekly</changefreq>\n";
        echo "    <priority>0.8</priority>\n";
        echo "  </url>\n";
    }
}

echo "</urlset>";

// --------------------
// Flush output
// --------------------
ob_end_flush();
