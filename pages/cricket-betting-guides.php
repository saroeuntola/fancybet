<?php
require_once '../admin/page/library/db.php';
require_once '../admin/page/library/post_lib.php';
require_once './services/bn-date.php';
require_once '../baseURL.php';
$postObj = new Post();
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';

$categoryId = 2;
$limit = 8;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Sorting
$sort = $_GET['sort'] ?? 'all';
$orderBy = '';
$orderDir = '';

switch ($sort) {
    case 'latest':
        $orderBy = 'created_at';
        $orderDir = 'DESC';
        break;
    case 'oldest':
        $orderBy = 'created_at';
        $orderDir = 'ASC';
        break;
    case 'a-z':
        $orderBy = 'name';
        $orderDir = 'ASC';
        break;
    case 'z-a':
        $orderBy = 'name';
        $orderDir = 'DESC';
        break;
    default:
        $sort = 'all';
}

$totalPosts = count($postObj->getPostByCategory($categoryId, $lang));
$totalPages = ceil($totalPosts / $limit);
$posts = $postObj->getPostByCategory($categoryId, $lang, $limit, $offset, $orderBy, $orderDir);
?>

<!DOCTYPE html>
<html lang="en">

<?php
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';

$title = $lang === 'en'
    ? "Cricket Betting Guides - Tips & Strategies for Betting"
    : "ক্রিকেট বেটিং গাইড - বেটিং এর টিপস ও কৌশল";

$description = $lang === 'en'
    ? "Learn cricket betting strategies, tips, and guides. Improve your cricket betting skills with FancyBet Bangladesh for IPL, BPL, ICC, PSL, and SA20 matches."
    : "ক্রিকেট বেটিং স্ট্র্যাটেজি, টিপস এবং গাইড শিখুন। IPL, BPL, ICC, PSL এবং SA20 ম্যাচে আপনার ক্রিকেট বেটিং দক্ষতা উন্নত করুন FancyBet বাংলাদেশ-এর মাধ্যমে।";

$keywords = $lang === 'en'
    ? "Cricket Betting, Betting Guides, Cricket Tips, IPL, BPL, ICC, PSL, SA20, FancyBet, Online Betting Bangladesh"
    : "ক্রিকেট বেটিং, বেটিং গাইড, ক্রিকেট টিপস, IPL, BPL, ICC, PSL, SA20, ফ্যান্সি বেট, অনলাইন বেটিং বাংলাদেশ";

$url = "https://fancybet.info/pages/cricket-betting-guides?lang={$lang}";
$image = "https://fancybet.info/image/favicon-96x96.png";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Dynamic SEO -->
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($keywords) ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="<?= htmlspecialchars($url) ?>">

    <!-- Open Graph / Social -->
    <meta property="og:title" content="<?= htmlspecialchars($title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($description) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($url) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($image) ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($description) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($image) ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/image/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/image/favicon.svg" />
    <link rel="shortcut icon" href="/image/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/image/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="FancyBet" />
    <link rel="manifest" href="/image/site.webmanifest" />

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "<?= addslashes($title) ?>",
            "description": "<?= addslashes($description) ?>",
            "url": "<?= addslashes($url) ?>",
            "publisher": {
                "@type": "Organization",
                "name": "FancyBet",
                "logo": {
                    "@type": "ImageObject",
                    "url": "<?= addslashes($image) ?>"
                }
            },
            "mainEntityOfPage": "<?= addslashes($url) ?>"
        }
    </script>

    <script src="./js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="/src/output.css">
    <link rel="stylesheet" href="/css/pagination.css">
</head>


