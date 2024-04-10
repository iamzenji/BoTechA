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
                                <a href="order-add.php" class="btn btn-primary btn-rounded">
                                    <i class="fas fa-plus"></i> Add Order
                                </a>
                            </li>
                        </ul>
                        <form action="">
                            <div class="input-group d-flex mt-4">
                                <span class="input-group-text"><i class="lni lni-search-alt"></i></span>
                                <input type="search" class="form-control" placeholder="Search">
                            </div>
                        </form>
                        <table>
                            <thead>
                                <tr>
                                    <th>View Order</th>
                                    <th>Tracking Number</th>
                                    <th>Item</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php


                                // Fetch distinct tracking numbers from the cart table
                                $query = "SELECT DISTINCT c.tracking_number, o.grand_total
          FROM cart c
          INNER JOIN orders o ON c.order_id = o.id";
                                $result = mysqli_query($connection, $query);

                                // Check if query executed successfully
                                if ($result) {
                                    // Output table rows for each unique tracking number
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Fetch the first item details associated with the tracking number
                                        $itemQuery = "SELECT brand, unit, type
                      FROM cart
                      WHERE tracking_number = '{$row['tracking_number']}'
                      LIMIT 1";
                                        $itemResult = mysqli_query($connection, $itemQuery);

                                        // Check if item query executed successfully
                                        if ($itemResult) {
                                            $itemRow = mysqli_fetch_assoc($itemResult);
                                            $brand = $itemRow['brand'];
                                            $unit = $itemRow['unit'];
                                            $type = $itemRow['type'];

                                            // Output table row
                                            echo "<tr>";
                                            echo "<td class='text-center'><a href='#' class='view-order-link text-decoration-none' data-tracking-number='{$row['tracking_number']}'>View Order</a></td>";
                                            echo "<td class='text-center'>{$row['tracking_number']}</td>";
                                            echo "<td class='text-center'> $brand,  $unit, $type</td>"; // Display item details
                                            echo "<td class='text-center'>{$row['grand_total']}</td>"; // Display grand total
                                            echo "</tr>";
                                        } else {
                                            // Handle the case where the item query fails
                                            echo "Error fetching item: " . mysqli_error($connection);
                                        }
                                    }
                                } else {
                                    // Handle the case where the query fails
                                    echo "Error fetching data: " . mysqli_error($connection);
                                }
                                ?>




                            </tbody>
                        </table>
                    </div>
                </div>
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