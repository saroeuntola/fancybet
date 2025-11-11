<?php
// ===========================================
// FancyBet Posts Sitemap (with Image + News)
// ===========================================

// ⚠️ Critical: Stop all previous output
while (ob_get_level()) ob_end_clean();
ob_start();

header("Content-Type: application/xml; charset=utf-8");
require_once __DIR__ . '/admin/page/library/db.php';
require_once __DIR__ . '/admin/page/library/post_lib.php';

$baseUrl = "https://fancybet.info";
$languages = ['en', 'bn'];
$today = date('Y-m-d');

$postLib = new Post();
try {
    $posts = $postLib->getPost();
} catch (Exception $e) {
    $posts = [];
}

ob_clean();

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
<?php
foreach ($posts as $post) {
    if (empty($post['slug'])) continue;

    $slug = urlencode($post['slug']);
    $title = htmlspecialchars(strip_tags($post['name'] ?? ''), ENT_XML1);
    $desc = htmlspecialchars(strip_tags(mb_substr($post['description'] ?? '', 0, 150)), ENT_XML1);
    $image = !empty($post['image']) ? htmlspecialchars($baseUrl . '/admin/page/post/' . $post['image'], ENT_XML1) : '';
    $lastmod = !empty($post['updated_at']) ? date('Y-m-d', strtotime($post['updated_at'])) : $today;
    $pubDate = !empty($post['created_at']) ? date('Y-m-d', strtotime($post['created_at'])) : $today;

    foreach ($languages as $lang) {
        $loc = "$baseUrl/pages/detail?slug=$slug&lang=$lang";
?>
  <url>
    <loc><?= htmlspecialchars($loc, ENT_XML1) ?></loc>
    <lastmod><?= $lastmod ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>

<?php if ($image): ?>
    <image:image>
        <image:loc><?= $image ?></image:loc>
        <image:title><?= $title ?></image:title>
    </image:image>
<?php endif; ?>

    <!-- 📰 News metadata for Google News -->
    <news:news>
        <news:publication>
            <news:name>FancyBet</news:name>
            <news:language><?= $lang ?></news:language>
        </news:publication>
        <news:publication_date><?= $pubDate ?></news:publication_date>
        <news:title><?= $title ?></news:title>
    </news:news>

  </url>
<?php
    }
}
?>
</urlset>
<?php
ob_end_flush();
