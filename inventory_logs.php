<?php
include 'includes/connection.php';
include 'includes/header.php';
?>
<div class="container mt-4">
    <div class="col-md-6">
        <h2>Inventory Logs</h2>
    </div>
    <div class="row mb-2">
        <div class="col-md-6 d-flex">
            <input type="text" id="searchInput" class=" form-control" style="width: 200px;" placeholder="Search">
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <button class="btn btn-primary">Export Logs</button>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Beginning -> Ending Stock On Hand</th>
                <th>Transaction</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mar 13, 2024, 5:50pm</td>
                <td>Biogesic</td>
                <td>+1000</td>
                <td>0 -> 1000</td>
                <td>Stock Order</td>
                <td>Zenji</td>
            </tr>
            <tr>
                <td>Mar 14, 2024, 6:50pm</td>
                <td>Biogesic</td>
                <td>-10</td>
                <td>1000 -> 990</td>
                <td>Purchase Order</td>
                <td>Loi</td>
            </tr>
            <tr>
                <td>Mar 15, 2024, 7:50pm</td>
                <td>Biogesic</td>
                <td>+10</td>
                <td>990 -> 1000</td>
                <td>Purchase Return</td>
                <td>Loi</td>
            </tr>
        </tbody>
    </table>
</div>