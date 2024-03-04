<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Include header
include('includes/header.php');

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Connect to the database
    require('includes/database.php');

    // Initialize errors array
    $errors = array();

// Check common fields
$common_fields = array('username', 'first_name', 'last_name', 'email', 'password', 'actor', 'trade', 'skills', 'certifications', 'location', 'hourly_rate');
foreach ($common_fields as $field) {
    if (empty($_POST[$field])) {
        $errors[] = "Enter your $field.";
    } else {
        ${$field} = $dbc->real_escape_string(trim($_POST[$field]));
    }
}

// Hash the password
$password_hash = sha1($password);

// Set the role
$role = 'tradesman';

// Check if email is already registered
$q = "SELECT user_id FROM users WHERE email=?";
$stmt = $dbc->prepare($q);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $errors[] = 'Email address already registered. <a href="login.php">Login</a>';
}

// If no errors, insert user record into the database
if (empty($errors)) {
    $password_hash = sha1($password);

    // Prepare the SQL statement
    $stmt = $dbc->prepare("INSERT INTO users (username, first_name, last_name, email, pass, role, trade, skills, certifications, location, hourly_rate, reg_date)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    if (!$stmt) {
        die('Error in prepare: ' . $dbc->error);
    }

    // Bind parameters
    $stmt->bind_param("sssssssssss", $username, $first_name, $last_name, $email, $password_hash, $role, $trade, $skills, $certifications, $location, $hourly_rate);

    if ($stmt->execute()) {
        echo '<h1>Registered!</h1>
              <p>You are now registered.</p>
              <p><a href="login.php">Login</a></p>';
        $stmt->close();
        $dbc->close();
        include('includes/footer.php');
        exit();
    } else {
        $errors[] = 'Registration failed. Please try again later.';
        error_log($stmt->error); // Log the database error

        // Display detailed error information
        echo '<pre>';
        var_dump($stmt);
        echo '</pre>';

        $stmt->close();
    }
}



    // If registration was not successful, display error message(s)
    if (!empty($errors)) {
        echo '<h1>Error!</h1>';
        echo '<div class="error-msg">';
        foreach ($errors as $msg) {
            echo "<p>$msg</p>";
        }
        echo '</div>';
        echo '<p>Please try again.</p>';
        $dbc->close();

        // Add more detailed error information
        echo '<pre>';
        var_dump($stmt);
        echo '</pre>';
    }
}

// Include footer
include('includes/footer.php');
?>
