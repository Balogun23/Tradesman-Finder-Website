<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Public User Dashboard</title>
</head>

<body>
    <!-- Include the header content -->
<?php include('includes/header.php'); ?>
   <div>
     <h1>Welcome to Your Public User Dashboard</h1>

    <!-- Search functionality for finding tradesmen -->
    <h2>Find Tradesmen</h2>
    <!-- Button to access the search functionality -->
    <a href="search.php" class="dashboard-button">Find Tradesmen</a>

    <!-- Job request history and status -->
    <h2>Job Request History and Status</h2>
    <!-- Button to view job request history and status -->
    <a href="view_job_history.php" class="dashboard-button">View Job Request History</a>

    <!-- Communication tools for interacting with tradesmen -->
    <h2>Communication Tools</h2>
    <!-- Button to access communication tools -->
    <a href="communication_tools.php" class="dashboard-button">Communication Tools</a>

    <!-- Access to account settings and profile management -->
    <h2>Account Settings and Profile Management</h2>
    <!-- Button to access account settings and profile management -->
    <a href="account_settings.php" class="dashboard-button">Account Settings and Profile Management</a>
</div>

</body>
<!-- Include the footer content -->
<?php include('includes/footer.php'); ?></html>
