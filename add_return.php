<?php
session_start();

include 'includes/connection.php';

if (isset($_POST['addReturn'])) {

    if (
        isset($_POST['category']) &&
        isset($_POST['brand']) &&
        isset($_POST['type']) &&
        isset($_POST['unitQuantity'])
    ) {
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $brand = mysqli_real_escape_string($connection, $_POST['brand']);
        $type = mysqli_real_escape_string($connection, $_POST['type']);
        $unitQuantity = mysqli_real_escape_string($connection, $_POST['unitQuantity']);

        $query = "INSERT INTO return_item (category, brand, type, unit_qty) 
                  VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $category, $brand, $type, $unitQuantity);

        if (mysqli_stmt_execute($stmt)) {
            echo "Returned item inserted successfully.<br>";
            mysqli_stmt_close($stmt);

            // Update inventory quantity
            $update_query = "UPDATE inventory SET unit_inv_qty = unit_inv_qty - ? 
                             WHERE category = ? AND brand = ? AND type = ?";
            $update_stmt = mysqli_prepare($connection, $update_query);
            mysqli_stmt_bind_param($update_stmt, "isss", $unitQuantity, $category, $brand, $type);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);

            // Log the inventory update
            $insert_query = "INSERT INTO inventory_logs (inventory_id, date, brand_name, employee, quantity, stock_after, reason) 
                VALUES ('$category', NOW(), '$brand', '$employee_id', '$unitQuantity', '$unit_qty', 'Return Item')";
            $insert_result = mysqli_query($connection, $insert_query);

            header("Location: inventory_return.php");
            exit();
        } else {
            echo "Error inserting returned item: " . mysqli_error($connection) . "<br>";
        }
    } else {
        echo "Invalid POST data";
    }
}
