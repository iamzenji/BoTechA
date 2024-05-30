<?php

include 'includes/connection.php';
session_start();
function updateReturnStatus($returnId, $statusId) {
    global $connection;
    $status_check_query = "SELECT return_status_id FROM return_table WHERE id = $returnId";
    $status_check_result = mysqli_query($connection, $status_check_query);

    if ($status_check_result && mysqli_num_rows($status_check_result) > 0) {
        $status_row = mysqli_fetch_assoc($status_check_result);
        $current_status_id = $status_row['return_status_id'];
        if ($current_status_id != 2 && $current_status_id != 3) {
            $update_query = "UPDATE return_table SET return_status_id = $statusId WHERE id = $returnId";
            $update_result = mysqli_query($connection, $update_query);

            if ($update_result) {
                $_SESSION['message'] = "Return status updated.";
            } else {
                $_SESSION['message'] = "Error updating return status: " . mysqli_error($connection);
            }
        } else {
            $_SESSION['message'] = "Return status cannot be updated again.";
        }
    } else {
        $_SESSION['message'] = "Error checking return status.";
    }
}

if (isset($_POST['return_id']) && isset($_POST['status_name'])) {
    $return_id = $_POST['return_id'];
    $status_name = $_POST['status_name'];
    $statusId = 0; 
    switch ($status_name) {
        case 'Accepted':
            $statusId = 2;
            break;
        case 'Declined':
            $statusId = 3; 
            break;
    }
    if ($statusId !== 0) {
        updateReturnStatus($return_id, $statusId);
    } else {
        $_SESSION['message'] = "Error updating return status: Invalid status name.";
    }
    header("Location: return.php");
    exit();
}
if (isset($_POST['reportreturn'])) {
    $supplier_id = $_POST['supplier'];
    $transaction_number = $_POST['transaction_number'];
    $item = $_POST['item'];
    $reason_return = $_POST['reason_return'];
    $note = $_POST['note'];
    $status_query = "SELECT delivery_status_id FROM cart_table WHERE tracking_number = '$transaction_number'";
    $status_result = mysqli_query($connection, $status_query);

    if ($status_result && mysqli_num_rows($status_result) > 0) {
        $status_row = mysqli_fetch_assoc($status_result);
        $delivery_status_id = $status_row['delivery_status_id'];
        if ($delivery_status_id == 4 || $delivery_status_id == 5) {
            $insert_query = "INSERT INTO return_table (supplier_id, delivery_status_id, transaction_number, item, reason_return, Note, return_status_id) VALUES ('$supplier_id', '$delivery_status_id', '$transaction_number', '$item', '$reason_return', '$note', 1)";
            $insert_result = mysqli_query($connection, $insert_query);

            if ($insert_result) {
                $_SESSION['message'] = "Return reported.";
            } else {
                $_SESSION['message'] = "Error: " . mysqli_error($connection);
            }
        } else {
            $_SESSION['message'] = "Return reporting is only allowed for transactions where the order has been received.";
        }
    } else {
        $_SESSION['message'] = "Error: Unable to fetch delivery status.";
    }
    header("Location: return.php");
    exit();
}
if (isset($_POST['updateReturnStatus'])) {
    $return_id = $_POST['return_id'];
    $status_id = $_POST['status_id'];
    $status_name = $_POST['status_name'];
    updateReturnStatus($return_id, $status_id, $status_name);
    header("Location: return.php");
    exit();
}
