<?php
// =======================================================
// FancyBet Advanced SEO Sitemap (RankMath-style)
// =======================================================

while (ob_get_level()) ob_end_clean();
ob_start();

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
// Includes
// --------------------
require_once __DIR__ . '/admin/page/library/db.php';
require_once __DIR__ . '/admin/page/library/post_lib.php';

// --------------------
// Fetch posts
// --------------------
$postLib = new Post();
try {
    $posts = $postLib->getPost();
} catch (Exception $e) {
    $posts = [];
}

// --------------------
// Static Pages
// --------------------
$pages = [
    ['slug' => '', 'priority' => 1.0, 'freq' => 'daily'],
    ['slug' => '/pages/about', 'priority' => 0.8, 'freq' => 'monthly'],
    ['slug' => '/pages/services', 'priority' => 0.8, 'freq' => 'monthly'],
    ['slug' => '/pages/cricket-news', 'priority' => 0.9, 'freq' => 'daily'],
    ['slug' => '/pages/cricket-betting-guides', 'priority' => 0.8, 'freq' => 'weekly'],
    ['slug' => '/pages/match-previews', 'priority' => 0.9, 'freq' => 'daily'],
];

$languages = ['en', 'bn'];
$today = date('Y-m-d');
ob_clean ();
// --------------------
// Output XML header
// --------------------
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset 
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
>' . "\n";

// --------------------
// Static pages
// --------------------
foreach ($pages as $page) {
    foreach ($languages as $lang) {
        $loc = rtrim($baseUrl, '/') . '/' . ltrim($page['slug'], '/');
        $loc .= (strpos($loc, '?') === false ? '?lang=' . $lang : '&lang=' . $lang);

        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
        echo "    <lastmod>$today</lastmod>\n";
        echo "    <changefreq>{$page['freq']}</changefreq>\n";
        echo "    <priority>{$page['priority']}</priority>\n";
        echo "  </url>\n";
    }
}

// --------------------
// Dynamic posts
// --------------------
foreach ($posts as $post) {
    if (empty($post['slug'])) continue;
    $slug = urlencode($post['slug']);
    $lastmod = !empty($post['updated_at']) ? date('Y-m-d', strtotime($post['updated_at'])) : $today;
    $image = !empty($post['image']) ? htmlspecialchars($baseUrl . '/admin/page/post/' . $post['image'], ENT_XML1) : '';
    $title = htmlspecialchars(strip_tags($post['name'] ?? ''), ENT_XML1);
    $desc = htmlspecialchars(strip_tags(mb_substr($post['description'] ?? '', 0, 150)), ENT_XML1);

    foreach ($languages as $lang) {
        $loc = "$baseUrl/pages/detail?slug=$slug&lang=$lang";
        echo "  <url>\n";
        echo "    <loc>$loc</loc>\n";
        echo "    <lastmod>$lastmod</lastmod>\n";
        echo "    <changefreq>daily</changefreq>\n";
        echo "    <priority>0.9</priority>\n";

        // Add image metadata if available
        if ($image) {
            echo "    <image:image>\n";
            echo "      <image:loc>$image</image:loc>\n";
            echo "      <image:title>$title</image:title>\n";
            echo "    </image:image>\n";
        }

        // Optional: News sitemap entry (Google News)
        echo "    <news:news>\n";
        echo "      <news:publication>\n";
        echo "        <news:name>FancyBet</news:name>\n";
        echo "        <news:language>$lang</news:language>\n";
        echo "      </news:publication>\n";
        echo "      <news:publication_date>$lastmod</news:publication_date>\n";
        echo "      <news:title>$title</news:title>\n";
        echo "      <news:keywords>betting, cricket, sports, $lang</news:keywords>\n";
        echo "    </news:news>\n";

        echo "  </url>\n";
    }
}

echo "</urlset>";
ob_end_flush();
