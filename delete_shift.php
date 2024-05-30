<?php
// Include database connection file
include 'includes/connection.php';

// Check if shift ID and employee ID are provided in the URL
if (isset($_GET['id']) && isset($_GET['employee_id'])) {
    // Get shift ID and employee ID from the URL
    $shift_id = $_GET['id'];
    $employee_id = $_GET['employee_id'];

    // Prepare SQL statement for deleting shift
    $sql = "DELETE FROM shift WHERE id = ?";
    $stmt = $connection->prepare($sql);

    // Bind parameter
    $stmt->bind_param("i", $shift_id);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Close prepared statement
        $stmt->close();

        // Redirect to shift manager page after deletion
        header("Location: shiftManager.php?id=$employee_id");
        exit();
    } else {
        echo "Error deleting shift: " . $connection->error;
    }
} else {
    echo "Shift ID or employee ID is not provided in the URL.";
}

// Close database connection
$connection->close();
?>
