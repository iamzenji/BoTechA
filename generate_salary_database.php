<?php
// Start the session
include 'includes/connection.php';
include 'includes/header.php';

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['employee_id'])) {
    // Retrieve form data
    $employee_id = $_POST['employee_id'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $total_hours_worked = $_POST['total_hours_worked'];
    $insurance = $_POST['insurance'];
    $tax = $_POST['tax'];
    $pay_per_hour = $_POST['pay_per_hour'];
    $gross_salary = $_POST['gross_salary'];
    $total_deductions = $_POST['total_deductions'];
    $total_salary = $_POST['total_salary'];

    // Insert payroll record into employee_salary_revised table
    $sql_insert_payroll = "INSERT INTO employee_salary_revised (employee_id, from_date, to_date, hours_worked, insurance, tax, pay_per_hour, gross_salary, total_deductions, total_salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_payroll = $connection->prepare($sql_insert_payroll);
    $stmt_insert_payroll->bind_param("isssdddiii", $employee_id, $from_date, $to_date, $total_hours_worked, $insurance, $tax, $pay_per_hour, $gross_salary, $total_deductions, $total_salary);

    // Execute the prepared statement
    if ($stmt_insert_payroll->execute()) {
        echo "<script>alert('Payroll Inserted Successfully!'); window.location.href = 'salary.php?id=" . $employee_id . "';</script>";
    } else {
        echo "Error inserting payroll record: " . $connection->error;
    }

    // Close the prepared statement and database connectionection
    $stmt_insert_payroll->close();
    // FINANCE----------------------------------------------------------------------
    // Fetch balance
    $balquery = "SELECT * FROM finance_balance ORDER by date DESC";
    $balresult = mysqli_query($connection, $balquery);
    $bal = mysqli_fetch_assoc($balresult);

    // Automatic Request Budget after ordering, inserting data to finance balance
    if ($total_salary > 0) {
        function generateTrackingNumber()
        {
            // Generate a unique tracking number (you can use any logic here)
            return "TN" . uniqid();
        }
        $trackingNumber = generateTrackingNumber();
        $grandTotal = $total_salary;
        $companyName = "Human Resources";
        $totalPrice = ($grandTotal) * (-1);
        $totalbal = ($bal['currentbal']) + ($totalPrice);
        $description = "Payroll Given";

        // Insert Data
        $financebalquery = "INSERT INTO `finance_balance` (trackingID, currentbal, company, cost, description) VALUES ('$trackingNumber','$totalbal', '$companyName', '$totalPrice', '$description')";
        $financeresult = mysqli_query($connection, $financebalquery);

        // Fetch Receipt
        $freceiptfetchquery = "SELECT * FROM finance_receipt";
        $freceiptresult = mysqli_query($connection, $freceiptfetchquery);
        $receiptrow = mysqli_fetch_assoc($freceiptresult);

        // Add current price
        $totalreceipt = ($receiptrow['hr']) + ($totalPrice);

        // Update Receipt
        $freceiptquery = "UPDATE finance_receipt SET hr = $totalreceipt";
        $freceiptresult = mysqli_query($connection, $freceiptquery);
        //----------------------------------------------------------------------------------------
    }
    $connection->close();
} else {
    // Redirect to the previous page if form data is not submitted
    header("Location: generate_salary.php");
    exit();
}
?>