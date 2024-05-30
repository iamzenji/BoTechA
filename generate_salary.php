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

// Fetch the earliest and latest DTR record dates for the employee
$sql_dtr_dates = "SELECT MIN(date) AS min_date, MAX(date) AS max_date FROM dtrrevised WHERE employee_id = ?";
$stmt_dtr_dates = $connection->prepare($sql_dtr_dates);
$stmt_dtr_dates->bind_param("i", $employee_id);
$stmt_dtr_dates->execute();
$result_dtr_dates = $stmt_dtr_dates->get_result();

// Retrieve the earliest and latest DTR record dates
$row_dtr_dates = $result_dtr_dates->fetch_assoc();
$earliest_date = $row_dtr_dates['min_date'];
$latest_date = $row_dtr_dates['max_date'];

// Set the default "From" date to the earliest DTR record date
$from_date_default = $earliest_date;
$to_date_default = date("Y-m-d"); // Set the default "To" date to the current date

// Initialize variables to hold form data
$from_date = $from_date_default;
$to_date = $to_date_default;

// Fetch DTR records for the employee from the dtrrevised table
$sql_dtr = "SELECT date, time_in, time_out, break_out, break_in, broken_time_in, broken_break_out, broken_break_in, broken_time_out FROM dtrrevised WHERE employee_id = ?";
$stmt_dtr = $connection->prepare($sql_dtr);
$stmt_dtr->bind_param("i", $employee_id);
$stmt_dtr->execute();
$result_dtr = $stmt_dtr->get_result();

// Check if the form is submitted and if the form values are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['from_date']) && isset($_POST['to_date'])) {
    // Retrieve selected dates from the form
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    
    // Perform salary generation based on the selected dates
    // Your salary generation logic goes here...
    // Calculate total hours worked within the selected date range
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
    WHERE employee_id = ? AND date >= ? AND date <= ?";
$stmt_total_hours = $connection->prepare($sql_total_hours);
$stmt_total_hours->bind_param("iss", $employee_id, $from_date, $to_date);
$stmt_total_hours->execute();
$result_total_hours = $stmt_total_hours->get_result();
$row_total_hours = $result_total_hours->fetch_assoc();
$total_hours_worked = round($row_total_hours['total_hours'], 0); // Round to 2 decimal places

    // Calculate break hours within the selected date range
    $sql_break_hours = "SELECT SUM(
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
    ) / 3600 AS break_hours 
    FROM dtrrevised 
    WHERE employee_id = ? AND date >= ? AND date <= ?";
    $stmt_break_hours = $connection->prepare($sql_break_hours);
    $stmt_break_hours->bind_param("iss", $employee_id, $from_date, $to_date);
    $stmt_break_hours->execute();
    $result_break_hours = $stmt_break_hours->get_result();
    $row_break_hours = $result_break_hours->fetch_assoc();
    $break_hours = round($row_break_hours['break_hours'], 0); // Round to 2 decimal places

    // Calculate total hours worked excluding break hours
    $total_hours_worked = $total_hours_worked - $break_hours;
    $total_hours_worked_rounded = round($total_hours_worked,1);

    // Retrieve Insurance, Tax, and Pay Per Hour from employee_salary table
    $sql_salary_info = "SELECT insurance, sss, pag_ibig, tax, pay_per_hour FROM employee_salary WHERE employee_id = ?";
    $stmt_salary_info = $connection->prepare($sql_salary_info);
    $stmt_salary_info->bind_param("i", $employee_id);
    $stmt_salary_info->execute();
    $result_salary_info = $stmt_salary_info->get_result();
    $row_salary_info = $result_salary_info->fetch_assoc();
    $insurance = $row_salary_info['insurance'];
    $sss = $row_salary_info['sss'];
    $pag_ibig = $row_salary_info['pag_ibig'];
    $tax = $row_salary_info['tax'];
    $pay_per_hour = $row_salary_info['pay_per_hour'];

    // Calculate total salary
    $total_salary = ($total_hours_worked * $pay_per_hour) - $insurance - $sss - $pag_ibig - $tax;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generate Salary</title>
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
        color: white;
        text-align: center;
      background-color: #8FA8FF
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
      ;
      font-family: monospace;
    }
    button {
    padding: 10px 20px;
    background-color: #0056b3; /* Set the background color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #004080; /* Darker shade for hover effect */
}

  </style>
</head>
<body>
    <div id="container">
        <!-- Display DTR records -->
    <h2>Daily Time Record</h2>
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
        </tr>
        <?php
        // Initialize total hours worked for DTR
        $total_hours_worked_dtr = 0;

        // Loop through the fetched DTR records and display them in the table
