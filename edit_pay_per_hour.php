<?php
include 'includes/connection.php';

// Check if employee ID is provided in the URL
if(isset($_GET['id'])) {
    $employee_id = $_GET['id'];
} else {
    // Handle case where employee ID is not provided
    exit('Employee ID not provided.');
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_pay_per_hour'])) {
    // Validate and sanitize the input
    $new_pay_per_hour = $_POST['new_pay_per_hour'];

    // Update the pay per hour value in the database
    $sql = "UPDATE employee_salary SET pay_per_hour = ? WHERE employee_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("di", $new_pay_per_hour, $employee_id);
    
    if ($stmt->execute()) {
        // Pay per hour updated successfully
        echo "<script>alert('Pay per hour updated successfully!'); window.location.href = 'salary.php?id=" . $employee_id . "';</script>";

    } else {
        // Error updating pay per hour
        echo "<script>alert('Error updating pay per hour!');</script>";
    }

    // Close statement
    $stmt->close();
}

// Fetch current pay per hour value for the employee
$sql_pay_per_hour = "SELECT pay_per_hour FROM employee_salary WHERE employee_id = ?";
$stmt_pay_per_hour = $connection->prepare($sql_pay_per_hour);
$stmt_pay_per_hour->bind_param("i", $employee_id);
$stmt_pay_per_hour->execute();
$result_pay_per_hour = $stmt_pay_per_hour->get_result();

if ($result_pay_per_hour->num_rows > 0) {
    $row_pay_per_hour = $result_pay_per_hour->fetch_assoc();
    $current_pay_per_hour = $row_pay_per_hour['pay_per_hour'];
} else {
    // Handle case where no pay per hour value is found for the employee
    exit('No pay per hour value found for the employee.');
}

// Close statement and database connectionection
$stmt_pay_per_hour->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pay Per Hour</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center">Edit Pay Per Hour</h2>
        </div>
        <div class="card-body">
            <form id="payPerHourForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $employee_id; ?>">
                <div class="form-group">
                    <label for="new_pay_per_hour">New Pay Per Hour:</label>
                    <input type="number" class="form-control" id="new_pay_per_hour" name="new_pay_per_hour" value="<?php echo $current_pay_per_hour; ?>" >
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="update_pay_per_hour" onclick="validatePayPerHour()">Update Pay Per Hour</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to display SweetAlert
    function showAlert(message, type) {
        Swal.fire({
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 1500 // milliseconds
        });
    }

    // Function to validate pay per hour input
    function validatePayPerHour() {
        var payPerHourValue = document.getElementById("new_pay_per_hour").value;
        if (payPerHourValue.trim() === "") {
            showAlert("Pay per hour cannot be empty.", "error");
            event.preventDefault(); // Prevent form submission
        }
    }
</script>

</body>
</html>