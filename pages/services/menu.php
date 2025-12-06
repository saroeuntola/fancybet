<?php
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