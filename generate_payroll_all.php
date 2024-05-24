<?php
// Start the session
include 'includes/connection.php';
include 'includes/header.php';

date_default_timezone_set('Asia/Manila');

// Check if the form is submitted and if the form values are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['from_date']) && isset($_POST['to_date'])) {
    // Retrieve selected dates from the form
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // Generate payroll for all employees based on the selected dates
    $payroll_data = generatePayrollForAllEmployees($connection, $from_date, $to_date);
}

// Function to calculate total hours worked for an employee within a date range
function calculateTotalHours($connection, $employee_id, $from_date, $to_date)
{
    $sql_total_hours = "SELECT SUM(
                            TIME_TO_SEC(TIMEDIFF(
                                time_out,
                                time_in
                            )) + 
                            IFNULL(
                                TIME_TO_SEC(TIMEDIFF(
                                    broken_time_out,
                                    broken_time_in
                                )), 
                                0
                            )
                        ) / 3600 AS total_hours 
                        FROM dtrrevised 
                        WHERE employee_id = ? AND date BETWEEN ? AND ?";
    $stmt_total_hours = $connection->prepare($sql_total_hours);
    $stmt_total_hours->bind_param("iss", $employee_id, $from_date, $to_date);
    $stmt_total_hours->execute();
    $result_total_hours = $stmt_total_hours->get_result();
    $row_total_hours = $result_total_hours->fetch_assoc();
    if ($row_total_hours !== null) {
        return round($row_total_hours['total_hours'], 0); // Round to 0 decimal places
    } else {
        return 0; // Return 0 if no hours worked
    }
}

// Function to calculate total break hours for an employee within a date range
function calculateTotalBreakHours($connection, $employee_id, $from_date, $to_date)
{
    $sql_total_break_hours = "SELECT SUM(
        TIME_TO_SEC(TIMEDIFF(
            break_in,
            break_out
        )) + 
        IFNULL(
            TIME_TO_SEC(TIMEDIFF(
                broken_break_in,
                broken_break_out
            )), 
            0
        )
    ) / 3600 AS total_break_hours 
    FROM dtrrevised 
    WHERE employee_id = ? AND date BETWEEN ? AND ?";
    $stmt_total_break_hours = $connection->prepare($sql_total_break_hours);
    $stmt_total_break_hours->bind_param("iss", $employee_id, $from_date, $to_date);
    $stmt_total_break_hours->execute();
    $result_total_break_hours = $stmt_total_break_hours->get_result();
    $row_total_break_hours = $result_total_break_hours->fetch_assoc();
    if ($row_total_break_hours !== null) {
        return round($row_total_break_hours['total_break_hours'], 0); // Round to 2 decimal places
    } else {
        return 0; // Return 0 if no break hours
    }
}

// Function to generate payroll for all employees
function generatePayrollForAllEmployees($connection, $from_date, $to_date)
{
    $payroll_data = array();

    // Fetch employee details including salary information
    $sql_employee_data = "SELECT e.employee_id, e.employee_name, s.insurance, s.sss, s.pag_ibig, s.tax, s.pay_per_hour 
                          FROM employee_details e 
                          LEFT JOIN employee_salary s ON e.employee_id = s.employee_id 
                          ORDER BY e.employee_id";
    $result_employee_data = $connection->query($sql_employee_data);

    // Loop through each employee data
    while ($row_employee_data = $result_employee_data->fetch_assoc()) {
        $employee_id = $row_employee_data['employee_id'];
        $employee_name = $row_employee_data['employee_name'];

        // Calculate total hours worked for the employee within the specified date range
        $total_hours_worked = calculateTotalHours($connection, $employee_id, $from_date, $to_date);

        // Calculate total break hours for the employee within the specified date range
        $total_break_hours = calculateTotalBreakHours($connection, $employee_id, $from_date, $to_date);

        // Calculate gross salary based on total work hours minus total break hours
        $net_work_hours = $total_hours_worked - $total_break_hours;
        $gross_salary = $net_work_hours * $row_employee_data['pay_per_hour'];

        // Calculate total deductions
        $total_deductions = $row_employee_data['insurance'] + $row_employee_data['sss'] + $row_employee_data['pag_ibig'] + $row_employee_data['tax'];

        // Calculate total salary
        $total_salary = $gross_salary - $total_deductions;

        // Store payroll data for the employee including the dates
        $payroll_data[] = array(
            'employee_id' => $employee_id,
            'employee_name' => $employee_name,
            'total_hours_in_shift' => $total_hours_worked,
            'total_break_hours' => $total_break_hours,
            'total_hours_worked' => $net_work_hours,
            'pay_per_hour' => $row_employee_data['pay_per_hour'],
            'gross_salary' => $gross_salary,
            'total_deductions' => $total_deductions,
            'insurance' => $row_employee_data['insurance'],
            'sss' => $row_employee_data['sss'],
            'pag_ibig' => $row_employee_data['pag_ibig'],
            'tax' => $row_employee_data['tax'],
            'total_salary' => $total_salary,
            'from_date' => date("F j, Y", strtotime($from_date)),
            'to_date' => date("F j, Y", strtotime($to_date))
        );
    }

    return $payroll_data;
}

