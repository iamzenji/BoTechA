<?php
include 'includes/connection.php';
if (isset($_POST['insertdata'])) {
    // Retrieving form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_person = $_POST['contact_person'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // SQL query to insert data into the database
    $query = "INSERT INTO supplier (`name`, `address`, `contact_person`, `email`, `contact`) 
              VALUES ('$name', '$address', '$contact_person', '$email', '$contact')";

    // Executing the query
    $query_run = mysqli_query($connection, $query);

    // Checking if data is inserted successfully
    if ($query_run) {
        // Data is successfully inserted
        echo '<script> alert("Data Saved"); </script>';
        // Redirecting to another page
        echo '<script>window.location.href = "supplier.php";</script>';
    } else {
        // Data is not inserted
        echo '<script> alert("Data Not Saved"); </script>';
        echo '<script>window.location.href = "supplier.php";</script>';
    }
}
