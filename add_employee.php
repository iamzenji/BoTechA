<?php
include 'includes/connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $employeeName = $_POST['employeeName'];
    $employeePosition = $_POST['employeePosition'];
    $employeeContact = $_POST['employeeContact'];
    $employeeDate = $_POST['employeeDate'];
    $employeeUsername = $_POST['employeeUsername'];
    $employeePassword = $_POST['employeePassword'];

    // Prepare the SQL statement
    $sql = "INSERT INTO employee_details (employee_name, employee_position, employee_contact, employee_datestart, employee_username, employee_password) 
            VALUES ('$employeeName', '$employeePosition', '$employeeContact', '$employeeDate', '$employeeUsername', '$employeePassword')";

    // Execute the SQL statement
    if ($connection->query($sql) === TRUE) {
        echo '<script>alert("Employee Added Successfully!");</script>';
        echo '<script>window.location.href = "employeees.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}
$connection->close();
