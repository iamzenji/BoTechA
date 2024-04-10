<?php
include 'includes/connection.php';
include 'includes/header.php';
?>
<div class="wrapper">
    <div class="main p-3">
        <div class="text-center">

            <ul class="list">
                <li class="d-flex justify-content-between align-items-center">
                    <h2 class="me-3">Supplier's medicine List</h2>
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
                        <th>#</th>
                        <th>Category</th>
                        <th>Brand Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                if (isset($_GET['supplier_id'])) {
                    // Fetch supplier ID from the GET parameters
                    $supplier_id = $_GET['supplier_id'];

                    // Fetch medicine list for the selected suppliers
                    $query = "SELECT ml.*, c.category_name, mt.type_name
                            FROM medicine_list ml
                            JOIN Category c ON ml.category_id = c.category_id
                            JOIN MedicineType mt ON ml.type_id = mt.type_id
                            WHERE ml.supplier_id = $supplier_id";
                    $query_run = mysqli_query($connection, $query);

                    // Check if query executed successfully
                    if ($query_run && mysqli_num_rows($query_run) > 0) {
                        // Output data of each rows
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            // Output medicine details as desired
                            // For example:
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
                            <div class='dropdown-menu text-justify' aria-labelledby='dropdownMenuButton" . $row["medicine_id"] . "' style='min-width: 90px;'>";
                            echo "<button type='button' class='dropdown-item text-success btn' onclick=\"openEditModal('" . $row["medicine_id"] . "', '" . $row["brand"] . "', '" . $row["category_id"] . "', '" . $row["type_id"] . "', '" . $row["description"] . "', '" . $row["unit"] . "', '" . $row["price"] . "')\"><i class='bi bi-pencil-fill mr-2'></i>Edit</button>";
                            echo " <button type='button' class='btn text-danger deleteitem'> <i class='bi bi-trash3-fill'></i> Delete</button>";
                            echo "</div>
                        </div>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no medicines found for the selected supplier
                        echo "<tr><td colspan='8'>No medicines found for this supplier.</td></tr>";
                    }
                } else {
                    // If supplier_id parameter is not set, show all medicines
                    echo "<tr><td colspan='8'>Please select a supplier.</td></tr>";
                }

                ?>

                </tbody>
            </table>

            </form>


            <!-- EDIT MODAL -->
            <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form id="editItemForm" action="item-update.php" method="post">
                            <div class="modal-body  text-left">
                                <input type="hidden" name="id" id="editItemId">
                                <input type="hidden" name="supplier_id" value="<?php echo $_GET['supplier_id']; ?>">
                                <div class="form-group">
                                    <label for="editCategory">Category</label>
                                    <select name="category" id="editCategory" class="form-control" required>
                                        <!-- Populate options dynamically using PHP -->
                                        <?php
                                        $query = "SELECT category_id, category_name FROM category";
                                        $query_run = mysqli_query($connection, $query);
                                        if ($query_run && mysqli_num_rows($query_run) > 0) {
                                            while ($row = mysqli_fetch_assoc($query_run)) {
                                                echo "<option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
                                            }
                                        } else {
                                            echo "<option value='' disabled>No categories found</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="editBrand">Brand </label>
                                    <input type="text" name="brand" id="editBrand" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="editType" class="control-label">Type</label>
                                    <select name="type" id="editType" class="select-tag" class="form-control rounded-0">
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
                                    <label for="editDescription"> Description</label>
                                    <textarea name="description" id="editDescription" class="form-control rounded-0" cols="30" rows="2"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="editUnit"> Unit</label>
                                    <input type="text" name="unit" id="editUnit" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="editPrice"> Price</label>
                                    <input type="text" name="price" id="editPrice" class="form-control" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" name="itemupdate">Save Changes</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- DELETE POP UP FORM (Bootstrap MODAL) -->
        <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Delete Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="item-delete.php" method="POST">

                        <div class="modal-body">

                            <input type="hidden" name="delete_id" id="delete_id">

                            <h4> Do you want to Delete this Data ??</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> No </button>
                            <button type="submit" name="deletedata" class="btn btn-danger"> Delete </button>
                        </div>
                    </form>

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
    function openEditModal(itemId, brand, category, type, description, unit, price) {
        $('#editItemId').val(itemId);
        $('#editBrand').val(brand);
        $('#editCategory').val(category);
        $('#editType').val(type);
        $('#editDescription').val(description);
        $('#editUnit').val(unit);
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