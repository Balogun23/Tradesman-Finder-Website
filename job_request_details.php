<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set the character set and viewport for better rendering on various devices -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to the external stylesheet for styling -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Set the title of the HTML page -->
    <title>Job Request Details</title>
</head>
<body>

<?php
    // Connect to the database
    require('includes/database.php');

    // Check if job_id is set in the URL
    if (isset($_POST['job_id'])) {
        // Retrieve job_id from the form submission
        $job_id = $_POST['job_id'];

        // Query to retrieve job details based on job_id
        $query = "SELECT * FROM job_requests WHERE request_id = $job_id";

        // Execute the query
        $result = $dbc->query($query);

        // Check if the query executed successfully
        if ($result) {
            // Fetch the job details
            $jobDetails = $result->fetch_assoc();

            // Display job details retrieved from the database
            echo '<div>';
            echo '<h1>Job Request Details</h1>';
            echo '<p>Job Nature: ' . htmlspecialchars($jobDetails['job_nature']) . '</p>';

            // Check if 'location' index is set before displaying
            if (isset($jobDetails['location'])) {
                echo '<p>Location: ' . htmlspecialchars($jobDetails['location']) . '</p>';
            } else {
                echo '<p>Location: Not specified</p>';
            }

            // Check if 'additional_information' index is set before displaying
            if (isset($jobDetails['additional_information'])) {
                echo '<p>Additional Information: ' . htmlspecialchars($jobDetails['additional_information']) . '</p>';
            } else {
                echo '<p>Additional Information: Not specified</p>';
            }

            // Accept or Decline buttons
            echo '<form action="process_job_response.php" method="post">';
            echo '<input type="hidden" name="job_id" value="' . $job_id . '">';
            echo '<button type="submit" name="accept">Accept Job</button>';
            echo '<button type="submit" name="decline">Decline Job</button>';
            echo '</form>';
            echo '</div>';
        } else {
            // Handle query error
            echo "Error: " . $dbc->error;
        }
    } else {
        // Handle the case where job_id is not set in the URL
        echo "Job ID not provided.";
    }
?>

</body>
</html>
