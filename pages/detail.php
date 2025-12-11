<?php
include '../admin/page/library/post_lib.php';
include '../admin/page/library/comment_lib.php';
include '../admin/page/library/db.php';
include './services/bn-date.php';
include '../baseURL.php';
include './breadcrumb.php';

require_once '../pages/services/menu.php';
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';
$slug = $_GET['slug'] ?? '';
$postLib = new Post();
$post = $postLib->getPostBySlug($slug, $lang);
$currentSlug = $_GET['slug'] ?? '';
$commentLib = new Comment();
$comments = $commentLib->getByPost($post['id'] ?? 0);
$relatedPosts = $postLib->getRelatedpost($post['id'] ?? 0, $post['category_id'] ?? 0, 6);
$recentPosts = $postLib->getRecentPost(8, $lang);

$desktopLimit = 4;
$desktopPage = isset($_GET['related_page']) ? max(1, intval($_GET['related_page'])) : 1;
$totalDesktopPages = ceil(count($relatedPosts) / $desktopLimit);
$desktopStart = ($desktopPage - 1) * $desktopLimit;
$desktopPosts = array_slice($relatedPosts, $desktopStart, $desktopLimit);

$baseURL = $ImageURL;
$postTitle =  ($post['name'] ?? '');
$postDescription =  ($post['meta_desc'] ?? '');
$postKeywords = ($post['meta_keyword'] ?? '');
$postImage = $post['image'] ?? '/image/favicon-96x96.png';
$postUrl = "https://fancybet.info/pages/detail?slug=" . urlencode($slug) . "&lang=" . $lang;
 


    $descriptionWithFullUrl = preg_replace_callback(
    '/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i',
    function ($matches) use ($ImageURL) {
        $src = $matches[1];

        if (!preg_match('#^https?://#i', $src)) {
            $src = rtrim($ImageURL, '/') . '/' . ltrim($src, '/');
        }
        return str_replace($matches[1], $src, $matches[0]);
    },
    $post['description'] ?? ''
);



$breadcrumbs = generateBreadcrumb($lang, $menu);

$baseURL =  "https://fancybet.info/";

?>


