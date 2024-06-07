<?php
session_start();

include 'includes/connection.php';

if (isset($_POST['addDiscount'])) {
    if (
        isset($_POST['supplier']) &&
        isset($_POST['category']) &&
        isset($_POST['brand']) &&
        isset($_POST['type']) &&
        isset($_POST['unit']) &&
        isset($_POST['value']) &&
        isset($_POST['unitQuantity'])
    ) {
        // Escape user inputs for security
        $supplier = mysqli_real_escape_string($connection, $_POST['supplier']);
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $brand = mysqli_real_escape_string($connection, $_POST['brand']);
        $type = mysqli_real_escape_string($connection, $_POST['type']);
        $unit = mysqli_real_escape_string($connection, $_POST['unit']);
        $value = mysqli_real_escape_string($connection, $_POST['value']);
        $unitQuantity = mysqli_real_escape_string($connection, $_POST['unitQuantity']);

        // Check if employee_id is set in the session
        if (isset($_SESSION['employee_id'])) {
            $employee_id = $_SESSION['employee_id'];
            $userName = "";
            $query = "SELECT employee_name FROM employee_details WHERE employee_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 's', $employee_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $userName);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if (!$userName) {
                // Handle the case when employee details are not found
                echo "Employee details not found.";
                exit();
            }

            $total_cost = $value * $unitQuantity;

            // Handle database operations within a try-catch block to capture errors
            try {
                // Check if the product already exists in discount
                $check_discount_query = "SELECT * FROM discounted_item WHERE supplier = ? AND category = ? AND brand = ? AND type = ? AND unit = ?";
                $check_discount_stmt = mysqli_prepare($connection, $check_discount_query);
                mysqli_stmt_bind_param($check_discount_stmt, 'sssss', $supplier, $category, $brand, $type, $unit);
                mysqli_stmt_execute($check_discount_stmt);
                $check_discount_result = mysqli_stmt_get_result($check_discount_stmt);

                if (mysqli_num_rows($check_discount_result) > 0) {
                    // Retrieve the current unit_qty from the discounted_item table
                    $prev_dis_query = "SELECT unit_qty FROM discounted_item WHERE supplier = ? AND category = ? AND brand = ? AND type = ? AND unit = ?";
                    $prev_dis_stmt = mysqli_prepare($connection, $prev_dis_query);
                    mysqli_stmt_bind_param($prev_dis_stmt, 'sssss', $supplier, $category, $brand, $type, $unit);
                    mysqli_stmt_execute($prev_dis_stmt);
                    $prev_dis_result = mysqli_stmt_get_result($prev_dis_stmt);

                    // Product exists in discount, update the quantity
                    $update_discount_query = "UPDATE discounted_item SET unit_qty = unit_qty + ?, total_cost = value * (unit_qty + ?) WHERE supplier = ? AND category = ? AND brand = ? AND type = ? AND unit = ?";
                    $update_discount_stmt = mysqli_prepare($connection, $update_discount_query);
                    mysqli_stmt_bind_param($update_discount_stmt, 'iisssss', $unitQuantity, $unitQuantity, $supplier, $category, $brand, $type, $unit);
                    if (mysqli_stmt_execute($update_discount_stmt)) {
                        echo "Discount updated successfully.<br>";
                    } else {
                        echo "Error updating discount: " . mysqli_stmt_error($update_discount_stmt) . "<br>";
                    }
                    mysqli_stmt_close($update_discount_stmt);

                    // Retrieve the updated unit_qty from the discounted_item table
                    $upd_dis_query = "SELECT unit_qty FROM discounted_item WHERE supplier = ? AND category = ? AND brand = ? AND type = ? AND unit = ?";
                    $upd_dis_stmt = mysqli_prepare($connection, $upd_dis_query);
                    mysqli_stmt_bind_param($upd_dis_stmt, 'sssss', $supplier, $category, $brand, $type, $unit);
                    mysqli_stmt_execute($upd_dis_stmt);
                    $upd_dis_result = mysqli_stmt_get_result($upd_dis_stmt);

                    // Check if the query was successful and if a row was returned
                    if ($prev_dis_result && mysqli_num_rows($prev_dis_result) > 0 && $upd_dis_result && mysqli_num_rows($upd_dis_result) > 0) {
                        $row_prev_dis_result = mysqli_fetch_assoc($prev_dis_result);
                        $row_upd_dis_result = mysqli_fetch_assoc($upd_dis_result);
                        $stock_before = $row_prev_dis_result['unit_qty'];
                        $stock_after = $row_upd_dis_result['unit_qty'];

                        // Check the stock quantity and update item label accordingly
                        if (100 < $stock_after) {
                            // Update the item label to 'High Stock'
                            $update_item_label_query = "UPDATE inventory SET item_label = 'High Stock' WHERE supplier = '$supplierName' AND category = '$category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                        } else if (100 > $stock_after  && 30 > $stock_after) {
                            // Update the item label to 'Stable'
                            $update_item_label_query = "UPDATE inventory SET item_label = 'Stable' WHERE supplier = '$supplierName' AND category = '$category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                        } else if (30 < $stock_after) {
                            // Update the item label to 'Low Stock'
                            $update_item_label_query = "UPDATE inventory SET item_label = 'Low Stock' WHERE supplier = '$supplierName' AND category = '$category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                        }

                        // Execute the update query for item_label
                        if (mysqli_query($connection, $update_item_label_query)) {
                            echo "Item label updated successfully.<br>";
                        } else {
                            echo "Error updating item label: " . mysqli_error($connection) . "<br>";
                        }

                        // Insert into inventory_logs table using the retrieved unit_qty as stock_before
                        $insert_query = "INSERT INTO inventory_logs (inventory_id, date, brand_name, type, unit, employee, quantity, stock_before, stock_after, reason) 
                                        VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?, 'Purchase order')";
                        $insert_stmt = mysqli_prepare($connection, $insert_query);
                        mysqli_stmt_bind_param($insert_stmt, 'sssssiii', $category, $brand, $type, $unit, $userName, $unitQuantity, $stock_before, $stock_after);
                        mysqli_stmt_execute($insert_stmt);
                        mysqli_stmt_close($insert_stmt);

                        if ($insert_stmt) {
                            echo "Inventory log added successfully.";
                        } else {
                            echo "Error: " . mysqli_error($connection);
                        }
                    } else {
                        echo "Error retrieving inventory details: " . mysqli_error($connection);
                    }

                    mysqli_stmt_close($prev_dis_stmt);
                    mysqli_stmt_close($upd_dis_stmt);

                } else {
                    // Product does not exist in inventory, insert new entry
                    $insert_discount_query = "INSERT INTO discounted_item (employee, supplier, category, brand, type, unit, value, unit_qty, total_cost) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $insert_discount_stmt = mysqli_prepare($connection, $insert_discount_query);
                    mysqli_stmt_bind_param($insert_discount_stmt, 'ssssssidd', $userName, $supplier, $category, $brand, $type, $unit, $value, $unitQuantity, $total_cost);
                    if (mysqli_stmt_execute($insert_discount_stmt)) {
                        echo "Discount item inserted successfully.<br>";
                    } else {
                        echo "Error inserting discount item: " . mysqli_stmt_error($insert_discount_stmt) . "<br>";
                    }
                    mysqli_stmt_close($insert_discount_stmt);

                    // Insert into inventory_logs table
                    $insert_query = "INSERT INTO inventory_logs (inventory_id, date, brand_name, type, unit, employee, quantity, stock_before, stock_after, reason) 
                                     VALUES (?, NOW(), ?, ?, ?, ?, ?, 0, ?, 'Add Discount')";
                    $insert_stmt = mysqli_prepare($connection, $insert_query);
                    mysqli_stmt_bind_param($insert_stmt, 'sssssii', $category, $brand, $type, $unit, $userName, $unitQuantity, $unitQuantity);
                    mysqli_stmt_execute($insert_stmt);
                    mysqli_stmt_close($insert_stmt);

                    // Check for successful insertion into inventory_logs
                    if (!$insert_stmt) {
                        echo "Error inserting into inventory_logs: " . mysqli_error($connection) . "<br>";
                    }
                }

                // Update inventory quantity
                $update_query = "UPDATE inventory SET unit_inv_qty = unit_inv_qty - ?, total_cost = unit_cost * unit_inv_qty WHERE supplier = ? AND category = ? AND brand = ? AND type = ? AND unit = ?";
                $update_stmt = mysqli_prepare($connection, $update_query);
                mysqli_stmt_bind_param($update_stmt, 'isssss', $unitQuantity, $supplier, $category, $brand, $type, $unit);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);

                // Check if the update was successful
                if ($update_stmt) {
                    // Redirect after successful operation
                    header("Location: inventory_discount.php");
                    exit();
                } else {
                    echo "Error updating total cost.";
                }

            } catch (Exception $e) {
                // Log the error and display a friendly message to the user
                echo "An error occurred: " . $e->getMessage();
            }
        } else {
            echo "Employee ID not set in session.";
        }
    } else {
        echo "Invalid POST data";
    }
} else {
    // Handle the case when the 'addDiscount' parameter is not set
    echo "Add discount parameter not set.";
}
?>
