<?php
include 'includes/connection.php';// -----------------------------------------------
// HR PAYROLL SENDING

if (isset($_POST['pay'])) {
    // Fetch balance
    $balquery = "SELECT * FROM finance_balance ORDER by date DESC";
    $balresult = mysqli_query($connection, $balquery);
    $bal = mysqli_fetch_assoc($balresult);

    // Automatic Request Budget after ordering, inserting data to finance balance
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