while ($row_dtr = $result_dtr->fetch_assoc()) {
    // Convert date to a format where the month is in words
    $date = date("F j, Y", strtotime($row_dtr['date']));
    echo '<tr>';
    echo '<td>' . $date . '</td>';
    echo '<td>' . $row_dtr['time_in'] . '</td>';
    echo '<td>' . $row_dtr['break_out'] . '</td>';

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
    
    echo '<td>' . $row_dtr['break_in'] . '</td>';
    echo '<td>' . $row_dtr['time_out'] . '</td>';
    echo '<td>' . $row_dtr['broken_time_in'] . '</td>';
    echo '<td>' . $row_dtr['broken_break_out'] . '</td>';
    echo '<td>' . $row_dtr['broken_break_in'] . '</td>';
    echo '<td>' . $row_dtr['broken_time_out'] . '</td>';
    // Round break time hours to 2 decimal places
    $rounded_break_hours = round($break_time_hours, 0);
    echo '<td>' . $rounded_break_hours . '</td>';   

    // Calculate total hours worked including break time
    $hours_worked = (($time_out - $time_in) + ($broken_time_out - $broken_time_in)) / (60 * 60) - $rounded_break_hours;

    // Store hours worked for each date in the array
    $total_hours_worked_dtr += $hours_worked;

    // Round hours worked to 2 decimal places
    $rounded_hours_worked = round($hours_worked, 0);
    echo '<td>' . $rounded_hours_worked . '</td>';
    echo '</tr>';

    
}
// Display total hours worked at the end of the table
echo '<tr>';
echo '<td colspan="10" style="text-align: right;"><b>Total Hours Worked:</b></td>';
// Round total hours worked to 2 decimal places
$total_hours_worked_dtr_rounded = round($total_hours_worked_dtr, 0);
echo '<td><b>' . $total_hours_worked_dtr_rounded . '</b></td>';
echo '</tr>';      
        ?>
    </table>
    <h2>Generate Salary</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $employee_id; ?>" onsubmit="return validateDate()">
            <div class="form-group">
                <label for="from_date">From Date:</label>
                <input type="date" id="from_date" name="from_date" value="<?php echo $from_date; ?>" min="<?php echo $earliest_date; ?>" max="<?php echo $latest_date; ?>" required>
            </div>
            <div class="form-group">
                <label for="to_date">To Date:</label>
                <input type="date" id="to_date" name="to_date" value="<?php echo $to_date; ?>" min="<?php echo $from_date_default; ?>" max="<?php echo $latest_date; ?>" required oninput="setToDateMin()">
            </div>
            <button type="submit">Generate Salary</button>
        </form>
        
        <!-- Table to display DTR records within the selected date range -->
        <h2>Payroll for Selected Dates</h2>
        <table align="center" class="roundtable">
            <tr>
                <th>From Date</th>
                <th>To Date</th>
                <th>Pay Per Hour</th>
                <th>Current Hours Worked</th>
                <th>Gross Salary</th>
                <th>PhilHealth</th>
                <th>SSS</th>
                <th>Pag-IDIG</th>
                <th>Withholding Tax</th>
                <th>Total Deductions</th>
                <th>Net Salary</th>
            </tr>
            <?php
            if (isset($total_hours_worked_rounded)) {
                $from_date_formatted = date("F j, Y", strtotime($from_date));
                $to_date_formatted = date("F j, Y", strtotime($to_date));
     
                echo '<tr>';
                echo '<td>' . $from_date_formatted . '</td>';
                echo '<td>' . $to_date_formatted . '</td>';
                echo '<td>' . $pay_per_hour . '</td>';
                echo '<td>' . $total_hours_worked_rounded   . '</td>';

                // Calculate gross salary
                $gross_salary = ($total_hours_worked_rounded * $pay_per_hour);
                echo '<td>' . $gross_salary . '</td>';

                echo '<td>' . $insurance . '</td>';
                echo '<td>' . $sss . '</td>';
                echo '<td>' . $pag_ibig . '</td>';
                echo '<td>' . $tax . '</td>';

                // Calculate total deductions
                $total_deductions = $insurance + $sss + $pag_ibig + $tax;
                echo '<td>' . $total_deductions . '</td>';

                // Calculate total salary
                $total_salary = $gross_salary - $total_deductions;
                echo '<td>' . $total_salary . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
        <form method="post" action="generate_salary_database.php">
            <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
            <input type="hidden" name="from_date" value="<?php echo $from_date; ?>">
            <input type="hidden" name="to_date" value="<?php echo $to_date; ?>">
            <input type="hidden" name="total_hours_worked" value="<?php echo $total_hours_worked_rounded; ?>">
            <input type="hidden" name="insurance" value="<?php echo $insurance; ?>">
            <input type="hidden" name="sss" value="<?php echo $sss; ?>">
            <input type="hidden" name="pag_ibig" value="<?php echo $pag_ibig; ?>">
            <input type="hidden" name="tax" value="<?php echo $tax; ?>">
            <input type="hidden" name="pay_per_hour" value="<?php echo $pay_per_hour; ?>">
            <input type="hidden" name="gross_salary" value="<?php echo $gross_salary; ?>">
            <input type="hidden" name="total_deductions" value="<?php echo $total_deductions; ?>">
            <input type="hidden" name="total_salary" value="<?php echo $total_salary; ?>">
            <button type="submit">Confirm</button>
        </form>
    </div>
    <script>
        function validateDate() {
            var fromDate = new Date(document.getElementById('from_date').value);
            var toDate = new Date(document.getElementById('to_date').value);

            if (toDate < fromDate) {
                alert('To date must not be less than from date');
                return false;
            }

            return true;
        }

        function setToDateMin() {
            var fromDate = new Date(document.getElementById('from_date').value);
            document.getElementById('to_date').min = fromDate.toISOString().split('T')[0];
        }
    </script>
</body>
</html>