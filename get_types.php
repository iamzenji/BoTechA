<?php
include 'includes/connection.php';

if (isset($_POST['brand'])) {
    $brand = $_POST['brand'];
    $query = "SELECT DISTINCT type FROM inventory WHERE brand = '$brand'";
    $result = mysqli_query($connection, $query);

    $output = '<option value="" selected disabled>Select type</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<option value="' . $row['type'] . '">' . $row['type'] . '</option>';
    }
    echo $output;
}
