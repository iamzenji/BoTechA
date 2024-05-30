<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Time Record</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <?php
// Include database connection file
include 'includes/connection.php';
session_start();

// Set timezone to Philippine Standard Time
date_default_timezone_set('Asia/Manila');

// Check if the employee ID is provided in the URL
if(isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // Retrieve employee information from the database based on the employee ID
    $sql_employee = "SELECT * FROM employee_details WHERE employee_id = $employee_id";
    $result_employee = $connection->query($sql_employee);

    if ($result_employee->num_rows > 0) {
        $row_employee = $result_employee->fetch_assoc();
        $employee_name = $row_employee['employee_name'];
        $employee_number = $row_employee['employee_number'];
        $employee_position = $row_employee['employee_position'];
        $employee_contact = $row_employee['employee_contact'];
        $employee_datestart = date('F j, Y', strtotime($row_employee['employee_datestart']));
        $employee_age = $row_employee['employee_age'];
        $employee_birthday = date('F j, Y', strtotime($row_employee['employee_birthday']));
        $employee_address = $row_employee['employee_address'];
        $employee_email = $row_employee['employee_email'];
        $employee_gender = $row_employee['employee_gender'];
        $employee_height = $row_employee['employee_height'];
        $employee_weight = $row_employee['employee_weight'];

        // Retrieve shift details for the employee
        $sql_shift = "SELECT * FROM shift WHERE employee_id = $employee_id";
        $result_shift = $connection->query($sql_shift);

        // Check if the employee has a shift
        $has_shift = ($result_shift->num_rows > 0);

        // Retrieve DTR records for the employee
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['from_date']) && isset($_POST['to_date'])) {
            $from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];

            $sql_dtr = "SELECT * FROM dtrRevised WHERE employee_id = $employee_id AND date BETWEEN '$from_date' AND '$to_date'";
            $result_dtr = $connection->query($sql_dtr);
        } else {
            // Default: Retrieve all DTR records
            $sql_dtr = "SELECT * FROM dtrRevised WHERE employee_id = $employee_id";
            $result_dtr = $connection->query($sql_dtr);
        }
    } else {
        echo "Employee information not found.";
        exit();
    }
} else {
    echo "Employee ID not provided.";
    exit();
}
?>

        <h2 class="mb-4">Employee Information</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Employee Details</h5>
                        <p class="card-text"><strong>Employee Number:</strong> <?php echo $employee_number; ?></p>
                        <p class="card-text"><strong>Name:</strong> <?php echo $employee_name; ?></p>
                        <p class="card-text"><strong>Position:</strong> <?php echo $employee_position; ?></p>
                        <p class="card-text"><strong>Age:</strong> <?php echo $employee_age; ?></p>
                        <p class="card-text"><strong>Birthday:</strong> <?php echo $employee_birthday; ?></p>
                        <p class="card-text"><strong>Address:</strong> <?php echo $employee_address; ?></p>
                        <p class="card-text"><strong>Email:</strong> <?php echo $employee_email; ?></p>
                        <p class="card-text"><strong>Gender:</strong> <?php echo $employee_gender; ?></p>
                        <p class="card-text"><strong>Height:</strong> <?php echo $employee_height; ?></p>
                        <p class="card-text"><strong>Weight:</strong> <?php echo $employee_weight; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Contact Information</h5>
                        <p class="card-text"><strong>Contact:</strong> <?php echo $employee_contact; ?></p>
                        <p class="card-text"><strong>Date Started:</strong> <?php echo $employee_datestart; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-4 mb-3">Daily Time Record</h2>
        <form method="post" class="form-inline mb-3">
            <label for="from_date" class="mr-2">From:</label>
            <input type="date" id="from_date" name="from_date" class="form-control mr-2" required>
            <label for="to_date" class="mr-2">To:</label>
            <input type="date" id="to_date" name="to_date" class="form-control mr-2" required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <button type="button" class="btn btn-secondary mb-3" onclick="window.print()">Print DTR</button>

        <?php if ($result_dtr->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time In (PST)</th>
                        <th>Break Out (PST)</th>
                        <th>Break In (PST)</th>
                        <th>Time Out (PST)</th>
                        <th>Broken Time In (PST)</th>
                        <th>Broken Break Out(PST)</th>
                        <th>Broken Break In (PST)</th>
                        <th>Broken Time Out (PST)</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row_dtr = $result_dtr->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date('F j, Y', strtotime($row_dtr['date'])); ?></td>
                            <td><?php echo date('h:i A', strtotime($row_dtr['time_in'])); ?></td>
                            <td><?php echo ($row_dtr['break_out']) ? date('h:i A', strtotime($row_dtr['break_out'])) : '-'; ?></td>
                            <td><?php echo ($row_dtr['break_in']) ? date('h:i A', strtotime($row_dtr['break_in'])) : '-'; ?></td>
                            <td><?php echo ($row_dtr['time_out']) ? date('h:i A', strtotime($row_dtr['time_out'])) : '-'; ?></td>
                            <td><?php echo ($row_dtr['broken_time_in']) ? date('h:i A', strtotime($row_dtr['broken_time_in'])) : '-'; ?></td>
                            <td><?php echo ($row_dtr['broken_break_out']) ? date('h:i A', strtotime($row_dtr['broken_break_out'])) : '-'; ?></td>
                            <td><?php echo ($row_dtr['broken_break_in']) ? date('h:i A', strtotime($row_dtr['broken_break_in'])) : '-'; ?></td>
                            <td><?php echo ($row_dtr['broken_time_out']) ? date('h:i A', strtotime($row_dtr['broken_time_out'])) : '-'; ?></td>
                            <td>
                                <?php echo $row_dtr['remarks']; ?>
                                <button onclick="window.location.href = 'add_remark.php?id=<?php echo $row_dtr['record_id']; ?>'" class="btn btn-sm btn-primary ml-2">Add/Edit</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No DTR records found.</p>
        <?php endif; ?>
        <!-- <form action="record_time.php?id=<?php echo $employee_id; ?>" method="post">
        <button type="submit" name="time_in" class="btn btn-primary">Time In</button>
        </form>
        <form action="record_time.php?id=<?php echo $employee_id; ?>" method="post">
        <button type="submit" name="time_out" class="btn btn-primary">Time Out</button>
        </form>
        <form action="record_time.php?id=<?php echo $employee_id; ?>" method="post">
        <button type="submit" name="break_out" class="btn btn-primary">Break Out</button>
        <?php ?>  -->
        <!-- Check if the employee has a shift -->
        <!-- <?php if ($has_shift): ?>
            <form action="record_time.php?id=<?php echo $employee_id; ?>" method="post"> -->        
                <!-- Time In button -->
                <!-- <button type="submit" name="time_in" class="btn btn-primary">Time In</button>
            </form>
            <form action="record_time.php?id=<?php echo $employee_id; ?>" method="post"> -->
                <!-- Time Out button -->
                <!-- <button type="submit" name="time_out" class="btn btn-primary">Time Out</button>
            </form> -->
            <!-- <form action="record_time.php?id=<?php echo $employee_id; ?>" method="post"> -->
                <!-- Break Out button -->
                <!-- <button type="submit" name="break_out" class="btn btn-primary">Break Out</button> -->
                <?php 
                // Check if there's a break out record
                // $sql_check_break_out = "SELECT * FROM dtrRevised WHERE employee_id = $employee_id AND break_out IS NOT NULL";
                // $result_check_break_out = $connection->query($sql_check_break_out);
                // if ($result_check_break_out->num_rows > 0) {
                //     echo '<button type="submit" name="break_in" class="btn btn-primary">Break In</button>';
                // } else {
                //     echo '<button type="submit" name="break_in" class="btn btn-primary" disabled>Break In</button>';
                // }
                ?>
            </form>
        <?//php else: ?>
            <!-- If the employee doesn't have a shift, disable all buttons -->
            <!-- <button type="button" class="btn btn-primary" disabled>Time In</button>
            <button type="button" class="btn btn-primary" disabled>Time Out</button>
            <button type="button" class="btn btn-primary" disabled>Break Out</button>
            <button type="button" class="btn btn-primary" disabled>Break In</button>
            <p class="mt-3">This employee does not have a shift assigned.</p>   
        <?php endif; ?> -->
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php
    // Close database connection
    $connection->close();
    ?>


</body>
</html>