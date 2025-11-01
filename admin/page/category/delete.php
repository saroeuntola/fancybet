<?php
include('../library/category_lib.php');
include('../library/checkroles.php');
protectPathAccess();
$category = new Category();

if (isset($_GET['id'])) {
    $categoryId = intval($_GET['id']);
    if ($category->deleteCategory($categoryId)) {
        echo "<script>alert('Category deleted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to delete category!'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='index.php';</script>";
}
?>
