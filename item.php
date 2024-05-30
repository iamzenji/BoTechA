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

            <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">

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
            </div>
        </div>
    </div>
    <div class="container">
                <div class="card-body d-flex justify-content-between align-items-center">
                            <h2 class="mt-3">Items List</h2>
                            <button class="btnadditem btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                <i class="fas fa-plus"></i> Add Items
                            </button>
                    </div>
                    <div class="card-body">
                    <form action="importitems.php" method="POST" enctype="multipart/form-data">
        <div class="row">
       
            <div class="col-sm-6 offset-sm-4">
                   
                <div class="mb-3">
                    <input type="file" name="import_file" id="import_file" class="form-control" accept=".xls,.xlsx" required>
                </div>
            </div>
            <div class="col-sm-2">
                <button type="submit" name="save_excel_data" class="btn btn-primary btn-block">Import</button>
            </div>
        </div>
    </form>
</div>
                    <ul class="nav nav-tabs mt-20" id="supplierTabs" role="tablist">
                    <?php
                        $query = "SELECT * FROM supplier";
                        $result = mysqli_query($connection, $query);
                        $defaultSupplierId = 1; 

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
                        mysqli_data_seek($result, 0); 
                        while ($row = mysqli_fetch_assoc($result)) {
                            $supplierId = $row['supplier_id'];
                            $isActive = $supplierId == $defaultSupplierId ? 'show active' : '';
                            echo "<div class='tab-pane fade $isActive' id='supplierContent$supplierId' role='tabpanel' aria-labelledby='supplierTab$supplierId'></div>";
                        }
                        ?>
                    </div>
                </div>    
    <div class="modal fade insertitem" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <form id="addItemForm" action="item-add.php" method="post">
                    <input type="hidden" name="id">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="name" class="control-label">Supplier</label>
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
                        </div>
        <div class="form-group">
            <label for="name" class="control-label">Category</label>
            
            <input type="text" name="category" id="category" class="form-control rounded-0"  required></input>
        </div>
        <div class="form-group">
            <label for="medicinename" class="control-label">Brand Name</label>
            <input type="text" name="brand" id="brand" class="form-control rounded-0"  required></input>
        </div>
        <div class="form-group">
            <label for="type" class="control-label">Type</label>
            <select name="type" id="type" class="select-tag" class="form-control rounded-0" >
            <option value="" disabled selected>--Select a Medicine Type--</option>
          
                <?php
                $query = "SELECT type_id, type_name FROM MedicineType ORDER BY type_name ASC"; 
                $query_run = mysqli_query($connection, $query);
                if ($query_run && mysqli_num_rows($query_run) > 0) {
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
            <textarea name="description" id="description"class="form-control rounded-0"  cols="30" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label for="unit" class="control-label">Dose</label>
            <input type="text"name="unit" id="unit" class="form-control rounded-0" required></input>
        </div>
        <div class="form-group">
            <label for="Price" class="control-label"> Pcs. per Box</label>
            <input type="text" name = "unit_qty" id="unit_qty"class="form-control rounded-0"  required>
        </div>
        <div class="form-group">
            <label for="WholesalePrice" class="control-label">Wholesale Price</label>
            <input type="text" id="wholesaleprice" name="wholesaleprice" class="form-control rounded-0"   pattern="[0-9]+(\.[0-9]+)?" title="Please enter numbers only">
            <p id="error" style="color: red;"></p>
        </div>
        <div class="form-group">
            <label for="unitcost" class="control-label">Unit Cost</label>
            <input type="text" id="unitcost" name="unitcost" class="form-control rounded-0"   pattern="[0-9]+(\.[0-9]+)?" title="Please enter numbers only">
            <p id="error" style="color: red;"></p>
        </div>
        
    </div>
    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="addItemBtn">Add</button>
            </div>
        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script> 


    <script>
$(document).ready(function() {
    function loadMedicineList(supplierId) {
        $.ajax({
            url: 'fetch_medicine_list.php', 
            method: 'GET',
            data: {supplier_id: supplierId}, // Send the supplier_id parameter
            dataType: 'html',
            success: function(response) {
                $('#supplierContent' + supplierId).html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Iterate through each supplier tab to load its medicine list
    $('#supplierTabs a[data-toggle="tab"]').each(function() {
        var supplierId = $(this).attr('href').replace('#supplierContent', '');
        loadMedicineList(supplierId);
    });

    // Bind event handler to load medicine list when a tab is shown
    $('#supplierTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var supplierId = $(e.target).attr('href').replace('#supplierContent', '');
        loadMedicineList(supplierId);
    });
});
</script>

 <script>
    function openEditModal(itemId, brand, category, type, description, unit, unit_qty, wholesaleprice, unitcost) {
        $('#editItemId').val(itemId);
        $('#editBrand').val(brand);
        $('#editCategory').val(category);
        $('#editType').val(type);
        $('#editDescription').val(description);
        $('#editUnit').val(unit);
        $('#editUnit_qty').val(unit_qty);
        $('#editWholesalePrice').val(wholesaleprice);
        $('#editUnitCost').val(unitcost);
        $('#editItemModal').modal('show');
    }
</script>
<script>
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
        document.getElementById("numberInput").addEventListener("input", function() {
            var input = this.value;
            var errorElement = document.getElementById("error");
            if (!/^\d+(\.\d+)?$/.test(input)) {
                errorElement.textContent = "Please enter numbers only.";
            } else {
                errorElement.textContent = ""; 
            }
        });
    </script>
<?php } ?>