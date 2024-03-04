<link rel="stylesheet" type="text/css" href="css/style.css">

<?php
include('includes/header.php');

// Check if user is logged in (you might want to include more checks)
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!-- Tradesman profile content goes here -->

<?php include('includes/footer.php'); ?>
