<?php
require_once '../admin/page/library/db.php';
require_once '../admin/page/library/post_lib.php';
require_once './services/bn-date.php'; // for Bangla date formatting

$postObj = new Post();
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn']) ? $_GET['lang'] : 'bn';
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

// Fetch search results
$posts = $query ? $postObj->searchpost($query, $lang) : [];
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang === 'en' ? 'Search Results' : 'অনুসন্ধানের ফলাফল' ?></title>
    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>

<body class="bg-gray-900 text-white">
    <?php include "navbar.php"; ?>
    <div class="px-4 py-8 mt-16 max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">
            <?= $lang === 'en' ? "Search Results for '$query'" : "'$query'-এর জন্য অনুসন্ধানের ফলাফল" ?>
        </h1>
        <?php if (!$query): ?>
            <p class="text-gray-300"><?= $lang === 'en' ? 'Please enter a search query.' : 'অনুগ্রহ করে অনুসন্ধান লিখুন।' ?></p>
        <?php elseif (empty($posts)): ?>
            <p class="text-gray-300"><?= $lang === 'en' ? 'No results found.' : 'কোন ফলাফল পাওয়া যায়নি।' ?></p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <?php
                        // Skip if slug or name is missing
                        if (empty($post['slug']) || empty($post['name'])) continue;

                        $postName = htmlspecialchars($post['name']);
                        $postSlug = urlencode($post['slug']);
                        $postImage = !empty($post['image']) ? htmlspecialchars($post['image']) : null;
                        $postDesc = strip_tags($post['description'] ?? '');
                        $postDesc = html_entity_decode($postDesc, ENT_QUOTES | ENT_HTML5);
                        if (mb_strlen($postDesc, 'UTF-8') > 80) {
                            $postDesc = mb_substr($postDesc, 0, 75, 'UTF-8') . '...';
                        }
                        $postDesc = htmlspecialchars($postDesc);
                        $createdAt = $post['created_at'] ?? '';
                        ?>
                        <a href="/pages/detail?slug=<?= $postSlug ?>&lang=<?= $lang ?>">
                            <div class="bg-gray-800 shadow rounded-lg overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-300">
                                <!-- Image -->
                                <?php if ($postImage): ?>
                                    <img src="/admin/page/post/<?= $postImage ?>" alt="<?= $postName ?>"
                                        class="w-full lg:h-[200px] h-[230px] object-cover">
                                <?php else: ?>
                                    <div class="w-full lg:h-[200px] h-[230px] bg-gray-600 flex items-center justify-center text-gray-300 text-sm">
                                        <?= $lang === 'en' ? 'No Image' : 'ছবি নেই' ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Content -->
                                <div class="p-3 flex-1 flex flex-col justify-between">
                                    <!-- Title & Description -->
                                    <div>
                                        <h2 class="lg:text-lg text-md font-semibold mb-2 text-white break-words">
                                            <?= $postName ?>
                                        </h2>
                                        <p class="text-gray-300 mb-3 text-sm break-words lg:text-md">
                                            <?= $postDesc ?>
                                        </p>
                                    </div>

                                    <!-- Date -->
                                    <div class="flex flex-wrap items-center gap-1 text-gray-400 text-xs mt-2 break-words">
                                        <i class="fa-solid fa-earth-americas"></i>
                                        <span>
                                            <?= $lang === 'bn'
                                                ? formatDateByLang($createdAt, 'bn')
                                                : date("F j, Y", strtotime($createdAt)) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-300 text-center col-span-full mt-4">
                        <?= $lang === 'en' ? 'No posts found.' : 'কোনো পোস্ট পাওয়া যায়নি।' ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>