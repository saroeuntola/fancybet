<footer class="bg-black text-gray-200 mt-10">
    <div class="px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 max-w-screen-lg mx-auto">
        <!-- FW Tools / Resources -->
        <div>
            <h4 class="text-white font-semibold mb-4"><?= $lang === 'en' ? 'Fancybet' : 'Fancybet' ?></h4>
            <p>
                <?= $lang === 'en'
                    ? 'Fancybet is your go-to platform for the latest cricket news, betting guides, and match previews. Stay informed and make smarter bets with us.'
                    : 'Fancybet হল আপনার প্রিয় প্ল্যাটফর্ম সর্বশেষ ক্রিকেট সংবাদ, বেটিং গাইড এবং ম্যাচ প্রিভিউয়ের জন্য। আমাদের সাথে থাকুন এবং আরও স্মার্ট বেট করুন।'
                ?>
            </p>
        </div>

        <!-- Quick Link -->
        <div>
            <h4 class="text-white font-semibold mb-4"><?= $lang === 'en' ? 'Quick Links' : 'দ্রুত লিঙ্ক' ?></h4>
            <ul class="space-y-2">
                <li><a href="/pages/about" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'About Us' : 'আমাদের সম্পর্কে' ?></a></li>
                <li><a href="/pages/contact" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Contact' : 'যোগাযোগ' ?></a></li>
                <li><a href="/pages/privacy-policy" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Privacy Policy' : 'প্রাইভেসি পলিসি' ?></a></li>
                <li><a href="/pages/terms" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Terms & Conditions' : 'শর্তাবলী' ?></a></li>
            </ul>
        </div>


        <!-- About & Social -->
        <div>
            <h4 class="text-white font-semibold mb-4"><?= $lang === 'en' ? 'Follow Us' : 'আমাদের সম্পর্কে' ?></h4>
            <!-- Social Media Icons -->
            <div class="flex space-x-3">
                <a href="#" class="bg-blue-600 hover:bg-blue-700 p-2 rounded-full transition text-white">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="bg-blue-400 hover:bg-blue-500 p-2 rounded-full transition text-white">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="bg-blue-800 hover:bg-blue-900 p-2 rounded-full transition text-white">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="bg-pink-600 hover:bg-pink-700 p-2 rounded-full transition text-white">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
        <!-- Newsletter / Contact -->
        <div>
            <h4 class="text-white font-semibold mb-4"><?= $lang === 'en' ? 'Subscribe to Our Newsletter' : 'আমাদের নিউজলেটারে সাবস্ক্রাইব করুন' ?></h4>
            <p class="text-gray-400 mb-4 text-sm">
                <?= $lang === 'en'
                    ? 'Get weekly updates directly to your inbox about news, tutorials, and community events.'
                    : 'সাপ্তাহিক সংবাদ, টিউটোরিয়াল এবং কমিউনিটি ইভেন্টগুলির আপডেট সরাসরি আপনার ইনবক্সে পান।'
                ?>
            </p>
            <form action="" method="POST" class="flex flex-col gap-2">
                <input type="email" name="email" required placeholder="<?= $lang === 'en' ? 'Enter your email' : 'আপনার ইমেইল লিখুন' ?>"
                    class="p-3 rounded-lg border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <?= $lang === 'en' ? 'Subscribe' : 'সাবস্ক্রাইব করুন' ?>
                </button>
            </form>
        </div>


    </div>

    <!-- Bottom copyright -->
    <div class="border-t border-gray-700 mt-6 py-[30px] text-center text-sm text-gray-400">
        <p class="text-gray-400 mt-2 text-sm">
            <?= $lang === 'en' ? '18+, Play Responsibly' : '১৮+ শুধুমাত্র, দায়িত্বশীলভাবে খেলুন' ?>
        </p> <br>
        &copy; <?= date('Y') ?> FancyBet. <?= $lang === 'en' ? 'All rights reserved.' : 'সকল অধিকার সংরক্ষিত।' ?>
    </div>
</footer>