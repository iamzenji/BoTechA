<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {
    function generateTrackingNumber()
    {
        // Generate a unique tracking number (you can use any logic here)
        return "TN" . uniqid();
    }

    // Fetch balance
    $balquery = "SELECT * FROM finance_balance ORDER by id DESC";
    $balresult = mysqli_query($connection, $balquery);
    $bal = mysqli_fetch_assoc($balresult);

    // -----------------------------------------------
    // HR PAYROLL SENDING

    if (isset($_POST['pay'])) {
        // Automatic Request Budget after ordering, inserting data to finance balanc
        $trackingNumber = generateTrackingNumber();
        $moneygen = random_int(00000, 40000);
        $grandTotal = $moneygen;
        $companyName = "Human Resources";
        $totalPrice = ($grandTotal) * (-1);
        $totalbal = ($bal['currentbal']) + ($totalPrice);
        $description = "Payroll Given";

        // Insert Data
        $financebalquery = "INSERT INTO `finance_balance` (trackingID, currentbal, company, cost, description) VALUES ('$trackingNumber','$totalbal', '$companyName', '$totalPrice', '$description')";
        $financeresult = mysqli_query($connection, $financebalquery);

        // Fetch Receipt
        $freceiptfetchquery = "SELECT * FROM finance_receipt";
        $freceiptresult = mysqli_query($connection, $freceiptfetchquery);
        $receiptrow = mysqli_fetch_assoc($freceiptresult);

        // Add current price
        $totalreceipt = ($receiptrow['hr']) + ($totalPrice);

        // Update Receipt
        $freceiptquery = "UPDATE finance_receipt SET hr = $totalreceipt";
        $freceiptresult = mysqli_query($connection, $freceiptquery);
    }
    // -----------------------------------------------

    ?>

    <body>
        <section class="container">
            <button type="submit" class="btn btn-dark" name='hr' data-toggle="modal" data-target="#hrModal">Human
                Resources</button>
        </section>

        <!-- Modals -->
        <!-- HR Modal -->
        <div class="modal fade" id="hrModal" tabindex="-1" aria-labelledby="hrModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hrModalLabel">Confirm</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Pay Test?</p>
                        <form action="financeDummyData.php" method="post">
                            <button type="submit" class="btn btn-success" name="pay">Pay</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                aria-label="Close">Back</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com / 67c4787375.js" crossorigin="anonymous"></script>

<?php }

mysqli_close($connection); ?>