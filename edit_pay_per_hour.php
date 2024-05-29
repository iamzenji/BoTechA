<?php
include 'includes/connection.php';

// Check if employee ID is provided in the URL
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];
} else {
    // Handle case where employee ID is not provided
    exit('Employee ID not provided.');
}

// Fetch current pay per hour for the employee
$sql = "SELECT pay_per_hour FROM employee_salary WHERE employee_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if employee exists
if ($result->num_rows == 0) {
    exit('Employee not found.');
}

// Get current pay per hour
$row = $result->fetch_assoc();
$current_pay_per_hour = $row['pay_per_hour'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pay_per_hour"])) {
    // Get new pay per hour value from the form
    $new_pay_per_hour = $_POST["pay_per_hour"];

    // Update pay per hour in the database
    $sql_update = "UPDATE employee_salary SET pay_per_hour = ? WHERE employee_id = ?";
    $stmt_update = $connection->prepare($sql_update);
    $stmt_update->bind_param("di", $new_pay_per_hour, $employee_id);

    if ($stmt_update->execute()) {
        // Redirect to salary.php with the updated employee ID
        header("Location: salary.php?id=" . $employee_id);
        exit();
    } else {
        echo "Error updating pay per hour: " . $connection->error;
    }

    // Close prepared statement
    $stmt_update->close();
}

// Close prepared statement and database connection
$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Pay Per Hour</title>
    <link rel="stylesheet" type="text/css" href="stylee.css">
</head>

<body>

    <div id="container">
        <h2>Edit Pay Per Hour</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $employee_id; ?>">
            <label for="pay_per_hour">New Pay Per Hour:</label>
            <input type="number" id="pay_per_hour" name="pay_per_hour" value="<?php echo $current_pay_per_hour; ?>" required>
            <br><br>
            <input type="submit" value="Update Pay Per Hour">
        </form>
    </div>

</body>

</html>