<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? "en-BD" : "bn-BD" ?>" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic SEO -->
    <title><?= htmlspecialchars($postTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($postDescription) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($postKeywords) ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- Canonical -->
    <link rel="canonical" href="<?= htmlspecialchars($postUrl) ?>">

    <!-- Open Graph / Social -->
    <meta property="og:title" content="<?= htmlspecialchars($postTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($postDescription) ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= htmlspecialchars($postUrl) ?>">
    <meta property="og:image" content="<?= $ImageURL ?><?= htmlspecialchars($postImage) ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($postTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($postDescription) ?>">
    <meta name="twitter:image" content="<?= $ImageURL ?><?= htmlspecialchars($postImage) ?>">
    <!-- Favicon -->
    <link rel="icon" href="<?= $ImageURL ?><?= htmlspecialchars($postImage) ?>" type="image/png">

    <link rel="stylesheet" href="/src/output.css">
    <link rel="stylesheet" href="/css/breadcrumb.css">

    <!-- Preload Critical CSS -->
    <link rel="preload" href="/css/detail.css" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="/css/style.css" as="style" onload="this.rel='stylesheet'">
    


    <!-- Schema.org Article  -->
    <?php outputFullSchema($breadcrumbs, $post, $baseURL, $ImageURL); ?>

    <!-- Deferred JS -->
    <script src="./js/jquery-3.7.1.min.js" defer></script>
</head>
<style>
    .desc-editor a {
        color: skyblue;
        text-decoration: underline;
    }
</style>

<body class="dark:bg-black bg-[#f5f5f5]">
    <?php
    include "navbar.php"
    ?>
    <main class="container max-w-7xl mx-auto px-4 mt-[80px]">
      <?php 
        include './services/breadcrumb-menu.php';
      ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <!-- Main Content -->
            <section class="lg:col-span-2 space-y-6 dark:text-white text-gray-800 ">
                <!-- Post Card -->
                <div class="mb-6 bg-white dark:bg-[#252525] p-4 shadow-[0_0_5px_0_rgba(0,0,0,0.2)]">
                    <h1 class="lg:text-3xl text-lg font-bold mb-2"><?= htmlspecialchars($post['name'] ?? '') ?></h1>

                    <?php if (!empty($post['created_at'])): ?>
                        <p class="dark:text-gray-100 text-gray-800 text-sm mb-4">
                            <?= $lang === 'en' ? 'Published on' : 'প্রকাশিত তারিখ' ?>
                            <?= formatDateByLang($post['created_at'] ?? '', $lang) ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($post['image'])): ?>
                        <img src="<?= $ImageURL ?><?= htmlspecialchars($post['image']) ?>" class="w-full h-auto mb-4 rounded">
                    <?php endif; ?>

                    <div class="break-words desc-editor" style="white-space: pre-line;">
                        <?= $descriptionWithFullUrl ?>
                    </div>

                    <h3 class="font-semibold text-lg dark:text-gray-100 text-gray-900 mt-10">
                        <?= $lang === 'en' ? 'Share this post:' : 'এই পোস্টটি শেয়ার করুন:' ?>
                    </h3>

                    <!-- Social Share Buttons -->
                    <div class="mt-3 flex flex-wrap gap-3 justify-start md:justify-start items-center">
                        <!-- Facebook -->
                        <a
                            href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('https://fancybet.info/pages/detail?slug=' . $slug . '&lang=' . $lang) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition text-sm md:text-base">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>

                        <!-- Twitter -->
                        <a
                            href="https://twitter.com/intent/tweet?url=<?= urlencode('https://fancybet.info/pages/detail?slug=' . $slug . '&lang=' . $lang) ?>&text=<?= urlencode($post['name']) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center gap-2 bg-blue-400 hover:bg-blue-500 text-white px-3 py-2 rounded-lg transition text-sm md:text-base">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>

                        <!-- LinkedIn -->
                        <a
                            href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode('https://fancybet.info/pages/detail?slug=' . $slug . '&lang=' . $lang) ?>&title=<?= urlencode($post['name']) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center gap-2 bg-blue-800 hover:bg-blue-900 text-white px-3 py-2 rounded-lg transition text-sm md:text-base">
                            <i class="fab fa-linkedin-in"></i> LinkedIn
                        </a>

                        <!-- Pinterest -->
                        <a
                            href="https://pinterest.com/pin/create/button/?url=<?= urlencode('https://fancybet.info/pages/detail?slug=' . $slug . '&lang=' . $lang) ?>&media=<?= urlencode($post['image'] ?? 'https://fancybet.info/assets/img/logo.png') ?>&description=<?= urlencode($post['name']) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition text-sm md:text-base">
                            <i class="fab fa-pinterest-p"></i> Pinterest
                        </a>

                        <!-- Copy Link -->
                        <button
                            id="copyLinkBtn"
                            onclick="copyPostLink('<?= 'https://fancybet.info/pages/detail?slug=' . $slug . '&lang=' . $lang ?>')"
                            class="flex items-center gap-2 bg-gray-700 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition text-sm md:text-base">
                            <i class="fas fa-link"></i> Copy Link
                        </button>
                    </div>
                    <!-- Comments & Related Posts -->
                    <div class="space-y-6 mt-10">
                        <!-- Comments Section -->
                        <div>
                            <h3 class="text-xl font-semibold mb-4"><?= $lang === 'en' ? 'Comments' : 'মন্তব্য' ?> (<?= count($comments) ?>)</h3>
                            <form id="commentForm" class=" mb-6 space-y-3">
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?? 0 ?>">
                                <input type="hidden" name="parent_id" value="">
                                <input type="text" name="name" placeholder="<?= $lang === 'en' ? 'Enter your name' : 'আপনার নাম লিখুন' ?>" required class="w-full px-4 py-2 rounded-lg focus:ring-2 focus:ring-red-500 bg-gray-300 text-gray-800">
                                <textarea name="comment" placeholder="<?= $lang === 'en' ? 'Write your comment here...' : 'আপনার মন্তব্য এখানে লিখুন...' ?>" required rows="6" class="w-full px-4 py-2 rounded-lg focus:ring-2 focus:ring-red-500 bg-gray-300 text-gray-800 resize-none"></textarea>
                                <button type="submit" class="bg-red-800 text-white px-6 py-2 rounded-lg hover:bg-red-700"> <?= $lang === 'en' ? 'Submit Comment' : 'মন্তব্য জমা দিন' ?> </button>
                            </form>
                            <div id="commentsWrapper" class="max-h-[400px] overflow-y-auto space-y-3 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800">
                                <div id="comments"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bg-white dark:bg-[#252525] p-4 shadow-[0_0_5px_0_rgba(0,0,0,0.2)]">
                    <!-- Related Posts -->
                    <?php if (!empty($relatedPosts)): ?>
                        <div class="">
                            <h2 class="text-xl font-bold mb-3"><?= $lang === 'en' ? 'Related Contents' : 'সম্পর্কিত বিষয়বস্তু' ?></h2>

                            <div class="relative w-full overflow-hidden">
                                <!-- Left Arrow -->
                                <button
                                    id="relatedPrev"
                                    class="absolute left-2 top-24 -translate-y-1/2 bg-gray-800/70 hover:opacity-90 text-white w-10 h-10 rounded-full shadow-lg flex items-center justify-center z-10">
                                    &#10094;
                                </button>

                                <!-- Right Arrow -->
                                <button
                                    id="relatedNext"
                                    class="absolute right-2 top-24 -translate-y-1/2 bg-gray-800/70 hover:opacity-90 text-white w-10 h-10 rounded-full shadow-lg flex items-center justify-center z-10">
                                    &#10095;
                                </button>

                                <div
                                    id="relatedGrid"
                                    class="post-grid grid grid-flow-col gap-3 overflow-x-auto scroll-smooth snap-x snap-mandatory touch-pan-x cursor-grab select-none px-4 scrollbar-hide">
                                    <?php foreach ($relatedPosts as $rPost): ?>
                                        <a href="/pages/detail?slug=<?= urlencode($rPost['slug']) ?> &lang=<?= $lang ?>" class="w-[270px] flex-shrink-0 snap-start">
                                            <div class="overflow-hidden flex flex-col h-[340px]">
                                                <?php if (!empty($rPost['image'])): ?>
                                                    <img
                                                        src="/admin/page/post/<?= htmlspecialchars($rPost['image']) ?>"
                                                        class="w-full h-[180px]">
                                                <?php endif; ?>
                                                <div class="py-2">
                                                    <div>
                                                        <h3 class="dark:text-white text-gray-900 font-semibold text-md mb-2"><?= htmlspecialchars($rPost['name']) ?></h3>
                                                        <p class="dark:text-gray-300 text-gray-900 mb-1 break-words whitespace-normal text-sm">
                                                            <?php
                                                            // Remove HTML tags
                                                            $plainText = strip_tags($rPost['description'] ?? '');
                                                            // Decode HTML entities
                                                            $plainText = html_entity_decode($plainText, ENT_QUOTES | ENT_HTML5);
                                                            // Truncate multibyte string to 80 characters
                                                            if (mb_strlen($plainText, 'UTF-8') > 50) {
                                                                $plainText = mb_substr($plainText, 0, 75, 'UTF-8') . '...';
                                                            }
                                                            echo htmlspecialchars($plainText);
                                                            ?>
                                                        </p>
                                                    </div>


                                                    <!-- Date with globe icon -->
                                                    <div class="flex items-center gap-1 text-gray-400 text-xs mt-2">
                                                        <i class="fa-solid fa-earth-americas"></i>
                                                        <span><?= formatDateByLang($rPost['created_at'] ?? '', $lang) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>

                                    <!-- See More Card -->
                                    <?php
                                    $categoryId = $post['category_id'] ?? null;
                                    $seeMoreLink = '/pages/cricket-news';
                                    if ($categoryId == 2) {
                                        $seeMoreLink = '/pages/cricket-betting-guides';
                                    } elseif ($categoryId == 3) {
                                        $seeMoreLink = '/pages/cricket-news';
                                    } elseif ($categoryId == 6) {
                                        $seeMoreLink = '/pages/match-preview';
                                    }
                                    ?>
                                    <!-- See More Card -->
                                    <a href="<?= htmlspecialchars($seeMoreLink) ?>" class="w-[260px] flex-shrink-0 snap-start cursor-pointer py-20">
                                        <div class="overflow-hidden flex flex-col items-center justify-center">
                                            <button class="bg-red-700 p-2 rounded-lg">See More</button>
                                        </div>
                                    </a>

                                </div>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Right Sidebar -->
            <aside class="lg:col-span-1 dark:text-white text-gray-800 bg-white dark:bg-[#252525] shadow-[0_0_5px_0_rgba(0,0,0,0.2)]">
                <div class="p-4 rounded-lg lg:sticky lg:top-15 h-fit right-sidebar">

                    <h2 class="text-lg font-bold mb-4 border-b border-gray-700 pb-2">
                        <?= $lang === 'en' ? 'Recent Posts' : 'সাম্প্রতিক পোস্ট' ?>
                    </h2>

                    <ul class="space-y-4">
                        <?php foreach ($recentPosts as $r): ?>
                            <li class="flex items-start gap-3">
                                <div class="flex-1">
                                    <?php
                                    $title = htmlspecialchars($r['name']);
                                    if (mb_strlen($title, 'UTF-8') > 80) {
                                        $title = mb_substr($title, 0, 57, 'UTF-8') . '...';
                                    }
                                    ?>
                                    <a href="/pages/detail?slug=<?= urlencode($r['slug']) ?>&lang=<?= $lang ?>"
                                        class="block w-full font-medium hover:text-red-500 text-sm">
                                        <?= $title ?>
                                    </a>

                                    <div class="flex items-center gap-2 mt-2">
                                        <i class="fa-solid fa-earth-americas text-gray-400"></i>
                                        <p class="text-xs text-gray-400 mt-1"><?= formatDateByLang($r['created_at'] ?? '', $lang) ?></p>
                                    </div>

                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <h1 class="mt-5 text-lg font-bold mb-4 border-b border-gray-700 pb-2">
                        <?= $lang === 'en' ? "Category" : "বিভাগ"  ?>
                    </h1>
                    <ul class="flex flex-col gap-2">
                        <a href="/pages/cricket-news?lang=<?= $lang ?>" class="hover:text-red-500">
                            <?= $lang === 'en' ? 'Cricket News' : 'ক্রিকেট সংবাদ' ?>
                        </a>
                        <a href="/pages/cricket-betting-guides?lang= <?= $lang ?>" class="hover:text-red-500">
                            <?= $lang === 'en' ? 'Cricket Betting Guides' : 'ক্রিকেট বেটিং গাইড' ?>
                        </a>
                        <a href="/pages/match-previews?lang= <?= $lang ?>" class="hover:text-red-500">
                            <?= $lang === 'en' ? 'Match Previews' : 'ম্যাচ প্রিভিউ' ?>
                        </a>

                    </ul>

                </div>
            </aside>
        </div>

    </main>

    <?php include "./footer.php" ?>
    <?php include 'scroll-to-top.php'; ?>
    <?php
    $comments_json = json_encode($comments);
    $post_id = json_encode($post['id'] ?? 0);

    $js = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/js/comment.js');

    $js = str_replace(
        ['__COMMENTS_JSON__', '__POST_ID__'],
        [$comments_json, $post_id],
        $js
    );
    $encoded = base64_encode($js);
    echo '<script src="data:text/javascript;base64,' . $encoded . '" defer></script>';
    ?>

    <?php
    $related_js = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/js/scroll-related-posts.js');
    $related_js_encoded = base64_encode($related_js);
    echo '<script src="data:text/javascript;base64,' . $related_js_encoded . '" defer></script>';
    ?>
</body>

</html>