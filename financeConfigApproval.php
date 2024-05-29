<?php include 'includes/connection.php';
$currentDate = date('y-m-d h:i:s');

if (isset($_POST['Approved'])) {
    $financeID = $_POST['id'];
    $approvalmsg = $_POST['approvalmsg'];

    // Detect the company name and cost
    $companyName = $_POST['companyname'];
    $costNum = $_POST['cost'];

    $balanceUpdate = "UPDATE finance_balance SET currentbal = currentbal-$costNum";
    $balanceUpdateResult = mysqli_query($connection, $balanceUpdate);

    $balanceQuery = "INSERT INTO `finance_balance` (transactionID, companyname, cost) VALUES ('$financeID','$companyName', '$costNum')";
    $balanceResult = mysqli_query($connection, $balanceQuery);
        
    // Send to finance inbox all the info
    $niceQuery = "UPDATE finance_inbox SET status = 'Approved', approvaldate = now(), approvalmsg = '$approvalmsg' WHERE id = '$financeID'";
    $niceUpdate = mysqli_query($connection, $niceQuery);

    // Send to PO inbox the msg and info
    $nicePOQuery = "UPDATE finance_inbox_po SET status = 'Approved', approvaldate = now(), approvalmsg = '$approvalmsg' WHERE id = '$financeID'";
    $nicePOUpdate = mysqli_query($connection, $nicePOQuery);

    header('location:financeInbox.php');
} elseif (isset($_POST['Denied'])) {
    $financeID = $_POST['id'];
    $approvalmsg = $_POST['approvalmsg'];

    $failQuery = "UPDATE finance_inbox SET status = 'Denied', approvaldate = now(), approvalmsg = '$approvalmsg' WHERE id = '$financeID'";
    $failUpdate = mysqli_query($connection, $failQuery);
    
    // Send to PO inbox the msg and info
    $failPOQuery = "UPDATE finance_inbox_po SET status = 'Denied', approvaldate = now(), approvalmsg = '$approvalmsg' WHERE id = '$financeID'";
    $failPOUpdate = mysqli_query($connection, $failPOQuery);
    header('location:financeInbox.php');
    
    // $test = filter_input(INPUT_POST, "approvalmsg", FILTER_SANITIZE_SPECIAL_CHARS);
}
?>