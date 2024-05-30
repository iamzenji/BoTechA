<?php
include 'includes/connection.php';

if (isset($_POST['btnaddbudget'])) {
    $addbal = $_POST['addbal'];
    $cost = "+" . $addbal;
    $transactNumber = generateTransactNumber();
    $companyName = "FINANCE";
    // Send the balance to database
    $totalPrice = ($grandTotal) * (-1);
    $totalbal = ($bal['currentbal']) + ($totalPrice);

    $balsendquery = "INSERT INTO `finance_balance` (transactionID, cost, companyname) VALUES ('$transactNumber', '$cost', '$companyName')";
    $balsendresult = mysqli_query($connection, $balsendquery);

    header('location:financeHome.php');
}

if (isset($_POST['addexpense'])) {
    $name = $_POST['expenses-name'];
    $cost = $_POST['expenses-cost'];

    $query = "INSERT INTO `finance_expenses` (expenses, cost) VALUES ('$name', '$cost')";
    $result = mysqli_query($connection, $query);

    header('location:financeHome.php');
}

if (isset($_POST['removeexpense'])) {
    $id = $_POST['id'];
    $name = $_POST['expenses-name'];

    $query = "DELETE FROM`finance_expenses` WHERE id = $id";
    $result = mysqli_query($connection, $query);

    header('location:financeHome.php');
}
// ------------- ADDED BY: FINANCES ----------
function generateTransactNumber()
{
    // Generate a unique tracking number (you can use any logic here)
    return "253" . uniqid();
}
// -------------------------------------------- 

// SENDING MESSAGES TO MANAGEMENTS

if (isset($_POST['send-mail'])) {
    $msginfo = filter_input(INPUT_POST, "msginfo", FILTER_SANITIZE_SPECIAL_CHARS);
    $management = $_POST['pick-add'];
    $user = $_POST['user'];
    $sender = '';

    // Finance
    if ($user == 'Finance Officer') {
        $sender = 'Finance';
        if ($management == "Purchase Order") {
            $inboxQuery = "INSERT INTO `finance_inbox` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_po` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInbox.php');
        }
        if ($management == "Human Resources") {
            $inboxQuery = "INSERT INTO `finance_inbox` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_hr` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInbox.php');
        }
        if ($management == "Sales") {
            $inboxQuery = "INSERT INTO `finance_inbox` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_sales` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInbox.php');
        }
        if ($management == "Inventory") {
            $inboxQuery = "INSERT INTO `finance_inbox` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_inv` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInbox.php');
        }
    }
    // Purchase Order
    if ($user == 'Purchase Order Officer') {
        $sender = 'Purchase Order';
        if ($management == "Finance") {
            $inboxPOQuery = "INSERT INTO `finance_inbox_po` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            $inboxQuery = "INSERT INTO `finance_inbox` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);
            
            header('location:financeInboxPO.php');
        }
        if ($management == "Human Resources") {
            $inboxQuery = "INSERT INTO `finance_inbox_po` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_hr` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInboxPO.php');
        }
        if ($management == "Sales") {
            $inboxQuery = "INSERT INTO `finance_inbox_po` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_sales` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInboxPO.php');
        }
        if ($management == "Inventory") {
            $inboxQuery = "INSERT INTO `finance_inbox_po` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_inv` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInboxPO.php');
        }
    }
    // Human Resources
    if ($user == 'HR Officer') {
        $sender = 'Human Resources';
        if ($management == "Purchase Order") {
            $inboxQuery = "INSERT INTO `finance_inbox_hr` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_po` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInboxHR.php');
        }
        if ($management == "Finance") {
            $inboxPOQuery = "INSERT INTO `finance_inbox_hr` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            $inboxQuery = "INSERT INTO `finance_inbox` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            header('location:financeInboxHR.php');
        }
        if ($management == "Sales") {
            $inboxQuery = "INSERT INTO `finance_inbox_hr` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_sales` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInboxHR.php');
        }
        if ($management == "Inventory") {
            $inboxQuery = "INSERT INTO `finance_inbox_hr` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_inv` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInboxHR.php');
        }
    }
    // Inventory
    if ($user == 'Inventory Officer') {
        $sender = 'Inventory';
        if ($management == "Purchase Order") {
            $inboxQuery = "INSERT INTO `finance_inbox_inv` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_po` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInboxInventory.php');
        }
        if ($management == "Human Resources") {
            $inboxPOQuery = "INSERT INTO `finance_inbox_inv` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            $inboxQuery = "INSERT INTO `finance_inbox_hr` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            header('location:financeInboxInventory.php');
        }
        if ($management == "Sales") {
            $inboxQuery = "INSERT INTO `finance_inbox_inv` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_sales` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInboxInventory.php');
        }
        if ($management == "Finance") {
            $inboxPOQuery = "INSERT INTO `finance_inbox_inv` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            $inboxQuery = "INSERT INTO `finance_inbox` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            header('location:financeInboxInventory.php');
        }
    }
    // Sales
    if ($user == 'Sales Officer - Cashier') {
        $sender = 'Sales';
        if ($management == "Purchase Order") {
            $inboxQuery = "INSERT INTO `finance_inbox_sales` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox_po` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInboxSALES.php');
        }
        if ($management == "Human Resources") {
            $inboxPOQuery = "INSERT INTO `finance_inbox_sales` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            $inboxQuery = "INSERT INTO `finance_inbox_hr` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            header('location:financeInboxSALES.php');
        }
        if ($management == "Finance") {
            $inboxQuery = "INSERT INTO `finance_inbox_sales` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            $inboxPOQuery = "INSERT INTO `finance_inbox` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            header('location:financeInboxSALES.php');
        }
        if ($management == "Inventory") {
            $inboxPOQuery = "INSERT INTO `finance_inbox_sales` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxPOResult = mysqli_query($connection, $inboxPOQuery);

            $inboxQuery = "INSERT INTO `finance_inbox_inv` (msginfo, sender, receiver) VALUES ('$msginfo', '$sender', '$management')";
            $inboxResult = mysqli_query($connection, $inboxQuery);

            header('location:financeInboxSALES.php');
        }
    }
}
