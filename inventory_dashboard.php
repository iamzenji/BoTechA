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
                        <i class="lni lni-invest-monitor" style="font-size: 70px;"></i>
                        <h5 class="card-title">Stocks</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="inventory_logs.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <i class="lni lni-files" style="font-size: 70px;"></i>
                        <h5 class="card-title">Inventory Logs</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="inventory_discount.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <i class="lni lni-graph" style="font-size: 65px;"></i>
                        <h5 class="card-title">Discount</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="inventory_return.php" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <i class="lni lni-reply" style="font-size: 65px;"></i>
                        <h5 class="card-title">Return</h5>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>