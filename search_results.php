<!-- search_results.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Search Results</title>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="content-container">
        <h2>Search Results</h2>

        <?php
        // Include necessary files and database connection
        include('includes/database.php');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the search results
            $results = searchTradesmen($dbc);

            // Display the search results
            displaySearchResults($results, $dbc);
        } else {
            echo 'Invalid request. Please use the search form.';
        }

        // Close the database connection
        $dbc->close();

        // Function to search for tradesmen
        function searchTradesmen($dbc) {
            $skills = $dbc->real_escape_string($_POST['skills']);
            $location = $dbc->real_escape_string($_POST['location']);
            $availability = $dbc->real_escape_string($_POST['availability']);

            // Build the query dynamically based on provided search parameters
            $query = "SELECT * FROM `users` WHERE 1";

            if (!empty($skills)) {
                $query .= " AND skills LIKE '%$skills%'";
            }

            if (!empty($location)) {
                $query .= " AND location LIKE '%$location%'";
            }

            if (!empty($availability)) {
                $query .= " AND availability LIKE '%$availability%'";
            }

            // Order by professional accreditation status (assuming the column is named 'professional_accreditation')
            $query .= " ORDER BY professional_certification DESC";

            $result = $dbc->query($query);

            if ($result) {
                // Check if any rows were returned
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $results[] = $row;
                    }
                }
            }

            return $results;
        }

        // Function to display search results
        function displaySearchResults($results, $dbc) {
            if (!empty($results)) {
                foreach ($results as $row) {
                    // Check if 'user_id' and 'username' indexes exist in the $row array
                    if (isset($row['user_id']) && isset($row['username'])) {
                        // Display user list with links to detailed profiles
                        echo '<div class="tradesman-info">';
                        echo '<h3><a href="tradesman_profile.php?tradesman_id=' . $row['user_id'] . '">' . $row['username'] . '</a></h3>';
                        echo '<p>Skills: ' . $row['skills'] . '</p>';
                        echo '<p>Location: ' . $row['location'] . '</p>';
                        echo '<p>Availability: ' . $row['availability'] . '</p>';                            
                        echo '<form action="send_job_request.php" method="POST">';
                        echo '<input type="hidden" name="tradesman_id" value="' . $row['user_id'] . '">';
                        echo '<input type="hidden" name="job_nature" value="' . $dbc->real_escape_string($_POST['job_nature']) . '">';
                        echo '<input type="hidden" name="additional_info" value="' . $dbc->real_escape_string($_POST['additional_info']) . '">';
                        echo '<button type="submit">Send Job Request</button>';
                        echo '</div>';
                    } else {
                        echo 'Invalid data in the database.';
                    }
                }
            } else {
                echo 'No results found. Refine your search criteria.';
            }
        }
        ?>

    </div>
    <?php include('includes/footer.php'); ?>
</body>
</html>
