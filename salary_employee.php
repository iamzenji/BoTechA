<?php
// Start the session
session_start();
include 'includes/connection.php';
include 'includes/header.php';

date_default_timezone_set('Asia/Manila');

// Get employee ID from the URL
$employee_id = $_SESSION['employee_id'];


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
    <link rel="stylesheet" type="text/css" href="stylee.css">

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
        <caption>Previous Payroll</caption>
        <table class="roundtable">
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
    </div>
</body>

</html>