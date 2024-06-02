<?php
session_start(); // Start the session

include 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inventory_id = $_POST['inventory_id'];
    $qty_stock = $_POST['qty_stock'];
    $unit_inv_qty = $_POST['unit_inv_qty'];
    $storage_location = $_POST['storage_location'];
    $showroom_quantity_stock = $_POST['showroom_quantity_stock'];
    $showroom_location = $_POST['showroom_location'];
    $quantity_to_reorder = $_POST['quantity_to_reorder'];

    // Previous inventory data retrieval
    $prev_inventory_query = "SELECT * FROM inventory WHERE inventory_id = '$inventory_id'";
    $prev_inventory_result = mysqli_query($connection, $prev_inventory_query);
    $prev_inventory_row = mysqli_fetch_assoc($prev_inventory_result);
    $prev_showroom_quantity_stock = $prev_inventory_row['showroom_quantity_stock'];
    $prev_unit_inv_qty = $prev_inventory_row['unit_inv_qty'];

    // Calculate the correct unit_inv_qty change
    $unit_inv_qty_change = $unit_inv_qty - $prev_unit_inv_qty;
    $corrected_unit_inv_qty = $unit_inv_qty - $showroom_quantity_stock + $prev_showroom_quantity_stock;

    // Update inventory table
    $update_query = "UPDATE inventory SET 
        qty_stock = '$qty_stock', 
        unit_inv_qty = '$corrected_unit_inv_qty',
        storage_location = '$storage_location', 
        showroom_quantity_stock = '$showroom_quantity_stock', 
        showroom_location = '$showroom_location', 
        quantity_to_reorder = '$quantity_to_reorder', 
        total_cost = $unit_inv_qty * unit_cost 
        WHERE inventory_id = '$inventory_id'";
    $update_result = mysqli_query($connection, $update_query);

    // Check if employee_id is set in the session
    if (isset($_SESSION['employee_id'])) {
        $employee_id = $_SESSION['employee_id'];
        $userName = "";
        $query = "SELECT employee_name FROM employee_details WHERE employee_id = '$employee_id'";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $userName = $row['employee_name'];
        }
    } else {
        echo "Employee ID not set in session.";
        exit; // Exit if employee_id is not set
    }

    if ($update_result) {
        // Calculate quantity changes
        $total_quantity_change = $unit_inv_qty_change + ($showroom_quantity_stock - $prev_showroom_quantity_stock);

        // Edit history of item
        $insert_query = "INSERT INTO inventory_logs (inventory_id, date, brand_name, type, unit, employee, quantity, stock_after, reason) 
            VALUES ('$inventory_id', NOW(), '{$prev_inventory_row['brand']}', '{$prev_inventory_row['type']}', '{$prev_inventory_row['unit']}', '$userName', '$total_quantity_change', '$corrected_unit_inv_qty', 'Edit Item')";
        $insert_result = mysqli_query($connection, $insert_query);

        if ($insert_result) {
            header('location:inventory.php');
            exit;
        } else {
            echo "Error inserting into inventory_logs: " . mysqli_error($connection);
        }
    } else {
        echo "Error updating inventory: " . mysqli_error($connection);
    }
}
?>
