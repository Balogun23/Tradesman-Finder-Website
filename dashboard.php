<?php
session_start(); // Start or resume the session

// Function to redirect users based on their roles
function redirectDashboardBasedOnRole($role) {
    echo "Redirecting to role: $role"; //  this line is for debugging

    switch ($role) {
        case 'admin':
            header('Location: admin_dashboard.php'); // Redirect to admin dashboard
            break;
        case 'client':
            header('Location: client_dashboard.php'); // Redirect to client dashboard
            break;
        case 'tradesman':
            header('Location: tradesman_dashboard.php'); // Redirect to tradesman dashboard
            break;
        default:
            // Handle other roles or unexpected values
            header('Location: index.php'); // Redirect to a default page
            break;
    }

    exit(); // Stop further execution after redirection
}

// Check if the user is logged in and has a role
if (isset($_SESSION['role'])) {
    echo "User Role: " . $_SESSION['role']; // Output user role for debugging
    // Call the function to redirect based on user role
    redirectDashboardBasedOnRole($_SESSION['role']);
}

var_dump($_SESSION); // Output the session data for debugging
?>
