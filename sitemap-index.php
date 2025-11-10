<?php
// ===========================================
// FancyBet Sitemap Index (Rank Math style)
// ===========================================

// ⚠️ Stop all previous output
while (ob_get_level()) ob_end_clean();
ob_start();

// Headers
header("Content-Type: application/xml; charset=utf-8");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Base URL and date
$baseUrl = "https://fancybet.info";
$today = date('Y-m-d');

// ⚠️ Clean previous output buffer
ob_clean();

// Output XML declaration
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc><?= $baseUrl ?>/sitemap-pages.xml</loc>
        <lastmod><?= $today ?></lastmod>
    </sitemap>
    <sitemap>
        <loc><?= $baseUrl ?>/sitemap-posts.xml</loc>
        <lastmod><?= $today ?></lastmod>
    </sitemap>
</sitemapindex>
<?php
ob_end_flush();
