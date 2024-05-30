<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
}
?>
<div class="container mt-5">
    <div class="row">
        <h1>Dashboard</h1>
        <div class="col-md-3">
            <a href="inventory.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                    <?php $sql1 = "SELECT inventory_id from inventory";
                                $query1 = mysqli_query($connection, $sql1); 
                                $toinventory = mysqli_num_rows($query1);
                    ?>
                        <i class="lni lni-invest-monitor" style="font-size: 70px;"></i>
                        <h5 class="card-title">Stocks</h5>
                        <h5 style="font-size: 27px;" ><?php echo $toinventory;?></h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="inventory_logs.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                    <?php $sql2 = "SELECT log_id from inventory_logs";
                                $query2 = mysqli_query($connection, $sql2);                           
                                $toinventory_logs = mysqli_num_rows($query2);
                    ?>
                        <i class="lni lni-files" style="font-size: 70px;"></i>
                        <h5 class="card-title">Inventory Logs</h5>
                        <h5 style="font-size: 27px;" ><?php echo $toinventory_logs;?></h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="inventory_discount.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                    <?php $sql3 = "SELECT id from discounted_item";
                                $query3 = mysqli_query($connection, $sql3);                           
                                $todiscounted_item = mysqli_num_rows($query3);
                    ?>
                        <i class="lni lni-graph" style="font-size: 65px;"></i>
                        <h5 class="card-title">Discount</h5>
                        <h5 style="font-size: 27px;" ><?php echo $todiscounted_item;?></h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="inventory_return.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                    <?php $sql4 = "SELECT id from return_item";
                                $query4 = mysqli_query($connection, $sql4);                           
                                $toreturn_item = mysqli_num_rows($query4);
                    ?>
                        <i class="lni lni-reply" style="font-size: 65px;"></i>
                        <h5 class="card-title">Return</h5>
                        <h5 style="font-size: 27px;" ><?php echo $toreturn_item;?></h5>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>