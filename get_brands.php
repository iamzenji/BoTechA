<?php
include 'includes/connection.php';

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    $query = "SELECT DISTINCT brand FROM inventory WHERE category = '$category'";
    $result = mysqli_query($connection, $query);

    $output = '<option value="" selected disabled>Select brand</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<option value="' . $row['brand'] . '">' . $row['brand'] . '</option>';
    }
    echo $output;
}
