<?php
// Include database connection file
include 'includes/connection.php';
date_default_timezone_set('Asia/Manila');

// Initialize the $employee_id variable
$employee_id = null;

// Check if employee_id is provided in the URL
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];
}

// Check if the form is submitted and the "Time In" button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["time_in"])) {
    // Get the current date
    $currentDate = date("Y-m-d");

    // Check if there is already a record for the current date
    $sql_check = "SELECT * FROM dtrrevised WHERE employee_id = ? AND date = ?";
    $stmt_check = $connection->prepare($sql_check);
    $stmt_check->bind_param("ss", $employee_id, $currentDate);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    // If there is already a record for the current date, show a message
    if ($result_check->num_rows > 0) {
        echo "<script>alert('You have already timed in today!'); window.location.href = 'dtrRevisedManager.php?id=" . $employee_id . "';</script>";
    } else {
        // Get the current time
        $currentTime = date("H:i:s");

        // Insert the current date, time, and employee_id into the database
        $sql = "INSERT INTO dtrrevised (date, time_in, employee_id) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sss", $currentDate, $currentTime, $employee_id);

        if ($stmt->execute()) {
            // Check for late remark
            $current_time = date('H:i:s');
            $sql_shift_details = "SELECT * FROM shiftdetails WHERE employee_id = ? AND day = DAYNAME(?)";
            $stmt_shift_details = $connection->prepare($sql_shift_details);
            $stmt_shift_details->bind_param("is", $employee_id, $currentDate);
            $stmt_shift_details->execute();
            $result_shift_details = $stmt_shift_details->get_result();

            // Check if shift details are found for the current date
            if ($result_shift_details->num_rows > 0) {
                $row_shift_details = $result_shift_details->fetch_assoc();
                $scheduled_time_in = $row_shift_details['time_in'];

                $diff = strtotime($current_time) - strtotime($scheduled_time_in);
                $diff_minutes = round($diff / 60);

                if ($diff_minutes > 2) {
                    $remark = "Late";
                } else {
                    $remark = "On time";
                }

                // Insert the remark into the dtrrevised table
                $sql_insert_remark = "UPDATE dtrrevised SET remarks = ? WHERE employee_id = ? AND date = ?";
                $stmt_insert_remark = $connection->prepare($sql_insert_remark);
                $stmt_insert_remark->bind_param("sss", $remark, $employee_id, $currentDate);
                $stmt_insert_remark->execute();
                $stmt_insert_remark->close();
            }

            // Redirect to dtrRevisedManager.php with the employee_id parameter
            echo "<script>alert('Time In Recorded Successfully!'); window.location.href = 'dtrRevisedManager.php?id=" . $employee_id . "';</script>";
        } else {
            echo "Error recording Time In: " . $connection->error;
        }

        // Close prepared statements
        $stmt->close();
        $stmt_check->close();
        $stmt_shift_details->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["time_out"])) {
    // Get the current date
    $currentDate = date("Y-m-d");

    // Check if there is already a record for the current date and time_out is not null
    $sql_check = "SELECT * FROM dtrrevised WHERE employee_id = ? AND date = ? AND time_out IS NOT NULL";
    $stmt_check = $connection->prepare($sql_check);
    $stmt_check->bind_param("ss", $employee_id, $currentDate);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    // If there is a record for the current date and time_out is not null, show a message
    if ($result_check->num_rows > 0) {
        echo "<script>alert('You have already timed out today!'); window.location.href = 'dtrRevisedManager.php?id=" . $employee_id . "'; </script>";
    } else {
        // Get the current time
        $currentTime = date("H:i:s");

        // Update the existing record in the database
        $sql = "UPDATE dtrrevised SET time_out = ? WHERE employee_id = ? AND date = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sss", $currentTime, $employee_id, $currentDate);

        if ($stmt->execute()) {
            // Redirect to dtrRevisedManager.php with the employee_id parameter
            echo "<script>alert('Time Out Recorded Successfully!'); window.location.href = 'dtrRevisedManager.php?id=" . $employee_id . "';</script>";
        } else {
            echo "Error recording Time Out: " . $connection->error;
        }

        // Close prepared statement
        $stmt->close();
    }

    // Close prepared statement for checking existing record
    $stmt_check->close();
}

// Close database connectionection
$connection->close();
