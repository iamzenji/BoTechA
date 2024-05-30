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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_sss'])) {
    // Validate and sanitize the input
    $new_tax = $_POST['new_tax'];

    // Update the tax value in the database
    $sql = "UPDATE employee_salary SET sss = ? WHERE employee_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("di", $new_tax, $employee_id);
    
    if ($stmt->execute()) {
        // Tax updated successfully
        echo "<script>alert('SSS updated successfully!'); window.location.href = 'salary.php?id=" . $employee_id . "';</script>";

    } else {
        // Error updating tax
        echo "<script>alert('Error updating tax!');</script>";
    }

    // Close statement
    $stmt->close();
}

// Fetch current tax value for the employee
$sql_tax = "SELECT sss FROM employee_salary WHERE employee_id = ?";
$stmt_tax = $connection->prepare($sql_tax);
$stmt_tax->bind_param("i", $employee_id);
$stmt_tax->execute();
$result_tax = $stmt_tax->get_result();

if ($result_tax->num_rows > 0) {
    $row_tax = $result_tax->fetch_assoc();
    $current_tax = $row_tax['sss'];
} else {
    // Handle case where no tax value is found for the employee
    exit('No tax value found for the employee.');
}

// Close statement and database connectionection
$stmt_tax->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit SSS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center">Edit SSS</h2>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $employee_id; ?>">
                <div class="form-group">
                    <label for="new_tax">New Tax Value:</label>
                    <input type="number" class="form-control" id="new_tax" name="new_tax" value="<?php echo $current_tax; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="update_sss" onclick="return validateTax()">Update SSS</button>
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

    // Function to validate tax input
    function validateTax() {
        var taxValue = document.getElementById("new_tax").value;
        if (taxValue.trim() === "") {
            showAlert("SSS value cannot be empty.", "error");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>

</body>
</html>