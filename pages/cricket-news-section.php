<div class="text-white pt-4 lg:pt-10">
    <div class="flex justify-between items-center mb-4">
        <h1 class="lg:text-2xl text-lg font-bold text-white ">
            <?= $lang === 'en' ? 'Cricket News' : 'ক্রিকেট সংবাদ' ?>
        </h1>
        <a href="/pages/cricket-news?lang=<?= $lang ?>"
            class="inline-flex items-center gap-1 underline hover:text-red-700 transition text-sm lg:text-base">
            <?= $lang === 'en' ? 'View All' : 'সব দেখুন' ?>
        </a>
    </div>

    <div class="flex flex-col md:flex-row gap-2">
        <!-- MAIN SLIDER -->
        <div class="relative overflow-hidden rounded-lg shadow-lg item-left">
            <div id="mainSlider" class="flex transition-transform duration-700 ease-in-out w-full bg-gray-800 h-auto">
                <?php
                if (!empty($limitedPosts)):
                    $mainSlides = array_slice($limitedPosts, 0, 3);
                    foreach ($mainSlides as $post):
                ?>
                        <a href="/pages/detail?slug=<?= urlencode($post['slug']) ?>&lang=<?= $lang ?>"
                            class="flex-shrink-0 w-full bg-gray-800">

                            <?php if (!empty($post['image'])): ?>
                                <img src="/admin/page/post/<?= htmlspecialchars($post['image']) ?>"
                                    alt="<?= htmlspecialchars($post['name']) ?>"
                                    class="w-full">
                            <?php else: ?>
                                <div class="w-full h-[200px] lg:h-[350px] bg-gray-700 flex items-center justify-center text-gray-300 text-sm">
                                    <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                                </div>
                            <?php endif; ?>

                            <!-- TEXT BELOW IMAGE -->
                            <div class="p-4">
                                <h2 class="text-xl lg:text-2xl font-bold mb-2 line-clamp-2">
                                    <?= htmlspecialchars($post['name']) ?>
                                </h2>
                          
                                <div class="flex items-center gap-1 text-gray-400 text-xs mt-2">
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
                class="absolute left-2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white p-2 rounded-full z-10">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button id="nextSlide"
                class="absolute right-2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white p-2 rounded-full z-10">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <!-- FEATURE CARDS -->
        <div class="flex flex-col gap-2">
            <?php foreach (array_slice($limitedPosts, 2, 3) as $post): ?>
                <a href="/pages/detail?slug=<?= urlencode($post['slug']) ?>&lang=<?= $lang ?>">
                    <div class="bg-gray-800 hover:bg-gray-700 shadow rounded-lg overflow-hidden flex h-[160px] lg:h-[160px] transition-transform duration-300 hover:scale-[1.02]">
                        <?php if (!empty($post['image'])): ?>
                            <img src="/admin/page/post/<?= htmlspecialchars($post['image']) ?>"
                                alt="<?= htmlspecialchars($post['name']) ?>"
                                class="w-[160px] object-cover">
                        <?php else: ?>
                            <div class="w-[160px] bg-gray-600 flex items-center justify-center text-gray-300 text-sm">
                                <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                            </div>
                        <?php endif; ?>

                        <div class="flex flex-col justify-between p-3 item-right">
                            <h3 class="text-md font-semibold line-clamp-2">
                                <?= htmlspecialchars($post['name']) ?>
                            </h3>

                            <p class="text-gray-300 text-sm mt-1 line-clamp-2">
                                <?= htmlspecialchars(mb_strimwidth(strip_tags(html_entity_decode($post['description'] ?? '')), 0, 60, '...')) ?>
                            </p>

                            <div class="flex items-center gap-1 text-gray-400 text-xs mt-2">
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const slider = document.getElementById("mainSlider");
        const slides = slider.querySelectorAll("a");
        const dots = document.querySelectorAll("#sliderDots .dot");
        const prev = document.getElementById("prevSlide");
        const next = document.getElementById("nextSlide");
        let current = 0;
        let interval;

        function showSlide(index) {
            const offset = -index * 100;
            slider.style.transform = `translateX(${offset}%)`;
            dots.forEach((dot, i) => {
                dot.classList.toggle("bg-red-600", i === index);
                dot.classList.toggle("bg-gray-400", i !== index);
            });
            current = index;
        }

        function nextSlide() {
            showSlide((current + 1) % slides.length);
        }

        function prevSlideFunc() {
            showSlide((current - 1 + slides.length) % slides.length);
        }

        function startAutoSlide() {
            interval = setInterval(nextSlide, 4000);
        }

        function stopAutoSlide() {
            clearInterval(interval);
        }

        dots.forEach((dot, i) => {
            dot.addEventListener("click", () => {
                stopAutoSlide();
                showSlide(i);
                startAutoSlide();
            });
        });

        next.addEventListener("click", () => {
            stopAutoSlide();
            nextSlide();
            startAutoSlide();
        });

        prev.addEventListener("click", () => {
            stopAutoSlide();
            prevSlideFunc();
            startAutoSlide();
        });

        startAutoSlide();
    });
</script>