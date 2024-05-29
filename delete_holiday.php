_<?php
    include 'includes/connection.php';
    // Check if the holiday ID is provided in the URL
    if (isset($_GET['id'])) {
        // Get the holiday ID from the URL
        $holiday_id = $_GET['id'];

        // Delete the holiday from the database
        $sql_delete = "DELETE FROM holiday WHERE id = $holiday_id";

        if ($connection->query($sql_delete) === TRUE) {
            // Redirect to the holidays page after successful deletion
            header("Location: holidaymanager.php");
            exit();
        } else {
            echo "Error deleting record: " . $connection->error;
        }
    } else {
        echo "Holiday ID is missing.";
        exit();
    }

    // Close database connection
    $connection->close();
    ?>