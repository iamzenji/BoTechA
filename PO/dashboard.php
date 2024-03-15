<?php

session_start();
include('db_conn.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->

    <title>Document</title>
    <style>
        .welcome {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-size: 45px;
            border: 3px solid white;
            padding: 65px;
            width: 1200px;
            /* Increase width */
            height: 500px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* Creates 4 equal width columns */
            grid-gap: 10px;
            /* Adjust the gap between columns */
            background-color: transparent;
            /* Sets background color to white */
            padding: 20px;
            /* Adds padding for spacing inside the container */
        }

        .column {
            border: 1px solid black;
            /* Adds a border around each column */
            padding: 15px;
            /* Adds padding inside each column */
            background: white;
            display: flex;
            align-items: center;
            border: none;
            border-radius: 15px;
            height: 100px;
        }

        h3 {
            font-weight: normal;
        }

        .icons {
            margin-right: 15px;
            /* Adjust space between icon and text */
            margin-left: 15px;
            /* Adjust space between icon and text */
            font-size: 25px;
            background-color: blue;
            color: white;
            padding: 10px;
            border-radius: 7px;
        }
    </style>
</head>

<body>
    <?php include('nav/sidenav.php'); ?>
    <section class="home">
        <div class="text">Welcome to Purcahse Order Management System - Dashboard</div>
        <hr>
        <div class="container">
            <div class="column">
                <div class="icons"><span class="icon material-symbols-outlined">local_shipping</span></div>
                <div>
                    <h3>Total Supplier</h3>
                    <p><?php
                        $supplier = $conn->query("SELECT * FROM supplier_list")->num_rows;
                        echo number_format($supplier);
                        ?>
                        <?php ?></p>
                </div>
            </div>
            <div class="column">
                <div class="icons" style="background-color: green;"><span class="material-symbols-outlined icon">box_add</span></div>
                <div>
                    <h3>Total Items</h3>
                    <p> <?php
                        $item = $conn->query("SELECT * FROM item_list where `status` =0 ")->num_rows;
                        echo number_format($item);
                        ?></p>
                </div>
            </div>
            <div class="column">
                <div class="icons" style="background-color: blue;"><span class="material-symbols-outlined">task</span></div>
                <div>
                    <h3>Approve PO</h3>

                </div>
            </div>
            <div class="column">
                <div class="icons" style="background-color: red;"><span class="material-symbols-outlined">task</span></div>
                <div>
                    <h3>Denied PO</h3>
                </div>
            </div>
        </div>

    </section>
    <script src="script.js"></script>
</body>

</html>

<?php

?>