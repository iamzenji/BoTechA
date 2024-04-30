<?php
// fetch_order_details.php

include('includes/connection.php');

if (isset($_GET['tracking_number'])) {
    $tracking_number = $_GET['tracking_number'];

    $query = "SELECT * FROM cart_table WHERE tracking_number = '$tracking_number'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Brand</th>";
            echo "<th>Quantity</th>";
            echo "<th>Unit</th>";
            echo "<th>Wholesale Price</th>";
            echo "<th>Retail Price</th>";
            echo "<th>Total</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['brand'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['unit'] . "</td>";
                echo "<td>" . $row['wholesaleprice'] . "</td>";
                echo "<td>" . $row['unitcost'] . "</td>";
                echo "<td>" . $row['total'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No items found for this order";
        }
    } else {
        echo "Error: " . mysqli_error($connection);
    }
} else {
    echo "Tracking number not provided";
}

mysqli_close($connection);
?>