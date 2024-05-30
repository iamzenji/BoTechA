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



<table class="table table-boarded table-striped " id="datatableid">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Brand Name</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Unit/Size</th>
                            <th>WholeSale Price</th>
                            <th>Unit Cost</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                if (isset($_GET['supplier_id'])) {
                    $supplier_id = $_GET['supplier_id'];
                

                    $query = "SELECT ml.*, c.category_name, mt.type_name
                            FROM medicine_list ml
                            JOIN Category c ON ml.category_id = c.category_id
                            JOIN MedicineType mt ON ml.type_id = mt.type_id
                            WHERE ml.supplier_id = $supplier_id";
                            $query_run = mysqli_query($connection, $query);
            
                    if ($query_run && mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            
                            echo "<tr>";
                            echo "<td>" . $row["medicine_id"] . "</td>";
                            echo "<td>" . $row["category_name"] . "</td>";
                            echo "<td>" . $row["brand"] . "</td>";
                            echo "<td>" . $row["description"] . "</td>";
                            echo "<td>" . $row["type_name"] . "</td>";
                            echo "<td>" . $row["unit"] . "</td>";
                            echo "<td>" . $row["wholesaleprice"] . "</td>";
                            echo "<td>" . $row["unitcost"] . "</td>";

                            echo "<td> 
                            <div class='dropdown'>
                            <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton" . $row["medicine_id"] . "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                Actions
                            </button>
                            <div class='dropdown-menu text-justify' aria-labelledby='dropdownMenuButton" . $row["medicine_id"] . "' style='min-width: 90px;'>";
                            echo "<button type='button' class='dropdown-item text-success btn' onclick=\"openEditModal('" . $row["medicine_id"] . "', '" . $row["brand"] . "', '" . $row["category_id"] . "', '" . $row["type_id"] . "', '" . $row["description"] . "', '" . $row["unit"] . "', '" . $row["wholesaleprice"] . "', '" . $row["unitcost"] . "')\"><i class='bi bi-pencil-fill mr-2'></i>Edit</button>";
                            echo "<button type='button' class='btn text-danger deleteitem'> <i class='bi bi-trash3-fill'></i> Delete</button>";
                            echo "</div>
                        </div>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                       
                        echo "<tr><td colspan='8'>No medicines found for this supplier.</td></tr>";
                    }
                } else {
                   
                    echo "<tr><td colspan='8'>Please select a supplier.</td></tr>";
                }

                ?>

                    </tbody>
                </table>
                

                <div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Supplier's Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="item-delete.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="delete_id" id="delete_id">
                    <input type="hidden" name="supplier_id" value="<?php echo $_GET['supplier_id']; ?>">
                    <h4>Do you want to delete this supplier's item?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" name="deletedata" class="btn btn-danger"><i class="bi bi-trash3-fill mr-2"></i>Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editItemModalLabel">Update Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="item-update.php" method="POST">
                <div class="modal-body text-left" style="max-height: 60vh; overflow-y: auto;">
                    <input type="hidden" name="id" id="editItemId">
                    <input type="hidden" name="supplier_id" value="<?php echo $_GET['supplier_id']; ?>">
                    <div class="form-group">
                        <label for="editCategory">Category</label>
                        <select name="category" id="editCategory" class="form-control" required>
                            
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
                        <select name="type" id="editType" class="select-tag" class="form-control rounded-0" >
                        <option value="" disabled selected>--Select a Medicine Type--</option>
                    
                            <?php
                           
                            $query = "SELECT type_id, type_name FROM MedicineType";
                            $query_run = mysqli_query($connection, $query);
                            
                            if ($query_run && mysqli_num_rows($query_run) > 0) {
                                
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
                        <textarea name="description" id="editDescription"class="form-control rounded-0"  cols="30" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editUnit">Unit/Size</label>
                        <input type="text" name="unit" id="editUnit" class="form-control" required>
                    </div> 
                  
                    <div class="form-group">
                        <label for="editWholesalePrice">Wholesale Price</label>
                        <input type="text" name="wholesaleprice" id="editWholesalePrice" class="form-control" required >
                    </div>
                    <div class="form-group">
                        <label for="editUnitCost">Unit Cost</label>
                        <input type="text" name="unitcost" id="editUnitCost" class="form-control" required>
                    </div>
            
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="updatedata" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>





            </div>
        </div>
    </div>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

<script>
    function openEditModal(itemId, brand, category, type, description, unit, wholesaleprice, unitcost) {
    $('#editItemId').val(itemId);
    $('#editBrand').val(brand);
    $('#editCategory').val(category);
    $('#editType').val(type);
    $('#editDescription').val(description);
    $('#editUnit').val(unit);
    $('#editWholesalePrice').val(wholesaleprice);
    $('#editUnitCost').val(unitcost);
    $('#editItemModal').modal('show');
}

    
    $(document).ready(function () {
        $('.deleteitem').on('click', function () {
            $('#deletemodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            $('#delete_id').val(data[0]);

        });
    });
</script>

<script>
    document.querySelectorAll('.btn-close').forEach(function(button) {
    button.addEventListener('click', function() {
        var modal = button.closest('.modal');
        if (modal) {
            $(modal).modal('hide');
        }
    });
});

</script>