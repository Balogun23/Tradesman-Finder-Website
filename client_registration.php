<?php
// Include header
include('includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Connect to the database
    require('includes/database.php');

    // Initialize errors array
    $errors = array();

    // Check first name
    if (empty($_POST['first_name'])) {
        $errors[] = 'Enter your first name.';
    } else {
        $first_name = $dbc->real_escape_string(trim($_POST['first_name']));
    }

    // Check last name
    if (empty($_POST['last_name'])) {
        $errors[] = 'Enter your last name.';
    } else {
        $last_name = $dbc->real_escape_string(trim($_POST['last_name']));
    }

    // Check username
    if (empty($_POST['username'])) {
        $errors[] = 'Enter your username.';
    } else {
        $username = $dbc->real_escape_string(trim($_POST['username']));
    }

    // Check email
    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address.';
    } else {
        $email = $dbc->real_escape_string(trim($_POST['email']));
    }

    // Check password
    if (empty($_POST['password'])) {
        $errors[] = 'Enter your password.';
    } else {
        $password = $dbc->real_escape_string(trim($_POST['password']));
    }

    // Check if email is already registered
    $q = "SELECT user_id FROM users WHERE email='$email'";
    $r = $dbc->query($q);
    $rowcount = $r->num_rows;
    if ($rowcount != 0) {
        $errors[] = 'Email address already registered. <a href="login.php">Login</a>';
    }

    // If no errors, insert user record into the database
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $dbc->prepare("INSERT INTO users (first_name, last_name, username, email, pass, role, reg_date) 
                              VALUES (?, ?, ?, ?, ?, 'client', NOW())");

        if (!$stmt) {
            die('Error in prepare: ' . $dbc->error);
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sssss", $first_name, $last_name, $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            echo '<h1>Registered!</h1>
                  <p>You are now registered.</p>
                  <p><a href="login.php">Login</a></p>';
            $stmt->close();
            $dbc->close();
            include('includes/footer.php');
        } else {
            $errors[] = 'Registration failed. Please try again later.';
            error_log('Registration failed: ' . $stmt->error); // Log the database error

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
?>

<!-- Display body section with sticky form. -->
<div class="registration-container">
    <form action="client_registration.php" method="post" class="form-signin" role="form">
    <h2 class="form-signin-heading">Create an Account (Client)</h2>
    <input type="text" name="first_name" size="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" placeholder="First Name">
    <input type="text" name="last_name" size="20" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" placeholder="Last Name"> 
    <input type="text" name="username" size="20" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" placeholder="Username"> 
    <input type="text" name="email" size="50" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Email Address">
    <input type="password" name="password" size="20" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" placeholder="Password">
    <p><button class="btn btn-primary" name="submit" type="submit">Register</button></p>
</form>
</div>

</body>
</html>

<?php
// Include footer
include('includes/footer.php');
?>
