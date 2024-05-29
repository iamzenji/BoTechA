<?php
include 'includes/connection.php';
include 'includes/header.php';
?>

<style>
        .notification-card {
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 1rem;
        }
        .notification-card h5 {
            margin-top: 0;
            margin-bottom: 0.5rem; 
        }
        .notification-card p {
            margin-bottom: 0.25rem; 
        }
    </style>
<body>
<div class="wrapper">
    
    <div class="main p-0 pt-2">
        <div class="text-left">
            <div class="container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <div class="container">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <h2 class="mt-3">Notification</h2>
                                </div>
                                <?php
                                $query = "SELECT * FROM inventory";
                                $result = mysqli_query($connection, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <div class="row notification-card">
                                        <div class="col-md-3">
                                            <h5>ReOrder</h5>
                                            <p><?php echo $row['supplier']; ?></p>
                                            <p><?php echo $row['category']; ?></p>
                                            <p><?php echo $row['brand']; ?></p>
                                            <p><?php echo $row['type']; ?></p>
                                            <p><?php echo $row['unit']; ?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p>Quantity Stock: <?php echo $row['qty_stock']; ?></p>
                                            <p>Unit Cost: <?php echo $row['unit_cost']; ?></p>
                                            <p>Qty to Reorder: <?php echo $row['quantity_to_reorder']; ?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p>Total Cost: <?php echo $row['total_cost']; ?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="order-add.php" class="btn btn-primary">Order Now</a>
                                        </div>
                                    </div>
                                    <div class="row notification-card">
                                        <div class="col-md-3">
                                            <h5>Return</h5>
                                            <p><?php echo $row['supplier']; ?></p>
                                            <p><?php echo $row['category']; ?></p>
                                            <p><?php echo $row['brand']; ?></p>
                                            <p><?php echo $row['unit']; ?></p>
                                            <p>Quantity: <?php echo $row['qty_stock']; ?></p>
                                            <p>Reason: Expired</p>
                                        </div>
                                        <div class="col-md-3">
                                            
                                        </div>
                                        <div class="col-md-3">
                                    
                                        </div>
                                        <div class="col-md-3">
                                            <a href="return.php" class="btn btn-danger">Report Return</a>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#itemTable').DataTable();
    });
</script>
</body>