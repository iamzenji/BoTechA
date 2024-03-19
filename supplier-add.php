<?php
include 'includes/connection.php';

$name = $_POST['name'];
$address = $_POST['address'];
$contact_person = $_POST['contact_person'];
$email = $_POST['email'];
$contact = $_POST['contact'];

$sql = "INSERT INTO supplier (name, address, contact_person, email, contact ) 
        VALUES ('$name', '$address', '$contact_person', '$email', '$contact' )";

if (mysqli_query($connection, $sql)) {
    echo "Item added successfully";
} else {

    echo "Error: " . $sql . "<br>" . mysqli_error($connection);
}
