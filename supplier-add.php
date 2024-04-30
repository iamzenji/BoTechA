<?php
include 'includes/connection.php';
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'botecha');

session_start();
if(isset($_POST['name']) && isset($_POST['address']) && isset($_POST['contact_person']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['shippingfee']) && isset($_POST['modeofpayment'])) {

    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_person = $_POST['contact_person'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $shippingfee = $_POST['shippingfee'];
    $modeofpayment = $_POST['modeofpayment'];
    $check_query = "SELECT * FROM supplier WHERE `name` = '$name' OR `email` = '$email' OR `contact_person` = '$contact_person'";
    $check_result = mysqli_query($connection, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        $_SESSION['message'] = "Supplier with the same name, email, or contact person already exists!";
        $_SESSION['message_type'] = "error";
        echo "error"; 
    } else {
        $query = "INSERT INTO supplier (`name`, `address`, `contact_person`, `email`, `contact`, `shippingfee`, `modeofpayment`) 
                  VALUES ('$name', '$address', '$contact_person', '$email', '$contact', '$shippingfee', '$modeofpayment')";

        $query_run = mysqli_query($connection, $query);
        if($query_run) {
            $_SESSION['message'] = "Supplier Added Successfully.";
            $_SESSION['message_type'] = "success";
            echo "success"; 
        } else {
            $_SESSION['message'] = "Error adding supplier! Please try again.";
            $_SESSION['message_type'] = "error";
            echo "error"; 
        }
    }
}
