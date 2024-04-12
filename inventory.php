<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

    $query = "SELECT * FROM inventory";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $existing_items = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $key = $row['category'] . $row['brand'] . $row['type'];

            if (array_key_exists($key, $existing_items)) {
                $existing_items[$key]['qty_stock'] = $row['qty_stock'];
                $existing_items[$key]['unit_inv_qty'] = $row['unit_inv_qty'];
            } else {
                $existing_items[$key] = $row;
            }
        }
?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8">
                    <h2>Manage Inventory</h2>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="inv-color-table table">
                                <thead>
                                    <tr class="align-middle text-center">
                                        <th>Category</th>
                                        <th>Brand name</th>
                                        <th>Type</th>
                                        <th>Quantity Stock</th>
                                        <th>Unit Quantity</th>
                                        <th>Storage Location</th>
                                        <th>Showroom Quantity Stock</th>
                                        <th>Showroom Location</th>
                                        <th>Quantity to Reorder</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($existing_items as $row) {
                                    ?>
                                        <tr class="edit-row align-middle text-center" data-toggle="modal" data-target="#editModal_<?php echo $row['inventory_id']; ?>">
                                            <td><?php echo $row['category']; ?></td>
                                            <td><?php echo $row['brand']; ?></td>
                                            <td><?php echo $row['type']; ?></td>
                                            <td><?php echo $row['qty_stock'] ?></td>
                                            <td><?php echo $row['unit_inv_qty'] - $row['showroom_quantity_stock']; ?></td>
                                            <td><?php echo $row['storage_location']; ?></td>
                                            <td><?php echo $row['showroom_quantity_stock']; ?></td>
                                            <td><?php echo $row['showroom_location']; ?></td>
                                            <td><?php echo $row['quantity_to_reorder']; ?></td>
                                        </tr>
                                        <div class="modal fade" id="editModal_<?php echo $row['inventory_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel_<?php echo $row['inventory_id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="editModalLabel_<?php echo $row['inventory_id']; ?>">Edit Inventory</h5>
                                                        <button type="button" class="close close-modal-button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="update_inventory.php" method="post">
                                                            <input type="hidden" name="inventory_id" value="<?php echo $row['inventory_id']; ?>">
                                                            <div class="form-group">
                                                                <label for="qty_stock">Quantity Stock:</label>
                                                                <input type="text" class="form-control" id="qty_stock" name="qty_stock" value="<?php echo $row['qty_stock']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="unit_inv_qty">Unit Quantity:</label>
                                                                <input type="text" class="form-control" id="unit_inv_qty" name="unit_inv_qty" value="<?php echo $row['unit_inv_qty']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="storage_location">Storage Location:</label>
                                                                <input type="text" class="form-control" id="storage_location" name="storage_location" value="<?php echo $row['storage_location']; ?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="showroom_quantity_stock">Showroom Quantity Stock:</label>
                                                                <input type="text" class="form-control" id="showroom_quantity_stock" name="showroom_quantity_stock" value="<?php echo $row['showroom_quantity_stock']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="showroom_location">Showroom Location:</label>
                                                                <input type="text" class="form-control" id="showroom_location" name="showroom_location" value="<?php echo $row['showroom_location']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="quantity_to_reorder">Quantity to Reorder:</label>
                                                                <input type="text" class="form-control" id="quantity_to_reorder" name="quantity_to_reorder" value="<?php echo $row['quantity_to_reorder']; ?>">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>
<script>
    document.getElementById('toggleSearch').addEventListener('click', function() {
        var searchContainer = document.getElementById('searchContainer');
        searchContainer.style.display = (searchContainer.style.display === 'none' || searchContainer.style.display === '') ? 'block' : 'none';
    });
    document.getElementById('rowsPerPage').addEventListener('change', function() {
        var rowsPerPage = parseInt(this.value);
        var rows = document.querySelectorAll('.edit-row');

        rows.forEach(function(row) {
            row.style.display = 'none';
        });

        for (var i = 0; i < rowsPerPage; i++) {
            if (rows[i]) {
                rows[i].style.display = 'table-row';
            }
        }
    });
</script>