<?php
include 'includes/connection.php';
include 'includes/header.php';

if (isset($_POST['updatedata'])) {
    // Retrieve form data
    $id = $_POST['update_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_person = $_POST['contact_person'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Connect to the database
    $connection = mysqli_connect("localhost", "root", "", "b");

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Update query
    $query = "UPDATE supplier SET name='$name', address='$address', contact_person='$contact_person', email='$email', contact='$contact' WHERE supplier_id='$id'";

    // Execute the query
    if (mysqli_query($connection, $query)) {
        // Redirect to the supplier list page after successful update
        header("Location: supplier.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }

    // Close connection
    mysqli_close($connection);
}
