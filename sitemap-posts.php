<?php

while (ob_get_level()) ob_end_clean();


header("Content-Type: application/xml; charset=utf-8");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
ob_start();
$baseUrl = "https://fancybet.info";
$today = date('Y-m-d');
require_once __DIR__ . '/admin/page/library/db.php';
require_once __DIR__ . '/admin/page/library/post_lib.php';

$baseUrl   = "https://fancybet.info";
$imageURL = "https://link123dzo.net/";
$languages = ['en', 'bn'];
$today     = date('Y-m-d');

// Fetch posts
$postLib = new Post();
try {
    $posts = $postLib->getPost();
} catch (Exception $e) {
    $posts = [];
}

ob_clean();
echo '<?xml version="1.0" encoding="UTF-8" ?>';


?>

<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">

    <?php foreach ($posts as $post): ?>
        <?php
        if (empty($post['slug'])) continue;

        $slug        = urlencode($post['slug']);
        $title       = htmlspecialchars(strip_tags($post['name'] ?? ''), ENT_XML1);
        $description = htmlspecialchars(strip_tags(mb_substr($post['description'] ?? '', 0, 160)), ENT_XML1);

        $image = !empty($post['image'])
            ? htmlspecialchars($imageURL . $post['image'], ENT_XML1)
            : "";

        $lastmod = !empty($post['updated_at'])
            ? date('Y-m-d', strtotime($post['updated_at']))
            : $today;

        $pubDate = !empty($post['created_at'])
            ? date('Y-m-d', strtotime($post['created_at']))
            : $today;
        ?>

        <?php foreach ($languages as $lang): ?>
            <?php
            $loc = $baseUrl . "/pages/detail?slug={$slug}&lang={$lang}";
            $priority = ($lang === 'en') ? '0.8' : '1.0';
            ?>

            <url>
                <loc><?= htmlspecialchars($loc, ENT_XML1) ?></loc>
                <lastmod><?= $lastmod ?></lastmod>
                <changefreq>daily</changefreq>
                <priority><?= $priority ?></priority>

                <?php if ($image): ?>
                    <image:image>
                        <image:loc><?= htmlspecialchars($image, ENT_XML1) ?></image:loc>
                        <image:title><?= htmlspecialchars($title, ENT_XML1) ?></image:title>
                    </image:image>
                <?php endif; ?>

                <news:news>
                    <news:publication>
                        <news:name>FancyBet</news:name>
                        <news:language><?= $lang ?></news:language>
                    </news:publication>
                    <news:publication_date><?= $pubDate ?></news:publication_date>
                    <news:title><?= htmlspecialchars($title, ENT_XML1) ?></news:title>
                </news:news>
            </url>
        <?php endforeach; ?>

    <?php endforeach; ?>

</urlset>