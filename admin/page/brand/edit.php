<?php
include('../library/brand_lib.php');
// include('../library/category_lib.php');
include('../library/checkroles.php');

protectPathAccess();

$brand = new Brand();
// $category = new Category();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

$brandData = $brand->getBrandById($id);
if (!$brandData) {
    die("Brand not found");
}
}
// $categories = $category->getCategories();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brandName = $_POST['brand_name'];
    $link = $_POST['link'];
   
    // Handle Image Upload
    $imagePath = $brandData['brand_image'];
    if (isset($_FILES['brand_image']) && $_FILES['brand_image']['error'] == 0) {
        $uploadDir = "brand_image/";
        $imagePath = $uploadDir . basename($_FILES["brand_image"]["name"]);
        move_uploaded_file($_FILES["brand_image"]["tmp_name"], $imagePath);
    }
    


    if ($brand->updateBrand($id,$brandName, $imagePath, $link )) {
        header("Location: index.php");
        exit;
    } else {
        echo "<p class='text-red-500'>Error: Brand could not be created.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Brand</title>
     <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Edit Brand</h2>

        <?php if (isset($error)): ?>
            <p class="text-red-500 text-center"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Edit Brand Form -->
        <form action="edit?id=<?php echo $brandData['id']; ?>" method="POST" enctype="multipart/form-data">
            <!-- Brand Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Brand Name</label>
                <input type="text" name="brand_name" value="<?= htmlspecialchars($brandData['brand_name']) ?>" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

           <!-- Brand Image with Preview -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Brand Image</label>
    <img id="imagePreview" src="<?= htmlspecialchars($brandData['brand_image']) ?>" class="h-20 w-20 object-cover rounded-md mb-2">
    <input type="file" name="brand_image" accept="image/*" onchange="previewImage(event)" class="mt-2">
</div>


            <!-- Brand Link -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Link</label>
                <textarea name="link" rows="3" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?= htmlspecialchars($brandData['link']) ?></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-center">
                <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Update Brand
                </button>
            </div>
        </form>
    </div>
</body>
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</html>
