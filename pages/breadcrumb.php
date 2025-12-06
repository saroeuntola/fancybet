<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/admin/page/library/post_lib.php';

/**
 * Get the real post title from slug.
 */
function getPostTitleFromSlug($slug, $lang = null)
{
    $postLib = new Post();
    $post = $postLib->getPostBySlug($slug, $lang);
    if ($post && !empty($post['name'])) {
        return $post['name'];
    }
    return ucfirst(str_replace('-', ' ', $slug));
}

/**
 * Generate breadcrumb array based on current request.
 */
function generateBreadcrumb($lang, $menu)
{
    $breadcrumbs = [];

    // Home
    $breadcrumbs[] = [
        "label" => $lang === "en" ? "Home" : "হোম",
        "url"   => "/?lang=" . $lang
    ];

    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

    foreach ($menu as $file => $item) {
        if (!is_array($item)) {
            // simple menu
            if (strpos($path, $file) === 0 && $file !== "/") {
                $breadcrumbs[] = [
                    "label" => $item,
                    "url"   => $file . "?lang=$lang"
                ];
            }
        } elseif (is_array($item)) {
            // menu with submenu
            if (strpos($path, $file) === 0) {
                $breadcrumbs[] = [
                    "label" => $item["title"],
                    "url"   => $file . "?lang=$lang"
                ];

                if (isset($item["submenu"]) && is_array($item["submenu"])) {
                    foreach ($item["submenu"] as $subFile => $subLabel) {
                        if (strpos($path, $subFile) === 0) {
                            $breadcrumbs[] = [
                                "label" => $subLabel,
                                "url"   => $subFile . "?lang=$lang"
                            ];
                        }
                    }
                }
            }
        }
    }

    // Add post title for detail pages
    if (isset($_GET["slug"]) && !empty($_GET["slug"])) {
        $realTitle = getPostTitleFromSlug($_GET["slug"], $lang);
        $breadcrumbs[] = [
            "label" => $realTitle,
            "url"   => "" // current page, non-clickable
        ];
    }

    return $breadcrumbs;
}

/**
 * Render HTML breadcrumbs
 */
function renderBreadcrumbHtml($breadcrumbs)
{
    if (empty($breadcrumbs)) return;

    echo '<div class="container mx-auto mt-24 mb-4 text-sm text-gray-300">';
    echo '<nav class="flex items-center space-x-2" aria-label="breadcrumb">';
    foreach ($breadcrumbs as $i => $bc) {
        $label = htmlspecialchars($bc["label"]);
        $url = htmlspecialchars($bc["url"]);
        if ($i < count($breadcrumbs) - 1 && !empty($url)) {
            echo "<a href='{$url}' class='hover:text-red-500'>{$label}</a>";
            echo "<span class='mx-1'>/</span>";
        } else {
            echo "<span class='font-semibold'>{$label}</span>";
        }
    }
    echo '</nav>';
    echo '</div>';
}

/**
 * Output combined JSON-LD: NewsArticle + BreadcrumbList
 */
function outputFullSchema($breadcrumbs, $post = [], $baseURL = null , $ImageURL = null)
{
    $baseURL = $baseURL ?? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST']);

    $breadcrumbItems = [];
    foreach ($breadcrumbs as $i => $b) {
        $breadcrumbItems[] = [
            "@type" => "ListItem",
            "position" => $i + 1,
            "name" => $b["label"],
            "item" => !empty($b["url"]) ? $baseURL . $b["url"] : $baseURL . $_SERVER["REQUEST_URI"]
        ];
    }

    $schema = [
        "@context" => "https://schema.org",
        "@graph" => [
            [
                "@type" => "NewsArticle",
                "headline" => $post['name'] ?? ($breadcrumbs[count($breadcrumbs) - 1]['label'] ?? 'Article'),
                // Strip HTML tags and decode entities
                "description" => isset($post['meta_desc']) ? html_entity_decode(($post['meta_desc'])) : '',
                "image" => [$ImageURL . ($post['image'] ?? '/image/favicon-96x96.png')],
                "author" => [
                    "@type" => "Organization",
                    "name" => "FancyBet"
                ],
                "publisher" => [
                    "@type" => "Organization",
                    "name" => "FancyBet",
                    "logo" => [
                        "@type" => "ImageObject",
                        "url" => $baseURL . "/image/favicon-96x96.png",
                        "width" => 96,
                        "height" => 96
                    ]
                ],
                "mainEntityOfPage" => $baseURL . $_SERVER['REQUEST_URI'],
                "datePublished" => $post['created_at'] ?? date('Y-m-d'),
                "dateModified" => $post['updated_at'] ?? $post['created_at'] ?? date('Y-m-d'),
                "url" => $baseURL . $_SERVER['REQUEST_URI']
            ],
            [
                "@type" => "BreadcrumbList",
                "itemListElement" => $breadcrumbItems
            ]
        ]
    ];


    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}


function outputFullSchemaPage($breadcrumbs, $post = [], $baseURL = null)
{
    $baseURL = $baseURL ?? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST']);

    $breadcrumbItems = [];
    foreach ($breadcrumbs as $i => $b) {
        $breadcrumbItems[] = [
            "@type" => "ListItem",
            "position" => $i + 1,
            "name" => $b["label"],
            "item" => !empty($b["url"]) ? $baseURL . $b["url"] : $baseURL . $_SERVER["REQUEST_URI"]
        ];
    }

    $schema = [
        "@context" => "https://schema.org",
        "@graph" => [
            [
                "@type" => "Article",
                "headline" => $post['name'] ?? ($breadcrumbs[count($breadcrumbs) - 1]['label'] ?? 'Article'),
                // Strip HTML tags and decode entities
                "description" => isset($post['description']) ? html_entity_decode(strip_tags( $post['description'])) : '',
                "image" => [$baseURL . ($post['image'] ?? '/image/favicon-96x96.png')],
                "author" => [
                    "@type" => "Organization",
                    "name" => "FancyBet"
                ],
                "publisher" => [
                    "@type" => "Organization",
                    "name" => "FancyBet",
                    "logo" => [
                        "@type" => "ImageObject",
                        "url" => $baseURL . "/image/favicon-96x96.png",
                        "width" => 96,
                        "height" => 96
                    ]
                ],
                "mainEntityOfPage" => $baseURL . $_SERVER['REQUEST_URI'],
                "datePublished" => $post['created_at'] ?? date('Y-m-d'),
                "dateModified" => $post['updated_at'] ?? $post['created_at'] ?? date('Y-m-d'),
                "url" => $baseURL . $_SERVER['REQUEST_URI']
            ],
            [
                "@type" => "BreadcrumbList",
                "itemListElement" => $breadcrumbItems
            ]
        ]
    ];


    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}
/**
 * Example usage
 */
$lang = $_GET['lang'] ?? 'bn';

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

