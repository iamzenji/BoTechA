<?php
include 'includes/connection.php';

if (isset($_POST['placeorder'])) {
    // Retrieve values from the form
    $subtotal = $_POST['subtotal'];
    $tax = $_POST['tax'];
    $shippingFee = $_POST['shippingfee'];
    $grandTotal = $_POST['grandtotal'];

    // Generate tracking number
    $trackingNumber = generateTrackingNumber();

    // Insert order details into the order table
    $query = "INSERT INTO `order` (subtotal, tax, shipping_fee, grand_total) VALUES ('$subtotal', '$tax', '$shippingFee', '$grandTotal')";
    $result = mysqli_query($connection, $query);

    // Check if order insertion was successful
    if ($result) {
        // Get the ID of the last inserted order row
        $order_id = mysqli_insert_id($connection);

        // Check if the required POST variables are set and are arrays
        if (
            isset($_POST['category']) && is_array($_POST['category']) &&
            isset($_POST['brand']) && is_array($_POST['brand']) &&
            isset($_POST['type']) && is_array($_POST['type']) &&
            isset($_POST['unit']) && is_array($_POST['unit']) &&
            isset($_POST['price']) && is_array($_POST['price']) &&
            isset($_POST['quantity']) && is_array($_POST['quantity']) &&
            isset($_POST['unitqty']) && is_array($_POST['unitqty']) &&
            isset($_POST['total']) && is_array($_POST['total'])
        ) {
            // Extract cart items from POST data
            $categories = $_POST['category'];
            $brands = $_POST['brand'];
            $types = $_POST['type'];
            $units = $_POST['unit'];
            $prices = $_POST['price'];
            $quantities = $_POST['quantity'];
            $unit_quantities = $_POST['unitqty'];
            $totals = $_POST['total'];

            // Get the count of categories to handle empty entries
            $count = count($categories);

            // Iterate through each cart item and insert into database
            for ($i = 0; $i < $count; $i++) {
                $category = mysqli_real_escape_string($connection, $categories[$i]);
                $brand = mysqli_real_escape_string($connection, $brands[$i]);
                $type = mysqli_real_escape_string($connection, $types[$i]);

                // Set unit value to a default value if it's empty at index 0
                $unit = isset($units[1]) ? mysqli_real_escape_string($connection, $units[1]) : "";

                $price = isset($prices[1]) ? mysqli_real_escape_string($connection, $prices[1]) : "";
                $quantity = mysqli_real_escape_string($connection, $quantities[$i]);
                $unit_qty = mysqli_real_escape_string($connection, $unit_quantities[$i]);
                // Set total value to a default value if it's empty at index 0
                $total = isset($totals[1]) ? mysqli_real_escape_string($connection, $totals[1]) : "";

                // Prepare the SQL query
                $query = "INSERT INTO cart (category, brand, type, unit, price, quantity, unit_qty, total, order_id, tracking_number) 
                          VALUES ('$category', '$brand', '$type', '$unit', '$price', '$quantity', '$unit_qty', '$total', '$order_id', '$trackingNumber')";


                // Execute the query and handle errors
                if (mysqli_query($connection, $query)) {
                    header("Location: order.php");
                } else {
                    echo "Error inserting cart item: " . mysqli_error($connection) . "<br>";
                }

                $query1 = "INSERT INTO inventory (category, brand, type, unit, qty_stock, unit_inv_qty) 
                VALUES ('$category', '$brand', '$type', '$unit', '$quantity', '$unit_qty')";

                // Execute the query and handle errors
                if (mysqli_query($connection, $query1)) {
                    echo "Inventory item inserted successfully.<br>";
                } else {
                    echo "Error inserting inventory item: " . mysqli_error($connection) . "<br>";
                }
            }

            // Redirect user to a thank you page or back to the form
            //header("Location: order.php");
            //exit();
        } else {
            // Handle the case where the required POST variables are not set or are not arrays
            echo "Invalid POST data";
        }
    } else {
        echo "Error inserting order: " . mysqli_error($connection);
    }
}

// Function to generate tracking number
function generateTrackingNumber()
{
    // Generate a unique tracking number (you can use any logic here)
    return "TN" . uniqid();
}
