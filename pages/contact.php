<?php
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';

?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? 'en-BD' : 'bn-BD' ?>">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang === 'en' ? 'Contact Us - FancyBet' : 'যোগাযোগ করুন - Fancybet' ?></title>

    <!-- SEO Meta -->
    <meta name="description" content="<?= $lang === 'en' ? 'Contact FancyBet for inquiries, support, or feedback. Reach out via form, email, or follow us on social media.' : 'প্রশ্ন, সহায়তা বা প্রতিক্রিয়ার জন্য ফ্যান্সিবেটের সাথে যোগাযোগ করুন। ফর্ম, ইমেইল বা সোশ্যাল মিডিয়ার মাধ্যমে আমাদের পৌঁছান।' ?>">
    <meta name="keywords" content="FancyBet, Contact, Support, Betting, Community, <?= $lang === 'en' ? 'Email, Phone, Address' : 'ইমেইল, ফোন, ঠিকানা' ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="<?= $lang === 'en' ? 'Contact Us - FancyBet' : 'যোগাযোগ করুন - ফ্যান্সিবেট' ?>">
    <meta property="og:description" content="<?= $lang === 'en' ? 'Contact FancyBet for inquiries, support, or feedback.' : 'প্রশ্ন, সহায়তা বা প্রতিক্রিয়ার জন্য ফ্যান্সিবেটের সাথে যোগাযোগ করুন।' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://fancybet.info/pages/contact">
    <meta property="og:image" content="https://fancybet.info/image/favicon-96x96.png">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $lang === 'en' ? 'Contact Us - FancyBet' : 'যোগাযোগ করুন - ফ্যান্সিবেট' ?>">
    <meta name="twitter:description" content="<?= $lang === 'en' ? 'Contact FancyBet for inquiries, support, or feedback.' : 'প্রশ্ন, সহায়তা বা প্রতিক্রিয়ার জন্য ফ্যান্সিবেটের সাথে যোগাযোগ করুন।' ?>">
    <meta name="twitter:image" content="https://fancybet.info/image/favicon-96x96.png">'

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/image/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/image/favicon.svg" />
    <link rel="shortcut icon" href="/image/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/image/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="FancyBet" />
    <link rel="manifest" href="/image/site.webmanifest" />

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="/src/output.css">
</head>


<body class="bg-gray-900 text-white">

    <?php
    include "./loader.php"
    ?>

    <?php include './navbar.php'; ?>
    <!-- Page Header -->
    <header class=" text-white py-6 text-center mt-28">
        <h1 class="text-3xl font-bold"><?= $lang === 'en' ? 'Contact Us' : 'যোগাযোগ করুন' ?></h1>
        <p class="mt-2 text-sm"><?= $lang === 'en' ? 'We would love to hear from you!' : 'আমরা আপনার প্রতিক্রিয়ার অপেক্ষায় আছি!' ?></p>
    </header>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-2 gap-3">

        <!-- Contact Form -->
        <div class="bg-gray-800 p-8 rounded-xl shadow-md">
            <h2 class="text-2xl font-semibold mb-6"><?= $lang === 'en' ? 'Send Us a Message' : 'আমাদের একটি বার্তা পাঠান' ?></h2>
            <form action="" method="POST" class="flex flex-col gap-4">
                <input type="text" name="name" placeholder="<?= $lang === 'en' ? 'Your Name' : 'আপনার নাম' ?>" required
                    class="p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 text-white">
                <input type="email" name="email" placeholder="<?= $lang === 'en' ? 'Your Email' : 'আপনার ইমেইল' ?>" required
                    class="p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 text-white">

                <textarea name="message" rows="6" placeholder="<?= $lang === 'en' ? 'Your Message' : 'আপনার বার্তা' ?>" required
                    class="p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 text-white"></textarea>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition-colors">
                    <?= $lang === 'en' ? 'Send Message' : 'বার্তা পাঠান' ?>
                </button>
            </form>
        </div>

        <!-- Contact Info & Social Media -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md">

            <div class="mb-6">
                <h2 class="text-2xl font-semibold mb-4"><?= $lang === 'en' ? 'Contact Information' : 'যোগাযোগের তথ্য' ?></h2>
                <p class="text-gray-300 mb-2"><strong><?= $lang === 'en' ? 'Email:' : 'ইমেইল:' ?></strong> info@fancybet.info</p>
                <p class="text-gray-300 mb-2"><strong><?= $lang === 'en' ? 'Phone:' : 'ফোন:' ?></strong> +880 12 345 678</p>
            </div>

            <div>
                <h3 class="text-xl font-semibold mb-2"><?= $lang === 'en' ? 'Social Media' : 'আমাদের অনুসরণ করুন' ?></h3>
                <div class="flex space-x-3 mt-2">
                    <a href="#" class="bg-blue-600 hover:bg-blue-700 p-3 rounded-full text-white transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="bg-blue-400 hover:bg-blue-500 p-3 rounded-full text-white transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="bg-blue-800 hover:bg-blue-900 p-3 rounded-full text-white transition"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="bg-pink-600 hover:bg-pink-700 p-3 rounded-full text-white transition"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

        </div>
    </main>

    <?php include './footer.php'; ?>
</body>

</html>