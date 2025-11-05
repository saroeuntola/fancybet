<?php
// --- Generate static sitemap.xml file with multi-language URLs ---

while (ob_get_level()) ob_end_clean();
ini_set('display_errors', 0);
error_reporting(0);

$baseUrl = "https://fancybet.info";
$languages = ['en', 'bn']; // Add more languages if needed

require_once __DIR__ . '/admin/page/library/db.php';
require_once __DIR__ . '/admin/page/library/post_lib.php';

$postLib = new Post();
try {
    $posts = $postLib->getPost();
} catch (Exception $e) {
    $posts = [];
}

// Static pages
$pages = [
    ['slug' => '', 'priority' => 1.0],
    ['slug' => '/pages/about', 'priority' => 0.8],
    ['slug' => '/pages/privacy-policy', 'priority' => 0.8],
];

$today = date('Y-m-d');

// Build XML
$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

// Helper to append URLs
function addUrlEntry(&$xml, $loc, $today, $priority, $languages)
{
    $xml .= "  <url>\n";
    $xml .= "    <loc>$loc</loc>\n";
    foreach ($languages as $lang) {
        $xml .= '    <xhtml:link rel="alternate" hreflang="' . $lang . '" href="' . $loc . '?lang=' . $lang . "\" />\n";
    }
    $xml .= "    <lastmod>$today</lastmod>\n";
    $xml .= "    <changefreq>weekly</changefreq>\n";
    $xml .= "    <priority>$priority</priority>\n";
    $xml .= "  </url>\n";
}

// Static pages (with lang)
foreach ($pages as $page) {
    $base = htmlspecialchars(rtrim($baseUrl, '/') . '/' . ltrim($page['slug'], '/'));
    foreach ($languages as $lang) {
        $loc = $base . '?lang=' . $lang;
        addUrlEntry($xml, $base, $today, $page['priority'], $languages);
    }
}

// Posts (with lang)
foreach ($posts as $post) {
    if (empty($post['slug'])) continue;
    $slug = urlencode($post['slug']);
    $base = htmlspecialchars("$baseUrl/pages/detail?slug=$slug");
    foreach ($languages as $lang) {
        addUrlEntry($xml, $base, $today, 0.8, $languages);
    }
}

$xml .= "</urlset>\n";

// Save to root directory
$file = __DIR__ . '/sitemap.xml';
if (file_put_contents($file, $xml)) {
    echo "✅ sitemap.xml generated successfully (" . date('Y-m-d H:i:s') . ")";
} else {
    echo "❌ Failed to write sitemap.xml (check file permissions).";
}
