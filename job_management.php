<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/header.php');
require('includes/database.php');

// Function to generate a unique 6-digit alphanumeric keyword
function generateUniqueKeyword() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $keyword = '';

    // Generate a 6-character keyword
    for ($i = 0; $i < 6; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $keyword .= $characters[$index];
    }

    return $keyword;
}

// Check if tradesman_id is set in the session
if (isset($_SESSION['tradesman_id'])) {
    $tradesman_id = $_SESSION['tradesman_id'];

    // Tradesman dashboard or job management section
    // Query job requests
    $query = "SELECT * FROM job_requests WHERE tradesman_id = $tradesman_id";
    $result = mysqli_query($dbc, $query);

    if (!$result) {
        die('Query error: ' . mysqli_error($dbc));
    }

    // Display the job requests
    while ($jobDetails = mysqli_fetch_assoc($result)) {
        $job_id = $jobDetails['request_id']; // Declare $job_id here

        echo "Job Nature: " . (isset($jobDetails['job_nature']) ? $jobDetails['job_nature'] : "N/A") . "<br>";
        echo "Status: " . (isset($jobDetails['status']) ? $jobDetails['status'] : "N/A") . "<br>";
        echo "Request Date: " . (isset($jobDetails['request_date']) ? $jobDetails['request_date'] : "N/A") . "<br>";
        echo "Additional Info: " . (isset($jobDetails['additional_info']) ? $jobDetails['additional_info'] : "N/A") . "<br>";
        echo "Location: " . (isset($jobDetails['location']) ? $jobDetails['location'] : "N/A") . "<br>";

        // Check if the job is in progress or completed to allow updating status
        if ($jobDetails['status'] == 'Pending' || $jobDetails['status'] == 'Accepted' || $jobDetails['status'] == 'Ongoing') {
            // Display a form for the tradesman to update job status
            echo "<form method='post'>";
            echo "Update Job Status: ";
            echo "<select name='new_status'>";
            echo "<option value='Pending' " . ($jobDetails['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>";
            echo "<option value='Accepted' " . ($jobDetails['status'] == 'Accepted' ? 'selected' : '') . ">Accepted</option>";
            echo "<option value='Declined' " . ($jobDetails['status'] == 'Declined' ? 'selected' : '') . ">Declined</option>";
            echo "<option value='Ongoing' " . ($jobDetails['status'] == 'Ongoing' ? 'selected' : '') . ">Ongoing</option>";
            echo "<option value='Completed' " . ($jobDetails['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>";
            echo "</select>";
            echo "<input type='submit' name='update_status' value='Update'>";
            echo "<input type='hidden' name='job_id' value='$job_id'>";
            echo "</form>";
        }

        // If the job is completed, display the unique keyword for rating
        if ($jobDetails['status'] == 'Completed') {
            // Check if the unique keyword is already generated
            if (empty($jobDetails['unique_keyword'])) {
                $uniqueKeyword = generateUniqueKeyword();

                // Store the unique keyword in the database associated with the completed job
                $updateKeywordQuery = "UPDATE job_requests SET unique_keyword = '$uniqueKeyword' WHERE request_id = $job_id";
                mysqli_query($dbc, $updateKeywordQuery);
            } else {
                $uniqueKeyword = $jobDetails['unique_keyword'];
            }

            echo "Unique Keyword for Rating: " . htmlspecialchars($uniqueKeyword) . "<br>";
        }

    }

    // Process the form submission outside the loop
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
        $newStatus = $_POST['new_status'];
        $job_id = $_POST['job_id']; // Make sure to capture the job_id

        // Update job status based on the form submission
        $updateQuery = "UPDATE job_requests SET status = '$newStatus' WHERE request_id = $job_id";
        mysqli_query($dbc, $updateQuery);

    }
}

// Include the communication tools only once
if (!function_exists('getChatMessages')) {
    include 'communication_tools.php';
}
?>
