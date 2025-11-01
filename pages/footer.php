<footer class="bg-black text-gray-200 mt-10">
    <div class="px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 max-w-screen-lg mx-auto">
        <!-- FW Tools / Resources -->
        <div>
            <h4 class="text-white font-semibold mb-4"><?= $lang === 'en' ? 'FW Tools / Resources' : 'FW টুলস / রিসোর্স' ?></h4>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Odds Calculator' : 'অডস ক্যালকুলেটর' ?></a></li>
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Betting Guides' : 'বেটিং গাইড' ?></a></li>
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Statistics' : 'স্ট্যাটিস্টিক্স' ?></a></li>
            </ul>
        </div>

        <!-- Community -->
        <div>
            <h4 class="text-white font-semibold mb-4"><?= $lang === 'en' ? 'Community' : 'কমিউনিটি' ?></h4>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Forums' : 'ফোরাম' ?></a></li>
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Chat Groups' : 'চ্যাট গ্রুপ' ?></a></li>
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Events' : 'ইভেন্ট' ?></a></li>
            </ul>
        </div>

        <!-- Legal & Responsible Betting -->
        <div>
            <h4 class="text-white font-semibold mb-4"><?= $lang === 'en' ? 'Legal & Responsible Betting' : 'আইনি ও দায়িত্বশীল বেটিং' ?></h4>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Terms & Conditions' : 'শর্তাবলী' ?></a></li>
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Privacy Policy' : 'প্রাইভেসি পলিসি' ?></a></li>
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Responsible Gambling' : 'দায়িত্বশীল জুয়া' ?></a></li>
            </ul>

        </div>

        <!-- About & Social -->
        <div>
            <h4 class="text-white font-semibold mb-4"><?= $lang === 'en' ? 'About' : 'আমাদের সম্পর্কে' ?></h4>
            <ul class="space-y-2 mb-4">
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Our Story' : 'আমাদের গল্প' ?></a></li>
                <li><a href="#" class="hover:text-red-500 transition"><?= $lang === 'en' ? 'Contact' : 'যোগাযোগ' ?></a></li>
            </ul>

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
    </div>

    <!-- Bottom copyright -->
    <div class="border-t border-gray-700 mt-6 py-[30px] text-center text-sm text-gray-400">
        <p class="text-gray-400 mt-2 text-sm">
            <?= $lang === 'en' ? '18+, Play Responsibly' : '১৮+ শুধুমাত্র, দায়িত্বশীলভাবে খেলুন' ?>
        </p> <br>
        &copy; <?= date('Y') ?> FancyBet. <?= $lang === 'en' ? 'All rights reserved.' : 'সকল অধিকার সংরক্ষিত।' ?>
    </div>
</footer>