<?php
include 'includes/connection.php';

// Check if employee ID is provided in the URL
if(isset($_GET['id'])) {
    $employee_id = $_GET['id'];
} else {
    // Handle case where employee ID is not provided
    exit('Employee ID not provided.');
}

// Check if form is submitted for adding pay per hour
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_pay_per_hour"])) {
    // Get new pay per hour value from the form
    $new_pay_per_hour = $_POST["new_pay_per_hour"];

    // Insert new pay per hour value into the database
    $sql_insert = "INSERT INTO employee_salary (employee_id, pay_per_hour) VALUES (?, ?)";
    $stmt_insert = $connection->prepare($sql_insert);
    $stmt_insert->bind_param("id", $employee_id, $new_pay_per_hour);

    if ($stmt_insert->execute()) {
        // Redirect to salary.php with the updated employee ID
        header("Location: salary.php?id=" . $employee_id);
        exit();
    } else {
        echo "Error adding pay per hour: " . $connection->error;
    }

    // Close prepared statement
    $stmt_insert->close();
}

// Close database connection
$connection->close();
?>
