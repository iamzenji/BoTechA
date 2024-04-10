<?php

include 'includes/connection.php';

if (isset($_POST['deletedata'])) {
  $id = $_POST['delete_id'];

  // SQL query to delete the medicine item
  $query = "DELETE FROM medicine_list WHERE medicine_id = '$id'";
  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    echo '<script>alert("Medicine item deleted successfully.");</script>';
    echo '<script>window.location.href = "supplier-list.php";</script>'; // Redirect to the supplier list page
  } else {
    echo '<script>alert("Failed to delete medicine item. Please try again.");</script>';
    echo '<script>window.location.href = "supplier-list.php";</script>'; // Redirect back to the supplier list page
  }
}
