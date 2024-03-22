<?php
include 'includes/connection.php';

// Check if form is submitted
if (isset($_POST['placeorder'])) {
    // Retrieve form data
    $supplier_id = $_POST['supplier_id'];
    $subtotal = $_POST['subtotal'];
    $tax = $_POST['tax'];
    $shippingfee = $_POST['shippingfee'];
    $grandtotal = $_POST['grandtotal'];

    // Insert into orders table
    $insert_order_query = "INSERT INTO orders (supplier_id, subtotal, tax, shipping_fee, grand_total) VALUES ('$supplier_id', '$subtotal', '$tax', '$shippingfee', '$grandtotal')";
    $result_order = mysqli_query($connection, $insert_order_query);

    if ($result_order) {
        // Get the order ID of the inserted order
        $order_id = mysqli_insert_id($connection);

        // Check if cart data is received
        if (isset($_POST['category']) && isset($_POST['brand']) && isset($_POST['medicinetype']) && isset($_POST['price']) && isset($_POST['unit']) && isset($_POST['qty']) && isset($_POST['total'])) {
            // Retrieve cart data
            $categories = $_POST['category'];
            $brands = $_POST['brand'];
            $types = $_POST['medicinetype'];
            $prices = $_POST['price'];
            $units = $_POST['unit'];
            $quantities = $_POST['qty'];
            $totals = $_POST['total'];

            // Loop through cart items and insert them into the database
            for ($i = 0; $i < count($categories); $i++) {
                $category = $categories[$i];
                $brand = $brands[$i];
                $type = $types[$i];
                $price = $prices[$i];
                $unit = $units[$i];
                $quantity = $quantities[$i];
                $total = $totals[$i];

                // Insert cart item into cart table
                $insert_cart_query = "INSERT INTO cart (order_id, category, brand, type, price, unit, quantity, total) VALUES ('$order_id', '$category', '$brand', '$type', '$price', '$unit', '$quantity', '$total')";
                $result_cart = mysqli_query($connection, $insert_cart_query);

                // Check if insertion was successful
                if (!$result_cart) {
                    // Handle insertion error
                    echo "Error inserting cart item: " . mysqli_error($connection);
                    // You can choose to rollback the order insertion here if needed
                }
            }

            // Redirect to a success page after all cart items are inserted
            header("Location: order.php");
            exit();
        } else {
            // Handle case where cart data is not received
            echo "Cart data not received.";
        }
    } else {
        // Handle order insertion error
        echo "Error inserting order: " . mysqli_error($connection);
    }
} else {
    // Handle cases where the form is not submitted
    echo "Form not submitted!";
}