// Fetch previous payroll history
$sql_previous_payroll = "SELECT payroll_date_released, payroll_date_from, payroll_date_to FROM payroll_all_history";
$result_previous_payroll = $connection->query($sql_previous_payroll);

// Check if confirm button is pressed
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_payroll'])) {
//     // Check if payroll data is set
//     if (isset($payroll_data)) {
//         // Insert payroll data into payroll_all_history table
//         $from_date = $_POST['from_date'];
//         $to_date = $_POST['to_date'];
//         $date_released = date('Y-m-d H:i:s'); // Current date and time

//         $sql_insert_payroll = "INSERT INTO payroll_all_history (payroll_date_from, payroll_date_to, payroll_date_released) VALUES (?, ?, ?)";
//         $stmt_insert_payroll = $connection->prepare($sql_insert_payroll);
//         $stmt_insert_payroll->bind_param("sss", $from_date, $to_date, $date_released);
//         $stmt_insert_payroll->execute();

//         // Display success message and redirect
//         echo "<script>alert('Payroll released successfully.'); window.location.href = 'generate_payroll_all.php';</script>";

//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Payroll for All Employees</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        #container {
            max-width: auto;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        h2 {
            text-align: center;
        }

        form {
            margin-bottom:
                20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
            border: 1px solid #000000;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media (max-width: 768px) {
            #container {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div id="container">
        <h2>Generate Payroll for All Employees</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="from_date">From Date:</label>
                <input type="date" id="from_date" name="from_date" max="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label for="to_date">To Date:</label>
                <input type="date" id="to_date" name="to_date" max="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <button type="submit" name="generate_payroll">Generate Payroll for All Employees</button>
        </form>

        <?php if (isset($payroll_data)): ?>
            <h2>Payroll for All Employees</h2>
            <?php if (!empty($payroll_data)): ?>
                <form method="post" action="generate_salary_all_database.php">
                    <input type="hidden" name="from_date" value="<?php echo $from_date; ?>">
                    <input type="hidden" name="to_date" value="<?php echo $to_date; ?>">
                    <input type="hidden" name="confirm_payroll">
                    <input type="hidden" name="payroll_data"
                        value="<?php echo htmlspecialchars(json_encode($payroll_data)); ?>">
                    <table>
                        <thead>
                            <tr>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Total Hours in Shift</th>
                                <th>Total Break Hours</th>
                                <th>Total Hours Worked</th>
                                <th>Pay Per Hour</th>
                                <th>Gross Salary</th>
                                <th>Insurance</th>
                                <th>SSS</th>
                                <th>PAG-IBIG</th>
                                <th>Withholding Tax</th>
                                <th>Total Deductions</th>
                                <th>Total Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payroll_data as $employee_payroll): ?>
                                <?php
                                // Calculate net work hours for this employee
                                $net_work_hours = $employee_payroll['total_hours_worked'] - $employee_payroll['total_break_hours'];
                                ?>
                                <tr>
                                    <!-- Existing table data remains the same -->
                                    <td><?php echo date("F j, Y", strtotime($employee_payroll['from_date'])); ?></td>
                                    <td><?php echo date("F j, Y", strtotime($employee_payroll['to_date'])); ?></td>
                                    <td><?php echo $employee_payroll['employee_id']; ?></td>
                                    <td><?php echo $employee_payroll['employee_name']; ?></td>
                                    <td><?php echo $employee_payroll['total_hours_in_shift']; ?></td>
                                    <td><?php echo $employee_payroll['total_break_hours']; ?></td>
                                    <td><?php echo $employee_payroll['total_hours_worked']; ?></td>
                                    <td><?php echo $employee_payroll['pay_per_hour']; ?></td>
                                    <td><?php echo $employee_payroll['gross_salary']; ?></td>
                                    <td><?php echo $employee_payroll['insurance']; ?></td>
                                    <td><?php echo $employee_payroll['sss']; ?></td>
                                    <td><?php echo $employee_payroll['pag_ibig']; ?></td>
                                    <td><?php echo $employee_payroll['tax']; ?></td>
                                    <td><?php echo $employee_payroll['total_deductions']; ?></td>
                                    <td><?php echo $employee_payroll['total_salary']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="confirm_payroll">Confirm</button>
                </form>
            <?php else: ?>
                <p>No payroll data available for the selected period.</p>
            <?php endif; ?>
        <?php endif; ?>

        <h2>Previous Payroll History</h2>
        <?php if ($result_previous_payroll !== null && $result_previous_payroll->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date Released</th>
                        <th>From Date</th>
                        <th>To Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_previous_payroll->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date("F j, Y", strtotime($row['payroll_date_released'])); ?></td>
                            <td><?php echo date("F j, Y", strtotime($row['payroll_date_from'])); ?></td>
                            <td><?php echo date("F j, Y", strtotime($row['payroll_date_to'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No previous payroll history available.</p>
        <?php endif; ?>

    </div>
</body>

</html>