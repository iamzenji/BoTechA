<?php

include 'includes/connection.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatestatus'])) {
    // Check if the tracking number and status are set in the POST request
    if(isset($_POST['tracking_number']) && isset($_POST['status'])) {
        $tracking_number = mysqli_real_escape_string($connection, $_POST['tracking_number']);
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        // Update the delivery status in the cart table
        $update_query = "UPDATE cart_table SET delivery_status_id = 
                        (SELECT id FROM delivery_status WHERE status_name = '$status') 
                        WHERE tracking_number = '$tracking_number'";

        if(mysqli_query($connection, $update_query)) {
            // Redirect back to the order list page
            header("Location: order.php");
            exit();
        } else {
            echo "Failed to update status: " . mysqli_error($connection);
        }
    } else {
        echo "Tracking number or status not provided.";
    }
} else {
    echo "Invalid request method.";
}

mysqli_close($connection);