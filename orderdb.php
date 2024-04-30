<?php
include('includes/connection.php');

function generateTrackingNumber() {
 
    $trackingNumber = "PO-" . uniqid();
    return $trackingNumber;
}

if(isset($_POST['subtotal'])) {
   
    $supplier_id = mysqli_real_escape_string($connection, $_POST['supplier_id']);
    $payment_method = mysqli_real_escape_string($connection, $_POST['payment']);
    $subtotal = mysqli_real_escape_string($connection, $_POST['subtotal']);
    $tax = mysqli_real_escape_string($connection, $_POST['tax']);
    $shipping_fee = mysqli_real_escape_string($connection, $_POST['shippingFee']); 

    $grand_total = mysqli_real_escape_string($connection, $_POST['grandtotal']);
    $order_date = date('Y-m-d'); 
    $order_time = date('H:i:s');
    $delivery_date = date('Y-m-d', strtotime('+5 days'));


    $tracking_number = generateTrackingNumber();

 
    $order_query = "INSERT INTO order_table (subtotal, tax, shipping_fee, grand_total, payment_method, supplier_id)
                    VALUES ('$subtotal', '$tax', '$shipping_fee', '$grand_total', '$payment_method', '$supplier_id')";
    
    if(mysqli_query($connection, $order_query)) {
        $order_id = mysqli_insert_id($connection);

        if(isset($_POST['selected_medicines'])) {
            foreach($_POST['selected_medicines'] as $index => $selected_medicine) {
            
                if(isset($_POST['category_name'][$index]) && isset($_POST['brand'][$index]) && isset($_POST['wholesaleprice'][$index]) && isset($_POST['unitcost'][$index]) && isset($_POST['unit'][$index]) && isset($_POST['unit_qty'][$index]) && isset($_POST['quantity'][$index]) && isset($_POST['type'][$index])) {
                    $category_name = mysqli_real_escape_string($connection, $_POST['category_name'][$index]);
                    $brand = mysqli_real_escape_string($connection, $_POST['brand'][$index]);
                    $wholesaleprice = mysqli_real_escape_string($connection, $_POST['wholesaleprice'][$index]);
                    $unitcost = mysqli_real_escape_string($connection, $_POST['unitcost'][$index]);
                    $unit = mysqli_real_escape_string($connection, $_POST['unit'][$index]);
                    $unit_qty = mysqli_real_escape_string($connection, $_POST['unit_qty'][$index]);
                    $quantity = mysqli_real_escape_string($connection, $_POST['quantity'][$index]);
                    $total_price = (float)$wholesaleprice * (int)$quantity;

                    $type_name = mysqli_real_escape_string($connection, $_POST['type'][$index]);
                    $type_query = "SELECT type_id FROM medicinetype WHERE type_name = '$type_name'";
                    $type_result = mysqli_query($connection, $type_query);
                    $row = mysqli_fetch_assoc($type_result);
                    $type_id = $row['type_id'];

                    $cart_query = "INSERT INTO cart_table (category, brand, unit, wholesaleprice, unitcost, unit_qty, quantity, total, order_id, tracking_number, order_date, order_time, delivery_status_id, delivery_date, supplier_id, type_id)
                                VALUES ('$category_name', '$brand', '$unit', '$wholesaleprice', '$unitcost', '$unit_qty', '$quantity', '$total_price', '$order_id', '$tracking_number', '$order_date', '$order_time', 1, '$delivery_date', '$supplier_id', '$type_id')";

 
                    if (!mysqli_query($connection, $cart_query)) {
                        echo "Failed to insert item into cart: " . mysqli_error($connection);
                    }

                } else {
                    echo "Required data for item at index $index is missing.<br>";
                }
            }
            
            header("Location: order.php");
        } else {
            echo "No items added to cart";
        }

    } else {
        echo "Failed to place order: " . mysqli_error($connection);
    }
} 

mysqli_close($connection);
?>


<?php
// include 'includes/connection.php';

// if (isset($_POST['subtotal'])) {
//     // Retrieve values from the form
//     $subtotal = $_POST['subtotal'];
//     $tax = $_POST['tax'];
//     $shippingFee = $_POST['shippingfee'];
//     $grandTotal = $_POST['grandtotal'];

//     // Generate tracking number
//     $trackingNumber = generateTrackingNumber();

//     // Insert order details into the order table
//     $query = "INSERT INTO `order` (subtotal, tax, shipping_fee, grand_total) VALUES ('$subtotal', '$tax', '$shippingFee', '$grandTotal')";
//     $result = mysqli_query($connection, $query);

//     // Check if order insertion was successful
//     if ($result) {
//         // Get the ID of the last inserted order row
//         $order_id = mysqli_insert_id($connection);
//         $employee_id = $_SESSION['employee_id'];

