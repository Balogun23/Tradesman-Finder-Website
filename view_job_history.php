<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files and database connection
include('includes/database.php');
include('includes/header.php');

// Assuming the public user is already authenticated and their ID is available in the session
$user_id = $_SESSION['user_id'];

// Fetch and display job request history
$jobRequests = getJobRequestHistory($user_id);

if ($jobRequests) {
    echo '<ul>';
    foreach ($jobRequests as $request) {
        echo '<li>';
        echo 'Job Nature: ' . $request['job_nature'] . ' - ';
        echo 'Status: ' . $request['status'];
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No job requests found.</p>';
}

// Function to fetch job request history from the database
function getJobRequestHistory($user_id) {
    global $dbc;

    // Implement the code to fetch job request history from the database based on the public user ID
    $query = "SELECT * FROM job_requests WHERE user_id = ?";
    $stmt = $dbc->prepare($query);

    if (!$stmt) {
        die('Error preparing statement: ' . $dbc->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die('Error executing query: ' . $stmt->error);
    }

    // Check if any records are found
    if ($result->num_rows > 0) {
        $jobRequests = array();
        while ($row = $result->fetch_assoc()) {
            $jobRequests[] = $row;
        }
        return $jobRequests;
    } else {
        return false;
    }
}

?>
<?php include('includes/footer.php'); ?>
