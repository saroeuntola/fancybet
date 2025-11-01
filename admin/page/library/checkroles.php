<?php
session_start();
include("auth.php");

function protectPathAccess() {

    $auth = new Auth();
    
    if ($auth->is_logged_in()) {
        if ($_SESSION['role_id'] != 1) {
            header("Location: /no_access");
            exit;
        }
    } else {
        header("Location: /no_access");
        exit;
    }
}
?>
