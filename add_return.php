<?php
session_start();

include 'includes/connection.php';

if (isset($_POST['addReturn'])) {

    if (
        isset($_POST['supplier']) &&
        isset($_POST['category']) &&
        isset($_POST['brand']) &&
        isset($_POST['type']) &&
        isset($_POST['unit']) &&
        isset($_POST['unitQuantity'])
   ) {

        $supplier = mysqli_real_escape_string($connection, $_POST['supplier']);
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $brand = mysqli_real_escape_string($connection, $_POST['brand']);
        $type = mysqli_real_escape_string($connection, $_POST['type']);
        $unit = mysqli_real_escape_string($connection, $_POST['unit']);
        $unitQuantity = mysqli_real_escape_string($connection, $_POST['unitQuantity']);

        // Check if employee_id is set in the session
        if (isset($_SESSION['employee_id'])) {

            $userName = "";
            $id = $_SESSION['employee_id'];
            $query = "SELECT employee_name FROM employee_details WHERE employee_id = '$id' ";
            $result = mysqli_query($connection, $query);
        
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $userName = $row['employee_name'];
            }

            // Insert return item
            $query = "INSERT INTO return_item (employee ,supplier, category, brand, type, unit, unit_qty) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "ssssssi", $userName, $supplier, $category, $brand, $type, $unit, $unitQuantity); // Fix: Changed 'sssi' to 'ssssi'

            if (mysqli_stmt_execute($stmt)) {
                echo "Returned item inserted successfully.<br>";
                mysqli_stmt_close($stmt);

                // Get before stock quantity
                $before_stock_query = "SELECT unit_inv_qty FROM inventory WHERE supplier = ? AND category = ? AND brand = ? AND type = ?";
                $before_stock_stmt = mysqli_prepare($connection, $before_stock_query);
                mysqli_stmt_bind_param($before_stock_stmt, "ssss", $supplier, $category, $brand, $type);
                mysqli_stmt_execute($before_stock_stmt);
                mysqli_stmt_bind_result($before_stock_stmt, $before_stock);
                mysqli_stmt_fetch($before_stock_stmt);
                mysqli_stmt_close($before_stock_stmt);

                // Update inventory quantity
                $update_query = "UPDATE inventory SET unit_inv_qty = unit_inv_qty - ? 
                WHERE supplier = ? AND category = ? AND brand = ? AND type = ?";
                $update_stmt = mysqli_prepare($connection, $update_query);
                mysqli_stmt_bind_param($update_stmt, "issss", $unitQuantity, $supplier, $category, $brand, $type); // Fix: Changed 'isss' to 'issss'
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);

                // Get current stock quantity
                $current_stock_query = "SELECT unit_inv_qty FROM inventory WHERE supplier = ? AND category = ? AND brand = ? AND type = ?";
                $current_stock_stmt = mysqli_prepare($connection, $current_stock_query);
                mysqli_stmt_bind_param($current_stock_stmt, "ssss", $supplier, $category, $brand, $type); // Fix: Changed 'sss' to 'ssss'
                mysqli_stmt_execute($current_stock_stmt);
                mysqli_stmt_bind_result($current_stock_stmt, $current_stock);
                mysqli_stmt_fetch($current_stock_stmt);
                mysqli_stmt_close($current_stock_stmt);

                // Update total cost
                $update_total_cost = "UPDATE inventory SET total_cost = $current_stock * unit_cost WHERE supplier = '$supplier' AND category = '$category' AND brand = '$brand' AND type = '$type'";
                $update_result = mysqli_query($connection, $update_total_cost);

                // Check the stock quantity and update item label accordingly
                if (100 < $current_stock) {
                    // Update the item label to 'High Stock'
                    $update_item_label_query = "UPDATE inventory SET item_label = 'High Stock' WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                } else if (100 > $current_stock  && 30 > $current_stock) {
                    // Update the item label to 'Stable'
                    $update_item_label_query = "UPDATE inventory SET item_label = 'Stable' WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                } else if (30 < $current_stock) {
                    // Update the item label to 'Low Stock'
                    $update_item_label_query = "UPDATE inventory SET item_label = 'Low Stock' WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                }

                // Execute the update query for item_label
                if (mysqli_query($connection, $update_item_label_query)) {
                    echo "Item label updated successfully.<br>";
                } else {
                    echo "Error updating item label: " . mysqli_error($connection) . "<br>";
                }
                // Log the inventory update
                $insert_query = "INSERT INTO inventory_logs (inventory_id, date, brand_name, type, unit, employee, quantity, stock_before, stock_after, reason) 
                    VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?, 'Return Item')";
                $insert_stmt = mysqli_prepare($connection, $insert_query);
                mysqli_stmt_bind_param($insert_stmt, "ssssssii", $category, $brand, $type, $unit, $userName, $unitQuantity, $before_stock, $current_stock); // Fix: Changed 'sssisi' to 'ssisi'
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
