<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Client Dashboard</title>
</head>

<body>
    <!-- Include the header content -->
    <?php include('includes/header.php'); ?>

<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Connect to the database
    require('includes/database.php');

    // Initialize errors array
    $errors = array();

    // Check username
    if (empty($_POST['username'])) {
        $errors[] = 'Enter your username.';
    } else {
        $username = $dbc->real_escape_string(trim($_POST['username']));
    }

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

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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
        // Prepare the SQL statement
        $stmt = $dbc->prepare("INSERT INTO users (username, first_name, last_name, email, pass, role, trade, skills, professional_certification, location, hourly_rate, reg_date)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        if (!$stmt) {
            die('Error in prepare: ' . $dbc->error);
        }

        // Additional Tradesman fields
        $trade = $dbc->real_escape_string(trim($_POST['trade']));
        $skills = $dbc->real_escape_string(trim($_POST['skills']));
        $professional_certification = $dbc->real_escape_string(trim($_POST['professional_certification']));
        $location = $dbc->real_escape_string(trim($_POST['location']));
        $hourly_rate = $dbc->real_escape_string(trim($_POST['hourly_rate']));

        // Bind parameters
        $stmt->bind_param("sssssssssss", $username, $first_name, $last_name, $email, $hashed_password, $role, $trade, $skills, $professional_certification, $location, $hourly_rate);

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

        // more detailed error information
        echo '<pre>';
        var_dump($stmt);
        echo '</pre>';
    }
}

?>


<div class="registration-container" style="max-width: 400px; margin: 0 auto;">
    <form action="tradesman_registration.php" method="post" enctype="multipart/form-data" class="registration-form">
        <!-- Common fields for all actors -->
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter your username" required>
        </div>

        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" placeholder="Enter your firstname" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last name:</label>
            <input type="text" name="last_name" id="last_name" placeholder="Enter your lastname" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
        </div>

        <!-- Additional fields for Tradesman -->
        <div class="form-group">
            <label for="trade">Select Trade:</label>
            <select id="trade" name="trade" required>
                <!-- trade options as needed -->
                <option value="builder">Builder</option>
                <option value="plumber">Plumber</option>
                <option value="electrician">Electrician</option>;
                <option value="carpenter">Carpenter</option>;
                <option value="painter">Painter</option>;
                <option value="gardener">Gardener</option>;
                <option value="mechanic">Mechanic</option>;
                <option value="chef">Chef</option>;
                <option value="hairdresser">Hairdresser</option>;
                <option value="tailor">Tailor</option>;
                <option value="photographer">Photographer</option>;
                <option value="web_developer">Web Developer</option>;
                <option value="graphic_designer">Graphic Designer</option>;
                <option value="writer">Writer</option>;
                <option value="musician">Musician</option>;
                <option value="personal_trainer">Personal Trainer</option>;
                <option value="architect">Architect</option>;
                <option value="landscaper">Landscaper</option>;
                <option value="plasterer">Plasterer</option>;
                <option value="cleaner">Cleaner</option>;
                <option value="electrician">Electrician</option>;
                <option value="massage_therapist">Massage Therapist</option>;
                <option value="car_mechanic">Car Mechanic</option>;
                <option value="event_planner">Event Planner</option>;
                <option value="makeup_artist">Makeup Artist</option>;
                <option value="fitness_instructor">Fitness Instructor</option>;
                <option value="software_engineer">Software Engineer</option>;
                <option value="interior_designer">Interior Designer</option>;
                <option value="security_guard">Security Guard</option>;
                <option value="barista">Barista</option>;
                <option value="video_editor">Video Editor</option>;
                <option value="florist">Florist</option>;
                <option value="carpenter">Carpenter</option>;
                <option value="tattoo_artist">Tattoo Artist</option>;
                <option value="yoga_instructor">Yoga Instructor</option>;
                <option value="carpenter">Carpenter</option>;
                <option value="translator">Translator</option>;            
            </select>
        </div>

        <div class="form-group">
            <label for="skills">Skills:</label>
            <input type="text" name="skills" id="skills" placeholder="Enter your skills" required>
        </div>

        <div class="form-group">
            <label for="professional_certification">Professional Certifications:</label>
            <input type="text" name="professional_certification" id="professional_certification" placeholder="professional_certification">
        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" name="location" id="location" placeholder="Enter your location">
        </div>

        <div class="form-group">
            <label for="hourly_rate">Hourly Rate:</label>
            <input type="text" name="hourly_rate" id="hourly_rate" placeholder="Enter your hourly rate" required>
        </div>

        <div class="form-group">
            <label for="picture">Upload Picture:</label>
            <input type="file" name="picture" id="picture" accept="image/*">
        </div>

        <input type="hidden" name="actor" value="tradesman">

        <button type="submit">Register</button>
    </form>
</div>

<?php
include('includes/footer.php');
?>

</body>
</html>



































