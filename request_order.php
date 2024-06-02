<?php

session_start();

include 'includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inventory_id = $_POST['inventory_id'];
    $supplier = $_POST['supplier'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $unit = $_POST['unit'];

    // Get the employee name from session
    if (isset($_SESSION['employee_id'])) {
      $employee_id = $_SESSION['employee_id'];
      $userName = "";
      $query = "SELECT employee_name FROM employee_details WHERE employee_id = '$employee_id' ";
      $result = mysqli_query($connection, $query);
  
      if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $userName = $row['employee_name'];
      }   

      // Insert into inventory_logs table
      $insert_query = "INSERT INTO inventory_logs (inventory_id, date, brand_name, type, unit, employee, reason) 
      VALUES ('$category', NOW(), '$brand', '$type', '$unit', '$userName', 'Request order')";
      $insert_result = mysqli_query($connection, $insert_query);

      // Product does not exist in inventory, insert new entry
      $insert_inventory_query = "INSERT INTO request_order (supplier, category, brand, type, unit) 
      VALUES ('$supplier', '$category', '$brand', '$type', '$unit')";
      if(mysqli_query($connection, $insert_inventory_query)) {
          echo "Inventory item inserted successfully.<br>";
      } else {
          echo "Error inserting inventory item: " . mysqli_error($connection) . "<br>";
      }

      // Check for successful insertion into inventory_logs
      if (!$insert_result) {
          echo "Error inserting into inventory_logs: " . mysqli_error($connection) . "<br>";
      }

      header("Location: inventory.php");

    } else {
        echo "Employee ID not set in session.";
    }

    

    $connection->close();
}
?>

