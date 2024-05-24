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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_insurance'])) {
    // Validate and sanitize the input
    $new_insurance = $_POST['new_insurance'];

    // Update the insurance value in the database
    $sql = "UPDATE employee_salary SET insurance = ? WHERE employee_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("di", $new_insurance, $employee_id);
    
    if ($stmt->execute()) {
        // Insurance updated successfully
        echo "<script>alert('Insurance updated successfully!'); window.location.href = 'salary.php?id=" . $employee_id . "';</script>";

    } else {
        // Error updating insurance
        echo "<script>alert('Error updating insurance!');</script>";
    }

    // Close statement
    $stmt->close();
}

// Fetch current insurance value for the employee
$sql_insurance = "SELECT insurance FROM employee_salary WHERE employee_id = ?";
$stmt_insurance = $connection->prepare($sql_insurance);
$stmt_insurance->bind_param("i", $employee_id);
$stmt_insurance->execute();
$result_insurance = $stmt_insurance->get_result();

if ($result_insurance->num_rows > 0) {
    $row_insurance = $result_insurance->fetch_assoc();
    $current_insurance = $row_insurance['insurance'];
} else {
    // Handle case where no insurance value is found for the employee
    exit('No insurance value found for the employee.');
}

// Close statement and database connectionection
$stmt_insurance->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Insurance</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center">Edit Insurance</h2>
        </div>
        <div class="card-body">
            <form id="insuranceForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $employee_id; ?>">
                <div class="form-group">
                    <label for="new_insurance">New Insurance Value:</label>
                    <input type="number" class="form-control" id="new_insurance" name="new_insurance" value="<?php echo $current_insurance; ?>" >
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="update_insurance" onclick="validateInsurance()">Update Insurance</button>
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

    // Function to validate insurance input
    function validateInsurance() {
        var insuranceValue = document.getElementById("new_insurance").value;
        if (insuranceValue == "") {
            showAlert("Insurance value cannot be empty.", "error");
            event.preventDefault(); // Prevent form submission
        }
    }
</script>

</body>
</html>