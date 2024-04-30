<?php

include 'includes/connection.php';
session_start();
if(isset($_POST['deletedata']))
{
    $connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, 'botecha');
    $delete_id = $_POST['delete_id'];
    $query = "DELETE FROM supplier WHERE supplier_id = '$delete_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Supplier Deleted Successfully.";
        $_SESSION['message_type'] = "success";
        header("Location: supplier.php");
    }
    else
    {
        $_SESSION['message'] = "Error updating record: " . mysqli_error($connection);
        $_SESSION['message_type'] = "danger";
    }
}
