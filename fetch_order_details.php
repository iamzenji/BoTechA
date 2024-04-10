<?php
// Include database connection
include 'includes/connection.php';

// Check if tracking number is provided in the URL
if (isset($_GET['tracking_number'])) {
    // Sanitize the input to prevent SQL injection
    $trackingNumber = mysqli_real_escape_string($connection, $_GET['tracking_number']);

    // Query to fetch order details based on tracking number
    $query = "SELECT * FROM cart WHERE tracking_number = '$trackingNumber'";
    $result = mysqli_query($connection, $query);

    // Check if query executed successfully
    if ($result) {
        // Prepare the order details HTML
        $orderDetailsHTML = "<table>";
        $orderDetailsHTML .= "<thead><tr><th>Category</th><th>Brand</th><th>Type</th><th>Unit</th><th>Price</th><th>Quantity</th><th>Total</th></tr></thead>";
        $orderDetailsHTML .= "<tbody>";

        // Fetch and append each row of order details to the HTML
        while ($row = mysqli_fetch_assoc($result)) {
            $orderDetailsHTML .= "<tr>";
            $orderDetailsHTML .= "<td>{$row['category']}</td>";
            $orderDetailsHTML .= "<td>{$row['brand']}</td>";
            $orderDetailsHTML .= "<td>{$row['type']}</td>";
            $orderDetailsHTML .= "<td>{$row['unit']}</td>";
            $orderDetailsHTML .= "<td>{$row['price']}</td>";
            $orderDetailsHTML .= "<td>{$row['quantity']}</td>";
            $orderDetailsHTML .= "<td>{$row['total']}</td>";
            $orderDetailsHTML .= "</tr>";
        }

        $orderDetailsHTML .= "</tbody></table>";

        // Return the order details HTML
        echo $orderDetailsHTML;
    } else {
        // Handle the case where the query fails
        echo "Error fetching order details: " . mysqli_error($connection);
    }
} else {
    // Handle the case where tracking number is not provided
    echo "Tracking number is missing in the URL.";
}
