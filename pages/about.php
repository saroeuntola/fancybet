<?php
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'en';
$pageName = "About Us";

?>
<!DOCTYPE html>
<html lang="<?= $lang === 'bn' ? 'bn-BD' : 'en' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= $lang === 'bn' ? 'FancyBet ক্রিকেট' : 'About FancyBet Cricket in Bangladesh' ?>
    </title>

    <meta name="description" content="<?= $lang === 'bn'
                                            ? 'বাংলাদেশে ক্রিকেট সম্পর্কে জানুন — খেলাধুলার জগতে সবচেয়ে জনপ্রিয় খেলা। ফ্যান্সি বেট ক্রিকেট আপডেট, খবর এবং বিশ্লেষণ।'
                                            : 'Learn about Cricket in Bangladesh — the most popular sport in the nation. FancyBet Cricket updates, news, and analysis.' ?>">

    <meta name="keywords" content="<?= $lang === 'bn'
                                        ? 'ক্রিকেট, বাংলাদেশ ক্রিকেট, ফ্যান্সি বেট ক্রিকেট, ক্রিকেট খবর, ক্রিকেট ম্যাচ'
                                        : 'Cricket, Bangladesh Cricket, FancyBet Cricket, Cricket News, Cricket Matches' ?>">

    <meta name="author" content="FancyBet Bangladesh">

    <!-- Canonical and Hreflang -->
    <link rel="canonical" href="https://fancybet.info/pages/about-cricket<?= $lang === 'bn' ? '?lang=bn' : '' ?>">
    <link rel="alternate" hreflang="en" href="https://fancybet.info/pages/about-cricket?lang=en">
    <link rel="alternate" hreflang="bn" href="https://fancybet.info/pages/about-cricket?lang=bn">
    <link rel="alternate" hreflang="x-default" href="https://fancybet.info/pages/about-cricket">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="<?= $lang === 'bn' ? 'bn_BD' : 'en_US' ?>">
    <meta property="og:title" content="<?= $lang === 'bn' ? 'বাংলাদেশে ক্রিকেট সম্পর্কে | FancyBet ক্রিকেট' : 'About Cricket in Bangladesh | FancyBet Cricket' ?>">
    <meta property="og:description" content="<?= $lang === 'bn'
                                                    ? 'ক্রিকেট বাংলাদেশের জাতীয় খেলা নয়, কিন্তু এটি সবচেয়ে জনপ্রিয়। ফ্যান্সি বেট ক্রিকেট খবর ও বিশ্লেষণ নিয়ে আসছে।'
                                                    : 'Cricket may not be Bangladesh’s national sport, but it’s the most loved. FancyBet brings you news and insights.' ?>">
    <meta property="og:image" content="https://fancybet.info/image/favicon-96x96.png">
    <meta property="og:url" content="https://fancybet.info/pages/about-cricket<?= $lang === 'bn' ? '?lang=bn' : '' ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $lang === 'bn' ? 'ক্রিকেট সম্পর্কে | FancyBet ক্রিকেট' : 'About Cricket | FancyBet Cricket' ?>">
    <meta name="twitter:description" content="<?= $lang === 'bn'
                                                    ? 'বাংলাদেশে ক্রিকেট খবর, ম্যাচ আপডেট এবং ফ্যান্সি বেট ক্রিকেটের বিশ্লেষণ।'
                                                    : 'Bangladesh Cricket news, match updates, and FancyBet Cricket insights.' ?>">
    <meta name="twitter:image" content="https://fancybet.info/image/favicon-96x96.png">

    <!-- Local SEO for Bangladesh -->
    <meta name="geo.region" content="BD">
    <meta name="geo.placename" content="Dhaka, Bangladesh">
    <meta name="geo.position" content="23.8103;90.4125">
    <meta name="ICBM" content="23.8103,90.4125">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/image/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/image/favicon.svg" />
    <link rel="shortcut icon" href="/image/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/image/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="FancyBet" />
    <link rel="manifest" href="/image/site.webmanifest" />

    <!-- Structured Data (Article Schema) -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "headline": "<?= $lang === 'bn' ? 'বাংলাদেশে ক্রিকেট সম্পর্কে' : 'About Cricket in Bangladesh' ?>",
            "description": "<?= $lang === 'bn'
                                ? 'বাংলাদেশে ক্রিকেট ইতিহাস, জনপ্রিয়তা এবং ফ্যান্সি বেট ক্রিকেট বিশ্লেষণ।'
                                : 'History, popularity, and FancyBet Cricket insights about cricket in Bangladesh.' ?>",
            "image": "https://fancybet.info/image/cricket-banner.jpg",
            "author": {
                "@type": "Organization",
                "name": "FancyBet Bangladesh"
            },
            "publisher": {
                "@type": "Organization",
                "name": "FancyBet",
                "logo": {
                    "@type": "ImageObject",
                    "url": "https://fancybet.info/image/favicon-96x96.png"
                }
            },
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "https://fancybet.info/pages/about-cricket<?= $lang === 'bn' ? '?lang=bn' : '' ?>"
            },
            "datePublished": "2025-11-01",
            "dateModified": "2025-11-01"
        }
    </script>
    <link rel="stylesheet" href="../src/output.css">
    <script src="/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="/css/breadcrumb.css">

    <?php include "./services/ahrefts.php" ?>
