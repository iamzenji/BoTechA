<?php

include 'includes/connection.php';


$id = $_GET["id"];
$sql = "DELETE FROM `supplier_list` WHERE id = $id";
$result = mysqli_query($connection, $sql);

if ($result) {
  session_start();
  $_SESSION['message'] = "Record successfully deleted";
  header("Location: supplier.php");
} else {
  echo "Failed: " . mysqli_error($connection);
}
