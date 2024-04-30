<?php
include 'includes/connection.php';
include 'includes/header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report Return </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="wrapper">
        
        <div class="modal fade" id="reportreturn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-plus-lg"></i> Report Item/Return </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="returndb.php" method="POST">
                    <div class="modal-body">
                    <div class="form-group">
                            <label> Supplier </label>
                            <select name="supplier" id="supplier" class="form-control select-tag" class="form-control rounded-0" required>
                                <option value="" disabled selected>--Select a supplier--</option>
                                <?php
                                $query = "SELECT supplier_id, name FROM supplier";
                                $query_run = mysqli_query($connection, $query);
                                if ($query_run && mysqli_num_rows($query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        echo "<option value='" . $row["supplier_id"] . "'>" . $row["name"] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No suppliers found</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Order Transaction Number </label>
                            <input type="text" name="transaction_number" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> Item </label>
                            <input type="text" name="item" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> Reason for Report Item/Return</label>
                            <select name="reason_return" id="" class="form-control" require>
                            <option value="" disable>--reason for report--</option>
                            <option value="Damage Item">Damage Item</option>
                            <option value="Expired Item">Expired Item</option>
                            <option value="Missing Item">Missing Item</option>
                            
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Note</label>
                            <input type="text" name="note" id="note" class="form-control" >                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="reportreturn">Report Item/Return</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div class="container">
    <?php
if(isset($_SESSION['message'])) {
    $auto_hide_duration = 3000; 
?>
    <div id="alert_message" class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-4" role="alert" style="z-index: 9999;">
        <strong><?= $_SESSION['message']; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php 
    unset($_SESSION['message']);
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alertMessage = document.getElementById('alert_message');
            setTimeout(function() {
                alertMessage.classList.add('d-none');
            }, <?= $auto_hide_duration ?>);
        });
    </script>
<?php
}
?>
        <div class="jumbotron p-0 mt-3">
            <div class="container border-0 bg-transparent">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h2>Report Item/Return </h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reportreturn">
                    <i class="bi bi-plus-lg"></i>Report 
                    </button>
                </div>
            </div>
            <div class="container border-0 bg-transparent">
                <div class="card-body">
                    <?php
                        include 'includes/connection.php';
                            $query = "SELECT return_table.*, supplier.name AS supplier_name, delivery_status.status_name AS delivery_status_name, return_status.return_name AS return_name
                            FROM return_table
                            INNER JOIN supplier ON return_table.supplier_id = supplier.supplier_id
                            INNER JOIN delivery_status ON return_table.delivery_status_id = delivery_status.id
                            INNER JOIN return_status ON return_table.return_status_id = return_status.id";
                            $result = mysqli_query($connection, $query);
                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    echo "<table class='table'>";
                                    echo "<thead style='background-color: #f2f2f2;'>";
                                    echo "<tr>
                                            <th>Date Report</th>
                                            <th>Supplier</th>
                                            <th>Transaction Number</th>
                                            <th>Item</th>
                                            <th>Reason for Return</th>
                                            <th>Note</th>
                                            <th>Approval Status </th>
                                            <th>Action </th>
                                        </tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $supplier_name = isset($row['supplier_name']) ? $row['supplier_name'] : 'N/A';
                                        echo "<tr>";
                                        echo "<td>" . $row['created_at'] . "</td>";
                                        echo "<td>" . $supplier_name . "</td>";
                                        echo "<td>" . $row['transaction_number'] . "<br>" . $row['delivery_status_name'] . "</td>";
                                        echo "<td>" . $row['item'] . "</td>";
                                        echo "<td>" . $row['reason_return'] . "</td>";
                                        echo "<td>" . $row['Note'] . "</td>";
                                        echo "<td>" . $row['return_name'] . "</td>";
                                        echo "<td>";
                                        echo "<button type='button' id='acceptBtn_" . $row['id'] . "' class='btn btn-success btn-sm mr-1' onclick='acceptReturn(" . $row['id'] . ")'>Accept</button>";
                                        echo "<button type='button' id='declineBtn_" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='declineReturn(" . $row['id'] . ")'>Decline</button>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "No return records found.";
                                }
                            } else {
                                echo "Error: " . mysqli_error($connection);
                            }
                            mysqli_close($connection);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function acceptReturn(returnId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to accept this return request?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, accept it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: 'returndb.php',
                data: {
                    return_id: returnId,
                    status_name: 'Accepted' 
                },
                success: function(response) {
                    location.reload();
                    $('#acceptBtn_' + returnId).prop('disabled', true);
                    $('#declineBtn_' + returnId).prop('disabled', true);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error accepting return request. Please try again.');
                }
            });
        }
    });
}
function declineReturn(returnId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to decline this return request?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, decline it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: 'returndb.php',
                data: {
                    return_id: returnId,
                    status_name: 'Declined'
                },
                success: function(response) {
                    $('#acceptBtn_' + returnId).prop('disabled', true);
                    $('#declineBtn_' + returnId).prop('disabled', true);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error declining return request. Please try again.');
                }
            });
        }
    });
}
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
