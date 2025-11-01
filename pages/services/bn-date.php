<?php
function formatDateByLang($dateStr, $lang = 'en')
{
    $timestamp = strtotime($dateStr);
    if (!$timestamp) return '';

    if ($lang === 'bn') {
        $months = [
            1 => 'জানুয়ারী',
            2 => 'ফেব্রুয়ারী',
            3 => 'মার্চ',
            4 => 'এপ্রিল',
            5 => 'মে',
            6 => 'জুন',
            7 => 'জুলাই',
            8 => 'আগস্ট',
            9 => 'সেপ্টেম্বর',
            10 => 'অক্টোবর',
            11 => 'নভেম্বর',
            12 => 'ডিসেম্বর'
        ];

        $day = strtr(date('j', $timestamp), ['0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯']);
        $month = $months[intval(date('n', $timestamp))];
        $year = strtr(date('Y', $timestamp), ['0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯']);

        return "{$month} {$day}, {$year}";
    } else {
        return date('F j, Y', $timestamp);
    }
}
