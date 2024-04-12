<?php
include 'includes/connection.php';
include 'includes/header.php';

$userName = "";

if (isset($_SESSION['employee_position'])) {
    $position = $_SESSION['employee_position'];

    $query = "SELECT employee_name FROM employee_details WHERE employee_position = '$position'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userName = $row['employee_name'];
    }
}

if (empty($_SESSION['employee_id'])) {
    header('location:login.php');
    session_destroy();
} else {

    $query = "SELECT inventory_logs.*, inventory.brand AS brand_name
              FROM inventory_logs 
              INNER JOIN inventory ON inventory_logs.inventory_id = inventory.inventory_id ";

    $result = mysqli_query($connection, $query);
?>

    <div class="container mt-4">
        <div class="col-md-6">
            <h2>Inventory Logs</h2>
        </div>
        <div class="container row mb-2">
            <div class="btn-group col-md-2 d-flex">
                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="lni lni-lineicons-symbol"></i> Reasons
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="">All Reasons</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="">Edit Item</a></li>
                    <li><a class="dropdown-item" href="">Receive Items</a></li>
                    <li><a class="dropdown-item" href="">Sale</a></li>
                    <li><a class="dropdown-item" href="">Discounted Items</a></li>
                </ul>
            </div>
        </div>
        <table class="table inv-color-table">
            <thead>
                <tr>
                    <td colspan="6">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <button class="btn btn-outline-primary" style="height: 40px;">Export Logs</button>
                                </div>
                                <div class="align-middle col-md-6">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-outline-primary" id="toggleSearch">
                                            <i class="lni lni-search-alt"></i>
                                        </button>
                                        <div id="searchContainer" class="col-md-6" style="display: none;">
                                            <div class="d-flex justify-content-end">
                                                <input type="text" id="searchInput" class="form-control col-md-6" style="width: 260px; height: 30px; font-size: 12px;" placeholder="Search by Date, Name, Employee, Reasons ">
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
                <tr>
                    <th class="align-middle">Date</th>
                    <th class="align-middle">Brand name</th>
                    <th class="align-middle">Employee</th>
                    <th class="align-middle">Adjustment</th>
                    <th class="align-middle">Stock after</th>
                    <th class="align-middle">Reasons</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $formattedDate = date('F j, Y g:i A', strtotime($row['date']));
                ?>
                    <tr>
                        <td><?php echo $formattedDate; ?></td>
                        <td><?php echo $row['brand_name']; ?></td>
                        <td><?php echo $userName; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['stock_after']; ?></td>
                        <td><?php echo $row['reason']; ?></td>
                    </tr>
                <?php
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
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="-1">All</option>
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
    <script>
        document.getElementById('toggleSearch').addEventListener('click', function() {
            var searchContainer = document.getElementById('searchContainer');
            searchContainer.style.display = (searchContainer.style.display === 'none' || searchContainer.style.display === '') ? 'block' : 'none';
        });
        document.getElementById('rowsPerPage').addEventListener('change', function() {
            // Get the selected number of rows per page
            var rowsPerPage = parseInt(this.value);

            // Get all table rows excluding the header and footer
            var rows = document.querySelectorAll('tbody tr');

            // Hide all rows
            rows.forEach(function(row) {
                row.style.display = 'none';
            });

            // Show only the first 10 rows
            for (var i = 0; i < Math.min(rowsPerPage, rows.length); i++) {
                rows[i].style.display = '';
            }
        });
    </script>
<?php
}
?>