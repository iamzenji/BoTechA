<?php
include('db_conn.php');
include('session_check.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lexend">
    <link rel="stylesheet" href="design/body.css">
    <title>Document</title>
</head>

<body>
    </head>

    <body>
        <?php include('nav/sidenav.php'); ?>
        <section class="home">
            <div class="text1">List of Orders</div>


            <div class="container1">
                <form action="" method="Post">


                    <ul class="list">
                        <li>
                            <h2>List of Orders</h2>
                            <a href="order-add.php" class="addorder"><i class="fas fa-plus"></i> Add Order</a>
                        </li>
                    </ul>

                    <form action="">
                        <div class="search">
                            <i class='bx bx-search'></i>
                            <input type="search" class="search-input" placeholder="Search">
                        </div>
                    </form>



                    <table>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Date Ordered</th>
                                <th>PO #</th>
                                <th>Supplier</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample data rows -->
                            <tr>
                                <td>1</td>
                                <td>2024-03-01</td>
                                <td>PO12345</td>
                                <td>Supplier A</td>
                                <td>5</td>
                                <td>$500</td>
                                <td>Completed</td>
                                <td><a href="#">View</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2024-03-02</td>
                                <td>PO67890</td>
                                <td>Supplier B</td>
                                <td>3</td>
                                <td>$300</td>
                                <td>Pending</td>

                                <td><?php echo '<a href="" class="btnedit"><button><span class="material-symbols-outlined  icons">edit</span></button></a>';
                                    echo '<a href="#" class="btndelete"><span class="material-symbols-outlined icons"> delete</span></a>'; ?></td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>

                </form>
            </div>
        </section>
        <script src="script.js"></script>

    </body>

</html>