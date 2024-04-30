<?php
include('db_conn.php');
session_start();

if (isset($_POST['updatedata'])) {
    
    $id = $_POST['id'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $unit = $_POST['unit'];
    $wholesaleprice = $_POST['wholesaleprice'];
    $unitcost = $_POST['unitcost'];
    $supplier_id = $_POST['supplier_id']; 


    $query = "UPDATE medicine_list 
              SET category_id = '$category', brand = '$brand', type_id = '$type', description = '$description', unit = '$unit', wholesaleprice = '$wholesaleprice', unitcost = '$unitcost'
              WHERE medicine_id = '$id'";

  
    $query_run = mysqli_query($connection, $query);

  
    if ($query_run) {
     
        if(isset($supplier_id)) {
            $_SESSION['message'] = "Item Updated Successfully.";
            $_SESSION['message_type'] = "success";
            echo '<script>window.location.href = "supplier-list.php?supplier_id=' . $supplier_id . '";</script>'; 
        } else {
            echo '<script>alert("No supplier selected.");</script>';
            echo '<script>window.location.href = "supplier-list.php";</script>'; 
        }
    } else {
        echo '<script>alert("Failed to update item. Please try again.");</script>';
        echo '<script>window.location.href = "item.php";</script>'; 
    }
}