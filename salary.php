<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
  header('location:login.php');
  session_destroy();
} else {

  date_default_timezone_set('Asia/Manila');

  // Get employee ID from the URL
  if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];
  } else {
    // Handle case where employee ID is not provided
    exit('Employee ID not provided.');
  }

  // Fetch data for the specific employee from the employee_details table
  $sql_employee = "SELECT employee_name, insurance, tax, pay_per_hour, date
                   FROM employee_details AS ed
                   JOIN employee_salary AS es ON ed.employee_id = es.employee_id
                   WHERE ed.employee_id = ?";
  $stmt_employee = $connection->prepare($sql_employee);
  $stmt_employee->bind_param("i", $employee_id);
  $stmt_employee->execute();
  $result_employee = $stmt_employee->get_result();

  // Fetch data for the specific employee from the employee_salary_revised table
  $sql_employee_revised = "SELECT ed.employee_name, esr.insurance, esr.tax, esr.pay_per_hour, esr.date, esr.hours_worked
                           FROM employee_details AS ed
                           JOIN employee_salary_revised AS esr ON ed.employee_id = esr.employee_id
                           WHERE ed.employee_id = ?";
  $stmt_employee_revised = $connection->prepare($sql_employee_revised);
  $stmt_employee_revised->bind_param("i", $employee_id);
  $stmt_employee_revised->execute();
  $result_employee_revised = $stmt_employee_revised->get_result();

  // Initialize $total_hours_worked outside the loop
  $total_hours_worked = 0;

  // Function to calculate total salary based on hours worked and pay per hour
  function calculateTotalSalary($hours_worked, $pay_per_hour, $insurance, $tax)
  {
    $totalSalary = $hours_worked * $pay_per_hour;
    // Subtract insurance and tax from total salary
    $totalSalary -= $insurance;
    $totalSalary -= $tax;
    return $totalSalary;
  }
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>


    <style>
      th {
        text-align: center;
        border-radius: 20px;
      }

      table,
      th,
      td {
        border: 2px solid #000;
        border-collapse: collapse;
      }

      th,
      td {
        padding: 10px;
        width: 130px;
      }

      td {
        background-color: #8FA8FF;
        font-family: monospace;
      }
    </style>
  </head>

  <body>

    <div id="container">
      <table class="roundtable">
        <caption>Current Payroll</caption>
        <tr>
          <th>Employee Name</th>
          <th>Insurance</th>
          <th>Tax</th>
          <th>Pay Per Hour</th>
          <th>Hours Worked</th>
          <th>Total Salary</th>
          <th>Release Salary Date</th>
          <th>Action</th>
        </tr>

        <?php
        // Loop through the fetched data from employee_salary and display it in the table
        while ($row_employee = $result_employee->fetch_assoc()) {
          $employeeName = $row_employee['employee_name'];
          $insurance = number_format($row_employee['insurance']);
          $tax = number_format($row_employee['tax']);
          $payPerHour = number_format($row_employee['pay_per_hour']);
          $date = $row_employee['date'];


          // Fetch data for the specific employee from the dtrrevised table to calculate total hours worked
          $sql_dtr = "SELECT time_in, time_out FROM dtrrevised WHERE employee_id = ?";
          $stmt_dtr = $connection->prepare($sql_dtr);
          $stmt_dtr->bind_param("i", $employee_id);
          $stmt_dtr->execute();
          $result_dtr = $stmt_dtr->get_result();

          // Calculate total hours worked
          $total_hours_worked = 0;
          while ($row_dtr = $result_dtr->fetch_assoc()) {
            $time_in = strtotime($row_dtr['time_in']);
            $time_out = strtotime($row_dtr['time_out']);
            $total_hours_worked += ($time_out - $time_in) / (60 * 60); // Convert seconds to hours
            // Store the value of total hours worked in another variable
            $total_hours_worked_stored = $total_hours_worked;
          }

          // Close statement
          $stmt_dtr->close();

          // Fetch all previous hours worked records from the employee_salary_revised table
          $sql_previous_hours = "SELECT hours_worked FROM employee_salary_revised WHERE employee_id = ?";
          $stmt_previous_hours = $connection->prepare($sql_previous_hours);
          $stmt_previous_hours->bind_param("i", $employee_id);
          $stmt_previous_hours->execute();
          $result_previous_hours = $stmt_previous_hours->get_result();

          // Initialize total previous hours worked
          $total_previous_hours_worked = 0;

          // Calculate total previous hours worked
          while ($row_previous_hours = $result_previous_hours->fetch_assoc()) {
            $total_previous_hours_worked += $row_previous_hours['hours_worked'];
          }

          // Close statement
          $stmt_previous_hours->close();

          // Subtract total previous hours worked from the current total hours worked
          $total_hours_worked = max(0, $total_hours_worked_stored - $total_previous_hours_worked);

          // Store the adjusted total hours worked in session
          $_SESSION['total_hours_worked'] = $total_hours_worked;

          // Calculate total salary based on hours worked, pay per hour, insurance, and tax
          $totalSalary = calculateTotalSalary($total_hours_worked, $row_employee['pay_per_hour'], $row_employee['insurance'], $row_employee['tax']);

          // Format total salary with commas
          $formattedTotalSalary = number_format($totalSalary);

          // Display the data in the table
          echo '<tr>';
          echo '<td>' . $employeeName . '</td>';
          echo '<td>' . $insurance . '</td>';
          echo '<td>' . $tax . '</td>';
          echo '<td>' . $payPerHour . '</td>';
          echo '<td>' . $total_hours_worked . '</td>'; // Display total hours worked
          echo '<td>' . $formattedTotalSalary . '</td>';
          echo '<td>' . $date . '</td>';
          echo '<td>';
          echo '<a href="edit_pay_per_hour.php?id=' . $employee_id . '">Edit Pay Per Hour</a> | ';
          echo '<a href="edit_insurance.php?id=' . $employee_id . '">Edit Insurance</a> | ';
          echo '<a href="edit_tax.php?id=' . $employee_id . '">Edit Tax</a> | ';
          echo '<a href="release_payroll.php?id=' . $employee_id . '">Release</a>';
          echo '</td>';
          echo '</tr>';
        }
        ?>

      </table>

      <table class="roundtable">
        <caption>Previous Payroll</caption>
        <tr>
          <th>Employee Name</th>
          <th>Insurance</th>
          <th>Tax</th>
          <th>Pay Per Hour</th>
          <th>Hours Worked</th>
          <th>Total Salary</th>
          <th>Release Salary Date</th>
        </tr>

        <?php
        // Loop through the fetched data from employee_salary_revised and display it in the table
        while ($row_employee_revised = $result_employee_revised->fetch_assoc()) {
          $employeeName = $row_employee_revised['employee_name'];
          $insurance = number_format($row_employee_revised['insurance']);
          $tax = number_format($row_employee_revised['tax']);
          $payPerHour = number_format($row_employee_revised['pay_per_hour']);
          $hoursWorked = $row_employee_revised['hours_worked']; // Retrieve hours worked from the database
          $date = $row_employee_revised['date'];

          // Calculate total salary based on hours worked, pay per hour, insurance, and tax
          $totalSalary = calculateTotalSalary($hoursWorked, $row_employee_revised['pay_per_hour'], $row_employee_revised['insurance'], $row_employee_revised['tax']);

          // Format total salary with commas
          $formattedTotalSalary = number_format($totalSalary);

          // Display the data in the table
          echo '<tr>';
          echo '<td>' . $employeeName . '</td>';
          echo '<td>' . $insurance . '</td>';
          echo '<td>' . $tax . '</td>';
          echo '<td>' . $payPerHour . '</td>';
          echo '<td>' . $hoursWorked . '</td>'; // Display hours worked from the database
          echo '<td>' . $formattedTotalSalary . '</td>';
          echo '<td>' . $date . '</td>';
          echo '</td>';
          echo '</tr>';
        }
        ?>

      </table>
      <!-- para sa generate salary data button -->
      <!-- <form method="post" action="generate_salary.php?id=">
          <button type="submit">Generate new Salary Data</button>
      </form> -->
    </div>
  </body>

  </html>

<?php } ?>