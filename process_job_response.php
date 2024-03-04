<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php include('includes/header.php'); ?>
<?php
require('includes/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];

    if (isset($_POST['accept'])) {
        // Update the job status to 'Accepted'
        updateJobStatus($request_id, 'Accepted');
        echo '<h2>Job accepted successfully!</h2>';
    } elseif (isset($_POST['decline'])) {
        // Update the job status to 'Declined'
        updateJobStatus($request_id, 'Declined');
        echo '<h2>Job declined successfully!</h2>';
    } elseif (isset($_POST['update_status'])) {
        // Check the value of the 'update_status' button
        $status = $_POST['update_status'];

        if ($status === 'Ongoing') {
            // Update the job status to 'Ongoing'
            updateJobStatus($request_id, 'Ongoing');
            echo '<h2>Job marked as ongoing!</h2>';
        } elseif ($status === 'Completed') {
            // Update the job status to 'Completed'
            updateJobStatus($request_id, 'Completed');
            echo '<h2>Job marked as completed!</h2>';
        } else {
            echo "Invalid action.";
        }
    } else {
        echo "Invalid action.";
    }
} else {
    echo "Invalid request.";
}

function updateJobStatus($request_id, $status) {
    global $dbc;
    $updateQuery = "UPDATE job_requests SET status = ? WHERE request_id = ?";
    $stmt = $dbc->prepare($updateQuery);

    if ($stmt) {
        $stmt->bind_param("si", $status, $request_id);
        if ($stmt->execute()) {
            echo '<h2>Job status updated successfully!</h2>';
        } else {
            echo "Error executing statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $dbc->error;
    }
}
?>
<?php include('includes/footer.php'); ?>
