<?php
// --- clean start, no spaces above this line ---

while (ob_get_level()) ob_end_clean();
ob_start(); // start fresh buffer
ini_set('display_errors', 0);
error_reporting(0);

header("Content-Type: application/xml; charset=utf-8");

$baseUrl = "https://fancybet.info";

// Include files
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
    ['slug' => '/pages/services', 'priority' => 0.8],
];

// --- Final cleanup before XML output ---
ob_clean();

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
    $today = date('Y-m-d');
    foreach ($pages as $page): ?>
        <url>
            <loc><?= htmlspecialchars(rtrim($baseUrl, '/') . '/' . ltrim($page['slug'], '/')) ?></loc>
            <lastmod><?= $today ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority><?= $page['priority'] ?></priority>
        </url>
    <?php endforeach; ?>

    <?php foreach ($posts as $post):
        if (empty($post['slug'])) continue;
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