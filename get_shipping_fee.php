<?php
include 'includes/connection.php';

if (isset($_GET['supplier_id'])) {
    
    $supplierId = $_GET['supplier_id'];
        $supplierId = mysqli_real_escape_string($connection, $_GET['supplier_id']);
        $query = "SELECT shippingfee FROM supplier WHERE supplier_id = $supplierId";
    
        $result = mysqli_query($connection, $query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $shippingFee = $row['shippingfee'];
            echo $shippingFee;
        } else {
            echo "0";
        }
    } else {
        echo "Error: Supplier ID not provided.";
    }
    mysqli_close($connection);