<?php
include 'includes/connection.php';

if (isset($_POST['addReturn'])) {

    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $unitQuantity = $_POST['unitQuantity'];

    $query = "INSERT INTO return_item (category, brand, type, unit_qty) VALUES ('$category', '$brand', '$type', '$unitQuantity')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "Return item added successfully!";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
    header("Location: inventory_return.php");
    exit();
}
