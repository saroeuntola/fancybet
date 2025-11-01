<?php 
include "../admin/page/library/checkroles.php";
include('../admin/page/library/users_lib.php');
protectPathAccess(); 
// $categoryCount = dbCount("categories");
// $productCount = dbCount("games");
// $userCount = dbCount("users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./page/assets/css/styles.css">
         <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>

    <!-- Header -->
    
<?php 
  include '../admin/page/include/header.php'
?>
    <!-- Sidebar -->
<?php 
  include '../admin/page/include/sidebars.php'
?>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <div class="page-header">
            <h1 class="page-title">Dashboard Overview</h1>
            <p class="page-subtitle">Welcome back! Here's what's happening with your platform today.</p>
        </div>

        <!-- Dynamic Content Area -->
        <div id="dynamicContent">
            <!-- Content Sections -->
            <div class="content-section">
                <h2 class="section-title">Recent Activity</h2>
                <p>This section would typically contain recent user activities, system logs, or important notifications. You can customize this area based on your specific admin needs.</p>
            </div>

            <div class="content-section">
                <h2 class="section-title">Quick Actions</h2>
                <p>Add commonly used administrative functions here such as user management tools, content moderation options, or system maintenance utilities.</p>
            </div>
        </div>
    </main>

<script src="./page/assets/js/admin_script.js"></script>
</body>
</html>