<?php
include 'includes/connection.php';

if (isset($_POST['supplier'])) {
    $supplier = $_POST['supplier'];
    $query = "SELECT DISTINCT category FROM inventory WHERE supplier = '$supplier'";
    $result = mysqli_query($connection, $query);

    $output = '<option value="" selected disabled>Select category</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<option value="' . $row['category'] . '">' . $row['category'] . '</option>';
    }
    echo $output;
}
