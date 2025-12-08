<?php

/**
 * Static Page Breadcrumb
 * Usage: include this file in About.php, Contact.php, etc.
 * Pass $pageName = "About" or "Contact"
 */

// Static pages mapping
$staticPages = [
    "About" => "about",
    "Contact" => "contact",
    "Privacy Policy" => "privacy-policy",
    "Terms & Conditions" => "terms",
    "Community" => "community",
    "Cricket News" => "cricket-news",
    "Cricket Betting Guides" => "cricket-betting-guides",
    "Match Previews" => "match-previews",
    "Home" => "",

];

// Home URL
$homeUrl = "https://fancybet.info/";

// Get page slug
$pageSlug = $staticPages[$pageName] ?? '';
$pageUrl = $pageSlug ? $homeUrl . "pages/" . $pageSlug : $homeUrl;

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

        <!-- Static Page -->
        <?php if ($pageSlug): ?>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name"><?= htmlspecialchars($pageName) ?></span>
                <meta itemprop="position" content="2" />
            </li>
        <?php endif; ?>

    </ol>
</nav>