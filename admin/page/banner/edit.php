<?php
include('../library/banner_lib.php');
// include('../library/category_lib.php');
include('../library/checkroles.php');

protectPathAccess();

$banner = new Banner();
// $category = new Category();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

$bannerData = $banner->getBannerById($id);
if (!$bannerData) {
    die("Banner not found");
}
}
// $categories = $category->getCategories();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bannerName = $_POST['title'];
    $link = $_POST['link'];
    // $price = $_POST['price'];
    // $stock = $_POST['stock'];
    // $categoryId = $_POST['category_id'];

    // Handle Image Upload
     $imagePath = $bannerData['image']; // Default to the existing image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = "banner_image/";
        $imagePath = $uploadDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    if ($banner->updateBanner($id,$bannerName, $imagePath, $link)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<p class='text-red-500'>Error: Banner could not be created.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Banner</title>
     <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Edit Banner</h2>

        <?php if (isset($error)): ?>
            <p class="text-red-500 text-center"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Edit Product Form -->
        <form action="edit?id=<?php echo $bannerData['id']; ?>" method="POST" enctype="multipart/form-data">
            <!-- Product Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Banner Title</label>
                <input type="text" name="title" value="<?= htmlspecialchars($bannerData['title']) ?>" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Product Image -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Banner Image</label>
                <img src="<?= htmlspecialchars($bannerData['image']) ?>" class="h-20 w-20 object-cover rounded-md">
                <input type="file" name="image" class="mt-2">
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Link</label>
                <textarea name="link" rows="3"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?= htmlspecialchars($bannerData['link']) ?></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-center">
                <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Update
                </button>
            </div>
        </form>
    </div>
</body>
</html>
