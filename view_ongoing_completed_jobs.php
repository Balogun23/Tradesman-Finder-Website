<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tradesman - View Ongoing and Completed Jobs</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php include('includes/header.php');
include('includes/database.php');
?>

<h1>View Ongoing and Completed Jobs</h1>

<!-- PHP code to fetch and display ongoing and completed jobs from the database -->
<?php

// $tradesmanId is retrieved from the session or database
$tradesmanId = $_SESSION['user_id']; // Replace with your actual session variable

// Fetch and display accepted job requests
$selectQuery = "SELECT * FROM job_requests WHERE tradesman_id = ? AND status = 'Ongoing'";
$stmt = $dbc->prepare($selectQuery);

if ($stmt) {
    $stmt->bind_param("i", $tradesmanId);
    $stmt->execute();
    $result = $stmt->get_result();

// Display job requests
while ($row = $result->fetch_assoc()) {
echo '<h2>Accepted Job</h2>';
echo '<p>You have accepted the following job request. Please update job status to ongoing when started and completed when done.</p>';

if (isset($row['request_id'])) {
    echo '<p>Job Nature: ' . $row['job_nature'] . '</p>';
    
    // Form to update status to "Completed"
    echo '<form action="process_job_response.php" method="post">';
    echo '<input type="hidden" name="request_id" value="' . $row['request_id'] . '">';
    echo '<button type="submit" name="update_status" value="Completed">Update to Completed</button>';
    echo '</form>';
    
    echo '<hr>';
}

if (isset($row['request_id'])) {
    // Form to view job details
    echo '<form action="job_request_details.php" method="post">';
    echo '<input type="hidden" name="request_id" value="' . $row['request_id'] . '">';
    // Include additional form elements or details if needed
    echo '<button type="submit">View Job Details</button>';
    echo '</form>';
    
    echo '<hr>';
}
}


    $stmt->close();
} else {
    // Handle the case where the statement preparation fails
    echo "Error preparing statement: " . $dbc->error;
}
?>
</div>

<?php include('includes/footer.php'); ?>
</body>
</html>
