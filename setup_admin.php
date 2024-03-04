<?php
// Include necessary files and database connection
include('includes/database.php');

$pass = 'Adm1nPa$$w0rd';
// Hash the admin password
$hashedAdminPassword = password_hash($pass, PASSWORD_DEFAULT);

$first_name = 'Emmanuel';
$last_name = 'Balogun';
$username = 'admin';
$email = 'Emmanuel.A.Balogun@student.shu.ac.uk';
$role = 'admin';
$reg_date = date('Y-m-d H:i:s');

// Prepare the SQL statement
$query = "INSERT INTO users (first_name, last_name, username, email, pass, role, reg_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbc->prepare($query);

if (!$stmt) {
    die("Error in prepare: " . $dbc->error);
}

// Bind parameters after preparing the statement
$stmt->bind_param('sssssss', $first_name, $last_name, $username, $email, $hashedAdminPassword, $role, $reg_date);

if ($stmt->execute()) {
    echo "Admin registration successful.";
} else {
    echo "Admin registration failed. Error: " . $stmt->error;
}

$stmt->close();
$dbc->close();
?>
