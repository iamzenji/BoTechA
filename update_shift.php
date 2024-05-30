<?php
// Include database connection file
include 'includes/connection.php';

// Get the employee ID from the URL
$employee_id = $_GET['id'];

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if shift ID is provided in the form data
    if (isset($_POST['shift_id']) && is_array($_POST['shift_id']) && isset($_POST['day']) && is_array($_POST['day'])) {
        // Prepare SQL statement for updating shift details
        $sql = "UPDATE shiftdetails SET time_in = ?, break_out = ?, break_in = ?, time_out = ? WHERE shift_id = ? AND day = ?";
        $stmt = $connection->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssssis", $time_in, $break_out, $break_in, $time_out, $shift_id, $day);

        // Loop through the provided time-in, time-out, break-out, break-in, shift_id, and day values
        for ($i = 0; $i < count($_POST['shift_id']); $i++) {
            // Get time-in, time-out, break-out, break-in, shift_id, and day values for the current iteration
            $time_in = $_POST['time_in'][$i];
            $break_out = $_POST['break_out'][$i];
            $break_in = $_POST['break_in'][$i];
            $time_out = $_POST['time_out'][$i];
            $shift_id = $_POST['shift_id'][$i];
            $day = $_POST['day'][$i];

            // Execute the SQL statement
            if (!$stmt->execute()) {
                echo "Error updating shift details for $day: " . $connection->error;
            }
        }

        // Update broken schedules
        // Prepare SQL statement for updating broken shift details
        $sql_broken = "UPDATE shiftdetails SET broken_time_in = ?, broken_time_out = ?, broken_break_out = ?, broken_break_in = ? WHERE shift_id = ? AND day = ?";
        $stmt_broken = $connection->prepare($sql_broken);

        // Bind parameters for broken schedules
        $stmt_broken->bind_param("ssssis", $broken_time_in, $broken_time_out, $broken_break_out, $broken_break_in, $shift_id, $day);

        // Loop through the provided broken schedules and update them
        foreach ($_POST['broken_time_in'] as $day => $broken_time) {
            // Get broken time-in, time-out, break-out, break-in, shift_id, and day values
            $broken_time_in = implode(',', $broken_time);
            $broken_time_out = implode(',', $_POST['broken_time_out'][$day]);
            $broken_break_out = implode(',', $_POST['broken_break_out'][$day]);
            $broken_break_in = implode(',', $_POST['broken_break_in'][$day]);

            // Execute the SQL statement for broken schedules
            if (!$stmt_broken->execute()) {
                echo "Error updating broken shift details for $day: " . $connection->error;
            }
        }

        // Close prepared statements
        $stmt->close();
        $stmt_broken->close();

        // Display success message
        echo "<script>alert('Shift details updated successfully!'); window.location.href = 'shiftManager.php?id=" . $employee_id . "';</script>";
        exit; // Terminate the script to prevent further execution
    } else {
        echo "Shift ID or day is missing or not provided as an array.";
    }
} else {
    echo "Invalid request.";
}

// Close database connectionection
$connection->close();
?>