<?php
include 'includes/connection.php';

if (isset($_POST['btnaddbudget'])) {
    $addbal = $_POST['addbal'];
    $cost = "+" . $addbal;
    $transactNumber = generateTransactNumber();
    $companyName = "FINANCE";
    // Add
    $balanceUpdate = "UPDATE finance_balance SET currentbal = currentbal";
    $balanceUpdateResult = mysqli_query($connection, $balanceUpdate);
    // Send the balance to database

    $balsendquery = "INSERT INTO `finance_balance` (transactionID, cost, companyname) VALUES ('$transactNumber', '$cost', '$companyName')";
    $balsendresult = mysqli_query($connection, $balsendquery);

    header('location:financeHome.php');
}
// ------------- ADDED BY: FINANCES ----------
function generateTransactNumber()
{
    // Generate a unique tracking number (you can use any logic here)
    return "253" . uniqid();
}
// -------------------------------------------- 
