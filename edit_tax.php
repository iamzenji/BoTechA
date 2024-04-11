<?php
include 'includes/connection.php';

// Check if employee ID is provided in the URL
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];
} else {
    // Handle case where employee ID is not provided
    exit('Employee ID not provided.');
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_tax'])) {
    // Validate and sanitize the input
    $new_tax = $_POST['new_tax'];

    // Update the tax value in the database
    $sql = "UPDATE employee_salary SET tax = ? WHERE employee_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("di", $new_tax, $employee_id);

    if ($stmt->execute()) {
        // Tax updated successfully
        echo "<script>alert('Tax updated successfully!'); window.location.href = 'salary.php?id=" . $employee_id . "';</script>";
    } else {
        // Error updating tax
        echo "<script>alert('Error updating tax!');</script>";
    }

    // Close statement
    $stmt->close();
}

// Fetch current tax value for the employee
$sql_tax = "SELECT tax FROM employee_salary WHERE employee_id = ?";
$stmt_tax = $connection->prepare($sql_tax);
$stmt_tax->bind_param("i", $employee_id);
$stmt_tax->execute();
$result_tax = $stmt_tax->get_result();

if ($result_tax->num_rows > 0) {
    $row_tax = $result_tax->fetch_assoc();
    $current_tax = $row_tax['tax'];
} else {
    // Handle case where no tax value is found for the employee
    exit('No tax value found for the employee.');
}

// Close statement and database connection
$stmt_tax->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tax</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h2>Edit Tax</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $employee_id; ?>">
            <div class="form-group">
                <label for="new_tax">New Tax Value:</label>
                <input type="number" id="new_tax" name="new_tax" value="<?php echo $current_tax; ?>" required>
            </div>
            <button type="submit" name="update_tax">Update Tax</button>
        </form>
    </div>

</body>

</html>