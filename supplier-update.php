<?php
include 'includes/connection.php';
include 'includes/header.php';

if(isset($_POST['updatedata'])) {
    $id = $_POST['update_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_person = $_POST['contact_person'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $connection = mysqli_connect("localhost", "root", "", "botecha");
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "UPDATE supplier SET name='$name', address='$address', contact_person='$contact_person', email='$email', contact='$contact' WHERE supplier_id='$id'";

    if (mysqli_query($connection, $query)) {
        $_SESSION['message'] = "Supplier Updated Successfully.";
        $_SESSION['message_type'] = "success";
        echo '<script>window.location.href = "supplier.php";</script>'; 
        exit(); 
    } else {
        $_SESSION['message'] = "Error updating record: " . mysqli_error($connection);
        $_SESSION['message_type'] = "danger";
    }
    mysqli_close($connection);
}
