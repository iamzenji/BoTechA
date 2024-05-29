<?php
include 'includes/connection.php';

// Check if employee ID is provided in the URL
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];
} else {
    // Handle case where employee ID is not provided
    exit('Employee ID not provided.');
}

// Get current date
$current_date = date("Y-m-d");

// Get release date from the database
$sql_release_date = "SELECT date FROM employee_salary WHERE employee_id = ?";
$stmt_release_date = $connection->prepare($sql_release_date);
$stmt_release_date->bind_param("i", $employee_id);
$stmt_release_date->execute();
$result_release_date = $stmt_release_date->get_result();
$row_release_date = $result_release_date->fetch_assoc();
$release_date = $row_release_date['date'];

// Calculate hours worked after the release date
$sql_hours_worked_after_release = "SELECT SUM(TIMESTAMPDIFF(HOUR, time_in, time_out)) AS total_hours_worked FROM dtrrevised WHERE employee_id = ? AND DATE(time_out) > ?";
$stmt_hours_worked_after_release = $connection->prepare($sql_hours_worked_after_release);
$stmt_hours_worked_after_release->bind_param("is", $employee_id, $release_date);
$stmt_hours_worked_after_release->execute();
$result_hours_worked_after_release = $stmt_hours_worked_after_release->get_result();
$row_hours_worked_after_release = $result_hours_worked_after_release->fetch_assoc();
$total_hours_worked_after_release = $row_hours_worked_after_release['total_hours_worked'];

// If total hours worked after release date is null, set it to 0
if ($total_hours_worked_after_release === null) {
    $total_hours_worked_after_release = 0;
}

// Fetch insurance, tax, and pay per hour from the database
$sql_employee_details = "SELECT insurance, tax, pay_per_hour FROM employee_salary WHERE employee_id = ?";
$stmt_employee_details = $connection->prepare($sql_employee_details);
$stmt_employee_details->bind_param("i", $employee_id);
$stmt_employee_details->execute();
$result_employee_details = $stmt_employee_details->get_result();
$row_employee_details = $result_employee_details->fetch_assoc();
$insurance = $row_employee_details['insurance'];
$tax = $row_employee_details['tax'];
$pay_per_hour = $row_employee_details['pay_per_hour'];

// Insert new record into employee_salary table with updated hours worked
$sql_insert_salary_data_after_release = "INSERT INTO employee_salary_revised (employee_id, insurance, tax, pay_per_hour, hours_worked) VALUES (?, ?, ?, ?, ?)";
$stmt_insert_salary_data_after_release = $connection->prepare($sql_insert_salary_data_after_release);
$stmt_insert_salary_data_after_release->bind_param("issii", $employee_id, $insurance, $tax, $pay_per_hour, $total_hours_worked_after_release);
$stmt_insert_salary_data_after_release->execute();

// Redirect to salary.php with the updated employee ID
header("Location: salary.php?id=" . $employee_id);
exit();

// Close prepared statements and database connectionection
$stmt_release_date->close();
$stmt_hours_worked_after_release->close();
$stmt_insert_salary_data_after_release->close();
$stmt_employee_details->close();
$connection->close();
