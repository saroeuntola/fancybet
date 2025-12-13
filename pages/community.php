<?php
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'en';

$content = [
    'en' => [
        'title' => 'FancyBet Community',
        'subtitle' => 'Connect with other betting fans, discuss cricket strategies, share predictions, and get expert insights from the FancyBet team.',
        'whyJoin' => 'Why Join Our Community?',
        'discussionTitle' => '💬 Discussions',
        'discussionDesc' => 'Talk about matches, betting markets, and your favorite teams with like-minded enthusiasts.',
        'tipsTitle' => '📊 Tips & Strategies',
        'tipsDesc' => 'Get community-shared tips, expert predictions, and betting insights to help you win smarter.',
        'globalTitle' => '🌍 Global Network',
        'globalDesc' => 'Meet members from around the world who share your passion for sports and fair betting.',
    ],
    'bn' => [
        'title' => 'Fancybet কমিউনিটি',
        'subtitle' => 'অন্যান্য বেটিং অনুরাগীদের সাথে যুক্ত হন, ক্রিকেট কৌশল আলোচনা করুন, পূর্বাভাস শেয়ার করুন এবং ফ্যান্সিবেট দলের বিশেষজ্ঞদের অন্তর্দৃষ্টি পান।',
        'whyJoin' => 'আমাদের কমিউনিটিতে যোগ দেবেন কেন?',
        'discussionTitle' => '💬 আলোচনা',
        'discussionDesc' => 'ম্যাচ, বেটিং মার্কেট এবং আপনার প্রিয় দলের বিষয়ে একই মতের মানুষের সাথে কথা বলুন।',
        'tipsTitle' => '📊 টিপস ও কৌশল',
        'tipsDesc' => 'কমিউনিটি-শেয়ার করা টিপস, বিশেষজ্ঞ পূর্বাভাস এবং জয়ের জন্য প্রয়োজনীয় অন্তর্দৃষ্টি পান।',
        'globalTitle' => '🌍 গ্লোবাল নেটওয়ার্ক',
        'globalDesc' => 'বিশ্বের বিভিন্ন প্রান্তের সদস্যদের সাথে পরিচিত হন যারা স্পোর্টস এবং ফেয়ার বেটিং সম্পর্কে আপনার মতোই আগ্রহী।',
    ]
];

$text = $content[$lang];
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="index, follow">

    <title><?= $lang === 'en' ? 'Community - FancyBet' : 'কমিউনিটি - ফ্যান্সিবেট'; ?></title>

    <meta name="description" content="<?= $lang === 'en'
                                            ? 'Join the FancyBet community to connect with other players, share betting strategies, and stay updated with the latest news and tips.'
                                            : 'ফ্যান্সিবেট কমিউনিটিতে যোগ দিন, অন্যান্য খেলোয়াড়দের সাথে যুক্ত হোন, বাজির কৌশল শেয়ার করুন এবং সর্বশেষ খবর ও টিপস সম্পর্কে জানুন।'; ?>">

    <meta name="keywords" content="<?= $lang === 'en'
                                        ? 'FancyBet community, sports betting, casino games, betting tips, online gaming, responsible gambling'
                                        : 'ফ্যান্সিবেট কমিউনিটি, স্পোর্টস বেটিং, ক্যাসিনো গেম, বেটিং টিপস, অনলাইন গেমিং, দায়িত্বশীল গেমিং'; ?>">

    <!-- Canonical & Hreflang -->
    <link rel="canonical" href="https://fancybet.info/pages/community" />
    <link rel="alternate" href="https://fancybet.info/pages/community?lang=en" hreflang="en" />
    <link rel="alternate" href="https://fancybet.info/pages/community?lang=bn" hreflang="bn-BD" />
    <link rel="alternate" href="https://fancybet.info/pages/community" hreflang="x-default" />

    <!-- Open Graph -->
    <meta property="og:title" content="<?= $lang === 'en' ? 'FancyBet Community - Connect, Learn & Share' : 'ফ্যান্সিবেট কমিউনিটি - সংযোগ, শিক্ষা ও শেয়ার করুন'; ?>" />
    <meta property="og:description" content="<?= $lang === 'en'
                                                    ? 'Join our growing community of players! Discuss betting strategies, share experiences, and learn responsible gaming.'
                                                    : 'আমাদের ক্রমবর্ধমান কমিউনিটিতে যোগ দিন! বেটিং কৌশল নিয়ে আলোচনা করুন, অভিজ্ঞতা শেয়ার করুন এবং দায়িত্বশীল গেমিং শিখুন।'; ?>" />
    <meta property="og:url" content="https://fancybet.info/pages/community" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://fancybet.info/image/og-banner.png" />

    <!-- Styles -->
    <link href="/src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="./dist/css/all.min.css" />
    <script src="./js/jquery-3.6.0.min.js"></script>
    <?= include "./services/ahrefts.php" ?>
</head>

<body class="dark:bg-black bg-[#f5f5f5] dark:text-white font-inter">
    <?php include 'navbar.php'; ?>
    <main class="max-w-5xl m-auto pt-10 px-4">
        <!-- Hero Section -->
        <section class="mt-10 dark:text-white text-center p-4 rounded-3xl">
            <div class="container mx-auto">
                <h1 class="text-2xl font-bold mb-6"><?= htmlspecialchars($text['title']) ?></h1>
                <p class="max-w-2xl mx-auto text-lg opacity-90">
                    <?= htmlspecialchars($text['subtitle']) ?>
                </p>
            </div>
        </section>

        <!-- Why Join Section -->
        <section class="py-12">
            <div class="container mx-auto text-white">
                <h2 class="text-2xl font-semibold mb-6 text-center dark:text-white text-gray-800"><?= htmlspecialchars($text['whyJoin']) ?></h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="p-6 bg-[#252525] rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-3"><?= htmlspecialchars($text['discussionTitle']) ?></h3>
                        <p><?= htmlspecialchars($text['discussionDesc']) ?></p>
                    </div>
                    <div class="p-6 bg-[#252525] rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-3"><?= htmlspecialchars($text['tipsTitle']) ?></h3>
                        <p><?= htmlspecialchars($text['tipsDesc']) ?></p>
                    </div>
                    <div class="p-6 bg-[#252525] rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-3"><?= htmlspecialchars($text['globalTitle']) ?></h3>
                        <p><?= htmlspecialchars($text['globalDesc']) ?></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>