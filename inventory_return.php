<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {
    $query = "SELECT DISTINCT supplier FROM inventory";
    $result = mysqli_query($connection, $query);
    $suppliers = mysqli_fetch_all($result, MYSQLI_ASSOC);



?>

    <div class="container mt-5">
        <div class="col-md-6">
            <h2>Return Product</h2>
        </div>
        <table class="inv-color-table table">
            <thead>
                <tr>
                    <td colspan="8">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <button id="addReturnButton" class="btn btn-outline-primary" style="height: 40px;">Add Return Product</button>
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
                    <th>Employee</th>
                    <th>Supplier</th>
                    <th>Category</th>
                    <th>Brand name</th>
                    <th>Type</th>
                    <th>Unit Quantity</th>
                    <th>Reasons</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM return_item";
                $result = mysqli_query($connection, $query);
                $return_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($return_items as $item) : ?>
                    <tr class="align-middle text-center">
                        <td><?php echo $item['employee']; ?></td>
                        <td><?php echo $item['supplier']; ?></td>
                        <td><?php echo $item['category']; ?></td>
                        <td><?php echo $item['brand']; ?></td>
                        <td><?php echo $item['type']; ?></td>
                        <td><?php echo $item['unit_qty']; ?></td>
                        <td>Purchase Return</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
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
    <div id="addReturnModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addReturnModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addReturnModalLabel">Add Return</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_return.php" method="post">
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <select class="form-control" id="supplier" name="supplier">
                                <option value="" selected disabled>Select supplier</option>
                                <?php foreach ($suppliers as $supplier) : ?>
                                    <option value="<?php echo $supplier['supplier']; ?>"><?php echo $supplier['supplier']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Category Dropdown -->
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" disabled>
                                <option value="" selected disabled>Select category</option>
                            </select>
                        </div>
                        <!-- Brand Dropdown -->
                        <div class="form-group">
                            <label for="brand">Brand name</label>
                            <select class="form-control" id="brand" name="brand" disabled>
                                <option value="" selected disabled>Select brand</option>
                            </select>
                        </div>
                        <!-- Type Dropdown -->
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type" disabled>
                                <option value="" selected disabled>Select type</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="unitQuantity">Unit Quantity</label>
                            <input type="text" class="form-control" name="unitQuantity" placeholder="Enter unit quantity">
                        </div>
                        <div class="form-group">
                            <label for="reasons">Reasons</label>
                            <input type="text" class="form-control" name="reasons" value="Purchase Return" disabled>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="addReturn">Add Return</button>
                </div>
                </form>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // AJAX request to fetch categories based on selected supplier
            $('#supplier').change(function() {
                var supplier = $(this).val();
                $.ajax({
                    url: 'get_categories.php',
                    type: 'post',
                    data: {
                        supplier: supplier
                    },
                    success: function(response) {
                        $('#category').html(response).prop('disabled', false);
                    }
                });
            });

            // AJAX request to fetch brands based on selected category
            $('#category').change(function() {
                var category = $(this).val();
                $.ajax({
                    url: 'get_brands.php',
                    type: 'post',
                    data: {
                        category: category
                    },
                    success: function(response) {
                        $('#brand').html(response).prop('disabled', false);
                    }
                });
            });

            // AJAX request to fetch types based on selected brand
            $('#brand').change(function() {
                var brand = $(this).val();
                $.ajax({
                    url: 'get_types.php',
                    type: 'post',
                    data: {
                        brand: brand
                    },
                    success: function(response) {
                        $('#type').html(response).prop('disabled', false);
                    }
                });
            });

            // Show add discount modal on button click
            $('#addReturnButton').click(function() {
                $('#addReturnModal').modal('show');
            });
        });
        document.getElementById('toggleSearch').addEventListener('click', function() {
            var searchContainer = document.getElementById('searchContainer');
            searchContainer.style.display = (searchContainer.style.display === 'none' || searchContainer.style.display === '') ? 'block' : 'none';
        });

        document.getElementById('addReturnButton').addEventListener('click', function() {
            $('#addReturnModal').modal('show');
        });

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

        document.getElementById('searchInput').addEventListener('input', function() {
            var searchQuery = this.value.toLowerCase();
            var rows = document.querySelectorAll('.inv-color-table tbody tr');

            rows.forEach(function(row) {
                var rowData = row.textContent.toLowerCase();
                if (rowData.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>



<?php } ?>