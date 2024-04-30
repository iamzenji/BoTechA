<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order List</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #f2f2f2;
            }

            /* Modal styles */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 80%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
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
                            <h2 class="me-3">Order List</h2>
                            <div>
        <a href="order-add.php" class="btn btn-primary btn-rounded">
            <i class="fas fa-plus"></i> Add Order
        </a>
        <a href="mailto:email@gmail.com" class="btn btn-primary">
        <i class="bi bi-envelope"></i>Email Receipt
        </a>
    </div>            
                  </li>
                    </ul>
                  
                    <form action="">
                        <div class="input-group d-flex mt-4">
                            <span class="input-group-text"><i class="lni lni-search-alt"></i></span>
                            <input type="search" class="form-control" placeholder="Search">
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="th">View Order</th>
                                <th class="th">Order Date</th>
                                <th class="th">Tracking Number</th>
                                <th class="th">Item</th>
                                <th class="th">Delivery Date</th>
                                <th class="th">Status</th>
                                <th class="th">Total</th>
                                <th class="th">Receipt</th>
                                <th class="th"> Update Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
include 'includes/connection.php';
$query = "SELECT cart_table.order_date, cart_table.tracking_number, cart_table.delivery_date, GROUP_CONCAT(cart_table.brand SEPARATOR ', ') AS brands, 
          GROUP_CONCAT(CONCAT(cart_table.quantity, ' ', cart_table.unit) SEPARATOR ', ') AS items, 
          order_table.grand_total, delivery_status.status_name
          FROM order_table
          INNER JOIN cart_table ON order_table.id = cart_table.order_id
          LEFT JOIN delivery_status ON cart_table.delivery_status_id = delivery_status.id
          GROUP BY cart_table.tracking_number, cart_table.delivery_date
          ORDER BY cart_table.order_time DESC"; 
$result = mysqli_query($connection, $query);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td><a href='#' class='view-order-link' data-tracking-number='" . $row['tracking_number'] . "'>View Order</a></td>";
            echo "<td>" . $row['order_date'] . "</td>";
            echo "<td>" . $row['tracking_number'] . "</td>";
            echo "<td>" . $row['brands'] . "</td>";
            echo "<td>" .$row['delivery_date'] . "</td>"; 
            echo "<td>" . $row['status_name'] . "</td>";
            echo "<td>" . $row['grand_total'] . "</td>";
            echo '<td>
                    <a href="mailto:your-email@gmail.com" class="btn btn-primary">
                        <button class="btn btn-primary downloadReceiptBtn">Download Receipt</button>
                    </a>
                  </td>';
        echo "<td>
        <form name='update_status_form' action='update_status.php' method='post'>
            <input type='hidden' name='tracking_number' value='" . $row['tracking_number'] . "'>
            <select name='status' class='form-select'>";
                if ($row['status_name'] == 'Pending') {
                    echo "<option value='To Ship'>To Ship</option>";
                    echo "<option value='Cancel'>Cancel</option>";
                } elseif ($row['status_name'] == 'To Ship') {
                    echo "<option value='To Receive'>To Receive</option>";  
                }  elseif ($row['status_name'] == 'To Receive') { 
                    echo "<option value='Order Received'>Order Received</option>";   
                } elseif ($row['status_name'] == 'Order Received') { 
                    echo "<option value='Completed'>Completed</option>"; 
                }  elseif ($row['status_name'] == 'Completed') { 
                    echo "<option value='Completed'>Completed</option>"; 
                } elseif ($row['status_name'] == 'Cancel') { 
                    echo "<option value='Cancel'>Cancel</option>"; 
                } else {
                    $status_query = "SELECT * FROM delivery_status";
                    $status_result = mysqli_query($connection, $status_query);
                    if ($status_result && mysqli_num_rows($status_result) > 0) {
                        while ($status_row = mysqli_fetch_assoc($status_result)) {
                            $selected = ($status_row['status_name'] == $row['status_name']) ? 'selected' : ''; 
                            echo "<option value='" . $status_row['status_name'] . "' $selected>" . $status_row['status_name'] . "</option>";
                        }
                    }
                }
echo       "</select>
            <button type='submit' name='updatestatus' class='btn btn-primary btn-sm'>Update</button>
        </form>
    </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No orders found</td></tr>";
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
        <!-- The Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Order Details</h3>
                <div id="orderDetails"></div>
            </div>
        </div>

        <script>
            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks on a "View Order" link
            var viewOrderLinks = document.querySelectorAll('.view-order-link');
            viewOrderLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var trackingNumber = this.getAttribute('data-tracking-number');
                    fetchOrderDetails(trackingNumber);
                });
            });

            // Fetch and display order details in the modal
            function fetchOrderDetails(trackingNumber) {
                fetch('fetch_order_details.php?tracking_number=' + trackingNumber)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("orderDetails").innerHTML = data;
                        modal.style.display = "block";
                    });
            }
        </script>
    </body>

    </html>


<?php } ?>