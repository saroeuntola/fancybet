<?php
include('../library/checkroles.php');
include('../library/post_lib.php');
include('../library/users_lib.php');

protectRoute([1, 3]);
$product = new Post();
$products = $product->getPost();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Content Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">

</head>

<body>
    <!-- Header -->
    <?php
    include '../include/header.php'
    ?>
    <!-- Sidebar -->
    <?php
    include '../include/sidebars.php'
    ?>
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Dynamic Content Area -->
        <div id="dynamicContent">
            <!-- Content Sections -->

            <div class="container mx-auto lg:p-10">

                <!-- Header -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-4 md:mb-0">Post Management</h2>
                    <a href="create.php"
                        class="bg-indigo-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:bg-indigo-700 transition duration-300 ease-in-out text-center">
                        + New Post
                    </a>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">Image</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Category</th>
                                <th scope="col" class="px-6 py-3">Post by </th>
                                <th scope="col" class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($products && count($products) > 0): ?>
                                <?php foreach ($products as $item): ?>
                                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="Game" class="h-12 w-12 object-cover rounded-md" loading="lazy">
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($item['name']); ?>
                                        </td>

                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($item['category_name']); ?>
                                        </td>

                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($item['public_by']); ?>
                                        </td>
                                        <td class="px-4 py-4 flex justify-center space-x-3">
                                            <a href="edit?id=<?php echo $item['id']; ?>"
                                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                                                Edit
                                            </a>
                                            <a href="delete?id=<?php echo $item['id']; ?>"
                                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                Delete
                                            </a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-lg">
                                        No post found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>

    <script src="../assets/js/admin_script.js"></script>
</body>

</html>