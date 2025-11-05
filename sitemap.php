<?php
// ===================================================
// Safe Sitemap Generator for SiteGround + Googlebot
// ===================================================

// Disable all buffering & compression early
if (function_exists('apache_setenv')) {
    @apache_setenv('no-gzip', '1');
}
ini_set('zlib.output_compression', 0);
ini_set('output_buffering', 'off');
while (ob_get_level() > 0) ob_end_clean();
ob_implicit_flush(true);
ob_start();
header("Content-Type: application/xml; charset=utf-8");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header("Connection: close"); // ✅ close properly instead of keep-alive

$baseUrl = "https://fancybet.info";

// Include required files
require_once __DIR__ . '/admin/page/library/db.php';
require_once __DIR__ . '/admin/page/library/post_lib.php';

$postLib = new Post();
try {
    $posts = $postLib->getPost();
} catch (Exception $e) {
    $posts = [];
}

$pages = [
    ['slug' => '', 'priority' => 1.0],
    ['slug' => '/pages/about', 'priority' => 0.8],
    ['slug' => '/pages/cricket-news', 'priority' => 0.8],
    ['slug' => '/pages/cricket-betting-guides', 'priority' => 0.8],
    ['slug' => '/pages/match-previews', 'priority' => 0.8],
];

$languages = ['en', 'bn'];
$today = date('Y-m-d');

ob_clean();
// --- Output XML ---
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Static pages
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

// Dynamic posts
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
