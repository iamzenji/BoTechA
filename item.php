<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

?>
    <div class="wrapper">
        <div class="main p-0 pt-2">
            <div class="text-left">
                <div class="container">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h2 class="mt-3">Items List</h2>
                        <button class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#addItemModal">
                            <i class="fas fa-plus"></i> Add Items
                        </button>
                    </div>
                    <ul class="nav nav-tabs mt-20" id="supplierTabs" role="tablist">
                        <?php
                        // Fetch list of suppliers from the database
                        $query = "SELECT * FROM supplier";
                        $result = mysqli_query($connection, $query);
                        $defaultSupplierId = 1; // Set the default supplier ID here

                        while ($row = mysqli_fetch_assoc($result)) {
                            $supplierId = $row['supplier_id'];
                            $supplierName = $row['name'];
                            $isActive = $supplierId == $defaultSupplierId ? 'active' : '';
                            echo "<li class='nav-item'>
                                    <a class='nav-link $isActive' id='supplierTab$supplierId' data-toggle='tab' href='#supplierContent$supplierId' role='tab' aria-controls='supplierContent$supplierId' aria-selected='false'>$supplierName</a>
                                </li>";
                        }
                        ?>
                    </ul>
                    <div class="tab-content" id="supplierTabsContent">
                        <?php
                        // Loop through each supplier to create tab content
                        mysqli_data_seek($result, 0); // Reset result pointer
                        while ($row = mysqli_fetch_assoc($result)) {
                            $supplierId = $row['supplier_id'];
                            $isActive = $supplierId == $defaultSupplierId ? 'show active' : '';
                            echo "<div class='tab-pane fade $isActive' id='supplierContent$supplierId' role='tabpanel' aria-labelledby='supplierTab$supplierId'></div>";
                        }
                        ?>
                    </div>
                </div>


                <!--insert modal-->
                <div class="modal fade insertitem" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addItemModalLabel">Add Items</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form id="addItemForm" action="item-add.php" method="post">

                                    <input type="hidden" name="id">
                                    <div class="container-fluid">
                                        <label for="name" class="control-label">Supplier</label>
                                        <select name="supplier" id="supplier" class="form-control select-tag" class="form-control rounded-0" required>
                                            <option value="" disabled selected>--Select a supplier--</option>
                                            <?php
                                            // Query to fetch supplier names--
                                            $query = "SELECT supplier_id, name FROM supplier";
                                            $query_run = mysqli_query($connection, $query);

                                            // Check if query executed successfully
                                            if ($query_run && mysqli_num_rows($query_run) > 0) {
                                                // Fetch and display supplier names as options
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
                                        <label for="name" class="control-label">Category</label>

                                        <input type="text" name="category" id="category" class="form-control rounded-0" required></input>
                                    </div>
                                    <div class="form-group">
                                        <label for="medicinename" class="control-label">Brand Name</label>
                                        <input type="text" name="brand" id="brand" class="form-control rounded-0" required></input>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="control-label">Type</label>
                                        <select name="type" id="type" class="select-tag" class="form-control rounded-0">
                                            <option value="" disabled selected>--Select a Medicine Type--</option>

                                            <?php
                                            // Query to fetch category names
                                            $query = "SELECT type_id, type_name FROM MedicineType";
                                            $query_run = mysqli_query($connection, $query);
                                            // Check if query executed successfully
                                            if ($query_run && mysqli_num_rows($query_run) > 0) {
                                                // Fetch and display category names as options
                                                while ($row = mysqli_fetch_assoc($query_run)) {
                                                    echo "<option value='" . $row["type_id"] . "'> " . $row["type_name"] . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No  found</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="control-label">Description</label>
                                        <textarea name="description" id="description" class="form-control rounded-0" cols="30" rows="2"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="unit" class="control-label">Unit</label>
                                        <input type="text" name="unit" id="unit" class="form-control rounded-0" required></input>
                                    </div>
                                    <div class="form-group">
                                        <label for="Price" class="control-label">Quantity pcs.</label>
                                        <input type="text" name="unit_qty" id="unit_qty" class="form-control rounded-0" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Price" class="control-label">Price</label>
                                        <input type="text" name="price" id="price" class="form-control rounded-0" required>
                                    </div>

                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="addItemBtn">Add</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script> -->


    <script>
        $(document).ready(function() {
            // Function to load medicine list for a specific supplier
            function loadMedicineList(supplierId) {
                $.ajax({
                    url: 'fetch_medicine_list.php', // Replace with the actual PHP script to fetch medicine list
                    method: 'GET',
                    data: {
                        supplier_id: supplierId
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#supplierContent' + supplierId).html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Load medicine list for the default supplier by default
            loadMedicineList(<?php echo $defaultSupplierId; ?>);

            // Event listener for tab change
            $('#supplierTabs a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var supplierId = $(e.target).attr('aria-controls').replace('supplierContent', '');
                loadMedicineList(supplierId);
            });
        });
    </script>

    <script>
        function openEditModal(itemId, brand, category, type, description, unit, price) {
            $('#editItemId').val(itemId);
            $('#editBrand').val(brand);
            $('#editCategory').val(category);
            $('#editType').val(type);
            $('#editDescription').val(description);
            $('#editUnit').val(unit);
            $('#editUnit_qty').val(unit_qty);
            $('#editPrice').val(price);
            $('#editItemModal').modal('show');
        }
    </script>

    <script>
        $(document).ready(function() {

            $('.deleteitem').on('click', function() {

                $('#deletemodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_id').val(data[0]);

            });
        });
    </script>
<?php } ?>