<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Remark</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
𓆤🐞🐞🐞🐞🐞🐞

<body>
    <div class="container mt-5">
        <?php
        // Include database connection file
        include 'includes/connection.php';

        // Check if the DTR record ID is provided in the URL
        if (isset($_GET['id'])) {
            $dtr_id = $_GET['id'];

            // Retrieve DTR record information from the database based on the DTR record ID
            $sql_dtr = "SELECT * FROM dtrRevised WHERE record_id = $dtr_id";
            $result_dtr = $connection->query($sql_dtr);

            if ($result_dtr->num_rows > 0) {
                $row_dtr = $result_dtr->fetch_assoc();
                $employee_id = $row_dtr['employee_id'];
                $date = $row_dtr['date'];
                $time_in = $row_dtr['time_in'];
                $time_out = $row_dtr['time_out'];
            } else {
                echo "<div class='alert alert-danger' role='alert'>DTR record not found.</div>";
                exit();
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>DTR record ID not provided.</div>";
            exit();
        }

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get remark from form
            $remark = $_POST['remark'];

            // Update the remark in the database
            $sql_update = "UPDATE dtrRevised SET remarks = '$remark' WHERE record_id = $dtr_id";

            if ($connection->query($sql_update) === TRUE) {
                echo "<div class='alert alert-success' role='alert'>Remark added successfully.</div>";
                header("Location: dtrRevisedManager.php?id=" . $row_dtr['employee_id']);
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error: " . $sql_update . "<br>" . $connection->error . "</div>";
            }
        }
        ?>

        <h2 class="mb-4">Add Remark</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="employee_id">Employee ID:</label>
                    <p id="employee_id"><?php echo $employee_id; ?></p>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <p id="date"><?php echo $date; ?></p>
                </div>
                <div class="form-group">
                    <label for="time_in">Time In:</label>
                    <p id="time_in"><?php echo $time_in; ?></p>
                </div>
                <div class="form-group">
                    <label for="time_out">Time Out:</label>
                    <p id="time_out"><?php echo $time_out; ?></p>
                </div>
            </div>
        </div>

        <form method="post">
            <div class="form-group">
                <label for="remark">Remark:</label>
                <select id="remark" name="remark" class="form-control">
                    <option value="Valid Time In">Valid Time In</option>
                    <option value="Valid Time Out">Valid Time Out</option>
                    <option value="Valid Time In and Time Out">Valid Time In and Time Out</option>
                    <option value="Valid Time In and Overtime">Valid Time In and Overtime</option>
                    <option value="Absent">Absent</option>
                    <option value="Overtime">Overtime</option>
                    <option value="Late and Overtime">Late and Overtime</option>
                    <option value="Late and Valid Time Out">Late and Valid Time Out</option>
                    <option value="On Leave">On Leave</option>
                    <!-- Add more options as needed -->
                </select>

            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php
    // Close database connection
    $connection->close();
    ?>
</body>

</html>