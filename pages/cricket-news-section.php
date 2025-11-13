<div class="dark:text-white text-gray-800 pt-4 lg:pt-10">
    <div class="flex justify-between items-center mb-4">
        <h1 class="lg:text-2xl text-lg font-bold flex items-center gap-2">
            <p class="bg-red-700 p-1 rounded-lg">
                <i class="fa-solid fa-newspaper text-white"></i>
            </p>

            <?= $lang === 'en' ? 'Cricket News' : 'ক্রিকেট সংবাদ' ?>
        </h1>
        <a href="/pages/cricket-news?lang=<?= $lang ?>"
            class="inline-flex items-center text-white gap-1 py-1 px-3 rounded-lg hover:bg-red-600 bg-red-700 transition text-sm lg:text-base">

            <?= $lang === 'en' ? 'View All' : 'সব দেখুন' ?>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="flex flex-col md:flex-row gap-2">

        <!-- MAIN SLIDER -->
        <div class="relative overflow-hidden item-left">
            <div id="mainSlider" class="flex transition-transform duration-700 ease-in-out w-full h-auto">
                <?php
                if (!empty($limitedPosts)):
                    $mainSlides = array_slice($limitedPosts, 0, 3);
                    foreach ($mainSlides as $post):
                ?>
                        <a href="/pages/detail?slug=<?= urlencode($post['slug']) ?>&lang=<?= $lang ?>"
                            class="flex-shrink-0 w-full relative">

                            <!-- Image -->
                            <?php if (!empty($post['image'])): ?>
                                <img src="/admin/page/post/<?= htmlspecialchars($post['image']) ?>"
                                    alt="<?= htmlspecialchars($post['name']) ?>"
                                    class="w-full h-[200px] lg:h-[300px] object-cover">
                            <?php else: ?>
                                <div class="w-full slide-image bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-300 text-sm">
                                    <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                                </div>
                            <?php endif; ?>

                            <!-- Overlay text -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-3 lg:p-6">
                                <h2 class="text-sm lg:text-2xl font-bold text-white mb-1 line-clamp-2">
                                    <?= htmlspecialchars($post['name']) ?>
                                </h2>
                                <div class="flex items-center gap-1 text-gray-300 text-xs lg:text-sm">
                                    <i class="fa-solid fa-earth-americas"></i>
                                    <span>
                                        <?= $lang === 'bn'
                                            ? formatDateByLang($post['created_at'], 'bn')
                                            : (!empty($post['created_at']) ? date("F j, Y", strtotime($post['created_at'])) : '') ?>
                                    </span>
                                </div>
                            </div>
                        </a>
                <?php endforeach;
                endif; ?>
            </div>

            <!-- Arrows -->
            <button id="prevSlide"
                class="absolute left-2 top-1/2 -translate-y-1/2 hover:opacity-70 cursor-pointer text-white p-2 rounded-full z-10">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button id="nextSlide"
                class="absolute right-2 top-1/2 -translate-y-1/2 hover:opacity-70 cursor-pointer text-white p-2 rounded-full z-10">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>



        <!-- FEATURE CARDS -->
        <div class="flex flex-col lg:gap-2 gap-4">
            <?php foreach (array_slice($limitedPosts, 3, 4) as $post): ?>
                <a href="/pages/detail?slug=<?= urlencode($post['slug']) ?>&lang=<?= $lang ?>">
                    <div class="overflow-hidden flex h-[120px]transition-transform duration-300 hover:scale-[1.02]">
                        <?php if (!empty($post['image'])): ?>
                            <img src="/admin/page/post/<?= htmlspecialchars($post['image']) ?>"
                                alt="<?= htmlspecialchars($post['name']) ?>"
                                class="w-[160px] object-cover">
                        <?php else: ?>
                            <div class="w-[160px] flex items-center justify-center text-gray-300 text-sm">
                                <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                            </div>
                        <?php endif; ?>

                        <div class="flex flex-col px-2 item-right">
                            <h3 class="text-md font-semibold line-clamp-2">
                                <?= htmlspecialchars($post['name']) ?>
                            </h3>

                            <p class="dark:text-gray-300 text-gray-800 text-sm mt-1 line-clamp-2 mb-1">
                                <?= htmlspecialchars(mb_strimwidth(strip_tags(html_entity_decode($post['description'] ?? '')), 0, 110, '...')) ?>
                            </p>

                            <div class="flex items-center gap-1 dark:text-gray-300 text-gray-800 text-xs">
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