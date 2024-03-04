<!-- search_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set the character set and viewport for better rendering on various devices -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to the external stylesheet for styling -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Set the title of the HTML page -->
    <title>Search Tradesmen</title>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <!-- Main content container -->
    <div class="content-container">
        <h1>Search for Tradesmen</h1>
        <!-- Search form with various input fields -->
        <form action="search_results.php" method="POST">
            <label for="skills">Skills:</label>
            <input type="text" name="skills" id="skills" placeholder="Enter skills">

            <label for="location">Location:</label>
            <input type="text" name="location" id="location" placeholder="Enter location">

            <label for="availability">Availability:</label>
            <!-- Dropdown for selecting availability -->
            <select name="availability" id="availability">
                <option value="immediately">Immediately</option>
                <option value="1 week">1 Week</option>
                <option value="2 weeks">2 Weeks</option>
                <option value="3 weeks">3 Weeks</option>
                <option value="4 weeks">4 Weeks</option>
                <option value="5 weeks">5 Weeks</option>
                <option value="6 weeks">6 Weeks</option>
                <option value="7 weeks">7 Weeks</option>
                <option value="8 weeks">8 Weeks</option>
            </select>

            <label for="job_nature">Job Nature:</label>
            <!-- Textarea for describing the job nature or providing additional information -->
            <textarea name="job_nature" id="job_nature" rows="4" cols="50" placeholder="Describe the job nature or provide additional information"></textarea>

            <label for="additional_info">Additional Information:</label>
            <!-- Textarea for entering any additional information -->
            <textarea name="additional_info" id="additional_info" placeholder="Enter any additional information"></textarea>

            <!-- Submit button to trigger the search -->
            <button type="submit">Search</button>
        </form>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
