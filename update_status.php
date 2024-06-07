<?php
session_start();

include 'includes/connection.php';

// Check if the form is submitted and the 'updatestatus' button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatestatus'])) {
    // Check if the tracking number and status are set in the POST request
    if (isset($_POST['tracking_number']) && isset($_POST['status'])) {
        $tracking_number = mysqli_real_escape_string($connection, $_POST['tracking_number']);
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        // Update the delivery status in the cart table
        $update_query = "UPDATE cart_table SET delivery_status_id = 
                        (SELECT id FROM delivery_status WHERE status_name = '$status') 
                        WHERE tracking_number = '$tracking_number'";

        // Prepare a SQL statement to fetch data from cart_table
        $stmt = $connection->prepare("SELECT 
            mt.type_name AS type, 
            c.Category, 
            c.brand, 
            c.unit, 
            c.unitcost, 
            c.quantity, 
            c.unit_qty, 
            c.total, 
            s.name,
            c.delivery_status_id
        FROM 
            cart_table c
        INNER JOIN 
            order_table o ON c.supplier_id = o.supplier_id 
        INNER JOIN 
            supplier s ON o.supplier_id = s.supplier_id 
        INNER JOIN 
            medicine_list ml ON c.supplier_id = ml.supplier_id 
        JOIN 
            MedicineType mt ON ml.type_id = mt.type_id
        WHERE 
            c.tracking_number = ?  
            AND c.delivery_status_id = 4");

        // Check if the statement is prepared successfully
        if ($stmt) {
            // Bind the tracking number parameter
            $stmt->bind_param("s", $tracking_number);

            // Execute the query
            if ($stmt->execute()) {
                // Bind the result to variables
                $stmt->bind_result($type, $Category, $brand, $unit, $unitcost, $quantity, $unit_qty, $total, $supplierName, $delivery_status_id);

                // Fetch the result
                $stmt->fetch();

                // Close the statement
                $stmt->close();

                // Check if delivery status ID is 4
                if ($delivery_status_id == 4) {

                    // Get the employee name from session
                    if (isset($_SESSION['employee_id'])) {
                        $employee_id = $_SESSION['employee_id'];
                        $userName = "";
                        $query = "SELECT employee_name FROM employee_details WHERE employee_id = '$employee_id' ";
                        $result = mysqli_query($connection, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $userName = $row['employee_name'];
                        }

                        // Check if the product already exists in inventory
                        $check_inventory_query = "SELECT * FROM inventory WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                        $check_inventory_result = mysqli_query($connection, $check_inventory_query);

                        $total = $unit_qty * $unitcost;

                        if (mysqli_num_rows($check_inventory_result) > 0) {

                            // Retrieve the current unit_inv_qty from the inventory table
                            $prev_inv_query = "SELECT unit_inv_qty FROM inventory WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                            $prev_inv_result = mysqli_query($connection, $prev_inv_query);

                            // Product exists in inventory, update the quantity
                            $update_inventory_query = "UPDATE inventory SET qty_stock = qty_stock + $quantity,  unit_inv_qty = unit_inv_qty + $unit_qty, total_cost = total_cost + $total WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                            if (mysqli_query($connection, $update_inventory_query)) {
                                echo "Inventory updated successfully.<br>";
                            } else {
                                echo "Error updating inventory: " . mysqli_error($connection) . "<br>";
                            }

                            // Retrieve the updated unit_inv_qty from the inventory table
                            $upd_inv_query = "SELECT unit_inv_qty FROM inventory WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                            $upd_inv_result = mysqli_query($connection, $upd_inv_query);

                            // Check if the query was successful and if a row was returned
                            if ($prev_inv_result && mysqli_num_rows($prev_inv_result) && $upd_inv_result && mysqli_num_rows($upd_inv_result)> 0) {
                                $row_prev_inv_result = mysqli_fetch_assoc($prev_inv_result);
                                $row_upd_inv_result = mysqli_fetch_assoc($upd_inv_result);
                                $stock_before = $row_prev_inv_result['unit_inv_qty'];
                                $stock_after = $row_upd_inv_result['unit_inv_qty'];

                                // Check the stock quantity and update item label accordingly
                                if (100 < $stock_after) {
                                    // Update the item label to 'High Stock'
                                    $update_item_label_query = "UPDATE inventory SET item_label = 'High Stock' WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                                } else if (100 > $stock_after  && 30 > $stock_after) {
                                    // Update the item label to 'Stable'
                                    $update_item_label_query = "UPDATE inventory SET item_label = 'Stable' WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                                } else if (30 < $stock_after) {
                                    // Update the item label to 'Low Stock'
                                    $update_item_label_query = "UPDATE inventory SET item_label = 'Low Stock' WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                                }

                                // Execute the update query for item_label
                                if (mysqli_query($connection, $update_item_label_query)) {
                                    echo "Item label updated successfully.<br>";
                                } else {
                                    echo "Error updating item label: " . mysqli_error($connection) . "<br>";
                                }

                                // Insert into inventory_logs table using the retrieved unit_inv_qty as stock_before
                                $insert_query = "INSERT INTO inventory_logs (inventory_id, date, brand_name, type, unit, employee, quantity, stock_before, stock_after, reason) 
                                                VALUES ('$Category', NOW(), '$brand', '$type', '$unit', '$userName', '$unit_qty', '$stock_before', '$stock_after', 'Purchase order')";
                                $insert_result = mysqli_query($connection, $insert_query);

                                if ($insert_result) {
                                    echo "Inventory log added successfully.";
                                } else {
                                    echo "Error: " . mysqli_error($connection);
                                }
                            } else {
                                echo "Error retrieving inventory details: " . mysqli_error($connection);
                            }
                            
                        } else {
                            // Product does not exist in inventory, insert new entry
                            $insert_inventory_query = "INSERT INTO inventory (supplier, category, brand, type, unit, qty_stock, unit_inv_qty, unit_cost, total_cost) 
                                VALUES ('$supplierName', '$Category', '$brand', '$type', '$unit', '$quantity', '$unit_qty', '$unitcost', $total)";
                            if (mysqli_query($connection, $insert_inventory_query)) {
                                echo "Inventory item inserted successfully.<br>";
                            } else {
                                echo "Error inserting inventory item: " . mysqli_error($connection) . "<br>";
                            }

                            // Check the stock quantity and update item label accordingly
                            if (100 < $unit_qty) {
                                // Update the item label to 'High Stock'
                                $update_item_label_query = "UPDATE inventory SET item_label = 'High Stock' WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                            } else if (100 > $unit_qty  && 30 > $unit_qty) {
                                // Update the item label to 'Stable'
                                $update_item_label_query = "UPDATE inventory SET item_label = 'Stable' WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                            } else if (30 < $unit_qty) {
                                // Update the item label to 'Low Stock'
                                $update_item_label_query = "UPDATE inventory SET item_label = 'Low Stock' WHERE supplier = '$supplierName' AND category = '$Category' AND brand = '$brand' AND type = '$type' AND unit = '$unit'";
                            }

                            // Execute the update query for item_label
                            if (mysqli_query($connection, $update_item_label_query)) {
                                echo "Item label updated successfully.<br>";
                            } else {
                                echo "Error updating item label: " . mysqli_error($connection) . "<br>";
                            }

                            // Insert into inventory_logs table
                            $insert_query = "INSERT INTO inventory_logs (inventory_id, date, brand_name, type, unit, employee,  quantity, stock_before, stock_after, reason) 
                            VALUES ('$Category', NOW(), '$brand', '$type', '$unit', '$userName', '$unit_qty', 0,'$unit_qty', 'Purchase order')";
                            $insert_result = mysqli_query($connection, $insert_query);

                            // Check for successful insertion into inventory_logs
                            if (!$insert_result) {
                                echo "Error inserting into inventory_logs: " . mysqli_error($connection) . "<br>";
                            }
                        }



                        // Execute the update query to update delivery status
                        if (mysqli_query($connection, $update_query)) {
                            // Redirect back to the order list page after successful update
                            header("Location: order.php");
                            exit();
                        } else {
                            // If update query fails, display error message
                            echo "Failed to update status: " . mysqli_error($connection);
                        }
                    } else {
                        echo "Employee ID not set in session.";
                    }
                } else {
                    // Execute the update query to update delivery status
                    if (mysqli_query($connection, $update_query)) {
                        // Redirect back to the order list page after successful update
                        header("Location: order.php");
                        exit();
                    } else {
                        // If update query fails, display error message
                        echo "Failed to update status: " . mysqli_error($connection);
                    }
                }
            } else {
                // If execution fails, display SQL error
                echo "Error executing query: " . $stmt->error;
            }
        } else {
            // If preparing statement fails, display SQL error
            echo "Error preparing statement: " . $connection->error;
        }
    } else {
        // If tracking number or status is not provided, display error message
        echo "Tracking number or status not provided.";
    }
} else {
    // If request method is not POST or 'updatestatus' button is not clicked, display error message
    echo "Invalid request method.";
}

// Close the database connection
mysqli_close($connection);
