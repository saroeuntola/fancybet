<?php
include '../admin/page/library/post_lib.php';
include '../admin/page/library/comment_lib.php';
include '../admin/page/library/db.php';
include './services/bn-date.php';

$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';
$slug = $_GET['slug'] ?? '';
$postLib = new Post();
$post = $postLib->getPostBySlug($slug, $lang);
$currentSlug = $_GET['slug'] ?? '';
$commentLib = new Comment();
$comments = $commentLib->getByPost($post['id'] ?? 0);
$relatedPosts = $postLib->getRelatedpost($post['id'] ?? 0, $post['category_id'] ?? 0, 6);

// Pagination variables for desktop
$desktopLimit = 4; // items per page for desktop
$desktopPage = isset($_GET['related_page']) ? max(1, intval($_GET['related_page'])) : 1;
$totalDesktopPages = ceil(count($relatedPosts) / $desktopLimit);
$desktopStart = ($desktopPage - 1) * $desktopLimit;
$desktopPosts = array_slice($relatedPosts, $desktopStart, $desktopLimit);


$baseURL = "https://fancybet.info";
// Dynamic SEO values from DB
$postTitle =  ($post['name'] ?? '');
$postDescription =  ($post['meta_desc'] ?? '');
$postKeywords = ($post['meta_keyword'] ?? '');
$postImage = $post['image'] ?? '/image/favicon-96x96.png';
$postUrl = "https://fancybet.info/pages/detail?slug=" . urlencode($slug) . "&lang=" . $lang;
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? "en-BD" : "bn-BD"?>" class="bg-gray-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic SEO -->
    <title><?= htmlspecialchars($postTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($postDescription) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($postKeywords) ?>">
    <meta name="robots" content="index, follow">

    <!-- Canonical -->
    <link rel="canonical" href="<?= htmlspecialchars($postUrl) ?>">

    <!-- Open Graph / Social -->
    <meta property="og:title" content="<?= htmlspecialchars($postTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($postDescription) ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= htmlspecialchars($postUrl) ?>">
    <meta property="og:image" content="<?= $baseURL ?>/admin/page/post/<?= htmlspecialchars($postImage) ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($postTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($postDescription) ?>">
    <meta name="twitter:image" content="<?= $baseURL ?>/admin/page/post/<?= htmlspecialchars($postImage) ?>">

    <!-- Favicon -->
    <link rel="icon" href="/admin/page/post/<?= htmlspecialchars($postImage) ?>" type="image/png">

    <!-- Schema.org Article -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "headline": "<?= addslashes($postTitle) ?>",
            "description": "<?= addslashes($postDescription) ?>",
            "image": "<?= $baseURL ?>/admin/page/post/<?= addslashes($postImage) ?>",
            "author": {
                "@type": "Organization",
                "name": "FancyBet"
            },
            "publisher": {
                "@type": "Organization",
                "name": "FancyBet",
                "logo": {
                    "@type": "ImageObject",
                    "url": "<?= $baseURL ?>/image/favicon-96x96.png"
                }
            },
            "url": "<?= addslashes($postUrl) ?>",
            "datePublished": "<?= $post['created_at'] ?? date('Y-m-d') ?>",
            "mainEntityOfPage": "<?= addslashes($postUrl) ?>"
        }
    </script>

    <!-- Styles & Scripts -->
    <link rel="stylesheet" href="/css/detail.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-900">
    <?php
    include "navbar.php"
    ?>
    <main class="container max-w-5xl mx-auto px-4 py-8 text-white pt-20 ">

        <!-- Post Card -->
        <div class=" mb-6">
            <h1 class="lg:text-3xl text-lg font-bold mb-2"><?= htmlspecialchars($post['name'] ?? '') ?></h1>
            <?php if (!empty($post['created_at'])): ?>
                <?php
                date_default_timezone_set('Asia/Phnom_Penh');
                $createdAt = new DateTime($post['created_at']);
                ?>
                <p class="text-gray-100 text-sm mb-4">
                    <?= $lang === 'en' ? 'Published on' : 'প্রকাশিত তারিখ  ' ?> <?= formatDateByLang($post['created_at'] ?? '', $lang) ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($post['image'])): ?>
                <img src="/admin/page/post/<?= htmlspecialchars($post['image']) ?>" class="w-full md:h-[380px] h-[220px] lg:h-[500px] mb-4 rounded">
            <?php endif; ?>
            <div class="break-words desc-editor">
                <?php
                $description = $post['description'] ?? '';
                $description = str_replace('../api/content_image/', '/admin/page/api/content_image/', $description);
                echo $description;
                ?>
            </div>

            <h3 class="font-semibold text-lg text-gray-100 mt-10">
                <?= $lang === 'en' ? 'Share this post:' : 'এই পোস্টটি শেয়ার করুন:' ?>
            </h3>
            <!-- Social Share Buttons -->
            <div class="mt-3 flex flex-wrap gap-3 justify-start md:justify-start items-center">
                <!-- Facebook -->
                <a
                    href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('https://fancybet.info/pages/detail?slug=' . $slug) ?>&lang=<?= $lang ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition text-sm md:text-base">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>

                <!-- Twitter -->
                <a
                    href="https://twitter.com/intent/tweet?url=<?= urlencode('https://fancybet.info/pages/detail?slug=' . $slug) ?>&text=<?= urlencode($post['name']) ?>&lang=<?= $lang ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center gap-2 bg-blue-400 hover:bg-blue-500 text-white px-3 py-2 rounded-lg transition text-sm md:text-base">
                    <i class="fab fa-twitter"></i> Twitter
                </a>

                <!-- LinkedIn -->
                <a
                    href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode('https://fancybet.info/pages/detail?slug=' . $slug) ?>&title=<?= urlencode($post['name']) ?>&lang=<?= $lang ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center gap-2 bg-blue-800 hover:bg-blue-900 text-white px-3 py-2 rounded-lg transition text-sm md:text-base">
                    <i class="fab fa-linkedin-in"></i> LinkedIn
                </a>

                <!-- Copy Link -->
                <button
                    id="copyLinkBtn"
                    onclick="copyPostLink('<?= 'https://fancybet.info/pages/detail?slug=' . $slug ?>&lang=<?= $lang ?>')"
                    class="flex items-center gap-2 bg-gray-700 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition text-sm md:text-base">
                    <i class="fas fa-link"></i> Copy Link
                </button>
            </div>
        </div>



        <div class="mt-6">
            <!-- Comments Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    <?= $lang === 'en' ? 'Comments' : 'মন্তব্য' ?> (<?= count($comments) ?>)
                </h3>
            </div>

            <!-- Comment Form -->
            <form id="commentForm" class="bg-gray-800 shadow-md rounded-lg p-4 mb-6">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?? 0 ?>">
                <input type="hidden" name="parent_id" value="">

                <div class="mb-3">
                    <label class="block text-gray-500 dark:text-gray-100 mb-1" for="name"><?= $lang === 'en' ? "Your Name" : "তোমার নাম" ?> </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="<?= $lang === 'en' ? 'Enter your name' : 'আপনার নাম লিখুন' ?>"
                        required
                        class="w-full px-4 py-2  rounded-lg focus:ring-2 focus:ring-red-500 focus:outline-none bg-gray-300 text-gray-800 transition" />
                </div>
                <div class="mb-3">
                    <label class="block text-gray-500 dark:text-gray-100 mb-1" for="comment"> <?= $lang === 'en' ? 'Comment' : 'মন্তব্য' ?></label>
                    <textarea
                        name="comment"
                        id="comment"
                        placeholder="<?= $lang === 'en' ? 'Write your comment here...' : 'আপনার মন্তব্য এখানে লিখুন...' ?>"
                        required
                        rows="6"
                        class="w-full px-4 py-2 rounded-lg focus:ring-2 focus:ring-red-500 focus:outline-none bg-gray-300 text-gray-800 transition resize-none"></textarea>
                </div>
                <button type="submit" class="bg-red-800 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition cursor-pointer">
                    <?= $lang === 'en' ? 'Submit Comment' : 'মন্তব্য জমা দিন' ?>
                </button>
            </form>

            <!-- Comments List -->
            <div id="commentsWrapper" class="max-h-[400px] overflow-y-auto space-y-3 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800">
                <div id="comments"></div>
            </div>
        </div>

        <?php if (!empty($relatedPosts)): ?>
            <div class="mb-6 mt-4">
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
                        class="post-grid grid grid-flow-col gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory touch-pan-x cursor-grab select-none px-4 scrollbar-hide">
                        <?php foreach ($relatedPosts as $rPost): ?>
                            <a href="/pages/detail?slug=<?= urlencode($rPost['slug']) ?> &lang=<?= $lang ?>" class="lg:w-[345px] w-[270px] flex-shrink-0 snap-start">
                                <div class="bg-gray-800 shadow rounded-lg overflow-hidden flex flex-col h-[360px]">
                                    <?php if (!empty($rPost['image'])): ?>
                                        <img
                                            src="/admin/page/post/<?= htmlspecialchars($rPost['image']) ?>"
                                            class="w-full h-[200px]">
                                    <?php endif; ?>
                                    <div class="p-2">
                                        <div>
                                            <h3 class="text-white font-semibold lg:text-lg text-sm mb-2"><?= htmlspecialchars($rPost['name']) ?></h3>
                                            <p class="text-gray-300 mb-1 break-words whitespace-normal">
                                                <?php
                                                // Remove HTML tags
                                                $plainText = strip_tags($rPost['description'] ?? '');
                                                // Decode HTML entities
                                                $plainText = html_entity_decode($plainText, ENT_QUOTES | ENT_HTML5);
                                                // Truncate multibyte string to 80 characters
                                                if (mb_strlen($plainText, 'UTF-8') > 80) {
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
                        <a href="<?= htmlspecialchars($seeMoreLink) ?>" class="lg:w-[345px] w-[260px] flex-shrink-0 snap-start cursor-pointer">
                            <div class="bg-gray-800 shadow rounded-lg overflow-hidden flex flex-col h-[360px] items-center justify-center">
                                <b class="bg-red-700 p-2 rounded-lg">See More</b>
                            </div>
                        </a>

                    </div>

                </div>
            </div>
        <?php endif; ?>
    </main>
    <?php include "./footer.php" ?>
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