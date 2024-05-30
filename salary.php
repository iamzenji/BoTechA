<?php 
// Start the session
include 'includes/connection.php';
include 'includes/header.php';

date_default_timezone_set('Asia/Manila');

// Get employee ID from the URL
if(isset($_GET['id'])) {
    $employee_id = $_GET['id'];
} else {
    // Handle case where employee ID is not provided
    exit('Employee ID not provided.');
}

// Fetch data for the specific employee from the employee_details table
$sql_employee = "SELECT ed.employee_id, ed.employee_name, es.insurance, es.sss, es.pag_ibig, es.tax, es.pay_per_hour, date
                 FROM employee_details AS ed
                 JOIN employee_salary AS es ON ed.employee_id = es.employee_id
                 WHERE ed.employee_id = ?";
$stmt_employee = $connection->prepare($sql_employee);
$stmt_employee->bind_param("i", $employee_id);
$stmt_employee->execute();
$result_employee = $stmt_employee->get_result();

// Fetch data for the specific employee from the employee_salary_revised table
$sql_employee_revised = "SELECT esr.insurance, esr.sss, esr.pag_ibig, esr.tax, esr.pay_per_hour, esr.hours_worked, esr.from_date, esr.to_date, esr.gross_salary, esr.total_deductions, esr.total_salary
                         FROM employee_details AS ed
                         JOIN employee_salary_revised AS esr ON ed.employee_id = esr.employee_id
                         WHERE ed.employee_id = ?";
$stmt_employee_revised = $connection->prepare($sql_employee_revised);
$stmt_employee_revised->bind_param("i", $employee_id);
$stmt_employee_revised->execute();
$result_employee_revised = $stmt_employee_revised->get_result();

// Fetch DTR records for the employee from the dtrrevised table
$sql_dtr = "SELECT date, time_in, time_out, break_out, break_in, broken_time_in, broken_break_in, broken_break_out, broken_time_out FROM dtrrevised WHERE employee_id = ?";
$stmt_dtr = $connection->prepare($sql_dtr);
$stmt_dtr->bind_param("i", $employee_id);
$stmt_dtr->execute();
$result_dtr = $stmt_dtr->get_result();

