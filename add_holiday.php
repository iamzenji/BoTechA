_<?php
    include 'includes/connection.php';

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $date = $_POST['date'];
        $title = $_POST['title'];
        $details = $_POST['details'];
        $offset_date = $_POST['offset_date'];

        // Prepare and execute SQL query to insert holiday
        $sql = "INSERT INTO holiday (date, title, details, offset_date) VALUES ('$date', '$title', '$details', '$offset_date')";
        if ($connection->query($sql) === TRUE) {
            // Redirect back to holiday module page after successful insertion
            header("Location: holidayManager.php");
            exit();
        } else {
            // If insertion fails, display error message
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    // Close database connection
    $connection->close();
    ?>