<?php
session_start();
include 'includes/connection.php';

// Retrieve employee information from the database
$sql_employee = "SELECT * FROM employee_details WHERE employee_id = {$_SESSION['employee_id']}";
$result_employee = $connection->query($sql_employee);

if ($result_employee->num_rows > 0) {
    $row_employee = $result_employee->fetch_assoc();
    $employee_name = $row_employee['employee_name'];
    $employee_position = $row_employee['employee_position'];
    $employee_contact = $row_employee['employee_contact'];
    $employee_datestart = $row_employee['employee_datestart'];
} else {
    echo "Employee information not found.";
    exit();
}

// Retrieve DTR records for the logged-in employee
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['from_date']) && isset($_POST['to_date'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $sql_dtr = "SELECT * FROM dtrRevised WHERE employee_id = {$_SESSION['employee_id']} AND date BETWEEN '$from_date' AND '$to_date'";
    $result_dtr = $connection->query($sql_dtr);
} else {
    // Default: Retrieve all DTR records
    $sql_dtr = "SELECT * FROM dtrRevised WHERE employee_id = {$_SESSION['employee_id']}";
    $result_dtr = $connection->query($sql_dtr);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Time Record</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <!-- Add jQuery UI library -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
    $( function() {
        // Datepicker for "From" and "To" dates
        $( "#from_date, #to_date" ).datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
    </script>
</head>
<body>
    <h2>Employee Information</h2>
    <p><strong>Name:</strong> <?php echo $employee_name; ?></p>
    <p><strong>Position:</strong> <?php echo $employee_position; ?></p>
    <p><strong>Contact:</strong> <?php echo $employee_contact; ?></p>
    <p><strong>Date Started:</strong> <?php echo $employee_datestart; ?></p>

    <h2>Daily Time Record</h2>
    <form method="post">
        <label for="from_date">From:</label>
        <input type="text" id="from_date" name="from_date" required>
        <label for="to_date">To:</label>
        <input type="text" id="to_date" name="to_date" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($result_dtr->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_dtr = $result_dtr->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row_dtr['date']; ?></td>
                        <td><?php echo $row_dtr['time_in']; ?></td>
                        <td><?php echo $row_dtr['time_out']; ?></td>
                        <td><?php echo $row_dtr['remarks']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No DTR records found.</p>
    <?php endif; ?>

    <form action="record_time_employee.php?id=<?php echo $_SESSION['employee_id']; ?>" method="post">
        <button type="submit" name="time_in" class="btn btn-primary">Time In</button>
        </form>
        <form action="record_time_employee.php?id=<?php echo $_SESSION['employee_id']; ?>" method="post">
        <button type="submit" name="time_out" class="btn btn-primary">Time Out</button>
        </form>

</body>
</html>

<?php
// Close database connection
$connection->close();
?>
