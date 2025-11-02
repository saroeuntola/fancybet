<?php
// Disable buffering and errors before output
if (ob_get_length()) ob_end_clean();
ob_start();

ini_set('display_errors', 0);
error_reporting(0);

header("Content-Type: application/xml; charset=utf-8");

// Base URL
$baseUrl = "https://fancybet.info";

// Include your database and post class
require_once __DIR__ . '/admin/page/library/db.php';
require_once __DIR__ . '/admin/page/library/post_lib.php';

$postLib = new Post();
$posts = [];

try {
    $posts = $postLib->getPost();
} catch (Exception $e) {
    $posts = [];
}

// Static pages
$pages = [
    ['slug' => '', 'priority' => 1.0],
    ['slug' => '/pages/about', 'priority' => 0.8],
    ['slug' => '/pages/services', 'priority' => 0.8],
];

ob_clean();

// Output XML header safely
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
    $today = date('Y-m-d');

    // Static pages
    foreach ($pages as $page): ?>
        <url>
            <loc><?= htmlspecialchars(rtrim($baseUrl, '/') . '/' . ltrim($page['slug'], '/')) ?></loc>
            <lastmod><?= $today ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority><?= $page['priority'] ?></priority>
        </url>
    <?php endforeach; ?>

    <?php
    // Dynamic posts
    foreach ($posts as $post):
        $slug = urlencode($post['slug']);
    ?>
        <url>
            <loc><?= htmlspecialchars("$baseUrl/pages/detail?slug=$slug") ?></loc>
            <lastmod><?= $today ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    <?php endforeach; ?>
</urlset>
<?php
ob_end_flush();
?>