// Function to calculate total salary based on hours worked and pay per hour
function calculateTotalSalary($hours_worked, $pay_per_hour, $insurance, $sss, $pag_ibig, $tax) {
    $grossSalary = $hours_worked * $pay_per_hour; // Calculate gross salary
    $totalSalary = $hours_worked * $pay_per_hour;
    // Subtract insurance and tax from total salary
    $totalSalary -= $insurance;
    $totalSalary -= $sss;
    $totalSalary -= $pag_ibig;
    $totalSalary -= $tax;
    $totalDeductions = $insurance + $sss + $pag_ibig + $tax;
    return array($grossSalary, $totalDeductions, $totalSalary); // Return both gross and total salary
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link rel="stylesheet" type="text/css" href="stylee.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
            body,
        button,
        input,
        select,
        textarea {
            font-family: 'Space Grotesk', sans-serif;
        }
    th {
    background-color: #8FA8FF;
      text-align: center;
      color: white;

    }

    table, th, td {
      border: 2px solid #000;
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      width: 130px;
    }

    td {

      font-family: monospace;
    }
        /* New styles for links and buttons */
        .action-links a {
      display: inline-block;
      padding: 5px 10px;
      margin-right: 5px;
      text-decoration: none;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }

    .action-links a:hover {
      background-color: #45a049;
    }

    .generate-button {
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      mar
      cursor: pointer;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .generate-button:hover {
      background-color: #0056b3;
    }
    .action-links button {
    display: inline-block;
    padding: 5px 10px;
    margin-right: 5px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-bottom: 5px;
}

.action-links button:hover {
    background-color: #45a049;
}
#container {
    text-align: center;
    margin-top: 20px; 
}

.caption {
    font-size: 24px; 
    font-weight: bold;
    margin-top: 20px; 
    padding-bottom: 10px; 
    margin-bottom: 20px; 
    color: #8FA8FF; 
    background: #091540;
    padding: 10px;
    color: White;
}

  </style>
</head>
<body>


<div id="container">
    <!-- Display DTR records -->
    <h4 class="caption">Daily Time Record</h4>
    <table align="center" class="roundtable">
        <tr>
            <th>Date</th>
            <th>Time In</th>
            <th>Break Out</th>
            <th>Break In</th>
            <th>Time Out</th>
            <th>Broken Time In</th>
            <th>Broken Break Out</th>
            <th>Broken Break In</th>
            <th>Broken Time Out</th>
            <th>Break Hours</th>
            <th>Hours Worked</th>
            <th>Status</th>
        </tr>
        <?php
        // Initialize total hours worked for DTR
        $total_hours_worked_dtr = 0;

        // Fetch previous payroll dates
        $previous_payroll_dates = [];
        while ($row_employee_revised = $result_employee_revised->fetch_assoc()) {
            $from_date = strtotime($row_employee_revised['from_date']);
            $to_date = strtotime($row_employee_revised['to_date']);
            while ($from_date <= $to_date) {
                $previous_payroll_dates[date('Y-m-d', $from_date)] = true;
                $from_date = strtotime('+1 day', $from_date);
            }
        }

                // Loop through the fetched DTR records and display them in the table
        while ($row_dtr = $result_dtr->fetch_assoc()) {
            // Convert date to a format where the month is in words
            $date = date("F j, Y", strtotime($row_dtr['date']));
            $status = isset($previous_payroll_dates[$row_dtr['date']]) ? 'Paid' : 'Unpaid';
            echo '<tr>';
            echo '<td>' . $date . '</td>';
            echo '<td>' . $row_dtr['time_in'] . '</td>';
            echo '<td>' . $row_dtr['break_out'] . '</td>';
            echo '<td>' . $row_dtr['break_in'] . '</td>';
            echo '<td>' . $row_dtr['time_out'] . '</td>';
            echo '<td>' . $row_dtr['broken_time_in'] . '</td>';
            echo '<td>' . $row_dtr['broken_break_out'] . '</td>';
            echo '<td>' . $row_dtr['broken_break_in'] . '</td>';
            echo '<td>' . $row_dtr['broken_time_out'] . '</td>';
            // Calculate hours worked
            $time_in = strtotime($row_dtr['time_in']);
            $time_out = strtotime($row_dtr['time_out']);
            $break_out = strtotime($row_dtr['break_out']);
            $break_in = strtotime($row_dtr['break_in']);
            $broken_time_in = isset($row_dtr['broken_time_in']) ? strtotime($row_dtr['broken_time_in']) : 0;
            $broken_break_out = isset($row_dtr['broken_break_out']) ? strtotime($row_dtr['broken_break_out']) : 0;
            $broken_break_in = isset($row_dtr['broken_break_in']) ? strtotime($row_dtr['broken_break_in']) : 0;
            $broken_time_out = isset($row_dtr['broken_time_out']) ? strtotime($row_dtr['broken_time_out']) : 0;
            
            // Calculate break time hours
            $break_time_hours = (($break_in - $break_out) + ($broken_break_in - $broken_break_out)) / (60 * 60); // Convert seconds to hours 
            $break_time_hours_rounded = round($break_time_hours, 0); // Round off to 2 decimal places

            // Calculate total hours worked including break time
            $hours_worked = (($time_out - $time_in) + ($broken_time_out - $broken_time_in)) / (60 * 60) - $break_time_hours_rounded;
            $hours_worked_rounded = round($hours_worked, 0); // Round off to 2 decimal places

            // Store hours worked for each date in the array
            $total_hours_worked_dtr += $hours_worked_rounded;

            // Display rounded break hours and rounded hours worked
            echo '<td>' . $break_time_hours_rounded . '</td>';
            echo '<td>' . $hours_worked_rounded . '</td>';
            echo '<td>' . $status . '</td>'; // Display status
            echo '</tr>';
        }
        // Display total hours worked at the end of the table
        echo '<tr>';
        echo '<td colspan="10" style="text-align: right;"><b>Total Hours Worked:</b></td>';
        echo '<td><b>' . round($total_hours_worked_dtr, 2) . '</b></td>'; // Round off total hours worked
        echo '</tr>';

        ?>
    </table>


    <!-- Current Payroll -->
    <h4 class ="caption">Current Payroll</h4>
    <table align="center" class="roundtable">
        <tr>
            <th>Employee Name</th>
            <th>Pay Per Hour</th>
            <th>Current Hours Worked</th>
            <th>Gross Salary</th>
            <th>PhilHealth</th>
            <th>SSS</th>
            <th>Pag-IBIG</th>
            <th>Withholding Tax</th>
            <th>Total Deductions</th>
            <th>Net Salary</th>
            <th>Action</th>
        </tr>
        <?php
        // Loop through the fetched data from employee_salary and display it in the table
while ($row_employee = $result_employee->fetch_assoc()) {
    // Retrieve data from the query result
    $employee_id = $row_employee['employee_id']; // Ensure the correct key is used
    $employeeName = $row_employee['employee_name'];
    $insurance = number_format($row_employee['insurance']);
    $sss = number_format($row_employee['sss']);
    $pag_ibig = number_format($row_employee['pag_ibig']);
    $tax = number_format($row_employee['tax']);
    $payPerHour = number_format($row_employee['pay_per_hour']);
    $date = $row_employee['date'];

    // Fetch total hours worked from employee_salary_revised for the current employee
$sql_previous_hours = "SELECT SUM(hours_worked) AS total_hours_worked FROM (SELECT DISTINCT date, hours_worked FROM employee_salary_revised WHERE employee_id = ?) AS unique_hours";
$stmt_previous_hours = $connection->prepare($sql_previous_hours);
$stmt_previous_hours->bind_param("i", $employee_id);
$stmt_previous_hours->execute();
$result_previous_hours = $stmt_previous_hours->get_result();

// Initialize total previous hours worked
$total_previous_hours_worked = 0;

// Fetch and calculate total previous hours worked
if ($row_previous_hours = $result_previous_hours->fetch_assoc()) {
    $total_previous_hours_worked = $row_previous_hours['total_hours_worked'];
}

// Close statement and result set
$stmt_previous_hours->close();

    // Calculate total hours worked (exclude duplicates)
    $total_hours_worked = max(0, $total_hours_worked_dtr - $total_previous_hours_worked);

    // Store the adjusted total hours worked in session
    $_SESSION['total_hours_worked'] = $total_hours_worked;

    // Calculate total salary based on hours worked, pay per hour, insurance, and tax
    list($grossSalary, $totalDeductions, $totalSalary) = calculateTotalSalary($total_hours_worked, $row_employee['pay_per_hour'], $row_employee['insurance'], $row_employee['sss'], $row_employee['pag_ibig'], $row_employee['tax']);

    // Format total salary with commas
    $formattedTotalSalary = number_format($totalSalary);

    // Display the data in the table
    echo '<tr>';
    echo '<td>' . $employeeName . '</td>';
    echo '<td>' . $payPerHour . '</td>';
    echo '<td>' . $total_hours_worked . '</td>'; // Display total hours worked
    echo '<td>' . $grossSalary . '</td>'; // Display gross salary
    echo '<td>' . $insurance . '</td>';
    echo '<td>' . $sss . '</td>';
    echo '<td>' . $pag_ibig . '</td>';
    echo '<td>' . $tax . '</td>';
    echo '<td>' . $totalDeductions . '</td>';
    echo '<td>' . $formattedTotalSalary . '</td>';
    echo '<td>';
    echo '<div class="action-links">';
    echo '<form method="get" action="edit_pay_per_hour.php">';
    echo '<input type="hidden" name="id" value="' . $employee_id . '">';
    echo '<button type="submit">Edit Pay Per Hour</button>';
    echo '</form>';
    echo '<form method="get" action="edit_insurance.php">';
    echo '<input type="hidden" name="id" value="' . $employee_id . '">';
    echo '<button type="submit">Edit Insurance</button>';
    echo '</form>';
    echo '<form method="get" action="edit_tax.php">';
    echo '<input type="hidden" name="id" value="' . $employee_id . '">';
    echo '<button type="submit">Edit Tax</button>';
    echo '</form>';
    echo '<form method="get" action="edit_sss.php">';
    echo '<input type="hidden" name="id" value="' . $employee_id . '">';
    echo '<button type="submit">Edit SSS</button>';
    echo '</form>';
    echo '<form method="get" action="edit_pag_ibig.php">';
    echo '<input type="hidden" name="id" value="' . $employee_id . '">';
    echo '<button type="submit">Edit Pag-IBIG</button>';
    echo '</form>';
    echo '</div>'; // Close the action-links div
    // echo '<a href="release_payroll.php?id=' . $employee_id . '">Release</a>';
    echo '</td>';
    echo '</tr>';
}

        ?>
    </table>
    
    <h4 class="caption">Previous Payroll/History</h4>
    <table align="center" class="roundtable">
    <tr>  
        
        <th>From Date</th>
        <th>To Date</th>
        <th>Pay Per Hour</th>
        <th>Total Hours Worked</th>
        <th>Gross Salary</th>
        <th>PhilHealth</th>
        <th>SSS</th>
        <th>Pag-IBIG</th>
        <th>Withholding Tax</th>
        <th>Total Deductions</th>
        <th>Net Salary</th>
    </tr>

    <?php
    // Reset the data seek pointer to the beginning of the result set
    mysqli_data_seek($result_employee_revised, 0);

    // Loop through the fetched data from employee_salary_revised and display it in the table
    while ($row_employee_revised = $result_employee_revised->fetch_assoc()) {
        $insurance = number_format($row_employee_revised['insurance']);
        $sss = number_format($row_employee_revised['sss']);
        $pag_ibig = number_format($row_employee_revised['pag_ibig']);
        $tax = number_format($row_employee_revised['tax']);
        $payPerHour = number_format($row_employee_revised['pay_per_hour']);
        $hoursWorked = $row_employee_revised['hours_worked']; // Retrieve hours worked from the database
        $to_date = $row_employee_revised['to_date'];
        $from_date = $row_employee_revised['from_date'];
        $grossSalary = number_format($row_employee_revised['gross_salary']);
        $totalDeductions = number_format($row_employee_revised['total_deductions']);
        $totalSalary = number_format($row_employee_revised['total_salary']);


        // Display the data in the table
        echo '<tr>';
        echo '<td>' . date("F j, Y", strtotime($from_date)) . '</td>'; // Format date with month in words
        echo '<td>' . date("F j, Y", strtotime($to_date)) . '</td>'; // Format date with month in words
        echo '<td>' . $payPerHour . '</td>';
        echo '<td>' . $hoursWorked . '</td>'; // Display hours worked from the database
        echo '<td>' . $grossSalary . '</td>';
        echo '<td>' . $insurance . '</td>';
        echo '<td>' . $sss . '</td>';
        echo '<td>' . $pag_ibig . '</td>'; 
        echo '<td>' . $tax . '</td>';
        echo '<td>' . $totalDeductions . '</td>';
        echo '<td>' . $totalSalary . '</td>';
        echo '</td>';
        echo '</tr>';
    }
    ?>

</table>
    <!-- para sa generate salary data button -->
    <form method="post" action="generate_salary.php?id=<?php echo $employee_id; ?>" style="text-align: center;">
        <button type="submit" class="generate-button">Generate New Salary Data</button>
    </form>
</div>
</body>
</html>
