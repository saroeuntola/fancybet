<?php
$categorySlugs = [
    "Cricket News" => "cricket-news",
    "Cricket Betting Guides" => "cricket-betting-guides",
    "Match Previews" => "match-previews",

];

$categoryName = $post['category_name'] ?? '';

$categorySlug = $categorySlugs[$categoryName] ?? '';


$homeUrl = "https://fancybet.info/";

$categoryUrl = $categorySlug
    ? $homeUrl . "pages/" . $categorySlug . "?lang=" . $lang
    : $homeUrl;


?>

<nav aria-label="breadcrumb">
    <ol itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumb">

        <!-- Home -->
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="<?= $homeUrl ?>">
                <span itemprop="name">
                    <i class="fa fa-home" aria-hidden="true"></i> Home
                </span>
            </a>
            <meta itemprop="position" content="1" />
        </li>

        <!-- Category -->
        <?php if ($categorySlug): ?>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="<?= $categoryUrl ?>">
                    <p itemprop="name"><?= htmlspecialchars($categoryName) ?></p>
                </a>
                <meta itemprop="position" content="2" />
            </li>
        <?php endif; ?>

        <!-- Post Title -->



    </ol>
</nav>