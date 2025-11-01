<?php
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';
?>
<div class="text-white">
    <div class="flex justify-between items-center mb-4">
        <h1 class="lg:text-3xl text-lg font-bold text-white">
            <?= $lang === 'en' ? 'Cricket News' : 'ক্রিকেট সংবাদ' ?>
        </h1>
        <a href="/pages/cricket-news?lang=<?= $lang ?>"
            class="inline-block bg-red-800 text-white px-2 lg:px-6 py-1 lg:py-2 rounded-lg hover:opacity-70 transition">
            
            <?= $lang === 'en' ? 'See More' : 'আরও দেখুন' ?>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-0 gap-2">
        <!-- Main Featured Post -->
        <?php if (!empty($limitedPosts)):
            $mainPost = array_shift($limitedPosts); // Take first post as main
        ?>
            <a href="/pages/detail?slug=<?= urlencode($mainPost['slug']) ?>&lang=<?= $lang ?>" class="lg:col-span-2 lg:w-[640px] lg:mb-0 mb-2">
                <div class="bg-gray-800 hover:bg-gray-700 shadow rounded-lg overflow-hidden h-full flex flex-col">
                    <?php if (!empty($mainPost['image'])): ?>
                        <img src="/admin/page/post/<?= htmlspecialchars($mainPost['image']) ?>" alt="<?= htmlspecialchars($mainPost['name']) ?>" class="w-full lg:h-[350px] h-[200px] object-cover">
                    <?php else: ?>
                        <div class="w-full lg:h-[350px] h-[200px] bg-gray-600 flex items-center justify-center text-gray-300 text-sm">
                            <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                        </div>
                    <?php endif; ?>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <h2 class="text-2xl font-bold mb-4 line-clamp-2">
                            <?= htmlspecialchars($mainPost['name']) ?>
                        </h2>
                        <p class="text-gray-300 mb-2 break-words whitespace-normal">
                            <?php
                            $plainText = strip_tags($mainPost['description'] ?? '');
                            $plainText = html_entity_decode($plainText, ENT_QUOTES | ENT_HTML5);
                            if (mb_strlen($plainText, 'UTF-8') > 80) {
                                $plainText = mb_substr($plainText, 0, 75, 'UTF-8') . '...';
                            }
                            echo htmlspecialchars($plainText);
                            ?>
                        </p>

                        <!-- Date with globe icon -->
                        <div class="flex items-center gap-1 text-gray-400 text-xs mt-4 truncate">
                            <i class="fa-solid fa-earth-americas"></i>
                            <span>
                                <?= $lang === 'bn'
                                    ? formatDateByLang($mainPost['created_at'], 'bn')
                                    : date("F j, Y", strtotime($mainPost['created_at'] ?? '')) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        <?php endif; ?>

        <!-- Smaller Posts on the Right -->
        <div class="flex flex-col gap-2">
            <?php foreach (array_slice($limitedPosts, 0, 4) as $post): ?>
                <a href="/pages/detail?slug=<?= urlencode($post['slug']) ?>&lang=<?= $lang ?>">
                    <div class="bg-gray-800 hover:bg-gray-700 shadow rounded-lg overflow-hidden flex h-[160px] lg:h-[140px]">
                        <?php if (!empty($post['image'])): ?>
                            <img src="/admin/page/post/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['name']) ?>" class="w-[160px] object-cover">
                        <?php else: ?>
                            <div class="w-[160px] bg-gray-600 flex items-center justify-center text-gray-300 text-sm">
                                <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                            </div>
                        <?php endif; ?>
                        <div class="p-3 w-2/3 flex flex-col justify-between">
                            <!-- Post Title -->
                            <h3 class="text-lg font-semibold line-clamp-2 break-words">
                                <?= htmlspecialchars($post['name']) ?>
                            </h3>

                            <!-- Post Description -->
                            <p class="text-gray-300 text-sm line-clamp-2 break-words">
                                <?= htmlspecialchars(mb_strimwidth(strip_tags(html_entity_decode($post['description'] ?? '')), 0, 70, '...')) ?>
                            </p>

                            <!-- Date with globe icon -->
                            <div class="flex items-center gap-1 text-gray-400 text-xs mt-1 truncate">
                                <i class="fa-solid fa-earth-americas"></i>
                                <span>
                                    <?= $lang === 'bn'
                                        ? formatDateByLang($post['created_at'], 'bn')
                                        : (!empty($post['created_at']) ? date("F j, Y", strtotime($post['created_at'])) : '') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</div>