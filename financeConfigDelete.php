<?php
include 'includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deletemsg'])) {
        $id = $_POST['id'];
        $user = $_POST['user'];

        // Finance
        if ($user == 'Finance Officer') {
            $query = "DELETE FROM`finance_inbox` WHERE id = $id";
            $result = mysqli_query($connection, $query);

            header('location:financeInbox.php');
        }
        if ($user == 'Purchase Order Officer') {
            $query = "DELETE FROM`finance_inbox_po` WHERE id = $id";
            $result = mysqli_query($connection, $query);

            header('location:financeInboxPO.php');
        }
        if ($user == 'HR Officer') {
            $query = "DELETE FROM`finance_inbox_hr` WHERE id = $id";
            $result = mysqli_query($connection, $query);

            header('location:financeInboxHR.php');
        }
        if ($user == 'Inventory Officer') {
            $query = "DELETE FROM`finance_inbox_inv` WHERE id = $id";
            $result = mysqli_query($connection, $query);

            header('location:financeInboxInventory.php');
        }
        if ($user == 'Sales Officer - Cashier') {
            $query = "DELETE FROM`finance_inbox_sales` WHERE id = $id";
            $result = mysqli_query($connection, $query);

            header('location:financeInboxSALES.php');
        }
    }
}
?>