<?php
include 'includes/connection.php';
include 'includes/header.php';

$userName = "";



if (empty($_SESSION['employee_id'])) {
    header('location:login.php');
    session_destroy();
} else {

    $query = "SELECT il.*, i.brand FROM inventory_logs il 
              INNER JOIN inventory i ON il.inventory_id = i.category AND il.brand_name = i.brand
              ORDER BY il.date DESC";


    $result = mysqli_query($connection, $query);
?>

    <div class="container mt-4">
        <div class="col-md-6">
            <h2>Inventory Logs</h2>
        </div>
        <div class="container row mb-1">

            <div class="dropdown-logs">
                <button class="dropbtn btn btn-outline-primary dropdown-toggle"><i class="lni lni-lineicons-symbol"></i> Reasons</button>
                <div class="dropdown-con">
                    <a href="#">All Reasons</a>
                    <hr>
                    <a href="#">Edit Item</a>
                    <a href="#">Purchase order</a>
                    <a href="#">Sale</a>
                    <a href="#">Add Discount</a>
                    <a href="#">Return Item</a>
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
                                        <button type="button" class="btn btn-outline-primary" id="toggleSearch" style="margin-right: 10px;">
                                            <i class="lni lni-search-alt"></i>
                                        </button>
                                        <div id="searchContainer" class="col-md-6" style="display: none;">
                                            <div class="d-flex justify-content-end">
                                                <input type="text" id="searchInput" class="form-control col-md-6" style="width: 260px; height: 30px; font-size: 12px; margin-right: 10px;" placeholder="Search by Date, Name, Employee, Reasons ">
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterByDateBtn">
                                            <i class="lni lni-lineicons-symbol"></i> Date
                                        </button>
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
                    <th class="align-middle">Before -> After Stock On Hand</th>
                    <th class="align-middle">Reasons</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $formattedDate = date('F j Y g:i A', strtotime($row['date']));
                    $stock_before = $row['stock_after'] + $row['quantity'];
                ?>
                    <tr data-reason="<?php echo $row['reason']; ?>">
                        <td><?php echo $formattedDate; ?></td>
                        <td><?php echo $row['brand_name']; ?></td>
                        <td><?php echo $row['employee']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $stock_before . ' -> ' . $row['stock_after']; ?></td>
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

    <div class="modal" id="dateFilterModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Filter by Date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="startDate">From Date:</label>
                        <input type="date" class="form-control" id="startDate">
                    </div>
                    <div class="form-group">
                        <label for="endDate">To Date:</label>
                        <input type="date" class="form-control" id="endDate">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="applyDateFilter">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleSearch').addEventListener('click', function() {
            var searchContainer = document.getElementById('searchContainer');
            searchContainer.style.display = (searchContainer.style.display === 'none' || searchContainer.style.display === '') ? 'block' : 'none';
        });
        document.getElementById('searchInput').addEventListener('input', function() {
            var searchValue = this.value.trim().toLowerCase();
            var rows = document.querySelectorAll('.inv-color-table tbody tr');

            rows.forEach(function(row) {
                var date = row.querySelector('td:nth-child(1)').textContent.trim().toLowerCase();
                var brand = row.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
                var employee = row.querySelector('td:nth-child(3)').textContent.trim().toLowerCase();
                var reasons = row.querySelector('td:nth-child(6)').textContent.trim().toLowerCase();

                if (date.includes(searchValue) || brand.includes(searchValue) || employee.includes(searchValue) || reasons.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
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
        document.querySelectorAll('.dropdown-con a').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                var selectedReason = this.textContent.trim();

                document.querySelectorAll('tbody tr').forEach(function(row) {
                    var rowReason = row.getAttribute('data-reason');
                    if (selectedReason === 'All Reasons' || selectedReason === rowReason) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        function exportToCSV() {
            var visibleRows = document.querySelectorAll('tbody tr:not([style*="display: none"])');

            var csvData = [];

            var headerRow = [];

            document.querySelectorAll('thead th').forEach(function(header) {
                headerRow.push(header.textContent.trim());
            });

            csvData.push(headerRow.join(','));

            visibleRows.forEach(function(row) {
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

        document.getElementById('filterByDateBtn').addEventListener('click', function() {
            $('#dateFilterModal').modal('show');
        });

        document.getElementById('applyDateFilter').addEventListener('click', function() {
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;

            document.querySelectorAll('tbody tr').forEach(function(row) {
                var date = row.querySelector('td:first-child').textContent.trim();
                var rowDate = new Date(date);

                if (startDate && endDate) {
                    var filterStartDate = new Date(startDate);
                    var filterEndDate = new Date(endDate);

                    if (rowDate >= filterStartDate && rowDate <= filterEndDate) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            $('#dateFilterModal').modal('hide');
        });
    </script>

<?php
}
?>