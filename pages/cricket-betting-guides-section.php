<?php
require_once './admin/page/library/post_lib.php';
$posts = new Post();
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';
$categoryPosts = $posts->getPostByCategory(2, $lang);
?>
<div class="scroll-section mb-20 relative">
    <div class="h-px bg-red-800 w-full mb-4 mt-5"></div>

    <div class="flex justify-between items-center mb-4 mt-10">
        <h1 class="lg:text-2xl text-lg font-bold text-white ">
            <?= $lang === 'en' ? 'Cricket Betting Guides' : 'ক্রিকেট বেটিং গাইড' ?>
        </h1>
        <a href="/pages/cricket-betting-guides?lang=<?= $lang ?>"
            class="inline-flex items-center gap-1 underline hover:text-red-700 transition text-sm lg:text-base text-white">
            <?= $lang === 'en' ? 'View All' : 'সব দেখুন' ?>
        </a>


    </div>

    <div class="relative w-full">
        <!-- Left Arrow -->
        <button

            class="scroll-left hidden lg:flex absolute left-2 top-[100px] -translate-y-1/2 bg-gray-800/70 hover:opacity-90 text-white w-10 h-10 rounded-full shadow-lg items-center justify-center z-10">
            &#10094;
        </button>

        <!-- Scrollable container -->
        <!-- Scrollable container -->
        <div class="scroll-grid flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory touch-pan-x cursor-grab select-none scrollbar-hide px-4 md:px-10 w-full">
            <?php foreach ($categoryPosts as $post): ?>
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
                <a href="/pages/detail?slug=<?= $postSlug ?>&lang=<?= $lang ?>" class="flex-shrink-0 w-[280px] sm:w-[300px] md:w-[310px] snap-start">
                    <div class="bg-gray-800 hover:bg-gray-700 transition shadow-lg rounded-xl overflow-hidden flex flex-col h-[380px]">
                        <!-- Image -->
                        <?php if ($postImage): ?>
                            <img src="/admin/page/post/<?= $postImage ?>" alt="<?= $postName ?>" class="w-full h-[200px] object-cover">
                        <?php else: ?>
                            <div class="w-full h-[200px] bg-gray-600 flex items-center justify-center text-gray-300 text-sm">
                                <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                            </div>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <h2 class="lg:text-xl text-md font-semibold mb-2 text-white line-clamp-2 break-words">
                                <?= $postName ?>
                            </h2>
                            <p class="text-gray-300 text-sm mb-2 break-words">
                                <?= $postDesc ?>
                            </p>
                            <!-- Date -->
                            <div class="flex items-center gap-1 text-gray-400 text-xs mt-2 truncate">
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
        <!-- Right Arrow -->
        <button

            class="absolute scroll-right right-2 top-[100px] -translate-y-1/2 bg-gray-800/70 hover:opacity-90 text-white w-10 h-10 rounded-full shadow-lg hidden lg:flex items-center justify-center z-10">
            &#10095;
        </button>
    </div>
</div>