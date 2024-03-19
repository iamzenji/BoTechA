<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

?>
    <div class="wrapper">
        <div class="main p-3 pt-5">
            <div class="text-left">
                <ul class="list">
                    <li class="d-flex justify-content-between align-items-center">
                        <h2 class="mt-3">Items List</h2>
                        <button class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#addItemModal">
                            <i class="fas fa-plus"></i> Add Items
                        </button>
                    </li>
                </ul>
                <form action="">
                    <div class="search">
                        <i class='bx bx-search'></i>
                        <input type="search" class="search-input" placeholder="Search">
                    </div>
                </form>
                <table class="table table-boarded table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT ml.*, c.category_name 
                   FROM MedicineList ml
                   JOIN Category c ON ml.category_id = c.category_id";
                        $result = mysqli_query($connection, $sql);

                        // Check if query executed successfully
                        if ($result && mysqli_num_rows($result) > 0) {
                            // Output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["medicine_id"] . "</td>";
                                echo "<td>" . $row["category_name"] . "</td>";
                                echo "<td>" . $row["brand"] . "</td>";
                                echo "<td>" . $row["description"] . "</td>";
                                echo "<td>" . $row["type"] . "</td>";
                                echo "<td>" . $row["unit"] . "</td>";
                                echo "<td>" . $row["price"] . "</td>";
                                echo "<td> 
                   <a href='#' onclick='openEditModal(" . $row["medicine_id"] . ")' class='btn btn-primary icon-ud'>Edit</a>
                   <a href='delete_medicine.php?id=" . $row["medicine_id"] . "' class='btn btn-danger'>Delete</a>
                 </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No medicines found.</td></tr>";
                        }
                        ?>

                    </tbody>
                </table>

                </form>
            </div>
            <!--insert modal-->
            <div class="modal fade insertitem" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form id="addItemForm" action="item-add.php" method="post">

                                <input type="hidden" name="id">
                                <div class="container-fluid">
                                    <label for="name" class="control-label">Supplier</label>
                                    <select name="supplier" id="supplier" class="form-control select-tag" class="form-control rounded-0" required>
                                        <option value="" disabled selected>Select a supplier</option>
                                        <?php
                                        // Query to fetch supplier names
                                        $sql = "SELECT supplier_id, name FROM Supplier";
                                        $result = mysqli_query($connection, $sql);

                                        // Check if query executed successfully
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            // Fetch and display supplier names as options
                                            while ($row = mysqli_fetch_assoc($result)) {
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
                                    <select name="category" id="category" class="form-control  select-tag" class="form-control rounded-0" required>
                                        <option value="" disabled selected>Select a category</option>

                                        <?php
                                        // Query to fetch category names
                                        $sql = "SELECT category_id, category_name FROM category";
                                        $result = mysqli_query($connection, $sql);

                                        // Check if query executed successfully
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            // Fetch and display category names as options
                                            while ($row = mysqli_fetch_assoc($result)) {

                                                echo "<option value='" . $row["category_id"] . "'> " . $row["category_name"] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No categories found</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="medicinename" class="control-label">Brand Name</label>
                                    <input type="text" name="brand" id="brand" class="form-control rounded-0" required></input>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="control-label">Type</label>
                                    <select name="type" id="type" class="select-tag" class="form-control rounded-0">
                                        <option value="" disabled selected>Choose type</option>
                                        <option value="">Tablet</option>
                                        <option value="">Capsule</option>
                                        <option value="">Syrup</option>
                                        <option value="">Suppository</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="control-label">Description</label>
                                    <textarea name="description" id="description" class="form-control rounded-0" cols="30" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="unit" class="control-label">Unit</label>
                                    <input type="text" name="unit" id="unit" class="form-control rounded-0" required></input>
                                </div>
                                <div class="form-group">
                                    <label for="Price" class="control-label">Price</label>
                                    <input type="text" name="price" id="price" class="form-control rounded-0" required>
                                </div>

                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="addItemBtn">Add</button>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
    </div>

    <script>
        document.getElementById('addItemBtn').addEventListener('click', function() {

        });

        // Function to open edit supplier modal with specific supplier ID
        function openEditModal(supplierId) {

            var editModal = new bootstrap.Modal(document.getElementById('editSupplierModal'));
            editModal.show();
        }

        function openEditModal(medicineId) {
            // Fetch medicine details
            var medicineDetails = {

            };

            // Populate modal fields with medicine details
            document.getElementById('editBrand').value = medicineDetails.brand;
            // Populate other fields similarly

            // Show the edit modal
            var editModal = new bootstrap.Modal(document.getElementById('editItemModal'));
            editModal.show();
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // JavaScript to handle form submission using AJAX
        $(document).ready(function() {
            $('#addItemBtn').click(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Serialize form data
                var formData = $('#addItemForm').serialize();

                // Send AJAX request to insert_item.php
                $.ajax({
                    type: 'POST',
                    url: 'item-add.php',
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        console.log('Item added successfully');
                        // Optionally, close the modal
                        $('#addItemModal').modal('hide');
                        // Reload the page to update the item list
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script src="script.js"></script>


<?php } ?>