<?php
include('../library/brand_lib.php');
include('../library/checkroles.php');
 protectPathAccess();
$brand = new Brand();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brandName = $_POST['brand_name'];
    $brandLink = $_POST['link'];


    // Handle Image Upload
    $imagePath = "";
    if (isset($_FILES['brand_image']) && $_FILES['brand_image']['error'] == 0) {
        $uploadDir = "brand_image/";
        $imagePath = $uploadDir . basename($_FILES["brand_image"]["name"]);
        move_uploaded_file($_FILES["brand_image"]["tmp_name"], $imagePath);
    }

    if ($brand->createBrand($brandName, $imagePath, $brandLink)) {
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
    <title>Create Brand</title>
     <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Create Brand</h2>

        <form action="create" method="POST" enctype="multipart/form-data">
            <!-- Brand Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Brand Name</label>
                <input type="text" name="brand_name" required class="w-full px-3 py-2 border rounded-md">
            </div>

            <!-- Brand Image -->
           <!-- Brand Image with Preview -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Upload Image</label>
    <input type="file" name="brand_image" accept="image/*" class="w-full px-3 py-2 border rounded-md" onchange="previewImage(event)">
    <div class="mt-2">
        <img id="imagePreview" src="#" alt="Preview" class="w-24 h-24 rounded-full object-cover border mt-2 hidden" />
    </div>
</div>

            <!-- Link -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Link</label>
                <textarea name="link" rows="3" class="w-full px-3 py-2 border rounded-md"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                Create Brand
            </button>
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
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</html>
