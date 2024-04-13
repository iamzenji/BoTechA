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

    $query = "SELECT * FROM inventory_logs";
    $result = mysqli_query($connection, $query);
?>

    <div class="container mt-4">
        <div class="col-md-6">
            <h2>Inventory Logs</h2>
        </div>
        <div class="container row mb-1">

            <div class="dropdown">
                <button class="dropbtn btn btn-outline-primary dropdown-toggle"><i class="lni lni-lineicons-symbol"></i> Reasons</button>
                <div class="dropdown-content">
                    <a href="#">All Reasons</a>
                    <hr>
                    <a href="#">Edit Item</a>
                    <a href="#">Receive Items</a>
                    <a href="#">Sale</a>
                    <a href="#">Discounted Items</a>
                </div>
            </div>
        </div>
        <table class="table inv-color-table">
            <thead>
                <tr>
                    <td colspan="6">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <button id="exportLogs" class="btn btn-outline-primary" style="height: 40px;">Export Logs</button>
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
                    $formattedDate = date('F j Y g:i A', strtotime($row['date']));
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('toggleSearch').addEventListener('click', function() {
            var searchContainer = document.getElementById('searchContainer');
            searchContainer.style.display = (searchContainer.style.display === 'none' || searchContainer.style.display === '') ? 'block' : 'none';
        });
        document.getElementById('rowsPerPage').addEventListener('change', function() {
            // Get the selected number of rows
            var rowsPerPage = parseInt(this.value);

            // Get all table rows
            var rows = document.querySelectorAll('tbody tr');

            // Hide all rows
            rows.forEach(function(row) {
                row.style.display = 'none';
            });

            for (var i = 0; i < Math.min(rowsPerPage, rows.length); i++) {
                rows[i].style.display = '';
            }
        });

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
            link.setAttribute("download", "inventory_logs.csv");

            document.body.appendChild(link);

            link.click();

            document.body.removeChild(link);
        }

        document.getElementById('exportLogs').addEventListener('click', exportToCSV);
    </script>
<?php
}
?>