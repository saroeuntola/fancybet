<?php
// --- Clean start, no spaces above this line ---
if (ob_get_level()) while (ob_get_level()) ob_end_clean();
ob_implicit_flush(1);

// Disable compression and error output
ini_set('zlib.output_compression', 0);
ini_set('display_errors', 0);
error_reporting(0);

// Headers for Google
header("Content-Type: application/xml; charset=utf-8");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Base URL
$baseUrl = "https://fancybet.info";

// Include database and post library
require_once __DIR__ . '/admin/page/library/db.php';
require_once __DIR__ . '/admin/page/library/post_lib.php';

// Get posts safely
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
    ['slug' => '/pages/services', 'priority' => 0.8],
];

// Today's date for lastmod
$today = date('Y-m-d');

// Start XML output
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($pages as $page): ?>
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
flush(); // flush output to avoid HTTP/2 protocol errors
exit;
?>