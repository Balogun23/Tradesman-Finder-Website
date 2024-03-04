<!-- admin_dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <!-- Include the header content -->
    <?php 
    include('includes/header.php'); 

?>

    <div>
        <h1>Welcome to the Admin Dashboard</h1>

        <!-- User management tools -->
        <h2>Update Trade List</h2>
        <a href="updateTrade.php" class="dashboard-button">Update Trade List</a>

        <!-- Overview of registered tradesmen and public users -->
        <h2>Overview of Users</h2>
        <a href="view_users.php" class="dashboard-button">View Registered Users</a>
        
        <!-- Overview of ratings -->
        <h2>Overview of Ratings</h2>
        <a href="monitor_ratings.php" class="dashboard-button">Monitor Ratings</a>

        <!-- Add User Function -->
        <h2>Add User</h2>
        <a href="register.php" class="dashboard-button">Add User Account</a>

        <!-- Deleting Users -->
        <h2>Delete User</h2>
        <a href="delete_user.php" class="dashboard-button">Delete User Account</a>
      
        <!-- Reseting User Password -->
        <h2>Reset User Password</h2>
        <a href="reset_password.php" class="dashboard-button">Reset User Password</a>
    </div>

    <!-- Include the footer content -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
