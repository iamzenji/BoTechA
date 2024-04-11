<?php
// Include database connection file
include 'includes/connection.php';


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve shift ID from URL parameter
    $shift_id = $_GET['shift_id'];

    // Array to store checked days
    $checked_days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

    // Insert day, time in, and time out details into the database for checked days
    foreach ($checked_days as $day) {
        if (isset($_POST[$day])) {
            $time_in = $_POST[$day . '_in'];
            $time_out = $_POST[$day . '_out'];
            $sql = "INSERT INTO shiftdetails (shift_id, day, time_in, time_out) VALUES ('$shift_id', '$day', '$time_in', '$time_out')";
            $connection->query($sql);
        }
    }

    // Shift details inserted successfully
    echo "<script>alert('Shift details added successfully.')</script>";
    echo "<script>window.location.href = 'shift_management.php';</script>";
}
