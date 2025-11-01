<?php
include('../library/announcement_lib.php');
include('../library/checkroles.php');
protectPathAccess();

$announcement = new Announcement();

if (isset($_GET['id'])) {
    $announcementId = intval($_GET['id']);

    if ($announcement->deleteAnnouncement($announcementId)) {
        echo "<script>alert('Announcement deleted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to delete announcement!'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='index.php';</script>";
}
?>
