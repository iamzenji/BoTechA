<?php

include 'includes/connection.php';
session_start();

if(isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];
    $supplier_id = $_POST['supplier_id']; 

    $query = "DELETE FROM medicine_list WHERE medicine_id = '$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        
        if(isset($supplier_id)) {
            $_SESSION['message'] = "Item Deleted Successfully.";
            $_SESSION['message_type'] = "success";
            echo '<script>window.location.href = "supplier-list.php?supplier_id=' . $supplier_id . '";</script>'; 
        } 
    } else {
        echo '<script>alert("Failed to delete item. Please try again.");</script>';
        echo '<script>window.location.href = "supplier-list.php?supplier_id=' . $supplier_id . '";</script>'; 
    }
}