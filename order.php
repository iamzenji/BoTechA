<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

?>
    <div class="wrapper">
        <div class="main p-3">
            <div class="text-left">
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
                    <table class="table table-boarded table-striped">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Date Ordered</th>
                                <th>Category</th>
                                <th>Brand Name</th>
                                <th>Type</th>
                                <th>Unit</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            ?>
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php } ?>