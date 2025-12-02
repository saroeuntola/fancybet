<?php
include "../admin/page/library/db.php";  
include "../admin/page/library/post_lib.php";     

$SECRET_KEY = 'ec08cf9ee658a95781564961c41f5b98';

$postLib = new Post(); 

// Get POST data
$secret_key      = $_POST['secret_key'] ?? '';
$slug            = $_POST['slug'] ?? null;
$name            = $_POST['name'] ?? '';
$description     = $_POST['description'] ?? '';
$meta_text       = $_POST['meta_text'] ?? '';

$name_bn         = $_POST['name_bn'] ?? '';
$description_bn  = $_POST['description_bn'] ?? '';
$meta_text_bn    = $_POST['meta_text_bn'] ?? '';

$meta_desc       = $_POST['meta_desc'] ?? '';
$meta_keyword    = $_POST['meta_keyword'] ?? '';
$meta_desc_bn    = $_POST['meta_desc_bn'] ?? '';
$meta_keyword_bn = $_POST['meta_keyword_bn'] ?? '';

$category_id     = $_POST['category_id'] ?? 0;
$image           = $_POST['image'] ?? '';
$link            = $_POST['link'] ?? '';
$public_by       = $_POST['public_by'] ?? 0;

// Validate secret key
if ($secret_key !== $SECRET_KEY) {
    http_response_code(403);
    die("Invalid secret key");
}

// Check duplicate by slug
$exists = dbSelect('post', 'id', 'slug="' . addslashes($slug) . '"');
if ($exists) {
    die("Post with this slug already exists.");
}

// Create post
$real_id = $postLib->createpost(
    $name,
    $image,
    $description,
    $link,
    $category_id,
    $meta_text,
    $name_bn,
    $description_bn,
    $meta_text_bn,
    $meta_desc,
    $meta_keyword,
    $meta_desc_bn,
    $meta_keyword_bn,
    $public_by,
    $slug
);

if ($real_id) {
    echo "Post Published Successfully! ID: $real_id";
} else {
    echo "Failed to publish post.";
}
