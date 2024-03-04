<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set the character set and viewport for better rendering on various devices -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to the external stylesheet for styling -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Set the title of the HTML page -->
    <title>Job Request Notification</title>
</head>
<body>

<?php
    // Include the header section of the page
    include('includes/header.php'); 

    // Fetch the most recent job request
    $query = "SELECT * FROM job_requests ORDER BY request_id DESC LIMIT 1";
    $result = $dbc->query($query);

    // Check if there are any job requests
    if ($result->num_rows > 0) {
        // Fetch the details of the most recent job request
        $jobRequest = $result->fetch_assoc();
        
        // Display job request details
        echo '<h1>New Job Request</h1>';
        echo '<p>You have received a new job request. Please check the details and respond.</p>';
        echo '<p>Tradesman ID: ' . $jobRequest['tradesman_id'] . '</p>';
        // Display other job request details as needed

        // Form to view the details of the job request
        echo '<form action="job_request_details.php" method="post">';
        echo '<input type="hidden" name="job_id" value="' . $jobRequest['request_id'] . '">';
        echo '<button type="submit">View Job Request</button>';
        echo '</form>';
    } else {
        // Display a message if no new job requests are found
        echo '<p>No new job requests found.</p>';
    }
?>

<?php
    // Include the footer section of the page
    include('includes/footer.php');
?>

</body>
</html>
