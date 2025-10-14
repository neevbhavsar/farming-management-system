<?php
// Start session
session_start();

// If admin is already logged in, redirect to dashboard
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true){
    header("Location: dashboard.php");
    exit;
} else {
    // Redirect to login page
    header("Location: login.php");
    exit;
}
?>
