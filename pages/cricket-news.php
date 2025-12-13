<?php
require_once '../admin/page/library/db.php';
require_once '../admin/page/library/post_lib.php';
require_once './services/bn-date.php';
require_once '../baseURL.php';
require_once './breadcrumb.php';
require_once '../pages/services/menu.php';

$postObj = new Post();
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';

$categoryId = 3;
$limit = 9;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$pageName = "Cricket News";
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
}

// Get posts
$totalPosts = count($postObj->getPostByCategory($categoryId, $lang));
$totalPages = ceil($totalPosts / $limit);
$posts = $postObj->getPostByCategory($categoryId, $lang, $limit, $offset, $orderBy, $orderDir);

$title = $lang === 'en'
    ? "Cricket News - Latest Cricket Updates & Betting Guides"
    : "ক্রিকেট নিউজ - সর্বশেষ ক্রিকেট আপডেট ও বেটিং গাইড";

$description = $lang === 'en'
    ? "Stay updated with the latest cricket news, match previews, and betting guides. Follow IPL, BPL, ICC, PSL, and SA20 updates with FancyBet."
    : "সর্বশেষ ক্রিকেট নিউজ, ম্যাচ প্রিভিউ এবং বেটিং গাইডের সাথে আপডেট থাকুন। IPL, BPL, ICC, PSL এবং SA20 আপডেট অনুসরণ করুন FancyBet এর মাধ্যমে।";

$keywords = $lang === 'en'
    ? "Cricket News, Cricket Updates, IPL, BPL, ICC, PSL, SA20, Cricket Betting, FancyBet, Online Casino Bangladesh, Betting Guide"
    : "ক্রিকেট নিউজ, ক্রিকেট আপডেট, IPL, BPL, ICC, PSL, SA20, ক্রিকেট বেটিং, ফ্যান্সি বেট, অনলাইন ক্যাসিনো বাংলাদেশ, বেটিং গাইড";

$url = "https://fancybet.info/pages/cricket-news?lang={$lang}";
$image = "https://fancybet.info/image/favicon-96x96.png";



// Generate breadcrumbs
$breadcrumbs = generateBreadcrumb($lang, $menu);
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? "en-BD" : "bn-BD" ?>" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($keywords) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($url) ?>">

    <!-- Open Graph / Twitter -->
    <meta property="og:title" content="<?= htmlspecialchars($title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($description) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($url) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($image) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($description) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($image) ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/image/favicon-96x96.png" sizes="96x96" />

    <!-- CSS & JS -->
    <link rel="stylesheet" href="/src/output.css">
    <link rel="stylesheet" href="/css/pagination.css">
    <link rel="stylesheet" href="/css/breadcrumb.css">
    <script src="./js/jquery-3.7.1.min.js"></script>
    <?= include "./services/ahrefts.php" ?>
    <!-- JSON-LD: NewsArticle + BreadcrumbList -->
    <?php outputFullSchemaPage($breadcrumbs, ['name' => $title, 'description' => html_entity_decode(strip_tags($description))], 'https://fancybet.info'); ?>
</head>




<body class="dark:bg-black bg-[#f5f5f5] dark:text-white text-gray-800">
    <?php include "navbar.php"; ?>

    <main class="px-4 max-w-7xl m-auto mt-[80px]">
        <?php
        include './services/breadcrumb-static.php';
        ?>
        <div class="bg-white dark:bg-[#252525]
            shadow-[0_0_5px_0_rgba(0,0,0,0.2)] p-4 card-container">
            <div class="flex justify-between items-center mb-4">

                <h1 class="text-xl font-bold">
                    <?= $lang === 'en' ? 'All Cricket News' : 'সমস্ত ক্রিকেট সংবাদ' ?>
                </h1>

                <!-- Sort Dropdown -->
                <form method="get" id="sortForm" class="relative inline-block">
                    <input type="hidden" name="lang" value="<?= $lang ?>">

                    <select name="sort" onchange="this.form.submit()"
                        class="appearance-none bg-gray-700 text-white px-3 py-1 rounded pr-8 border-0 focus:outline-none hover:bg-red-800 transition-all w-auto min-w-[4rem]">
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


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 ">
                <?php foreach ($posts as $post): ?>
                    <?php
                    $postName = htmlspecialchars($post['name'] ?? '');
                    if (mb_strlen($postName, 'UTF-8') > 80) {
                        $postName = mb_substr($postName, 0, 80, 'UTF-8') . '...';
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
                        <div class="flex flex-col transition-all duration-300 ">
                            <!-- Image -->
                            <div class="overflow-hidden h-[220px]">
                                <?php if ($postImage): ?>
                                    <img src="<?= $ImageURL ?><?= $postImage ?>"
                                        alt="<?= $postName ?>"
                                        class="w-full h-full object-cover transition-transform duration-500 ease-in-out hover:scale-110">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-600 flex items-center justify-center text-gray-300 text-sm">
                                        <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Content -->
                            <div class="py-2 flex-1 flex flex-col">
                                <div>
                                    <h2 class="lg:text-lg text-md font-semibold mb-2 dark:text-white text-gray-800 break-words">
                                        <?= $postName ?>
                                    </h2>
                                    <p class="dark:text-gray-300 text-gray-800 mb-3 text-sm break-words lg:text-md">
                                        <?= $postDesc ?>
                                    </p>
                                </div>

                                <!-- Date -->
                                <div class="flex flex-wrap items-center gap-1 dark:text-gray-400 text-gray-800 text-xs break-words">
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

    <?php include "footer.php" ?>
    <?php include 'scroll-to-top.php'; ?>
</body>

</html>