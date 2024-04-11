<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="employeeprof.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div class="container text-center mt-5">
        <img src="employee icon.png" alt="Profile Picture" class="profile-picture img-fluid rounded-circle mb-4">
        <?php
        // Include the database connection file
        include 'includes/connection.php';

        // Retrieve employee information from the database based on employee_id
        $employee_id = isset($_GET['id']) ? $_GET['id'] : null; // Assuming you pass the employee_id via URL
        $sql = "SELECT * FROM employee_details WHERE employee_id = $employee_id";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $employee_name = $row['employee_name'];
            $employee_position = $row['employee_position'];
        } else {
            echo "Employee not found.";
            exit();
        }

        // Output employee name and position
        echo '<h1 class="mb-2">' . $employee_name . '</h1>';
        echo '<h2 class="text-muted">' . $employee_position . '</h2>';
        ?>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <a href="holidayManager.php" class="btn btn-primary btn-block mb-3"><i class="fas fa-calendar-alt mr-2"></i>View/Edit Holidays</a>
                <a href="dtrRevisedManager.php?id=<?php echo $employee_id; ?>" class="btn btn-primary btn-block mb-3"><i class="far fa-clock mr-2"></i>View/Edit Daily Time Record</a>
                <a href="salary.php?id=<?php echo $employee_id; ?>" class="btn btn-primary btn-block mb-3"><i class="fas fa-money-bill mr-2"></i>View Payroll</a>
                <a href="shiftManager.php?id=<?php echo $employee_id; ?>" class="btn btn-primary btn-block mb-3"><i class="fas fa-users-cog mr-2"></i>Manage Shift</a>
            </div>
        </div>
    </div>
</body>

</html>