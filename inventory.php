<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

    $query = "SELECT i.*, il.stock_after
    FROM inventory i
    INNER JOIN (
        SELECT inventory_id, brand_name,MAX(date) AS latest_timestamp
        FROM inventory_logs
        GROUP BY inventory_id, brand_name
    ) latest_logs ON i.inventory_id = latest_logs.inventory_id
    INNER JOIN inventory_logs il ON latest_logs.inventory_id = il.inventory_id AND latest_logs.brand_name = i.brand AND latest_logs.latest_timestamp = il.date";

    // $query = "SELECT i.*, il.stock_after 
    //           FROM inventory_logs il
    //           JOIN inventory i";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
?>
        <div class="container mt-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>Manage Inventory</h2>
                </div>
                <!-- <div class="col-md-4 d-flex justify-content-end">
                    <button id=" yourButtonId" class="btn btn-outline-primary"><i class="fas fa-bell"></i></button>

                </div> -->
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="inv-color-table table">
                                <thead>
                                    <tr>
                                        <td colspan="13">
                                            <div class="container">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <button id="exportLogs" class="btn btn-outline-primary" style="height: 40px;">Export Inventory</button>
                                                    </div>
                                                    <div class="align-middle col-md-6">
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" class="btn btn-outline-primary" id="toggleSearch">
                                                                <i class="lni lni-search-alt"></i>
                                                            </button>
                                                            <div id="searchContainer" class="col-md-6" style="display: none;">
                                                                <div class="d-flex justify-content-end">
                                                                    <input type="text" id="searchInput" class="form-control col-md-6" style="width: 260px; height: 30px; font-size: 12px;" placeholder="Search by Category, Brand name, Type ">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </td>

                                    </tr>
                                </thead>
                                <thead>
                                    <tr class="align-middle text-center">
                                        <th>Supplier</th>
                                        <th>Category</th>
                                        <th>Brand name</th>
                                        <th>Type</th>
                                        <th>Unit</th>
                                        <th>Quantity Stock</th>
                                        <th>Unit Quantity</th>
                                        <th>Storage Location</th>
                                        <th>Showroom Quantity Stock</th>
                                        <th>Showroom Location</th>
                                        <th>Quantity to Reorder</th>
                                        <th>Total Cost</th>
                                        <th>Item Label</th>
                                        <th>Request Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr class="edit-row align-middle text-center" data-toggle="modal" data-target="#editModal_<?php echo $row['inventory_id']; ?>">
                                            <td><?php echo $row['supplier']; ?></td>
                                            <td><?php echo $row['category']; ?></td>
                                            <td><?php echo $row['brand']; ?></td>
                                            <td><?php echo $row['type']; ?></td>
                                            <td><?php echo $row['unit']; ?></td>
                                            <td><?php echo $row['qty_stock']  ?></td>
                                            <td><?php echo $row['unit_inv_qty'] - $row['showroom_quantity_stock'] . " (" . $row['unit_cost'] . "/ea)"; ?></td>
                                            <td><?php echo $row['storage_location']; ?></td>
                                            <td><?php echo $row['showroom_quantity_stock']; ?></td>
                                            <td><?php echo $row['showroom_location']; ?></td>
                                            <td><?php echo $row['quantity_to_reorder']; ?></td>
                                            <td><?php echo $row['total_cost']; ?></td>
                                            <td>
                                                <select name="item_label" class="item-label-select rounded-pill border border-primary" data-inventory-id="<?php echo $row['inventory_id']; ?>" onclick="stopPropagation(event);">
                                                    <option value="option1">High Stock</option>
                                                    <option value="option2">Low Stock</option>
                                                    <option value="option3">Fast moving</option>
                                                </select>
                                            <td>
                                                <form onsubmit="return confirmRequestOrder(event)">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill" onclick="stopPropagation(event);">Request Order</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmModalLabel">Confirm Request Order</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p id="modalBodyText"></p>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-primary" onclick="submitRequestOrder()">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Your order request has been successfully submitted.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
                                <tfoot>
                                    <tr>
                                        <td colspan="13">
                                            <div class="container pt-3">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <nav aria-label="Page navigation">
                                                            <ul class="pagination justify-content-start">
                                                                <li class="page-item disabled">
                                                                    <span class="page-link">&laquo;</span>
                                                                </li>
                                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#" aria-label="Next">
                                                                        <span aria-hidden="true">&raquo;</span>
                                                                        <span class="sr-only">Next</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex justify-content-end">
                                                            <label for="rowsPerPage" class="mr-2" style="flex-shrink: 0;">Rows per page:</label>
                                                            <select class="form-control pl-2" id="rowsPerPage" style="width: 60px;">
                                                                <option>10</option>
                                                                <option>25</option>
                                                                <option>50</option>
                                                                <option>100</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
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

    function stopPropagation(event) {
        event.stopPropagation();
    }

    function handleLabelSelection(event) {
        var select = event.target;
        var selectedOption = select.options[select.selectedIndex].value;

        // Reset border color
        select.classList.remove('border-danger');

        // Check the selected option and change border color if necessary
        if (selectedOption === 'option2') {
            select.classList.add('border-danger');
        }

        // Get the inventory ID associated with this select element
        var inventoryId = select.dataset.inventoryId;

        // Save selected label to localStorage for this specific inventory ID
        localStorage.setItem('selectedLabel_' + inventoryId, selectedOption);
    }

    // Add event listeners to each select element individually
    document.querySelectorAll('.item-label-select').forEach(function(select) {
        select.addEventListener('change', handleLabelSelection);
    });

    // Function to set the selected option when the page loads
    function setSelectedLabel() {
        document.querySelectorAll('.item-label-select').forEach(function(select) {
            var inventoryId = select.dataset.inventoryId;
            var selectedLabel = localStorage.getItem('selectedLabel_' + inventoryId);
            if (selectedLabel) {
                select.value = selectedLabel;
                // Trigger the selection change event to update border color if necessary
                handleLabelSelection({
                    target: select
                });
            }
        });
    }

    // Call the function to set the selected option when the page loads
    setSelectedLabel();

    // Function to handle search functionality
    function handleSearch() {
        var input = document.getElementById('searchInput').value.toLowerCase();
        var rows = document.querySelectorAll('.inv-color-table tbody tr');

        rows.forEach(function(row) {
            var category = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            var brand = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            var type = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

            if (category.indexOf(input) > -1 || brand.indexOf(input) > -1 || type.indexOf(input) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('searchInput').addEventListener('input', handleSearch);

    // Initial search to handle any pre-filled search input
    handleSearch();
    document.getElementById('rowsPerPage').addEventListener('change', function() {
        var rowsPerPage = parseInt(this.value);
        var rows = document.querySelectorAll('.inv-color-table tbody tr');
        var totalRows = rows.length;

        rows.forEach(function(row) {
            row.style.display = 'none';
        });

        for (var i = 0; i < rowsPerPage && i < totalRows; i++) {
            rows[i].style.display = '';
        }
    });

    document.getElementById('rowsPerPage').dispatchEvent(new Event('change'));

    function exportToCSV() {
        var rows = document.querySelectorAll('tbody tr');

        var csvData = [];

        var headerRow = [];

        document.querySelectorAll('thead th').forEach(function(header) {
            headerRow.push(header.textContent.trim());
        });

        csvData.push(headerRow.join(','));

        rows.forEach(function(row) {

            var rowData = [];

            var dateTime = row.querySelector('td:first-child').textContent.trim();
            rowData.push(dateTime);

            for (var i = 1; i < row.cells.length; i++) {
                rowData.push(row.cells[i].textContent.trim());
            }

            csvData.push(rowData.join(','));
        });

        var csvContent = csvData.join('\n');

        var blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        });

        var url = URL.createObjectURL(blob);

        var link = document.createElement("a");

        link.setAttribute("href", url);
        link.setAttribute("download", "inventory.csv");

        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);
    }

    document.getElementById('exportLogs').addEventListener('click', exportToCSV);


    function confirmRequestOrder(event) {
        var selectedRow = event.target.closest('tr');

        // Collect item details from the selected row
        var itemDetails = '';
        itemDetails += '<strong>Supplier:</strong> ' + selectedRow.cells[0].textContent.trim() + '<br>';
        itemDetails += '<strong>Category:</strong> ' + selectedRow.cells[1].textContent.trim() + '<br>';
        itemDetails += '<strong>Brand Name:</strong> ' + selectedRow.cells[2].textContent.trim() + '<br>';
        itemDetails += '<strong>Type:</strong> ' + selectedRow.cells[3].textContent.trim() + '<br>';

        document.getElementById('modalBodyText').innerHTML = itemDetails;
        $('#confirmModal').modal('show');

        return false;
    }

    function submitRequestOrder() {

        $('#confirmModal').modal('hide');
    }

    function submitRequestOrder() {
        $('#confirmModal').modal('hide');
        $('#successModal').modal('show');
    }
</script>