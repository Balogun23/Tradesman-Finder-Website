<!-- update_availability.php -->
<?php
// Display errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Include header
include('includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Availability</title>
</head>
<body>

<?php
require('includes/database.php');


// Check if user_id is set in the session
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newAvailability = $dbc->real_escape_string($_POST['availability']);

        // Update the user's availability in the database
        $updateQuery = "UPDATE users SET availability = '$newAvailability' WHERE user_id = $user_id";
        $updateResult = $dbc->query($updateQuery);

        if ($updateResult) {
            echo 'Availability updated successfully!';
        } else {
            echo 'Error updating availability: ' . $dbc->error;
        }
    }
?>

<form action="update_availability.php" method="post">
    <label for="availability">Availability:</label>
    <select name="availability" id="availability">
        <option value="immediately">Immediately Available</option>
        <option value="1_week">1 Week</option>
        <option value="2_weeks">2 Weeks</option>
        <option value="3_weeks">3 Weeks</option>
        <option value="4_weeks">4 Weeks</option>
        <option value="5_weeks">5 Weeks</option>
        <option value="6_weeks">6 Weeks</option>
        <option value="7_weeks">7 Weeks</option>
        <option value="8_weeks">8 Weeks</option>
    </select>
    <input type="submit" value="Update Availability">
</form>
<?php
} else {
    echo "User ID not set in the session. Please log in.";
}
 include('includes/footer.php'); ?>

</body>
</html>
