<?php
// Include necessary files and database connection
include('includes/database.php');
include('includes/header.php');

if (isset($_SESSION['user_id'])) {
    $tradesman_user_id = $_SESSION['user_id'];

    // Fetch ratings for the tradesman from the database
    $query = "SELECT * FROM ratings WHERE tradesman_id = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param('i', $tradesman_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ratings = $result->fetch_all(MYSQLI_ASSOC);

    // Close the database connection
    $stmt->close();
    $dbc->close();
} else {
    // Redirect to login if tradesman is not logged in
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>View Ratings</title>
</head>
<body>
    <h1>Your Ratings</h1>

    <?php if (empty($ratings)): ?>
        <p>No ratings available.</p>
    <?php else: ?>
        <!-- Display tradesman ratings -->
        <ul>
            <?php foreach ($ratings as $rating): ?>
                <li>
                    <!-- Display rating information (replace with actual display logic) -->
                    Rating: <?php echo $rating['rating']; ?><br>
                    Feedback: <?php echo $rating['feedback']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Add back button to tradesman dashboard -->
    <a href="tradesman_dashboard.php">Back to Dashboard</a>
<!-- Include the footer content -->
<?php include('includes/footer.php'); ?>
</body>
</html>
