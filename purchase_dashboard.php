<?php

// session_start();
include 'includes/connection.php';
include 'includes/header.php';

if(strlen($_SESSION['employee_id'])===0)
	{	
header('location:login.php');
session_destroy();

}
else{

?>
    <section class="home">
        <div class="text">Welcome to Purcahse Order Management System - Dashboard</div>
        <hr>
        <div class="container purchase-container">
            <div class="column">
                <div class="icons"><span class="icon material-symbols-outlined">local_shipping</span></div>
                <div>
                    <h3>Total Supplier</h3>
                    <p><?php
                        $supplier = $connection->query("SELECT * FROM supplier_list")->num_rows;
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
                        $item = $connection->query("SELECT * FROM item_list where `status` =0 ")->num_rows;
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

<?php } ?>