<?php
include 'includes/connection.php';
include 'includes/header.php';

if(strlen($_SESSION['employee_id'])===0)
	{	
header('location:login.php');
session_destroy();

}
else{

// Fetch data from the database
$sql = "SELECT ed.employee_name, es.salary, es.insurance, es.tax
        FROM employee_details AS ed
        JOIN employee_salary AS es 
        ON ed.employee_id = es.employee_id";
$result = $connection->query($sql);
?>
<div id="container">
  <table class="roundtable">
    <tr>
      <th>Employee Name</th>
      <th>Salary</th>
      <th>Insurance</th>
      <th>Tax</th>
      <th>Total Salary</th>
    </tr>

    <?php
    // Loop through the fetched data and display it in the table
    while ($row = $result->fetch_assoc()) {
      $employeeName = $row['employee_name'];
      $salary = number_format($row['salary']);
      $insurance = number_format($row['insurance']);
      $tax = number_format($row['tax']);

      // Ensure numeric values before performing calculations
      $numericSalary = floatval(str_replace(',', '', $row['salary']));
      $numericInsurance = floatval(str_replace(',', '', $row['insurance']));
      $numericTax = floatval(str_replace(',', '', $row['tax']));

      // Calculate total salary (Salary - Insurance - Tax)
      $totalSalary = $numericSalary - ($numericInsurance + $numericTax);

      // Format total salary with commas
      $formattedTotalSalary = number_format($totalSalary);

      // Display the data in the table
      echo '<tr>';
      echo '<td>' . $employeeName . '</td>';
      echo '<td>' . $salary . '</td>';
      echo '<td>' . $insurance . '</td>';
      echo '<td>' . $tax . '</td>';
      echo '<td>' . $formattedTotalSalary . '</td>';
      echo '</tr>';
    }

    // Close the result set and the database connection
    $result->close();
    $connection->close();
    ?>


  </table>
</div>

<?php } ?>