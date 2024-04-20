<?php
session_start();

include 'includes/connection.php';

if (isset($_POST['addDiscount'])) {

    if (
        isset($_POST['supplier']) &&
        isset($_POST['category']) &&
        isset($_POST['brand']) &&
        isset($_POST['type']) &&
        isset($_POST['value']) &&
        isset($_POST['unitQuantity'])
    ) {
        $supplier = mysqli_real_escape_string($connection, $_POST['supplier']);
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $brand = mysqli_real_escape_string($connection, $_POST['brand']);
        $type = mysqli_real_escape_string($connection, $_POST['type']);
        $value = mysqli_real_escape_string($connection, $_POST['value']);
        $unitQuantity = mysqli_real_escape_string($connection, $_POST['unitQuantity']);

        // Check if employee_id is set in the session
        if (isset($_SESSION['employee_id'])) {
            $employee_id = $_SESSION['employee_id'];

            // Get unit_inv_qty before the discount
            $select_unit_inv_qty_query = "SELECT unit_inv_qty FROM inventory WHERE supplier = ? AND category = ? AND brand = ? AND type = ?";
            $select_unit_inv_qty_stmt = mysqli_prepare($connection, $select_unit_inv_qty_query);
            mysqli_stmt_bind_param($select_unit_inv_qty_stmt, "ssss", $supplier, $category, $brand, $type);
            mysqli_stmt_execute($select_unit_inv_qty_stmt);
            mysqli_stmt_bind_result($select_unit_inv_qty_stmt, $unit_inv_qty_before);
            mysqli_stmt_fetch($select_unit_inv_qty_stmt);
            mysqli_stmt_close($select_unit_inv_qty_stmt);

            // Update inventory quantity
            $update_query = "UPDATE inventory SET unit_inv_qty = unit_inv_qty - ? WHERE supplier = ? AND category = ? AND brand = ? AND type = ?";
            $update_stmt = mysqli_prepare($connection, $update_query);
            mysqli_stmt_bind_param($update_stmt, "issss", $unitQuantity, $supplier, $category, $brand, $type);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);

            // Get unit_inv_qty after the discount
            $select_unit_inv_qty_stmt = mysqli_prepare($connection, $select_unit_inv_qty_query);
            mysqli_stmt_bind_param($select_unit_inv_qty_stmt, "ssss", $supplier, $category, $brand, $type);
            mysqli_stmt_execute($select_unit_inv_qty_stmt);
            mysqli_stmt_bind_result($select_unit_inv_qty_stmt, $unit_inv_qty_after);
            mysqli_stmt_fetch($select_unit_inv_qty_stmt);
            mysqli_stmt_close($select_unit_inv_qty_stmt);

            // Insert into discounted_item table
            $insert_discount_query = "INSERT INTO discounted_item (supplier, category, brand, type, value, unit_qty) 
                                      VALUES (?, ?, ?, ?, ?, ?)";
            $insert_discount_stmt = mysqli_prepare($connection, $insert_discount_query);
            mysqli_stmt_bind_param($insert_discount_stmt, "ssssid", $supplier, $category, $brand, $type, $value, $unitQuantity);
            mysqli_stmt_execute($insert_discount_stmt);
            mysqli_stmt_close($insert_discount_stmt);

            // Log the inventory update
            $insert_log_query = "INSERT INTO inventory_logs (inventory_id, date, brand_name, employee, quantity, stock_after, reason) 
                                VALUES (?, NOW(), ?, ?, ?, ?, 'Add Discount')";
            $insert_log_stmt = mysqli_prepare($connection, $insert_log_query);
            mysqli_stmt_bind_param($insert_log_stmt, "sssid", $category, $brand, $employee_id, $unitQuantity, $unit_inv_qty_after);
            mysqli_stmt_execute($insert_log_stmt);
            mysqli_stmt_close($insert_log_stmt);

            header("Location: inventory_discount.php");
            exit();
        } else {
            echo "Employee ID not set in session.";
        }
    } else {
        echo "Invalid POST data";
    }
}
