<?php
require_once '../admin/page/library/db.php';
require_once '../admin/page/library/post_lib.php';
require_once './services/bn-date.php';
$postObj = new Post();
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';

$categoryId = 3;
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
?>

<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? "en-BD" : "bn-BD" ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Dynamic SEO -->
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($keywords) ?>">
    <meta name="robots" content="index, follow">
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
            "@type": "NewsArticle",
            "headline": "<?= addslashes($title) ?>",
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

    <!-- Tailwind & Material Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/@material-tailwind/html@2.1.9/scripts/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@material-tailwind/html@2.1.9/scripts/ripple.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>


<body class="bg-gray-900 text-white">
    <?php include "navbar.php"; ?>

    <div class="px-4 py-8 mt-15 max-w-5xl m-auto">

        <div class="flex justify-between items-center mb-4">
            <h1 class="lg:text-3xl text-xl font-bold">
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


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($posts as $post): ?>
                <?php
                $postName = htmlspecialchars($post['name'] ?? '');
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
                    <div class="bg-gray-800 shadow rounded-lg overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-300">
                        <!-- Image -->
                        <?php if ($postImage): ?>
                            <img src="/admin/page/post/<?= $postImage ?>" alt="<?= $postName ?>" class="w-full lg:h-[200px] h-[230px] object-cover">
                        <?php else: ?>
                            <div class="w-full lg:h-[200px] h-[230px] bg-gray-600 flex items-center justify-center text-gray-300 text-sm">
                                <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                            </div>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="p-3 flex-1 flex flex-col justify-between">
                            <div>
                                <h2 class="lg:text-lg text-md font-semibold mb-2 text-white break-words">
                                    <?= $postName ?>
                                </h2>
                                <p class="text-gray-300 mb-3 text-sm break-words lg:text-md">
                                    <?= $postDesc ?>
                                </p>
                            </div>

                            <!-- Date -->
                            <div class="flex flex-wrap items-center gap-1 text-gray-400 text-xs mt-2 break-words">
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
            <div class="flex justify-center items-center space-x-2 mt-8 text-white">

                <!-- First Page -->
                <?php if ($page > 1): ?>
                    <a href="?page=1"
                        class="px-3 py-2 bg-gray-700 rounded hover:bg-gray-600">&laquo;</a>
                <?php endif; ?>

                <!-- Previous -->
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>"
                        class="px-3 py-2 bg-gray-700 rounded hover:bg-gray-600">&lt;</a>
                <?php endif; ?>

                <!-- Page Numbers -->
                <?php
                $range = 3; // show 3 pages before and after current
                $start = max(1, $page - $range);
                $end = min($totalPages, $page + $range);
                for ($i = $start; $i <= $end; $i++): ?>
                    <a href="?page=<?= $i ?>"
                        class="px-3 py-2 rounded <?= $i === $page ? 'bg-blue-600 text-white' : 'bg-gray-700 hover:bg-gray-600' ?>">

                        <?= $i ?>
                        
                    </a>
                <?php endfor; ?>

                <!-- Next -->
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>"
                        class="px-3 py-2 bg-gray-700 rounded hover:bg-gray-600">&gt;</a>
                <?php endif; ?>

                <!-- Last Page -->
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $totalPages ?>"
                        class="px-3 py-2 bg-gray-700 rounded hover:bg-gray-600">&raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</body>

</html>