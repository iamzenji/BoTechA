<?php

include 'includes/connection.php';

if (isset($_POST['deletedata'])) {
  // Establish a connection to the database
  $connection = mysqli_connect("localhost", "root", "");
  $db = mysqli_select_db($connection, 'botecha');

  // Get the supplier ID to be deleted
  $delete_id = $_POST['delete_id'];

  // Query to delete the supplier based on the supplier ID
  $query = "DELETE FROM supplier WHERE supplier_id = '$delete_id'";
  $query_run = mysqli_query($connection, $query);

  // Check if the query was executed successfully
  if ($query_run) {
    header("Location: supplier.php?Successfully=deleted");
  } else {
    // If not successful, display an error message
    echo '<script> alert("Data Not Deleted"); </script>';
  }
}
