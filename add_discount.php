<?php
session_start();

include 'includes/connection.php';

if (isset($_POST['addDiscount'])) {

    if (
        isset($_POST['category']) &&
        isset($_POST['brand']) &&
        isset($_POST['type']) &&
        isset($_POST['value']) &&
        isset($_POST['unitQuantity'])
    ) {
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $brand = mysqli_real_escape_string($connection, $_POST['brand']);
        $type = mysqli_real_escape_string($connection, $_POST['type']);
        $value = mysqli_real_escape_string($connection, $_POST['value']);
        $unitQuantity = mysqli_real_escape_string($connection, $_POST['unitQuantity']);

        $query = "INSERT INTO discounted_item (category, brand, type, value, unit_qty) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $category, $brand, $type, $value, $unitQuantity);

        if (mysqli_stmt_execute($stmt)) {
            echo "Discounted item inserted successfully.<br>";
            mysqli_stmt_close($stmt);
        } else {
            echo "Error inserting discounted item: " . mysqli_error($connection) . "<br>";
        }
        header("Location: inventory_discount.php");
        exit();
    } else {

        echo "Invalid POST data";
    }
}
