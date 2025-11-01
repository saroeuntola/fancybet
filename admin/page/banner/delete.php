<?php
include('../library/banner_lib.php');
include('../library/checkroles.php');
protectPathAccess();
$banner = new Banner();
if (isset($_GET['id'])) {
    $bannerId = intval($_GET['id']);
    if ($banner->deletebanner($bannerId)) {
        echo "<script>alert('product deleted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to delete product!'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='index.php';</script>";
}
?>