//         // Fetch supplier name based on the supplier ID
//         $supplierId = $_POST['supplier_id'];
//         $querySupplier = "SELECT name FROM supplier WHERE supplier_id = '$supplierId'";
//         $resultSupplier = mysqli_query($connection, $querySupplier);

//         // Check if the query executed successfully and fetch the supplier name
//         if ($resultSupplier && mysqli_num_rows($resultSupplier) > 0) {  //this is for inventory to fetch the supplier
//             $supplierRow = mysqli_fetch_assoc($resultSupplier);
//             $supplierName = $supplierRow['name'];

//             // Check if the required POST variables are set and are arrays
//             if (
//                 isset($_POST['category']) && is_array($_POST['category']) &&
//                 isset($_POST['brand']) && is_array($_POST['brand']) &&
//                 isset($_POST['type']) && is_array($_POST['type']) &&
//                 isset($_POST['unit']) && is_array($_POST['unit']) &&
//                 isset($_POST['price']) && is_array($_POST['price']) &&
//                 isset($_POST['quantity']) && is_array($_POST['quantity']) &&
//                 isset($_POST['unitqty']) && is_array($_POST['unitqty']) &&
//                 isset($_POST['total']) && is_array($_POST['total'])
//             ) {
//                 // Extract cart items from POST data
//                 $categories = $_POST['category'];
//                 $brands = $_POST['brand'];
//                 $types = $_POST['type'];
//                 $units = $_POST['unit'];
//                 $prices = $_POST['price'];
//                 $quantities = $_POST['quantity'];
//                 $unit_quantities = $_POST['unitqty'];
//                 $totals = $_POST['total'];

//                 // Get the count of categories to handle empty entries
//                 $count = count($categories);

//                 // Iterate through each cart item and insert into database
//                 for ($i = 0; $i < $count; $i++) {
//                     $category = mysqli_real_escape_string($connection, $categories[$i]);
//                     $brand = mysqli_real_escape_string($connection, $brands[$i]);
//                     $type = mysqli_real_escape_string($connection, $types[$i]);

//                     // Set unit value to a default value if it's empty at index 0
//                     $unit = isset($units[1]) ? mysqli_real_escape_string($connection, $units[1]) : "";

//                     $price = isset($prices[1]) ? mysqli_real_escape_string($connection, $prices[1]) : "";
//                     $quantity = mysqli_real_escape_string($connection, $quantities[$i]);
//                     $unit_qty = mysqli_real_escape_string($connection, $unit_quantities[$i]);
//                     // Set total value to a default value if it's empty at index 0
//                     $total = isset($totals[1]) ? mysqli_real_escape_string($connection, $totals[1]) : "";

//                     // Prepare the SQL query
//                     $query = "INSERT INTO cart (category, brand, type, unit, price, quantity, unit_qty, total, order_id, tracking_number) 
//                           VALUES ('$category', '$brand', '$type', '$unit', '$price', '$quantity', '$unit_qty', '$total', '$order_id', '$trackingNumber')";

//                     // Execute the query and handle errors
//                     if (mysqli_query($connection, $query)) {
//                         header("Location: order.php");
//                     } else {
//                         echo "Error inserting cart item: " . mysqli_error($connection) . "<br>";
//                     }

//                     
//                     // -----------------------------------------------
//                     // -- THIS PART IS ADDED BY: FINANCE MANAGEMENT --

//                     // Automatic Request Budget after ordering, inserting data to finance inbox
//                     $transactNumber = random_int(1000000, 9999999);
//                     $companyName = "PO";
//                     $msgInfo = "Purchase Order Request";
//                     $totalPrice = $grandTotal;
//                     $financeinboxquery = "INSERT INTO `finance_inbox` (id, company, msginfo, cost) VALUES ('$transactNumber','$companyName', '$msgInfo', '$totalPrice')";
//                     $financeresult = mysqli_query($connection, $financeinboxquery);

//                     // Inserting data to PO inbox
//                     $financeinboxPOquery = "INSERT INTO `finance_inbox_po` (id, company, msginfo, cost) VALUES ('$transactNumber','$companyName', '$msgInfo', '$totalPrice')";
//                     $financePOresult = mysqli_query($connection, $financeinboxPOquery);

//                     // -----------------------------------------------

//                 }

//                 // Redirect user to a thank you page or back to the form
//                 header("Location: order.php");
//                 //exit();
//             } else {
//                 // Handle the case where the required POST variables are not set or are not arrays
//                 echo "Invalid POST data";
//             }
//         } else {
//             // Handle the case where the supplier name couldn't be fetched
//             echo "Error fetching supplier name";
//         }
//     } else {
//         echo "Error inserting order: " . mysqli_error($connection);
//     }
// }

// // Function to generate tracking number
// function generateTrackingNumber()
// {
//     // Generate a unique tracking number (you can use any logic here)
//     return "TN" . uniqid();
// }
