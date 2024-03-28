<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

?>
    <div class="container mt-4">
        <div class="col-md-6">
            <h2>Inventory Logs</h2>
        </div>
        <div class="row mb-2">
            <div class="col-md-6 d-flex">
                <input type="text" id="searchInput" class=" form-control" style="width: 200px; height: 30px;" placeholder="Search">
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button class="btn btn-primary" style="height: 40px;">Export Logs</button>
            </div>
        </div>
        <table class="inv-color-table table-bordered">
            <thead>
                <tr>
                    <th class="bg-info">Date</th>
                    <th class="bg-info">Product</th>
                    <th class="bg-info">Employee</th>
                    <th class="bg-info">Quantity</th>
                    <th class="bg-info">Stock after</th>
                    <th class="bg-info">Transaction</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mar 13, 2024, 5:50pm</td>
                    <td>Biogesic</td>
                    <td>Zenji</td>
                    <td>+1000</td>
                    <td>0 -> 1000</td>
                    <td>Stock Order</td>
                </tr>
                <tr>
                    <td>Mar 14, 2024, 6:50pm</td>
                    <td>Biogesic</td>
                    <td>Loi</td>
                    <td>-10</td>
                    <td>1000 -> 990</td>
                    <td>Purchase Order</td>
                </tr>
                <tr>
                    <td>Mar 15, 2024, 7:50pm</td>
                    <td>Biogesic</td>
                    <td>Loi</td>
                    <td>+10</td>
                    <td>990 -> 1000</td>
                    <td>Purchase Return</td>

                </tr>

            </tbody>
        </table>
    </div>

<?php } ?>