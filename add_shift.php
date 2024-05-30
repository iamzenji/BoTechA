<?php
// Include database connection file
include 'includes/connection.php';

if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];
}

// Retrieve other form data
$effective_date = $_POST['effective_date'];
$created_by = $_POST['created_by'];
$days = $_POST['days'];
$time_in = $_POST['time_in']; // Access as an array
$time_out = $_POST['time_out']; // Access as an array

// Prepare SQL statement for shift table (with created_date)
$sql1 = "INSERT INTO shift (effective_date, created_by, created_date, employee_id) VALUES (?, ?, NOW(), ?)";
$stmt1 = $connection->prepare($sql1);
$stmt1->bind_param("sss", $effective_date, $created_by, $employee_id);

if ($stmt1->execute()) {
    $shift_id = $connection->insert_id;  // Get the ID of the newly inserted shift

    if (!empty($days)) {
        // Prepare SQL statement for shift_details table
        $sql2 = "INSERT INTO shiftdetails (shift_id, day, time_in, time_out, employee_id) VALUES (?, ?, ?, ?, ?)";
        $stmt2 = $connection->prepare($sql2);

        foreach ($days as $index => $day) {
            // Bind each time_in and time_out value based on their index in the array
            $stmt2->bind_param("isssi", $shift_id, $day, $time_in[$index], $time_out[$index], $employee_id);
            if (!$stmt2->execute()) {
                echo "Error adding shift details for $day: " . $connection->error;
            }
        }

        echo "<script>alert('Shift details added successfully!'); window.location.href = 'shiftManager.php?id=" . $employee_id . "';</script>";

        exit; // Terminate the script to prevent further execution
    } else {
        echo "No shift details to add!";
    }
} else {
    echo "Error adding shift: " . $connection->error;
}

// Close prepared statements
$stmt1->close();
$stmt2->close();

// Close database connection
$connection->close();
