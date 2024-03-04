<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files and database connection
include('includes/database.php');
include('includes/header.php');
?>
<link rel="stylesheet" href="css/style.css">
<?php

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if the necessary session variable is set
    if (!empty($_SESSION['client_id'])) {
        // Get client_id from the session
        $client_id = $_SESSION['client_id'];

        // Check if the necessary form variables are set
        if (isset($_POST['tradesman_id'], $_POST['job_nature'])) {
            // Get tradesman_id and job_nature from the form
            $tradesman_id = $_POST['tradesman_id'];
            $job_nature = $_POST['job_nature'];

            // Set a default value for additional_info (you can modify this as needed)
            $additional_info = "No additional info";

            // Prepare the SQL query
            $query = "INSERT INTO job_requests (user_id, tradesman_id, job_nature, additional_info, location) VALUES (?, ?, ?, ?, ?)";

            // Prepare the statement
            $stmt = $dbc->prepare($query);

            // Check if the statement was prepared successfully
            if ($stmt) {
                // Bind parameters
                $stmt->bind_param("iisss", $client_id, $tradesman_id, $job_nature, $additional_info, $location);

                // Execute the statement
                if ($stmt->execute()) {
                    // Check for success
                    if ($stmt->affected_rows > 0) {
                        echo "Job request sent successfully!";
                    } else {
                        echo "Error sending job request. No rows affected.";
                    }
                } else {
                    echo "Error executing the statement: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                // Display detailed error information if statement preparation fails
                echo "Error preparing the statement: " . $dbc->error;
            }
        } else {
            echo "Invalid form data. Tradesman ID or Job Nature is not set.";
        }
    } else {
        echo "Client not authenticated. Session client_id is empty.";
    }

    // Close the database connection
    $dbc->close();
}
 include('includes/footer.php'); ?>


