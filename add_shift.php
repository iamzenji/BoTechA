<?php
// Include database connection file
include 'includes/connection.php';

if(isset($_GET['id'])) {
    $employee_id = $_GET['id'];
}

// Retrieve other form data
$effective_date = $_POST['effective_date'];
$created_by = $_POST['created_by'];
$days = $_POST['days'];
$time_in = $_POST['time_in']; // Access as an array
$time_out = $_POST['time_out']; // Access as an array
$break_out = $_POST['break_out']; // Access as an array for Break Out
$break_in = $_POST['break_in']; // Access as an array for Break In

// Replace empty time inputs with NULL
foreach ($time_in as $index => $time) {
    if (empty($time)) {
        $time_in[$index] = null;
    }
}
foreach ($time_out as $index => $time) {
    if (empty($time)) {
        $time_out[$index] = null;
    }
}
foreach ($break_out as $index => $time) {
    if (empty($time)) {
        $break_out[$index] = null;
    }
}
foreach ($break_in as $index => $time) {
    if (empty($time)) {
        $break_in[$index] = null;
    }
}

// Retrieve additional form data for broken times
$broken_time_in = $_POST['broken_time_in']; // Access as a multidimensional array
$broken_time_out = $_POST['broken_time_out']; // Access as a multidimensional array
$broken_break_out = $_POST['broken_break_out']; // Access as a multidimensional array
$broken_break_in = $_POST['broken_break_in']; // Access as a multidimensional array

// Replace empty broken time inputs with NULL
foreach ($broken_time_in as $index => $times) {
    foreach ($times as $key => $time) {
        if (empty($time)) {
            $broken_time_in[$index][$key] = null;
        }
    }
}
foreach ($broken_time_out as $index => $times) {
    foreach ($times as $key => $time) {
        if (empty($time)) {
            $broken_time_out[$index][$key] = null;
        }
    }
}
foreach ($broken_break_out as $index => $times) {
    foreach ($times as $key => $time) {
        if (empty($time)) {
            $broken_break_out[$index][$key] = null;
        }
    }
}
foreach ($broken_break_in as $index => $times) {
    foreach ($times as $key => $time) {
        if (empty($time)) {
            $broken_break_in[$index][$key] = null;
        }
    }
}

// Prepare SQL statement for shift table (with created_date)
$sql1 = "INSERT INTO shift (effective_date, created_by, created_date, employee_id) VALUES (?, ?, NOW(), ?)";
$stmt1 = $connection->prepare($sql1);
$stmt1->bind_param("sss", $effective_date, $created_by, $employee_id);
if ($stmt1->execute()) {
    $shift_id = $connection->insert_id;  // Get the ID of the newly inserted shift

    if (!empty($days)) {
        // Prepare SQL statement for shift_details table
        $sql2 = "INSERT INTO shiftdetails (shift_id, day, time_in, time_out, break_out, break_in, broken_time_in, broken_time_out, broken_break_out, broken_break_in, employee_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $connection->prepare($sql2);

        // Inside the loop where you insert shift details
        foreach ($days as $index => $day) {
            // Check if the shift detail already exists for the same shift ID and day
            $sql_check_duplicate = "SELECT COUNT(*) as count FROM shiftdetails WHERE shift_id = ? AND day = ?";
            $stmt_check_duplicate = $connection->prepare($sql_check_duplicate);
            $stmt_check_duplicate->bind_param("is", $shift_id, $day);
            $stmt_check_duplicate->execute();
            $result_check_duplicate = $stmt_check_duplicate->get_result();
            $row_check_duplicate = $result_check_duplicate->fetch_assoc();
            $count = $row_check_duplicate['count'];

            // If the shift detail doesn't already exist, insert it
            if ($count == 0) {
                // Bind regular times
                $stmt2->bind_param("isssssssssi", $shift_id, $day, $time_in[$index], $time_out[$index], $break_out[$index], $break_in[$index], $broken_time_in[$index][0], $broken_time_out[$index][0], $broken_break_out[$index][0], $broken_break_in[$index][0], $employee_id);
                $stmt2->execute();
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
?>  