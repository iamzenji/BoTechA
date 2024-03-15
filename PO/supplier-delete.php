<?php

include('db_conn.php');

$id = $_GET["id"];
$sql = "DELETE FROM `supplier_list` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  session_start();
  $_SESSION['message'] = "Record successfully deleted";
  header("Location: supplier.php");
} else {
  echo "Failed: " . mysqli_error($conn);
}
?>