<body class="dark:bg-black bg-[#f5f5f5] dark:text-white text-gray-800">
    <?php include "navbar.php"; ?>
    <main class="px-4 mt-[80px] max-w-7xl m-auto">
        <div class="dark:text-white text-gray-800 bg-white dark:bg-[#252525]
            shadow-[0_0_5px_0_rgba(0,0,0,0.2)] p-4">

            <div class="flex justify-between items-center mb-4 lg:mt-4">
                <h1 class="text-xl font-bold dark:text-white text-gray-800">
                    <?= $lang === 'en' ? 'All Cricket Betting Guides' : 'সমস্ত ক্রিকেট বেটিং গাইড' ?>
                </h1>

                <!-- Sort Dropdown -->
                <form method="get" id="sortForm" class="relative ">
                    <input type="hidden" name="lang" value="<?= $lang ?>">
                    <select name="sort" onchange="this.form.submit()"
                        class="appearance-none bg-gray-700 text-white px-3 py-1 rounded pr-8 border-0 focus:outline-none hover:bg-red-800 transition-all">
                        <option value="all" <?= $sort === 'all' ? 'selected' : '' ?>>
                            <?= $lang === 'en' ? 'All' : 'সব' ?>
                        </option>
                        <option value="latest" <?= $sort === 'latest' ? 'selected' : '' ?>>
                            <?= $lang === 'en' ? 'Latest' : 'সর্বশেষ' ?>
                        </option>
                        <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>
                            <?= $lang === 'en' ? 'Oldest' : 'প্রাচীনতম' ?>
                        </option>
                        <option value="a-z" <?= $sort === 'a-z' ? 'selected' : '' ?>>
                            <?= $lang === 'en' ? 'A-Z' : 'ক-খ' ?>
                        </option>
                        <option value="z-a" <?= $sort === 'z-a' ? 'selected' : '' ?>>
                            <?= $lang === 'en' ? 'Z-A' : 'খ-ক' ?>
                        </option>
                    </select>
                    <!-- Font Awesome arrow -->
                    <i class="fa-solid fa-chevron-down absolute right-2 top-1/2 transform -translate-y-1/2 text-white pointer-events-none"></i>
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <?php foreach ($posts as $post): ?>
                    <?php
                    $postName = htmlspecialchars($post['name'] ?? '');
                    if (mb_strlen($postName, 'UTF-8') > 50) {
                        $postName = mb_substr($postName, 0, 60, 'UTF-8') . '...';
                    }
                    $postSlug = urlencode($post['slug'] ?? '');
                    $postImage = !empty($post['image']) ? htmlspecialchars($post['image']) : null;
                    $postDesc = strip_tags($post['description'] ?? '');
                    $postDesc = html_entity_decode($postDesc, ENT_QUOTES | ENT_HTML5);
                    if (mb_strlen($postDesc, 'UTF-8') > 80) {
                        $postDesc = mb_substr($postDesc, 0, 75, 'UTF-8') . '...';
                    }
                    $postDesc = htmlspecialchars($postDesc);
                    $createdAt = $post['created_at'] ?? '';
                    ?>
                    <a href="/pages/detail?slug=<?= $postSlug ?>&lang=<?= $lang ?>">
                        <div class="flex flex-row items-stretch transition-all duration-300">

                            <!-- Image (Left) -->
                            <div class="overflow-hidden w-[150px] lg:w-[280px] h-[120px] lg:h-[180px] flex-shrink-0">
                                <?php if ($postImage): ?>
                                    <img src="<?= $ImageURL ?><?= $postImage ?>"
                                        alt="<?= $postName ?>"
                                        class="w-full h-full object-cover transition-transform duration-500 ease-in-out hover:scale-110">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-600 flex items-center justify-center dark:text-gray-300 text-gray-800 text-sm">
                                        <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Content (Right) -->
                            <div class="ml-2 flex-1 flex flex-col">
                                <div>
                                    <h2 class="lg:text-lg text-md font-semibold mb-2 dark:text-white text-gray-800 break-words">
                                        <?= $postName ?>
                                    </h2>
                                    <p class="dark:text-gray-300 text-gray-800 mb-3 text-sm break-words lg:text-md hidden lg:block">
                                        <?= $postDesc ?>
                                    </p>
                                </div>

                                <div class="flex flex-wrap items-center gap-1 text-gray-400 text-xs break-words">
                                    <i class="fa-solid fa-earth-americas"></i>
                                    <span>
                                        <?= $lang === 'bn'
                                            ? formatDateByLang($createdAt, 'bn')
                                            : date("F j, Y", strtotime($createdAt)) ?>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </a>
                <?php endforeach; ?>
            </div>


            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination-container">
                    <nav class="pagination-nav">
                        <!-- First Page -->
                        <?php if ($page > 1): ?>
                            <a href="?page=1" class="pagination-btn" title="First page">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn disabled">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                                </svg>
                            </span>
                        <?php endif; ?>

                        <!-- Previous -->
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>" class="pagination-btn" title="Previous page">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn disabled">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <div class="pagination-pages">
                            <?php
                            $range = 3;
                            $start = max(1, $page - $range);
                            $end = min($totalPages, $page + $range);

                            // Show ellipsis if not starting at page 1
                            if ($start > 1): ?>
                                <span class="pagination-ellipsis">...</span>
                            <?php endif;

                            for ($i = $start; $i <= $end; $i++): ?>
                                <a href="?page=<?= $i ?>" class="pagination-number <?= $i === $page ? 'active' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor;

                            // Show ellipsis if not ending at last page
                            if ($end < $totalPages): ?>
                                <span class="pagination-ellipsis">...</span>
                            <?php endif; ?>
                        </div>

                        <!-- Next -->
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>" class="pagination-btn" title="Next page">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn disabled">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        <?php endif; ?>

                        <!-- Last Page -->
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $totalPages ?>" class="pagination-btn" title="Last page">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn disabled">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                </svg>
                            </span>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <?= include "footer.php" ?>

    <?php include 'scroll-to-top.php'; ?>
</body>

</html>