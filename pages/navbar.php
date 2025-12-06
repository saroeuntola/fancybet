<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';
$currentId = isset($_GET['slug']) ? trim($_GET['slug']) : null;

function buildLangUrl($langTarget, $currentPage, $currentId)
{
    $currentFile = basename($currentPage, '.php');
    // build query
    $params = ['lang' => $langTarget];

    if ($currentFile === 'detail' && $currentId) {
        $params['slug'] = $currentId;
    }

    if ($currentFile === 'index') {
        return '/?' . http_build_query($params);
    }
    return "{$currentFile}?" . http_build_query($params);
}

// Menu items
$menu = [
    '/' => $lang === 'en' ? 'Home' : 'হোম',
    '/blog' => [
        'title' => $lang === 'en' ? 'Blog' : 'ব্লগ',
        'submenu' => [
            '/pages/cricket-news' => $lang === 'en' ? 'Cricket News' : 'ক্রিকেট নিউজ',
            '/pages/cricket-betting-guides' => $lang === 'en' ? 'Betting Guides' : 'বেটিং গাইড',
            '/pages/match-previews' => $lang === 'en' ? 'Match Previews' : 'ম্যাচ প্রিভিউ',

        ]
    ],
    '/pages/about' => $lang === 'en' ? 'About' : 'আমাদের সম্পর্কে',
    '/pages/contact' => $lang === 'en' ? 'Contact' : 'যোগাযোগ',
    '/pages/community' => $lang === 'en' ? 'Community' : 'সম্প্রদায়',

];

// Function to map menu titles to icons
function getMenuIcon($title)
{
    $map = [
        // English → Bangla → Icon
        'home' => 'fa-house',
        'হোম' => 'fa-house',

        'blog' => 'fa-blog',
        'ব্লগ' => 'fa-blog',

        'cricket news' => 'fa-baseball-bat-ball',
        'ক্রিকেট নিউজ' => 'fa-baseball-bat-ball',

        'betting guides' => 'fa-book',
        'বেটিং গাইড' => 'fa-book',

        'match previews' => 'fa-eye',
        'ম্যাচ প্রিভিউ' => 'fa-eye',

        'about' => 'fa-circle-info',
        'আমাদের সম্পর্কে' => 'fa-circle-info',

        'contact' => 'fa-envelope',
        'যোগাযোগ' => 'fa-envelope',

        'community' => 'fa-users',
        'সম্প্রদায়' => 'fa-users',
    ];

    $title = trim(strtolower($title));
    return $map[$title] ?? 'fa-link';
}

?>
<style>
    .navlink {
        min-width: 150px;
    }

    .link-hover:hover {
        color: red;
        transition: 550ms;

    }
</style>
<link rel="preload"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    as="style"
    onload="this.onload=null;this.rel='stylesheet'">

<noscript>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</noscript>

