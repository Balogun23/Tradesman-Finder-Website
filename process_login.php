<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Include necessary files and database connection
include('includes/database.php');

// Debugging output
echo "Reached the beginning of the script.";

function redirectBasedOnRole($role) {
    echo "Redirecting to role: $role"; // Add this line for debugging
    switch ($role) {
        case 'admin':
            header('Location: admin_dashboard.php');
            break;
        case 'client':
            header('Location: client_dashboard.php');
            break;
        case 'tradesman':
            header('Location: tradesman_dashboard.php');
            break;
        default:
            // Handle other roles or unexpected values
            break;
    }

    exit();
}

// Start session
session_start();

// Assuming a form submission method (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Debugging output
    echo "User Input - Username: $username, Password: $password";

    // Validate user credentials against the database using hashed passwords
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // these lines for debugging
    echo "After executing the query.";
    var_dump($row);

    if ($row && password_verify($password, $row['pass'])) {
        // Store relevant user information in the session
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['role'] = $row['role'];

        // Debugging output
        echo "Login successful. Role: " . $row['role'];
    
        // Determine user role and redirect accordingly
        if ($row['role'] === 'admin') {
            header('Location: admin_dashboard.php');
        } elseif ($row['role'] === 'client') {
            $_SESSION['client_id'] = $row['user_id'];
            header('Location: client_dashboard.php');
        } elseif ($row['role'] === 'tradesman') {
            $_SESSION['tradesman_id'] = $row['user_id'];
            header('Location: tradesman_dashboard.php');
        } else {
            // Handle other roles or unexpected values
            echo "Invalid user role.";
        }
    
        exit();
    } else {
        // Display an error message if login fails
        echo "Invalid username or password. Please try again.";
    }
    

    $stmt->close();
}

 //Redirect to login page if accessed directly without form submission or unsuccessful login
header('Location: login.php');
exit();
?>
