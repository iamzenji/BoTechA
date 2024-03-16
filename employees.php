<?php
include 'includes/connection.php';
include 'includes/header.php';
$sql = "SELECT * FROM employee_details";
$result = $connection->query($sql);

?>

<div class="container">
  <div class="row">
    <div class="col-md-12 mb-4">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmployeeModal">Add Employee</button>
    </div>

    <?php
    // Loop through each row from the database result
    while ($row = $result->fetch_assoc()) {
      $employeeName = $row['employee_name'];
      $position = $row['employee_position'];
      $employeeContact = $row['employee_contact'];

      // Output the HTML structure for each employee
      echo '<div class="col-md-4">';
      echo '<div class="employee">';
      echo '<img src="https://via.placeholder.com/100" alt="' . $employeeName . '">';
      echo '<h3>' . $employeeName . '</h3>';
      echo '<p>Position: ' . $position . '</p>';
      echo '<p>Employee Contact: ' . $employeeContact . '</p>';
      echo '</div>';
      echo '</div>';
    }

    $connection->close();
    ?>

  </div>
</div>

<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="add_employee.php" method="post">
          <div class="form-group">
            <label for="employeeName">Employee Name</label>
            <input type="text" class="form-control" id="employeeName" name="employeeName" pattern="[A-Za-z\s]+" title="Please enter valid Employee Name" required>
          </div>

          <div class="form-group">
            <label for="employeePosition">Position</label>
            <select class="form-control" id="employeePosition" name="employeePosition" required>
              <option value="" disabled selected>Select Position</option>
              <option value="Purchase Order Officer">Purchase Order Officer</option>
              <option value="Inventory Officer">Inventory Officer</option>
              <option value="Sales Officer - Cashier">Sales Officer - Cashier</option>
              <option value="Finance Officer">Finance Officer</option>
              <option value="HR Officer">HR Officer</option>
            </select>
          </div>
          <div class="form-group">
            <label for="employeeUsername">Employee Username</label>
            <input type="text" class="form-control" id="employeeUsername" name="employeeUsername" pattern="[\w@#$%^&*()\-]+" title="Please enter a valid username with letters, numbers, or special characters (@, #, $, %, ^, &, *, (, ), -)" required>
          </div>

          <div class="form-group">
            <label for="employeePassword">Employee Password</label>
            <input type="password" class="form-control" id="employeePassword" name="employeePassword" pattern=".{6,}" title="Password must be at least 6 characters long" required>
          </div>
          <div class="form-group">
            <label for="employeeContact">Employee Contact</label>
            <input type="text" class="form-control" id="employeeContact" name="employeeContact" pattern="09[0-9]{9}" title="Please enter a valid contact number starting with 09" placeholder="Starts with 09" required>
          </div>
          <div class="form-group">
            <label for="employeeDate">Employee Datestart</label>
            <input type="date" class="form-control" id="employeeDate" name="employeeDate" max="<?php echo date('Y-m-d'); ?>" required>
          </div>

          <button type="submit" class="btn btn-primary">Add Employee</button>
        </form>
      </div>
    </div>
  </div>
</div>