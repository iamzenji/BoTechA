<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {
    $query = "SELECT DISTINCT supplier FROM inventory";
    $result = mysqli_query($connection, $query);
    $supplier = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $query = "SELECT DISTINCT category FROM inventory";
    $result = mysqli_query($connection, $query);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $query = "SELECT DISTINCT brand FROM inventory";
    $result = mysqli_query($connection, $query);
    $brands = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $query = "SELECT DISTINCT type FROM inventory";
    $result = mysqli_query($connection, $query);
    $types = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

    <div class="container mt-5">
        <div class="col-md-6">
            <h2>Discounts</h2>
        </div>
        <table class="inv-color-table table">
            <thead>
                <tr>
                    <td colspan="6">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <button id="addDiscountButton" class="btn btn-outline-primary" style="height: 40px;">Add Discount</button>
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
                    <th>Unit cost</th>
                    <th>Unit Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT supplier, category, brand, type, value, unit_qty FROM discounted_item";
                $result = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='align-middle text-center'>";
                    echo "<td>" . $row['supplier'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>" . $row['brand'] . "</td>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo "<td>" . $row['value'] . "</td>";
                    echo "<td>" . $row['unit_qty'] . "</td>";
                    echo "</tr>";
                }
                ?>
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
    <div id="addDiscountModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addDiscountModalLabel">Add Discount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_discount.php" method="post">
                        <div class="form-group">
                            <label for="supplier">supplier</label>
                            <select class="form-control" name="supplier">
                                <option value="" selected disabled>Select supplier</option>
                                <?php foreach ($supplier as $supplier) : ?>
                                    <option value="<?php echo $supplier['supplier']; ?>"><?php echo $supplier['supplier']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" name="category">
                                <option value="" selected disabled>Select category</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category['category']; ?>"><?php echo $category['category']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand name</label>
                            <select class="form-control" name="brand">
                                <option value="" selected disabled>Select brand</option>
                                <?php foreach ($brands as $brand) : ?>
                                    <option value="<?php echo $brand['brand']; ?>"><?php echo $brand['brand']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" name="type">
                                <option value="" selected disabled>Select type</option>
                                <?php foreach ($types as $type) : ?>
                                    <option value="<?php echo $type['type']; ?>"><?php echo $type['type']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="value">Unit cost</label>
                            <input type="text" class="form-control" name="value" placeholder="Enter value">
                        </div>
                        <div class="form-group">
                            <label for="unitQuantity">Unit Quantity</label>
                            <input type="text" class="form-control" name="unitQuantity" placeholder="Enter unit quantity">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="addDiscount">Add Discount</button>
                </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('toggleSearch').addEventListener('click', function() {
            var searchContainer = document.getElementById('searchContainer');
            searchContainer.style.display = (searchContainer.style.display === 'none' || searchContainer.style.display === '') ? 'block' : 'none';
        });

        document.getElementById('addDiscountButton').addEventListener('click', function() {
            $('#addDiscountModal').modal('show');
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
    </script>


<?php } ?>