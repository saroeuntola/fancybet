<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';
$currentId = isset($_GET['slug']) ? trim($_GET['slug']) : null;

// Build language switch URL
function buildLangUrl($langTarget, $currentPage, $currentId)
{
    // normalize filename
    $currentFile = basename($currentPage, '.php');

    // build query
    $params = ['lang' => $langTarget];

    // keep slug/title for detail pages
    if ($currentFile === 'detail' && $currentId) {
        $params['slug'] = $currentId;
    }

    // ✅ Home page fix
    if ($currentFile === 'index') {
        return '/?' . http_build_query($params);
    }

    return "{$currentFile}?" . http_build_query($params);
}

// Menu items
$menu = [
    '/' => $lang === 'en' ? 'Home' : 'হোম',
    '/pages/about' => $lang === 'en' ? 'About' : 'আমাদের সম্পর্কে',
    '/pages/contact' => $lang === 'en' ? 'Contact' : 'যোগাযোগ',
];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Navbar -->
<nav class="w-full bg-red-800 text-white shadow-md fixed top-0 left-0 z-30">
    <div class="container mx-auto flex items-center justify-between px-4 py-3 max-w-screen-lg">

        <!-- Left: Logo + Mobile Toggle -->
        <div class="flex items-center space-x-3">
            <button id="menu-toggle" class="lg:hidden rounded-md hover:bg-red-700 p-1 focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <a href="/?lang=<?= $lang ?>" class="text-lg font-semibold hover:text-gray-300">FancyBet</a>
        </div>

        <!-- Center: Desktop Menu -->
        <ul class="hidden lg:flex space-x-8 text-sm font-medium">
            <?php foreach ($menu as $file => $label): ?>
                <li>
                    <a href="<?= $file ?>?lang=<?= $lang ?>"
                        class="hover:text-gray-200 transition <?= $currentPage === $file ? 'font-bold text-white underline' : '' ?>">
                        <?= htmlspecialchars($label) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Add this inside the navbar container, after the menu or before right side -->
        <div class="relative">
            <!-- Desktop Search Box -->
            <form action="/pages/search" method="get" class="hidden lg:flex items-center">
                <input type="hidden" name="lang" value="<?= $lang ?>">
                <input type="text" name="q" placeholder="<?= $lang === 'en' ? 'Search...' : 'অনুসন্ধান করুন...' ?>"
                    class="px-3 py-1 rounded-l-md text-black focus:outline-none bg-gray-300" />
                <button type="submit" class="bg-gray-900 px-3 py-1 rounded-r-md hover:bg-gray-800 transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
            <!-- Mobile Search Icon -->
        </div>

        <!-- Right: Language Dropdown -->
        <div class="relative flex gap-6">

            <button id="mobile-search-btn" class="lg:hidden text-gray-200 hover:text-white focus:outline-none">
                <i class="fa-solid fa-magnifying-glass text-xl"></i>
            </button>
            <!-- Mobile Search Dropdown (hidden by default) -->
            <div id="mobile-search-dropdown" class="hidden fixed top-[60px] left-0 w-full bg-red-800 p-3 z-50 shadow-md">
                <form action="/pages/search" method="get" class="flex items-center">
                    <input type="hidden" name="lang" value="<?= $lang ?>" class="py-4">
                    <input type="text" name="q" placeholder="<?= $lang === 'en' ? 'Search...' : 'অনুসন্ধান করুন...' ?>"
                        class="flex-1 px-3 py-2 rounded-l-md text-black focus:outline-none bg-gray-300" />
                    <button type="submit" class="bg-gray-900 px-4 py-2 rounded-r-md hover:bg-gray-800 transition">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            <button id="lang-btn" class="flex items-center gap-2 py-1.5 rounded-md text-sm text-gray-200 cursor-pointer hover:opacity-70">
                <img id="lang-flag"
                    src="<?= $lang === 'bn' ? '/image/flag/flag_bn.png' : '/image/flag/flag_en.png' ?>"
                    alt="flag" class="w-6 rounded-sm">

            </button>

            <!-- Dropdown -->
            <div id="lang-menu"
                class="hidden absolute right-0 mt-12 w-28 bg-red-800 rounded-md shadow-lg border border-slate-700 transition-all duration-300">
                <a href="<?= buildLangUrl('en', $currentPage, $currentId) ?>"
                    class="flex items-center gap-2 w-full px-3 py-2 text-gray-200 hover:bg-slate-700 text-sm rounded-t-md">
                    <img src="/image/flag/flag_en.png" alt="EN" class="w-6"> EN
                </a>
                <a href="<?= buildLangUrl('bn', $currentPage, $currentId) ?>"
                    class="flex items-center gap-2 w-full px-3 py-2 text-gray-200 hover:bg-slate-700 text-sm rounded-b-md">
                    <img src="/image/flag/flag_bn.png" alt="BN" class="w-6"> BN
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Overlay -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-70 z-20 hidden transition-opacity duration-500"></div>

<!-- Sidebar -->
<div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-red-800 z-40 transform -translate-x-full transition-transform duration-500 ease-in-out lg:hidden">
    <div class="p-4 border-b border-slate-700 flex justify-between items-center">
        <span class="text-lg font-bold text-white">Menu</span>
        <button id="closeBtn" class="text-gray-300 hover:text-white focus:outline-none text-xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <ul class="flex flex-col py-4 space-y-2 text-gray-200">
        <?php foreach ($menu as $file => $label): ?>
            <li>
                <a href="<?= $file ?>?lang=<?= $lang ?>"
                    class="block px-4 py-2 hover:bg-slate-700 <?= $currentPage === $file ? 'bg-slate-700 font-semibold' : '' ?>">
                    <?= htmlspecialchars($label) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


<?php
$js = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/js/navbar.js');
$encoded = base64_encode($js);
echo '<script src="data:text/javascript;base64,' . $encoded . '" defer></script>';
?>