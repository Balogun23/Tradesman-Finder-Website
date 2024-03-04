<?php
// Include necessary files and database connection
include('includes/database.php');
include('includes/header.php');

// Check if the admin user is logged in
if (isset($_SESSION['user_id'])) {
    $admin_user_id = $_SESSION['user_id'];

    // Fetch all ratings from the database
    $query = "SELECT * FROM ratings";
    $result = $dbc->query($query);  // Update variable name to $dbc
    $allRatings = $result->fetch_all(MYSQLI_ASSOC);

    // Close the database connection
    $dbc->close();
} else {
    // Redirect to login if admin is not logged in
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to the external stylesheet for styling -->
    <link rel="stylesheet" href="css/style.css">
    <title>Monitor Ratings</title>
</head>
<body>
    <h1>Monitor Ratings</h1>

    <?php if (empty($allRatings)): ?>
        <!-- Display a message if there are no ratings available -->
        <p>No ratings available.</p>
    <?php else: ?>
        <!-- Display all ratings in an unordered list -->
        <ul>
            <?php foreach ($allRatings as $rating): ?>
                <li>
                    <!-- Display rating information with isset checks to handle possible null values -->
                    User ID: <?php echo isset($rating['user_id']) ? $rating['user_id'] : 'N/A'; ?><br>
                    Tradesman ID: <?php echo isset($rating['tradesman_id']) ? $rating['tradesman_id'] : 'N/A'; ?><br>
                    Rating: <?php echo isset($rating['rating']) ? $rating['rating'] : 'N/A'; ?><br>
                    Feedback: <?php echo isset($rating['comment']) ? $rating['comment'] : 'N/A'; ?><br>
                    Created At: <?php echo isset($rating['created_at']) ? $rating['created_at'] : 'N/A'; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Add a back button to return to the admin dashboard -->
    <a href="admin_dashboard.php">Back to Dashboard</a>
    
    <!-- Include the footer content -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
