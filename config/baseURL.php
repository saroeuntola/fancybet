<?php
$host = $_SERVER['HTTP_HOST'];
if ($host === 'fancybet:8080' || strpos($host, 'localhost') !== false) {
    $apiBaseURL = "http://fancybet:8080//admin/page/api/";
} else {
    $apiBaseURL = "https://fanciwheel.com/admin/page/api/";
}
