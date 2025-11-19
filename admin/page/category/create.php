<?php
include('../library/category_lib.php');
include('../library/checkroles.php');
protectRoute([1, 3]);

$cat = new Category();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $image = $_POST['cat_image'] ?? NULL;

  if ($cat->createCategory($name, $image)) {
    header("Location: index.php");
    exit;
  } else {
    echo "<p class='text-red-500 text-center'>❌ Error: could not be created.</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Announcement</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-6">Create Category</h2>

    <!-- Announcement Form -->
    <form action="create" method="POST">

      <!-- Message -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Category Name</label>
        <input name="name" required
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></input>
      </div>



      <!-- Submit -->
      <div>
        <button type="submit"
          class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg 
                 hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
          Create
        </button>
      </div>
    </form>
  </div>

</body>

</html>