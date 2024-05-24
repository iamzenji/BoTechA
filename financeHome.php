<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {


    // Fetch Receipt
    $receiptrowquery = "SELECT * FROM finance_receipt";
    $receiptrowresult = mysqli_query($connection, $receiptrowquery);

    // Add all the balance
    $addbalancequery = "SELECT currentbal FROM finance_balance";
    $addbalanceresult = mysqli_query($connection, $addbalancequery);
    $addbal = mysqli_fetch_assoc($addbalanceresult);

    // Function to generate tracking number
    function generateTrackingNumber()
    {
        // Generate a unique tracking number (you can use any logic here)
        return "TN" . uniqid();
    }
    // Select data from table to global variables
    $query = "SELECT * FROM finance_inbox ORDER BY date DESC";
    $result = mysqli_query($connection, $query);

    // Select data to display in expense table
    $expquery = "SELECT * FROM finance_expenses ORDER BY id ASC";
    $expresult = mysqli_query($connection, $expquery);

    // ------------------------------------------------------------------------------------------
    // Daily fetching of Sales
    $currentDate = date('Y-m-d');

    $salesDescription = "Daily Sales";
    $salesRecorded = false;

    // Check if sales have already been recorded for today
    $checkSalesQuery = "SELECT COUNT(*) AS count FROM finance_balance WHERE DATE(date) = CURDATE() and description = '$salesDescription'";
    $checkSalesResult = mysqli_query($connection, $checkSalesQuery);
    $checkSalesRow = mysqli_fetch_assoc($checkSalesResult);
    if ($checkSalesRow['count'] > 0) {
        $salesRecorded = true;
    }

    if (!$salesRecorded) {

        $totalSales = random_int(10000, 90000);

        // Fetch balance
        $balquery = "SELECT currentbal FROM finance_balance ORDER BY id DESC";
        $balresult = mysqli_query($connection, $balquery);
        $bal = mysqli_fetch_assoc($balresult);

        $trackingNumber = generateTrackingNumber();
        $companyName = "Point of Sales";
        $totalPrice = ($totalSales) * (1);

        $totalbal = ($bal['currentbal']) + ($totalPrice);
        $description = "Daily Sales";

        // Insert Sales record for today with current date and time
        $insertSalesquery = "INSERT INTO finance_balance (trackingID, currentbal, company, cost, description) VALUES ('$trackingNumber','$totalbal', '$companyName', '$totalPrice','$description')";
        $insertSalesresult = mysqli_query($connection, $insertSalesquery);

        // Fetch Receipt
        $freceiptfetchquery = "SELECT * FROM finance_receipt";
        $freceiptresult = mysqli_query($connection, $freceiptfetchquery);
        $receiptrow = mysqli_fetch_assoc($freceiptresult);

        // Add current price
        $totalreceipt = ($receiptrow['sales']) + ($totalPrice);

        // Update Receipt
        $freceiptquery = "UPDATE finance_receipt SET sales = $totalreceipt";
        $freceiptqueryresult = mysqli_query($connection, $freceiptquery);

        // Set the flag to indicate expenses for today have been recorded
        $salesRecorded = true;
    }

    // ----------------------------------------------------------------------------------------
    // Weekly Fetching of Expenses
    $dayOfWeekToRun = 5; // Assuming Friday as the day to run
    $isDateToday = date('w') == $dayOfWeekToRun;

    // Get the current date and time
    $currentDateTime = date('Y-m-d H:i:s');

    if ($isDateToday) {
        // Check if expenses for the day have already been recorded
        $expenseRecorded = false; // Initialize the variable to false

        $expenseDescription = "Expenses";

        // Check if expenses have already been recorded for today
        $checkExpQuery = "SELECT COUNT(*) AS count FROM finance_balance WHERE DATE(date) = CURDATE() and description = '$expenseDescription'";
        $checkExpResult = mysqli_query($connection, $checkExpQuery);
        $checkExpRow = mysqli_fetch_assoc($checkExpResult);
        if ($checkExpRow['count'] > 0) {
            $expenseRecorded = true; // Set to true if expenses have already been recorded for today
        }
        if (!$expenseRecorded) {
            // If expenses for today have not been recorded, proceed to record
            $totalexpense = 0;
            // Select data to display in expense table
            $weeklyquery = "SELECT * FROM finance_expenses ORDER BY id DESC";
            $weeklyresult = mysqli_query($connection, $weeklyquery);
            while ($weeklyexpense = mysqli_fetch_assoc($weeklyresult)) {
                $totalexpense += $weeklyexpense['cost'];
            }

            // Fetch balance
            $balquery = "SELECT currentbal FROM finance_balance ORDER BY date DESC";
            $balresult = mysqli_query($connection, $balquery);
            $bal = mysqli_fetch_assoc($balresult);

            $trackingNumber = generateTrackingNumber();
            $companyName = "Finance";
            $totalPrice = ($totalexpense) * (-1);

            $checkBalance = 0;
            // Check Balance
            $currentbalquery = "SELECT currentbal FROM finance_balance ORDER by id DESC LIMIT 1";
            $currentbalresult = mysqli_query($connection, $currentbalquery);

            $currentbalrow = mysqli_fetch_assoc($currentbalresult);
            $totalbal = ($currentbalrow['currentbal']) + ($totalPrice);

            // $totalbal = ($checkBalance) + ($totalPrice);
            $description = "Expenses";

            // Insert expenses record for today with current date and time
            $insertexpquery = "INSERT INTO finance_balance (trackingID, currentbal, company, cost, description) VALUES ('$trackingNumber','$totalbal', '$companyName', '$totalPrice','$description')";
            $insertexpresult = mysqli_query($connection, $insertexpquery);

            // Fetch Receipt
            $freceiptfetchquery1 = "SELECT * FROM finance_receipt";
            $freceiptresult1 = mysqli_query($connection, $freceiptfetchquery1);
            $receiptrow1 = mysqli_fetch_assoc($freceiptresult1);

            // Add current price
            $totalreceipt = ($receiptrow1['finance']) + ($totalPrice);

            // Update Receipt
            $freceiptquery1 = "UPDATE finance_receipt SET finance = $totalreceipt";
            $freceiptqueryresult1 = mysqli_query($connection, $freceiptquery1);

            // Set the flag to indicate expenses for today have been recorded
            $expenseRecorded = true;
        }
    }
    // ---------------------------------------------------------------------------------------
    // Monthly fetching of Receipt
    // Get the current year and month
    $currentReceiptMonth = date('Y-m');

    // Check if Receipt for the month have already been recorded
    $receiptRecorded = false; // Initialize the variable to false

    // Check if Receipt have already been recorded for this month
    $checkReceiptQuery = "SELECT COUNT(*) AS count FROM finance_receipt WHERE YEAR(date) = YEAR(CURRENT_DATE()) AND MONTH(date) = MONTH(CURRENT_DATE())";
    $checkReceiptResult = mysqli_query($connection, $checkReceiptQuery);
    $checkReceiptRow = mysqli_fetch_assoc($checkReceiptResult);
    if ($checkReceiptRow['count'] > 0) {
        $receiptRecorded = true; // Set to true if Receipt have already been recorded for this month
    }

    if (!$receiptRecorded) {
        // If Receipt for this month have not been recorded or the last recorded month is different from the current month, proceed to record

        // Backup the current receipt data
        $backupquery = "SELECT * FROM finance_receipt";
        $backupresult = mysqli_query($connection, $backupquery);
        $backupadd = mysqli_fetch_assoc($backupresult);

        // Generate a report ID
        $newreportID = random_int(1000000, 9999999); // random_int function does not accept leading zeros

        // Extract data for backup
        $reportID = $backupadd['reportid'];
        $finance = $backupadd['finance'];
        $po = $backupadd['po'];
        $hr = $backupadd['hr'];
        $inventory = $backupadd['inventory'];
        $sales = $backupadd['sales'];

        // Insert backup data into finance_receipt_backup table
        $insertexpquery = "INSERT INTO finance_receipt_backup (reportid, finance, po, hr, inventory, sales) VALUES ('$reportID','$finance', '$po', '$hr','$inventory','$sales')";
        $insertexpresult = mysqli_query($connection, $insertexpquery);

        $receiptUpdate = 0;
        $insertReceiptquery = "UPDATE finance_receipt SET reportid = $newreportID, finance = $receiptUpdate, po = $receiptUpdate, hr = $receiptUpdate, inventory = $receiptUpdate, sales = $receiptUpdate, date = now()";
        $insertReceiptresult = mysqli_query($connection, $insertReceiptquery);

        // Set receipt recorded to true
        $receiptRecorded = true;

        $currentReceiptMonth = date('Y-m');
    }
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
                            <div class="btn-group">
                                <button disabled class="btn btn-success" data-toggle="modal" data-target="#addBalModal"
                                    data-bs-placement=" top" title="Add Balance">+ Add Balance</button>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#receiptModal"
                                    data-bs-placement=" top" title="Add Balance">Print Receipt</button>
                            </div>
                            <!-- ------------------------------------------------------------------------------ -->
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
                                        <form action=financeConfigAdd.php method="POST">
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
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                    aria-label="Close">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- ------------------------------------------------------------------------------ -->
                            <!-- Receipt Modal -->
                            <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptLabel"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog mailinfo modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="receiptLabel">
                                                Receipt</h5>
                                            <button type="button" class="close btn-close" data-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            // Backup the current receipt data
                                            $checkreceiptquery = "SELECT * FROM finance_receipt";
                                            $checkreceiptresult = mysqli_query($connection, $checkreceiptquery);
                                            $receiptrow = mysqli_fetch_assoc($checkreceiptresult);
                                            ?>
                                            <div class="finance-receipt">
                                                <div class="customer-info">
                                                    <p><strong>Report ID:</strong> <?= $receiptrow['reportid'] ?></p>
                                                    <p><strong>Date:</strong> <?= $receiptrow['date'] ?></p>
                                                </div>
                                                <div class="finance-receipt-details">
                                                    <h3>--Accounting and Finance Reports--</h3>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Department</th>
                                                                <th scope="col">Cost</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $originalDate = $receiptrow['date'];
                                                            ?>
                                                            <tr>
                                                                <td><?= "Finance" ?></td>
                                                                <td><?= number_format($receiptrow['finance']) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><?= "Purchase Order" ?></td>
                                                                <td><?= number_format($receiptrow['po']) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><?= "Human Resources" ?></td>
                                                                <td><?= number_format($receiptrow['hr']) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><?= "Inventory" ?></td>
                                                                <td><?= number_format($receiptrow['inventory']) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><?= "Sales" ?></td>
                                                                <td><?= number_format($receiptrow['sales']) ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success" onclick="window.print()">Save &
                                                Print</button>
                                            <button class="btn btn-secondary" data-dismiss="modal"
                                                aria-label="Close">Back</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------------ -->

                        <div class="box-content totalbalance">
                            <div class="totalbalance-info">
                                <?php
                                // Balance
                                $balquery = "SELECT * FROM finance_balance ORDER by id DESC";
                                $balresult = mysqli_query($connection, $balquery);
                                // Fetch balance
                                $bal = mysqli_fetch_assoc($balresult);

                                // Check Balance
                                $currentbalquery = "SELECT currentbal FROM finance_balance ORDER by id DESC LIMIT 1";
                                $currentbalresult = mysqli_query($connection, $currentbalquery);

                                $currentbalrow = mysqli_fetch_assoc($currentbalresult);
                                $totalbal = $currentbalrow['currentbal'];
                                $totalbaldisplay = "₱" . number_format($totalbal); ?>
                                <span>Total Balance:</span>
                                <span><?php echo "$totalbaldisplay"; ?></span>
                            </div>
                            <table class="table table-hover recent-transaction-table finances-color-table payroll-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Tracking ID</th>
                                        <th scope="col">Management</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">Balance</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php // Reset pointer to beginning of result set
                                        mysqli_data_seek($balresult, 0);
                                        while ($bal = mysqli_fetch_assoc($balresult)) {
                                            $originalDate = $bal['date'];
                                            $newDate = date("m-d-Y", strtotime($originalDate)); ?>
                                        <tr>
                                            <td><?= $bal['trackingID'] ?></td>
                                            <td><?= $bal['company'] ?></td>
                                            <td><?= $bal['description'] ?></td>
                                            <td><?= $bal['cost'] ?></td>
                                            <td><?= $bal['currentbal'] ?></td>
                                            <td><?= $newDate ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Expenses and Utilities -->
                    <div class="box">
                        <div class="box-title">
                            <p>Expenses and Utilities</p>
                            <div class="tablebtn-container">
                                <!-- Add title button -->
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#expensesAddModal">Add</button>
                            </div>
                        </div>
                        <!-- Expenses and Utilities Table -->
                        <table class="table table-hover finances-color-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Expenses</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Cost</th>
                                    <th scope="col">*</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Reset pointer to beginning of result set
                                mysqli_data_seek($expresult, 0);
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($expresult)) {
                                    $expenseDate = $row['date'];
                                    $newexpenseDate = date("m-d-Y", strtotime($expenseDate)); ?>
                                    <tr>
                                        <td> <?= $i; ?> </td>
                                        <td> <?= $row['expenses'] ?> </td>
                                        <td> <?= $newexpenseDate ?> </td>
                                        <td> ₱<?= number_format($row['cost']) ?> </td>
                                        <td> <button class="btn btn-danger" id="expensesRemoveModal-<?= $row['id']; ?>"
                                                data-toggle="modal"
                                                data-target="#expensesRemoveModal-<?= $row['id']; ?>">Remove</button></td>
                                    </tr>
                                    <!-- ---------------------------------------------------------------------------------------- -->
                                    <!-- Remove Expense Modal -->
                                    <div class="modal fade" id="expensesRemoveModal-<?= $row['id']; ?>"
                                        aria-labelledby="expensesRemoveModalLabel-<?= $row['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <form action="financeConfigAdd.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="expensesRemoveModalLabel-<?= $row['id']; ?>">Confirm</h5>
                                                        <button type="button" class="btn-close" data-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure about this? You're deleting a data.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger"
                                                            name="removeexpense">Yes</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                            aria-label="Close">Back</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- ---------------------------------------------------------------------------------------- -->
                                    <!-- Add Expense Modal -->
                                    <div class="modal fade" id="expensesAddModal" tabindex="-1"
                                        aria-labelledby="expensesAddModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <form action="financeConfigAdd.php" method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="expensesAddModalLabel">Add Expense</h5>
                                                        <button type="button" class="btn-close" data-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="expenses-name" class="form-label">Expenses Name</label>
                                                            <input type="text" class="form-control" id="expenses-name"
                                                                name="expenses-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="expenses-cost" class="form-label">Cost</label>
                                                            <input type="number" min="0" class="form-control" id="expenses-cost"
                                                                name="expenses-cost">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success"
                                                            name="addexpense">Add</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                            aria-label="Close">Back</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- ---------------------------------------------------------------------------------------- -->
                                    <?php $i++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
                        crossorigin="anonymous"></script>
                    <script src="script.js"></script>
                    <script src="https://kit.fontawesome.com/67c4787375.js" crossorigin="anonymous"></script>

                    <?php
}
mysqli_close($connection); ?>