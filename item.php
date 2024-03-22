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
                    <div class="jumbotron p-0 mt-3">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <h2 class="mt-3">Items List</h2>
                                <button class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                    <i class="fas fa-plus"></i> Add Items
                                </button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-strippped  custom-datatable table-bordered text-center balanced-table">
                                    <thead class="bg-primary text-white">
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
                                        $connection = mysqli_connect("localhost", "root", "");
                                        $db = mysqli_select_db($connection, 'botecha');
                                        $query = "SELECT ml.*, c.category_name, mt.type_name
            FROM medicine_list ml
            JOIN category c ON ml.category_id = c.category_id
            JOIN MedicineType mt ON ml.type_id = mt.type_id";
                                        $query_run = mysqli_query($connection, $query);
                                        // Check if query executed successfully
                                        if ($query_run && mysqli_num_rows($query_run) > 0) {
                                            // Output data of each row
                                            while ($row = mysqli_fetch_assoc($query_run)) {
                                                echo "<tr>";
                                                echo "<td>" . $row["medicine_id"] . "</td>";
                                                echo "<td>" . $row["category_name"] . "</td>";
                                                echo "<td>" . $row["brand"] . "</td>";
                                                echo "<td>" . $row["description"] . "</td>";
                                                echo "<td>" . $row["type_name"] . "</td>";
                                                echo "<td>" . $row["unit"] . "</td>";
                                                echo "<td>" . $row["price"] . "</td>";
                                                echo "<td> 
            <div class='dropdown'>
            <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton" . $row["medicine_id"] . "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                Actions
            </button>
            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton" . $row["medicine_id"] . "' style='min-width: 90px;'>";
                                                echo "<a class='dropdown-item text-success' href='#' onclick='openEditModal(" . $row["medicine_id"] . ")'><i class='bi bi-pencil-fill mr-2'></i>Edit</a>";
                                                echo "<a class='dropdown-item  text-danger' href='delete_medicine.php?id=" . $row["medicine_id"] . "'><i class='bi bi-trash3-fill mr-2'></i>Delete</a>";
                                                echo "</div>
        </div>
            </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>No medicines found.</td></tr>";
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                </form>
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
                                    <select name="category" id="category" class="form-control  select-tag" class="form-control rounded-0" required>
                                        <option value="" disabled selected>--Select a category--</option>

                                        <?php
                                        // Query to fetch category names
                                        $query = "SELECT category_id, category_name FROM category";
                                        $query_run = mysqli_query($connection, $query);
                                        // Check if query executed successfully
                                        if ($query_run && mysqli_num_rows($query_run) > 0) {
                                            // Fetch and display category names as options
                                            while ($row = mysqli_fetch_assoc($query_run)) {
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
                                            echo "<option value=''>No categories found</option>";
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
<?php } ?>