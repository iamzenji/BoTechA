<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

    ?>

    <body>
        <section class="finance-container">
            <div class="right-window">
                <section class="right-window-container">
                    <!-- Finances and Budget -->
                    <div class="box">
                        <div class="box-title">
                            <!-- Total Money -->
                            <p>Total Financial Balance</p>
                            <button class="btn btn-success" data-toggle="modal" data-target="#addBalModal"
                                data-bs-placement=" top" title="Add Balance">+ Add Balance</button>
                            <!-- Add Balance Modal -->
                            <div class="modal fade" id="addBalModal" tabindex="-1" aria-labelledby="addbalLabel"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog mailinfo modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addbalLabel">
                                                Message
                                                Info</h5>
                                            <button type="button" class="close btn-close" data-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <form action=financeConfigAddBudget.php method="POST">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <p>Input a number to add balance:</p>
                                                    <input type="number" class="form-control" min="0" name="addbal"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="btnaddbudget">Add
                                                    Budget</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                    aria-label="Close">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-content totalbalance">
                            <div class="totalbalance-info">
                                <?php
                                // Balance
                                $balquery = "SELECT f_b.*, f_i.* FROM finance_balance f_b, finance_inbox f_i WHERE f_b.transactionID = f_i.id";
                                $balresult = mysqli_query($connection, $balquery);
                                $totalbal = 0;

                                while ($balrow = mysqli_fetch_assoc($balresult)) {
                                    $totalbal += $balrow['currentbal']; // Accumulate total balance
                                }
                                $totalbaldisplay = "₱" . number_format($totalbal); ?>
                                <span>Total Balance:</span>
                                <span><?php echo "$totalbaldisplay"; ?></span>
                            </div>
                            <table class="table table-hover recent-transaction-table finances-color-table payroll-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Management</th>
                                        <th scope="col">Current Balance</th>
                                        <th scope="col">Deducted Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php // Reset pointer to beginning of result set
                                        mysqli_data_seek($balresult, 0);
                                        while ($bal = mysqli_fetch_assoc($balresult)) { ?>
                                        <tr>
                                            <td><?= $bal['transactionID'] ?></td>
                                            <td><?= $bal['company'] ?></td>
                                            <td><?= $bal['currentbal'] ?></td>
                                            <td><?= $bal['cost'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Payroll -->
                    <div class="box">
                        <div class="box-title">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#payrollTableModal" data-bs-placement="top"
                                title="Click to Expand">Payroll</button>
                            <!-- Payroll Table Modal -->
                            <div class="modal fade" id="payrollTableModal" tabindex="-1" aria-labelledby="payrollModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-body modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="payrollModalLabel">Payroll Table</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Expanded Table using Modal -->
                                            <table class="table table-hover finances-color-table payroll-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Employee Name</th>
                                                        <th scope="col">Position</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Salary</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">4</th>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">5</th>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">6</th>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">7</th>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Payroll Kebab Button -->
                            <div class="dropdown kebab-button">
                                <svg class="dropdown-toggle" id="dropdownPayroll" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_111_105)">
                                        <path
                                            d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                        <path
                                            d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                        <path
                                            d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_111_105">
                                            <rect width="24" height="24" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <!-- Payroll Kebab Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownPayroll">
                                    <li><a class="dropdown-item" href="#">undefined</a></li>
                                    <li><a class="dropdown-item" href="#">undefined</a></li>
                                    <li><a class="dropdown-item" href="#">undefined</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Payroll Table -->
                        <table class="table finances-color-table payroll-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Employee Name</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">6</th>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">7</th>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Expenses and Utilities -->
                    <div class="box">
                        <div class="box-title">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#expensesTableModal" data-bs-placement="top"
                                title="Click to Expand">Expenses and Utilities</button>
                            <!-- Expenses and Utilities Modal -->
                            <div class="modal fade" id="expensesTableModal" tabindex="-1"
                                aria-labelledby="expensesModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="expensesModalLabel">Expenses Table</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Expanded Table using Modal -->
                                            <table class="table table-hover finances-color-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Month</th>
                                                        <th scope="col">Rent</th>
                                                        <th scope="col">Electricity</th>
                                                        <th scope="col">Water</th>
                                                        <th scope="col">Supplies</th>
                                                        <th scope="col">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">4</th>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">5</th>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success">Add</button>
                                            <button type="button" class="btn btn-danger">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown kebab-button">
                                <svg class="dropdown-toggle" id="dropdownExpAndUti" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_111_105)">
                                        <path
                                            d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                        <path
                                            d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                        <path
                                            d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_111_105">
                                            <rect width="24" height="24" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <!-- Expenses and Utilities Kebab Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownInbox">
                                    <li><a class="dropdown-item" href="#">Pending</a></li>
                                    <li><a class="dropdown-item" href="#">Paid</a></li>
                                    <li><a class="dropdown-item" href="#">test</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Expenses and Utilities Table -->
                        <table class="table table-hover finances-color-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Month</th>
                                    <th scope="col">Rent</th>
                                    <th scope="col">Electricity</th>
                                    <th scope="col">Water</th>
                                    <th scope="col">Supplies</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Inventory -->
                    <div class="box">
                        <div class="box-title">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#inventoryTableModal" data-bs-placement="top"
                                title="Click to Expand">Inventory</button>
                            <!-- Inventory Modal -->
                            <div class="modal fade" id="inventoryTableModal" tabindex="-1"
                                aria-labelledby="inventoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="inventoryModalLabel">Inventory Table</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Expanded Table using Modal -->
                                            <table class="table table-hover finances-color-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Product ID</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Qty</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Date Bought</th>
                                                        <th scope="col">Expiry Date</th>
                                                        <th scope="col">Total Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>1</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>2</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td>3</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">4</th>
                                                        <td>4</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">5</th>
                                                        <td>5</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">6</th>
                                                        <td>6</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">7</th>
                                                        <td>7</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success">Add</button>
                                            <button type="button" class="btn btn-danger">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown kebab-button">
                                <svg class="dropdown-toggle" id="dropdownInventory" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_111_105)">
                                        <path
                                            d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                        <path
                                            d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                        <path
                                            d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_111_105">
                                            <rect width="24" height="24" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <!-- Inventory Kebab Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownInventory">
                                    <li><a class="dropdown-item" href="#">?</a></li>
                                    <li><a class="dropdown-item" href="#">?</a></li>
                                    <li><a class="dropdown-item" href="#">?</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Inventory Table -->
                        <table class="table table-hover finances-color-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product ID</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Date Bought</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>2</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>3</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>4</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>5</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">6</th>
                                    <td>6</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">7</th>
                                    <td>7</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </section>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
                    crossorigin="anonymous"></script>
                <script src="script.js"></script>
                <script src="https://kit.fontawesome.com/67c4787375.js" crossorigin="anonymous"></script>

                <?php
}
mysqli_close($connection); ?>