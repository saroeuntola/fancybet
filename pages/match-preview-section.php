<?php
require_once './admin/page/library/post_lib.php';
$posts = new Post();
$categoryPosts = $posts->getPostByCategory(2, $lang);
?>
<div class="scroll-section mb-20 relative text-gray-800 dark:text-white">

    <div class="flex justify-between items-center mb-4">
        <h1 class="lg:text-2xl text-lg font-bold flex items-center gap-2 ">
            <p class="bg-red-700 p-1 rounded-lg">
                <i class="fa-solid fa-table-tennis-paddle-ball text-white"></i>
            </p>

            <?= $lang === 'en' ? 'Match Previews' : 'ম্যাচ প্রিভিউ' ?>
        </h1>
        <a href="/pages/cricket-previews?lang=<?= $lang ?>"
            class="inline-flex items-center text-white gap-1 py-1 px-3 rounded-lg hover:bg-red-600 bg-red-700 transition text-sm lg:text-base">

            <?= $lang === 'en' ? 'View All' : 'সব দেখুন' ?>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="relative w-full">
        <!-- Left Arrow -->
        <button

            class="scroll-left hidden lg:flex absolute left-2 top-[100px] -translate-y-1/2 bg-gray-800/70 hover:opacity-90 text-white w-10 h-10 rounded-full shadow-lg items-center justify-center z-10">
            &#10094;
        </button>

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
                <a href="/pages/detail?slug=<?= $postSlug ?>&lang=<?= $lang ?>" class="overflow-hidden flex-shrink-0 w-[280px] sm:w-[300px] md:w-[310px] snap-start">
                    <div class=" dark:text-white text-gray-800 transition flex flex-col h-[340px]">

                        <?php if ($postImage): ?>
                            <img src="/admin/page/post/<?= $postImage ?>" alt="<?= $postName ?>" class="w-full h-[200px] object-cover transition-transform duration-500 ease-in-out hover:scale-110 overflow-hidded">
                        <?php else: ?>
                            <div class="w-full h-[200px] bg-gray-600 flex items-center justify-center text-gray-300 text-sm">
                                <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                            </div>
                        <?php endif; ?>
                        <!-- Content -->
                        <div class="py-2 mt-2 flex-1 flex flex-col">
                            <h2 class="text-md font-semibold mb-2 dark:text-white text-gray-800 line-clamp-2 break-words">
                                <?= $postName ?>
                            </h2>
                            <p class="dark:text-gray-300 text-gray-800 text-sm break-words">
                                <?= $postDesc ?>
                            </p>
                            <!-- Date -->
                            <div class="flex items-center gap-1 dark:text-gray-400 text-gray-800 text-xs mt-2 truncate">
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