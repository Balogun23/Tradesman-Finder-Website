<?php include('includes/header.php'); ?>

<!-- Link to the external stylesheet for styling -->
<link rel="stylesheet" href="css/style.css">

<!-- HTML form for user login  -->
<div class="login-container">
    <section>
        <!-- Form for user login, with action pointing to the login processing script -->
        <form action="process_login.php" method="post" class="login-form">
            <!-- Username input field -->
            <div class="form-group">
                <label for="username">Username:</label>
                <!-- Input field for entering the username, with placeholder and required attribute -->
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
            </div>

            <!-- Password input field -->
            <div class="form-group">
                <label for="password">Password:</label>
                <!-- Input field for entering the password, with placeholder and required attribute -->
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <!-- Login button -->
            <div class="form-group">
                <!-- Button to submit the login form -->
                <button type="submit">Login</button>
            </div>
        </form>
    </section>
</div>

<?php include('includes/footer.php'); ?>
