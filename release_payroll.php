<?php
// Start the session
session_start();
include 'includes/connection.php';

// Check if employee ID is provided in the URL
if(isset($_GET['id'])) {
    $employee_id = $_GET['id'];
} else {
    // Handle case where employee ID is not provided
    exit('Employee ID not provided.');
}

// Get current date
$current_date = date("Y-m-d");

// Retrieve total hours worked from session
if(isset($_SESSION['total_hours_worked'])) {
    $total_hours_worked = $_SESSION['total_hours_worked'];
} else {
    // Handle case where total hours worked is not set in session
    exit('Total hours worked not found.');
}

// Fetch data from the employee_salary table
$sql_salary = "SELECT * FROM employee_salary WHERE employee_id = ?";
$stmt_salary = $connection->prepare($sql_salary);
$stmt_salary->bind_param("i", $employee_id);
$stmt_salary->execute();
$result_salary = $stmt_salary->get_result();

// Insert the fetched data into the employee_salary_revised table
$sql_insert_revised = "INSERT INTO employee_salary_revised (employee_id, insurance, tax, pay_per_hour, hours_worked, date) VALUES (?, ?, ?, ?, ?, ?)";
$stmt_insert_revised = $connection->prepare($sql_insert_revised);

// Bind parameters and execute the statement for each row in the result set
while ($row = $result_salary->fetch_assoc()) {
    $stmt_insert_revised->bind_param("idddds", $row['employee_id'], $row['insurance'], $row['tax'], $row['pay_per_hour'], $total_hours_worked, $current_date);
    $stmt_insert_revised->execute();
}

// Close prepared statements
$stmt_salary->close();
$stmt_insert_revised->close();
$connection->close();

// Redirect to salary.php with the updated employee ID
header("Location: salary.php?id=" . $employee_id);
exit();
?>
