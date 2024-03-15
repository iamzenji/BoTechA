<?php 
include 'connection.php';
include 'sidebar.php';
$sql = "SELECT * FROM employee_details";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee List</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
  
  .employee {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      border: 1px solid #000000; 
      margin-bottom: 25px;
    }

    .employee img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin-bottom: 10px;
    }
    
    
  </style>
</head>
<body>

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

   
    $conn->close();
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
            <input type="text" class="form-control" id="employeePosition" name="employeePosition" pattern="[A-Za-z\s]+" title="Please enter valid Employee Position" required>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
