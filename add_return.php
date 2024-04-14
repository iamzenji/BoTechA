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

        // Check if employee_id is set in the session
        if (isset($_SESSION['employee_id'])) {
            // Insert return item
            $query = "INSERT INTO return_item (category, brand, type, unit_qty) 
                      VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "sssi", $category, $brand, $type, $unitQuantity);

            if (mysqli_stmt_execute($stmt)) {
                echo "Returned item inserted successfully.<br>";
                mysqli_stmt_close($stmt);

                // Update inventory quantity
                $update_query = "UPDATE inventory SET unit_inv_qty = unit_inv_qty + ? 
                                 WHERE category = ? AND brand = ? AND type = ?";
                $update_stmt = mysqli_prepare($connection, $update_query);
                mysqli_stmt_bind_param($update_stmt, "isss", $unitQuantity, $category, $brand, $type);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);

                // Get current stock quantity
                $current_stock_query = "SELECT unit_inv_qty FROM inventory WHERE category = ? AND brand = ? AND type = ?";
                $current_stock_stmt = mysqli_prepare($connection, $current_stock_query);
                mysqli_stmt_bind_param($current_stock_stmt, "sss", $category, $brand, $type);
                mysqli_stmt_execute($current_stock_stmt);
                mysqli_stmt_bind_result($current_stock_stmt, $current_stock);
                mysqli_stmt_fetch($current_stock_stmt);
                mysqli_stmt_close($current_stock_stmt);

                // Log the inventory update
                $insert_query = "INSERT INTO inventory_logs (inventory_id, date, brand_name, employee, quantity, stock_after, reason) 
                    VALUES (?, NOW(), ?, ?, ?, ?, 'Return Item')";
                $insert_stmt = mysqli_prepare($connection, $insert_query);
                mysqli_stmt_bind_param($insert_stmt, "ssisi", $category, $brand, $_SESSION['employee_id'], $unitQuantity, $current_stock);
                mysqli_stmt_execute($insert_stmt);
                mysqli_stmt_close($insert_stmt);

                header("Location: inventory_return.php");
                exit();
            } else {
                echo "Error inserting returned item: " . mysqli_error($connection) . "<br>";
            }
        } else {
            echo "Employee ID not set in session.";
        }
    } else {
        echo "Invalid POST data";
    }
}
