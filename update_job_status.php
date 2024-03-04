<!-- update_job_status.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tradesman - Update Job Status</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Update Job Status</h1>
    
    <!-- PHP code and form for updating job statuses -->
    <?php
    // Include necessary files and database connection
    include('includes/header.php');
    include('includes/database.php');

    // $tradesmanId is retrieved from the session 
    $tradesmanId = $_SESSION['user_id']; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $jobId = $_POST['job_id'];
        $newStatus = $_POST['new_status'];

        // Update job status in the database
        $updateQuery = "UPDATE jobs SET status = ? WHERE job_id = ? AND tradesman_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sii", $newStatus, $jobId, $tradesmanId);

        if ($stmt->execute()) {
            echo '<p>Job status updated successfully.</p>';
        } else {
            echo '<p>Error updating job status.</p>';
        }

        $stmt->close();
    }
    ?>

    <!-- Form for updating job statuses -->
    <form action="update_job_status.php" method="post">
        <label for="job_id">Job ID:</label>
        <input type="text" name="job_id" id="job_id" required>

        <label for="new_status">New Status:</label>
        <input type="text" name="new_status" id="new_status" required>

        <button type="submit">Update Status</button>
    </form>

    
    <?php include('includes/footer.php'); ?>
</body>
</html>