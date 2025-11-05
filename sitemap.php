<?php
// --- clean start, no spaces above this line ---
while (ob_get_level()) ob_end_clean();
ob_start();
ini_set('display_errors', 0);
error_reporting(0);

header("Content-Type: application/xml; charset=utf-8");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header("Connection: close");

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

ob_clean();

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
    $today = date('Y-m-d');
    $languages = ['en', 'bn'];

    // ✅ Add static pages in both languages
    foreach ($pages as $page) {
        foreach ($languages as $lang) {
            $loc = htmlspecialchars(rtrim($baseUrl, '/') . '/' . ltrim($page['slug'], '/'));
            $loc .= (strpos($loc, '?') === false ? '?lang=' . $lang : '&lang=' . $lang);
    ?>
            <url>
                <loc><?= $loc ?></loc>
                <lastmod><?= $today ?></lastmod>
                <changefreq>weekly</changefreq>
                <priority><?= $page['priority'] ?></priority>
            </url>
        <?php
        }
    }

    // ✅ Add dynamic posts in both languages
    foreach ($posts as $post) {
        if (empty($post['slug'])) continue;
        $slug = urlencode($post['slug']);
        foreach ($languages as $lang) {
            $loc = htmlspecialchars("$baseUrl/pages/detail?slug=$slug&lang=$lang");
        ?>
            <url>
                <loc><?= $loc ?></loc>
                <lastmod><?= $today ?></lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.8</priority>
            </url>
    <?php
        }
    }
    ?>
</urlset>
<?php
ob_end_flush();
?>