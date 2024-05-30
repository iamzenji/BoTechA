<?php
// Start the session
session_start();
include 'includes/connection.php';
// include 'sidebar.php';

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_payroll'])) {
    // Retrieve and decode form data (payroll_data)connection
    $payroll_data = json_decode($_POST['payroll_data'], true);

    // Loop through each payroll data
    foreach ($payroll_data as $employee_payroll) {
        // Retrieve payroll data for each employee
        $employee_id = $employee_payroll['employee_id'];
        $from_date = date("Y-m-d", strtotime($employee_payroll['from_date'])); // Format to YYYY-MM-DD
        $to_date = date("Y-m-d", strtotime($employee_payroll['to_date'])); // Format to YYYY-MM-DD
        $total_hours_worked = $employee_payroll['total_hours_worked'];
        $insurance = $employee_payroll['insurance'];
        $tax = $employee_payroll['tax'];
        $pay_per_hour = $employee_payroll['pay_per_hour'];
        $gross_salary = $employee_payroll['gross_salary'];
        $total_deductions = $employee_payroll['total_deductions'];
        $total_salary = $employee_payroll['total_salary'];

        // Insert payroll record into employee_salary_revised table
        $sql_insert_payroll = "INSERT INTO employee_salary_revised (employee_id, from_date, to_date, hours_worked, insurance, tax, pay_per_hour, gross_salary, total_deductions, total_salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_payroll = $connection->prepare($sql_insert_payroll);
        $stmt_insert_payroll->bind_param("isssdddiii", $employee_id, $from_date, $to_date, $total_hours_worked, $insurance, $tax, $pay_per_hour, $gross_salary, $total_deductions, $total_salary);
        // Execute the prepared statement
        if (!$stmt_insert_payroll->execute()) {
            echo "<script>alert('Error inserting payroll record: " . $stmt_insert_payroll->error . "');</script>";
            // Redirect back to the previous page if insertion fails
            header("Location: generate_payroll_all.php");
            exit();
        }

        // Close the prepared statement
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
    }

    if (isset($payroll_data)) {
        // Insert payroll data into payroll_all_history table
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $date_released = date('Y-m-d H:i:s'); // Current date and time

        $sql_insert_payroll = "INSERT INTO payroll_all_history (payroll_date_from, payroll_date_to, payroll_date_released) VALUES (?, ?, ?)";
        $stmt_insert_payroll = $connection->prepare($sql_insert_payroll);
        $stmt_insert_payroll->bind_param("sss", $from_date, $to_date, $date_released);
        $stmt_insert_payroll->execute();

        // Display success message and redirect
        echo "<script>alert('Payroll released successfully.'); window.location.href = 'generate_payroll_all.php';</script>";

    }

    // If all insertions are successful, redirect to a confirmation page
    echo "<script>alert('Payroll Inserted Successfully!');</script>";
    header("refresh:0; url=generate_payroll_all.php"); // Redirect after alert is shown
    exit();
} else {
    // Redirect to the previous page if form data is not submitted
    header("Location: generate_payroll_all.php");
    exit();
}
?>