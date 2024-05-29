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
        session_start();
        include 'includes/connection.php';
        // Check if the user's position is "HR Officer"
        if (!isset($_SESSION['employee_position']) || $_SESSION['employee_position'] !== 'HR Officer') {
            // Redirect to a page with an unauthorized access message
            header("Location: unauthorized.php");
            exit();
        }
        // Check if the employee ID is provided in the URL
        if (isset($_GET['id'])) {
            $employee_id = $_GET['id'];

            // Retrieve employee information from the database based on the employee ID
            $sql_employee = "SELECT * FROM employee_details WHERE employee_id = $employee_id";
            $result_employee = $connection->query($sql_employee);

            if ($result_employee->num_rows > 0) {
                $row_employee = $result_employee->fetch_assoc();
                $employee_name = $row_employee['employee_name'];
                $employee_position = $row_employee['employee_position'];
                $employee_contact = $row_employee['employee_contact'];
                $employee_datestart = $row_employee['employee_datestart'];

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
                        <p class="card-text"><strong>Name:</strong> <?php echo $employee_name; ?></p>
                        <p class="card-text"><strong>Position:</strong> <?php echo $employee_position; ?></p>
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
                            <td>
                                <?php echo $row_dtr['remarks']; ?>
                                <button
                                    onclick="window.location.href = 'add_remark.php?id=<?php echo $row_dtr['record_id']; ?>'"
                                    class="btn btn-sm btn-primary ml-2">Add/Edit</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No DTR records found.</p>
        <?php endif; ?>
        <form action="record_time.php?id=<?php echo $employee_id; ?>" method="post">
            <button type="submit" name="time_in" class="btn btn-primary">Time In</button>
        </form>
        <form action="record_time.php?id=<?php echo $employee_id; ?>" method="post">
            <button type="submit" name="time_out" class="btn btn-primary">Time Out</button>
        </form>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php
    // Close database connectionection
    $connection->close();
    ?>


</body>

</html>