<!-- Navbar -->
<nav class="w-full bg-[#252525] text-gray-100 dark:text-white shadow-md fixed top-0 left-0 z-30">
    <div class="container mx-auto flex items-center justify-between px-4 max-w-7xl">
        <!-- Left: Logo + Mobile Toggle -->
        <div class="flex items-center space-x-3">
            <button id="menu-toggle" class="lg:hidden rounded-md hover:bg-red-700 p-1 focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            <a href="/?lang=<?= $lang ?>" class="text-lg font-semibold hover:text-gray-300">
                <img src="/image/FancyBet.png" alt="fancybet logo" class="w-28 hover:opacity-70 transition-all">
            </a>
        </div>

        <!-- Center: Desktop Menu -->
        <ul class="hidden lg:flex space-x-8 text-sm">
            <?php foreach ($menu as $file => $item): ?>
                <?php if (is_array($item)): ?>
                    <li class="relative dropdown">
                        <span class="cursor-pointer transition dropdown-toggle link-hover">
                            <?= htmlspecialchars($item['title']) ?>
                        </span>
                        <ul class="submenu absolute left-0 mt-4 navlink bg-gray-800 rounded-md shadow-lg hidden z-50">
                            <?php foreach ($item['submenu'] as $subFile => $subLabel): ?>
                                <li>
                                    <a href="<?= $subFile ?>?lang=<?= $lang ?>" class="block px-4 py-2 text-gray-200 hover:bg-red-700">
                                        <?= htmlspecialchars($subLabel) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?= $file ?>?lang=<?= $lang ?>" class="link-hover <?= $currentPage === basename($file) ? 'font-bold text-white underline' : '' ?>">
                            <?= htmlspecialchars($item) ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

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
            <div id="mobile-search-dropdown" class="hidden fixed top-[60px] left-0 w-full bg-red-800 p-3 z-40 shadow-md">
                <form action="/pages/search" method="get" class="flex items-center">
                    <input type="hidden" name="lang" value="<?= $lang ?>" class="py-4">
                    <input type="text" name="q" placeholder="<?= $lang === 'en' ? 'Search...' : 'অনুসন্ধান করুন...' ?>"
                        class="flex-1 px-3 py-2 rounded-l-md text-black focus:outline-none bg-gray-300" />
                    <button type="submit" class="bg-gray-900 px-4 py-2 rounded-r-md hover:bg-gray-800 transition">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
            <button
                id="theme-toggle"
                class="p-2 rounded-full hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors duration-300"
                aria-label="Toggle Theme">
                <svg
                    id="theme-icon"
                    class="h-6 w-6 text-black dark:text-white transition-colors duration-300"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">
                </svg>
            </button>

            <button id="lang-btn" class="flex items-center gap-2 py-1.5 rounded-md text-sm text-gray-200 cursor-pointer hover:opacity-70">
                <img id="lang-flag"
                    src="<?= $lang === 'bn' ? '/image/flag/flag_bn.png' : '/image/flag/flag_en.png' ?>"
                    alt="flag" class="w-6 rounded-sm"
                    loading="lazy">
            </button>

            <!-- Dropdown -->
            <div id="lang-menu"
                class="hidden absolute right-0 mt-12 w-28 bg-red-800 rounded-md shadow-lg border border-slate-700 transition-all duration-300">
                <a href="<?= buildLangUrl('en', $currentPage, $currentId) ?>"
                    class="flex items-center gap-2 w-full px-3 py-2 text-gray-200 hover:bg-slate-700 text-sm rounded-t-md">
                    <img src="/image/flag/flag_en.png" alt="EN" class="w-6" loading="lazy"> EN
                </a>
                <a href="<?= buildLangUrl('bn', $currentPage, $currentId) ?>"
                    class="flex items-center gap-2 w-full px-3 py-2 text-gray-200 hover:bg-slate-700 text-sm rounded-b-md">
                    <img src="/image/flag/flag_bn.png" alt="BN" class="w-6" loading="lazy"> BN
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Overlay -->
<div id="overlay" class="fixed inset-0 z-20 hidden transition-opacity duration-500"></div>

<!-- Sidebar -->
<div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-[#252525] z-40 transform -translate-x-full transition-transform duration-500 ease-in-out lg:hidden">
    <div class="p-4 border-b border-slate-700 flex justify-between items-center">
        <span class="text-lg font-bold text-white">
            <?=
            $lang === 'en' ? 'Menu' : 'মেনু'
            ?>
        </span>
        <button id="closeBtn" class="text-gray-300 hover:text-white focus:outline-none text-xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <ul class="flex flex-col py-4 space-y-2 text-gray-200">
        <?php foreach ($menu as $file => $item): ?>
            <?php if (is_array($item)): ?>
                <li class="mobile-dropdown">
                    <!-- Parent menu -->
                    <div class="flex items-center justify-between px-4 py-2 cursor-pointer hover:bg-slate-700 mobile-dropdown-toggle link-hover">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid <?= getMenuIcon($item['title']) ?> text-sm"></i>
                            <span class="font-semibold"><?= htmlspecialchars($item['title']) ?></span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>

                    <!-- Submenu -->
                    <ul class="hidden pl-6 mt-1 space-y-1 mobile-submenu">
                        <?php foreach ($item['submenu'] as $subFile => $subLabel): ?>
                            <li>
                                <a href="<?= $subFile ?>?lang=<?= $lang ?>"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-slate-700">
                                    <i class="fa-solid <?= getMenuIcon($subLabel) ?> text-xs"></i>
                                    <?= htmlspecialchars($subLabel) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?= $file ?>?lang=<?= $lang ?>"
                        class="flex items-center gap-2 px-4 py-2 hover:bg-slate-700 link-hover">
                        <i class="fa-solid <?= getMenuIcon($item) ?> text-sm"></i>
                        <?= htmlspecialchars($item) ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

</div>


<?php
$js = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/js/navbar.js');
$encoded = base64_encode($js);
echo '<script src="data:text/javascript;base64,' . $encoded . '" defer></script>';
?>