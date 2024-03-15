<?php
include 'connection.php';
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
    if ($conn->query($sql) === TRUE) {
    	echo '<script>alert("Employee Added Successfully!");</script>';
    	echo '<script>window.location.href = "employeees.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();

?>