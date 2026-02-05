<?php
include('../library/banner_lib.php');
include('../library/checkroles.php');
 protectPathAccess();
$banner = new Banner();
// $category = new Category();
// $categories = $category->getCategories();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bannerName = $_POST['title'];
    $bannerLink = $_POST['link'];
    // $price = $_POST['price'];
    // $stock = $_POST['stock'];
    // $categoryId = $_POST['category_id'];

    // Handle Image Upload
    $imagePath = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = "banner_image/";
        $imagePath = $uploadDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    if ($banner->createBanner($bannerName, $imagePath, $bannerLink)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<p class='text-red-500'>Error: Banner could not be created.</p>";
    }
}

ini_set('upload_max_filesize', '50M'); // or higher if needed
ini_set('post_max_size', '50M');
ini_set('max_execution_time', 300); // allow more time for large files

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Banner</title>
     <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Create Banner</h2>

        <form action="create" method="POST" enctype="multipart/form-data">
            <!-- Banner Title -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Banner Title</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border rounded-md">
            </div>

            <!-- Banner Image -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Upload Image</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded-md">
            </div>

            <!-- Link -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Link</label>
                <textarea name="link" rows="3" class="w-full px-3 py-2 border rounded-md"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                Create Banner
            </button>
        </form>
    </div>
</body>
</html>
