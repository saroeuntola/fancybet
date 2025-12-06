<?php
include './admin/page/library/post_lib.php';
include './admin/page/library/comment_lib.php';
include './admin/page/library/db.php';
include './pages/services/bn-date.php';
include './baseURL.php';
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';
$postLib = new Post();
$posts = $postLib->getPost($lang);
$posts = $postLib->getPostByCategory(3, $lang);
$limitedPosts = array_slice($posts, 0, 8);
$relatedPosts = $postLib->getRelatedpost($post['id'] ?? 0, $post['category_id'] ?? 0, 6);

// SEO data
$seo = [
    'en' => [
        'title' => 'FancyBet  - Cricket News & Betting Guide Bangladesh',
        'description' => 'FancyBet Cricket News, FancyBet Bangladesh - Your premium guide for cricket news, live cricket betting, and FancyBetting tips. Stay updated with match predictions, IPL, BPL, PSL, and ICC tournaments.',
        'keywords' => 'FancyBet, cricket news Bangladesh, cricket betting tips, FancyBetting guide, live cricket betting, IPL, BPL, PSL, ICC, sports betting Bangladesh, FancyBet Guide',
        'canonical' => 'https://fancybet.info/?lang=en'
    ],
    'bn' => [
        'title' => 'FancyBet - ক্রিকেট নিউজ ও বেটিং গাইড বাংলাদেশ',
        'description' => 'FancyBet বাংলাদেশ - ক্রিকেট নিউজ, লাইভ ক্রিকেট বেটিং এবং Fancy Betting টিপসের প্রিমিয়াম গাইড। IPL, BPL, PSL, ICC টুর্নামেন্ট আপডেট পান।',
        'keywords' => 'FancyBet, ক্রিকেট নিউজ বাংলাদেশ, ক্রিকেট বেটিং টিপস, Fancy Betting গাইড, লাইভ ক্রিকেট বেটিং, IPL, BPL, PSL, ICC, স্পোর্টস বেটিং বাংলাদেশ, FancyBet গাইড',
        'canonical' => 'https://fancybet.info'
    ]
];
$currentSeo = $seo[$lang];
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? "en-BD" : "bn-BD" ?>" class="dark:bg-gray-900 bg-amber-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <title><?= htmlspecialchars($currentSeo['title']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($currentSeo['description']) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($currentSeo['keywords']) ?>">
    <meta name="author" content="FancyBet">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- Canonical -->
    <link rel="canonical" href="<?= htmlspecialchars($currentSeo['canonical']) ?>">

    <!-- Language Alternates -->
    <link rel="alternate" hreflang="en" href="https://fancybet.info/?lang=en">
    <link rel="alternate" hreflang="bn" href="https://fancybet.info/?lang=bn">
    <link rel="alternate" hreflang="x-default" href="https://fancybet.info/?lang=bn">

    <!-- Open Graph / Twitter Card -->
    <meta property="og:title" content="<?= htmlspecialchars($currentSeo['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($currentSeo['description']) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($currentSeo['canonical']) ?>">
    <meta property="og:image" content="https://fancybet.info/image/favicon-96x96.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($currentSeo['title']) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($currentSeo['description']) ?>">
    <meta name="twitter:image" content="https://fancybet.info/image/favicon-96x96.png">

    <!-- Favicon / Apple Touch Icons -->
    <link rel="icon" type="image/png" href="/image/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="/image/favicon.svg">
    <link rel="shortcut icon" href="/image/favicon.ico">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/image/apple-touch-icon.png">
    <meta name="apple-mobile-web-app-title" content="FancyBet">
    <link rel="manifest" href="/image/site.webmanifest">

    <!-- Preload Critical CSS -->
    <link rel="preload" href="/src/output.css" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="./css/style.css" as="style" onload="this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="/src/output.css">
        <link rel="stylesheet" href="./css/style.css">
    </noscript>

    <!-- Preload Key Images -->
    <link rel="preload" href="https://fancybet.info/image/favicon-96x96.png" as="image">
    <link rel="preload" href="https://fancybet.info/image/apple-touch-icon.png" as="image">

    <!-- Preload JS -->
    <link rel="preload" href="./js/jquery-3.7.1.min.js" as="script">

    <!-- Deferred JS -->
    <script src="./js/jquery-3.7.1.min.js" defer></script>

    <!-- JSON-LD Schema -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "<?= addslashes($currentSeo['title']) ?>",
            "url": "<?= htmlspecialchars($currentSeo['canonical']) ?>",
            "description": "<?= addslashes($currentSeo['description']) ?>",
            "inLanguage": "<?= $lang === 'en' ? 'en' : 'bn' ?>",
            "publisher": {
                "@type": "Organization",
                "name": "FancyBet",
                "url": "https://fancybet.info/",
                "logo": {
                    "@type": "ImageObject",
                    "url": "https://fancybet.info/image/favicon-96x96.png"
                }
            }
        }
    </script>


</head>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }
</style>

<body class="dark:bg-black bg-[#f5f5f5]">
    <?php include './pages/navbar.php'; ?>
    <main class="px-4 max-w-7xl mx-auto">

        <section class="pt-20"></section>

        <section class="">
            <?php
            include "./pages/cricket-news-section.php"
            ?>
        </section>

        <section class="pt-10">
            <?php
            include "./pages/cricket-betting-guides-section.php"
            ?>
        </section>

        <section class="pt-10">

        </section>

        <section class="">
            <?php
            include "./pages/match-preview-section.php"
            ?>
        </section>
    </main>
    <?php
    include "./pages/footer.php"
    ?>
    <?php include './pages/scroll-to-top.php'; ?>
    <?php
    $js = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/js/cricket-news.js');
    $encoded = base64_encode($js);
    echo '<script src="data:text/javascript;base64,' . $encoded . '" defer></script>';
    ?>

    <?php
    $js = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/js/scroll-grid.js');
    $encoded = base64_encode($js);
    echo '<script src="data:text/javascript;base64,' . $encoded . '" defer></script>';
    ?>

</body>

</html>