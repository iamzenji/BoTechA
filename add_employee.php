<?php
include '../includes/connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $employeeName = $_POST['employeeName'];
    $employeePosition = $_POST['employeePosition'];
    $employeeContact = $_POST['employeeContact'];
    $employeeDate = $_POST['employeeDate'];

    // Prepare the SQL statement
    $sql = "INSERT INTO employee_details (employee_name, employee_position, employee_contact, employee_datestart) 
            VALUES ('$employeeName', '$employeePosition', '$employeeContact', '$employeeDate')";

    // Execute the SQL statement
    if ($connection->query($sql) === TRUE) {
        echo '<script>alert("Employee Added Successfully!");</script>';
        echo '<script>window.location.href = "employees.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

// Close the database connection
$connection->close();
