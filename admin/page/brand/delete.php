<?php
include('../library/brand_lib.php');
include('../library/checkroles.php');
protectPathAccess();
$brand = new Brand();
if (isset($_GET['id'])) {
    $brandId = intval($_GET['id']);
    if ($brand->deletebrand($brandId)) {
        echo "<script>alert('Brand deleted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to delete Brand!'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='index.php';</script>";
}
?>