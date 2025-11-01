<?php
include('../library/category_lib.php');
include('../library/checkroles.php');
protectPathAccess();

$category = new Category();

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $catData = $category->getCategory($id);

  if (!$catData) {
    die("Category not found");
  }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $catName = $_POST['name'];

  // Use existing image by default
  $imagePath = $catData['cat_image'];

  if (isset($_FILES['cat_image']) && $_FILES['cat_image']['error'] === 0) {
    $uploadDir = "cat_image/";
    $fileName = uniqid() . "_" . basename($_FILES["cat_image"]["name"]);
    $imagePath = $uploadDir . $fileName;
    move_uploaded_file($_FILES["cat_image"]["tmp_name"], $imagePath);
  }

  if ($category->updateCategory($id, $catName, $imagePath)) {
    header("Location: index.php");
    exit;
  } else {
    $error = "Error: Category could not be updated.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Category</title>

  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-6">Edit Category</h2>

    <?php if (isset($error)): ?>
      <p class="text-red-500 text-center"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="edit?id=<?= $catData['id'] ?>" method="POST" enctype="multipart/form-data">
      <!-- Category Name -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($catData['name']) ?>" required
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
      </div>

      <!-- Category Image with Preview -->


      <!-- Submit Button -->
      <div class="flex items-center justify-center">
        <button type="submit"
          class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          Update Category
        </button>
      </div>
    </form>
  </div>

  <script>
    const fileInput = document.getElementById('cat_image');
    const previewImage = document.getElementById('imagePreview');

    fileInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          previewImage.src = e.target.result; // Replace src with new image
        };
        reader.readAsDataURL(file);
      }
    });
  </script>

</body>

</html>