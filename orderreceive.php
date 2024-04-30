<?php
include 'includes/connection.php';
include 'includes/header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Order List</title>
    <link rel="stylesheet" href="style.css">
    <style>
       .th, .td {
           
            text-align: center;
            padding: 8px;
        }
        .th {
            background-color: #f2f2f2;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 80%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="wrapper">
    
        <div class="main p-3">
            <div class="text-center">
                <div class="container">
                    <ul class="list">
                        <li class="d-flex justify-content-between align-items-center">
                            <h2 class="me-3"> OrderReceive</h2>
                            <a href="order.php" class="btn btn-primary btn-rounded">
                            <i class="bi bi-arrow-left"></i>Back
                            </a>
                        </li>
                    </ul>
                    <form action="">
                        <div class="input-group d-flex mt-4">
                            <span class="input-group-text"><i class="lni lni-search-alt"></i></span>
                            <input type="search" class="form-control" placeholder="Search">
                        </div>
                    </form>
                    <table  style="width: 100%; border-collapse: collapse;">
                        <thead style="border: 1px solid #dee2e6; padding: 8px; ">
                            <tr>
                            <th class="th">View Order</th>
                                <th class="th">Order Date</th>
                                <th class="th">Tracking Number</th>
                                <th class="th">Item</th>
                                <th class="th">Delivery Date</th>
                              
                                <th class="th">Total</th>
                                
                            </tr>
                        </thead>
                        <tbody >
                        <?php
include 'includes/connection.php';
$query = "SELECT cart_table.order_date, cart_table.tracking_number, cart_table.brand, cart_table.quantity, cart_table.unit, cart_table.delivery_date, order_table.grand_total, delivery_status.status_name
          FROM order_table
          INNER JOIN cart_table ON order_table.id = cart_table.order_id
          LEFT JOIN  delivery_status ON cart_table.delivery_status_id = delivery_status.id
          WHERE  delivery_status.status_name = 'Order Received'
          ORDER BY cart_table.order_time DESC";

$result = mysqli_query($connection, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='td text-center'>";
            echo "<td  class='td text-center'><a href='#' class='view-order-link' data-tracking-number='" . $row['tracking_number'] . "'>View Order</a></td>";
            echo "<td  class='td text-center'>" . $row['order_date'] . "</td>";
            echo "<td  class='td text-center'>" . $row['tracking_number'] . "</td>";
            echo "<td  class='td text-center'>" . $row['brand'] . " (" . $row['quantity'] . " " . $row['unit'] . ")" . "</td>";
            echo "<td  class='td text-center'>" . $row['delivery_date']  .  "</td>";

            echo "<td  class=' td text-center'>" . $row['grand_total'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No orders found</td></tr>";
    }
} else {
    echo "Error: " . mysqli_error($connection);
}
mysqli_close($connection);
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
       <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Order Details</h3>
            <div id="orderDetails"></div>
        </div>
    </div>

    <script>
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function () {
            modal.style.display = "none";
        }
        var viewOrderLinks = document.querySelectorAll('.view-order-link');
        viewOrderLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                var trackingNumber = this.getAttribute('data-tracking-number');
                fetchOrderDetails(trackingNumber);
            });
        });
        function fetchOrderDetails(trackingNumber) {
            fetch('fetch_order_details.php?tracking_number=' + trackingNumber)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("orderDetails").innerHTML = data;
                    modal.style.display = "block";
                });
        }
    </script> 
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Order Details</h3>
            <div id="orderDetails"></div> 
        </div>
    </div>

</body>
</html>