</head>

<body class="dark:bg-black bg-[#f5f5f5] text-white">
    <?php include "navbar.php"; ?>

    <div class="mt-20 max-w-4xl mx-auto px-4">
        <?php include './services/breadcrumb-static.php';  ?>
    </div>

    <div class="px-4">
        <main class="max-w-4xl mx-auto px-6 leading-relaxed dark:text-gray-200 text-gray-800 py-4 dark:bg-[#252525] bg-white rounded-md">
            <header class="text-center">
                <h1 class="lg:text-3xl text-2xl font-bold mb-6">
                    <?= $lang === 'bn' ? 'বাংলাদেশে ক্রিকেট সম্পর্কে' : 'About Fancybet' ?>
                </h1>
            </header>
            <?php if ($lang === 'bn'): ?>
                <p class="mb-6">
                    ক্রিকেট বাংলাদেশের সবচেয়ে জনপ্রিয় খেলা এবং এটি দেশের প্রতিটি মানুষের হৃদয়ে বিশেষ জায়গা করে নিয়েছে।
                    ঢাকা থেকে শুরু করে প্রত্যন্ত গ্রামের মাঠে, ক্রিকেটই মানুষের একত্রিত হবার অন্যতম কারণ।
                    ১৯৭৭ সালে আন্তর্জাতিক ক্রিকেটে বাংলাদেশের যাত্রা শুরু হয়, এবং ২০০০ সালে টেস্ট মর্যাদা লাভের মাধ্যমে
                    ক্রিকেট বাংলাদেশের জাতীয় পরিচয়ের অংশে পরিণত হয়।
                </p>

                <p class="mb-6">
                    আজকের দিনে ক্রিকেট শুধু খেলা নয়, এটি একটি শিল্প, একটি অনুপ্রেরণা।
                    ফ্যান্সি বেট ক্রিকেট বাংলাদেশের ক্রিকেট ভক্তদের জন্য একটি নির্ভরযোগ্য প্ল্যাটফর্ম,
                    যেখানে আপনি পাবেন প্রতিটি ম্যাচের আপডেট, দলীয় বিশ্লেষণ, খেলোয়াড়দের পারফরম্যান্স রিপোর্ট এবং
                    ক্রিকেট বিশ্বের সর্বশেষ খবর।
                </p>

                <p>
                    আমাদের লক্ষ্য হল ক্রিকেটপ্রেমীদের জন্য একটি স্মার্ট, নিরাপদ এবং তথ্যসমৃদ্ধ জায়গা তৈরি করা।
                    আপনি হোন টেস্ট ম্যাচ প্রেমিক, টি-টোয়েন্টি অনুরাগী বা আইপিএল ভক্ত — ফ্যান্সি বেট ক্রিকেটে রয়েছে
                    আপনার জন্য সবকিছু। ক্রিকেট শুধু খেলা নয়, এটি বাংলাদেশের আত্মার অংশ।
                </p>

            <?php else: ?>
                <p class="mb-6">
                    Cricket is the heartbeat of Bangladesh — a game that transcends sport to become a national passion.
                    From the bustling streets of Dhaka to the quiet fields of rural villages, cricket unites people of all ages
                    and backgrounds. Bangladesh’s cricket journey began in 1977 and reached a historic milestone in 2000
                    when the country earned Test status, marking its place on the global cricket stage.
                </p>

                <p class="mb-6">
                    Today, cricket in Bangladesh is more than just competition; it’s a way of life.
                    FancyBet Cricket is dedicated to providing fans with up-to-date match coverage,
                    in-depth analysis, player insights, and the latest cricket news from Bangladesh and beyond.
                </p>

                <p>
                    Our mission is to create a smart, safe, and informative space for cricket enthusiasts.
                    Whether you follow Test cricket, T20 tournaments, or the Bangladesh Premier League —
                    FancyBet Cricket brings everything you need to stay connected with the game you love.
                    Cricket isn’t just played in Bangladesh; it lives in our hearts.
                </p>
            <?php endif; ?>
        </main>
    </div>


    <?php include "footer.php"; ?>
</body>


</html>