<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body,
        button,
        input,
        select,
        textarea {
            font-family: 'Space Grotesk', sans-serif;
        }
       body {

            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
            background: #091540;
            padding: 10px;
            color: White;
            text-align: center; 
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            
        }
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <?php 
    session_start();
    include 'includes/connection.php';
    ?>
    <h2>Leave Request Form</h2>
    
    <!-- Container to display leave credit information -->
    <div id="leaveCreditInfo"></div>
    
     <!-- Form for leave request -->
     <form id="leaveRequestForm" action="request_leave_database.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
        <!-- Button to check remaining leave credit -->
        <button type="button" onclick="checkLeaveCredit()">Check Leave Credit</button><br><br>
        <!-- Absence type -->
        <label for="absence_type">Types of Leave:</label><br>
        <select id="absence_type" name="absence_type" onchange="toggleFileUpload()">
            <option value="" disabled selected>Select Leave</option>
            <option value="Sick Leave">Sick Leave</option>
            <option value="Maternity Leave">Maternity Leave</option>
            <option value="Paternity Leave">Paternity Leave</option>
            <option value="Emergency Leave">Emergency Leave</option>
            <option value="Vacation Leave">Vacation Leave</option>
        </select><br><br>
        <!-- Reason for leave -->
        <label for="reason">Reason:</label><br>
        <textarea id="reason" name="reason" rows="4" cols="30" minlength="70"></textarea><br><br>
        <!-- Start date -->
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" onchange="populateEndDate()" min="<?php echo date('Y-m-d'); ?>"><br><br>
        <!-- End date -->
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" min="<?php echo date('Y-m-d'); ?>"><br><br>

        <!-- File upload for sick leave (initially hidden) -->
<div id="fileUploadSection" style="display: none;">
    <label for="sick_leave_evidence">Upload Leave Evidence:</label>
    <input type="file" id="sick_leave_evidence" name="sick_leave_evidence" accept=".jpg, .jpeg, .png"><br><br>
</div>
        <!-- Submit button -->
        <button type="submit" name="request_form" class="btn btn-primary">File Leave</button>
    </form>

    <?php
// Retrieve leave requests from the database
$employee_id = $_SESSION['employee_id'];
$sql = "SELECT * FROM request_leave WHERE employee_id = '$employee_id'";
$result = $connection->query($sql);

// Check if there are any leave requests
if ($result->num_rows > 0) {
    echo "<h2>Leave Requests</h2>";
    echo "<table id='leaveRequestsTable' border='1'>"; // Add id attribute here
    echo "<tr><th>From</th><th>To</th><th>Absence Type</th><th>Reason</th><th>Status</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . date('F j, Y', strtotime($row['start_date'])) . "</td>"; // Format date
        echo "<td>" . date('F j, Y', strtotime($row['end_date'])) . "</td>"; // Format date
        echo "<td>" . $row['absence_type'] . "</td>";
        echo "<td>" . $row['reason'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No leave requests found.";
}

// Close database connectionection
$connection->close();
?>

<script>
// Define allowed file types
var allowedTypes = ["image/jpeg", "image/jpg", "image/png"];

// Function to toggle file upload field based on selected absence type
function toggleFileUpload() {
    var absenceType = document.getElementById("absence_type").value;
    var fileUploadSection = document.getElementById("fileUploadSection");

    // If absence type is "Sick Leave", "Maternity Leave", or "Paternity Leave", show the file upload field; otherwise, hide it
    if (absenceType === "Sick Leave" || absenceType === "Maternity Leave" || absenceType === "Paternity Leave") {
        fileUploadSection.style.display = "block";
    } else {
        fileUploadSection.style.display = "none";
    }
}

// Function to populate end date field with start date value
function populateEndDate() {
    // Get the selected date from the "From" calendar field
    var startDate = document.getElementById("start_date").value;

    // Set the "To" calendar field to the same value as the "From" calendar field
    document.getElementById("end_date").value = startDate;
}

// Function to check leave credit
function checkLeaveCredit() {
    // Make an AJAX request to retrieve leave credit information
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Display the leave credit information
            document.getElementById("leaveCreditInfo").innerHTML = this.responseText;
        }
    };
    xhr.open("GET", "request_leave_database.php", true);
    xhr.send();
}

// Function to validate form before submission
function validateForm() {
    var reason = document.getElementById("reason").value;
    var startDate = document.getElementById("start_date").value;
    var endDate = document.getElementById("end_date").value;
    var reason = document.getElementById("reason").value.trim();
    var absenceType = document.getElementById("absence_type").value;
    var fileInput = document.getElementById("sick_leave_evidence");
    var file = fileInput ? fileInput.files[0] : null; // Check if file input exists

    // Check if reason, start date, and end date are filled
    if (reason.trim() === "") {
        alert("Please provide a reason for leave.");
        console.log("Reason not provided.");
        return false;
    }
    if (startDate.trim() === "") {
        alert("Please select a start date.");
        console.log("Start date not selected.");
        return false;
    }
    if (endDate.trim() === "") {
        alert("Please select an end date.");
        console.log("End date not selected.");
        return false;
    }

    // Check file upload only if the absence type requires it
    if ((absenceType === "Sick Leave" || absenceType === "Maternity Leave" || absenceType === "Paternity Leave") && !file) {
        alert("Please upload a file.");
        console.log("File not uploaded.");
        return false;
    }

    // Check file type
    if (file && !allowedTypes.includes(file.type)) {
        alert("Invalid file type. Please upload a JPG, JPEG, PNG");
        console.log("Invalid file type.");
        return false;
    }

    // Calculate leave duration in days
    var start = new Date(startDate);
    var end = new Date(endDate);
    var leaveDuration = Math.ceil((end - start) / (1000 * 60 * 60 * 24));

    // Check if reason meets minimum length requirement
    if (reason.length < 50) {
        alert("Reason must be at least 50 characters long.");
        console.log("Reason length insufficient.");
        return false;
    }

    // Check maximum duration for Sick Leave
    if (absenceType === "Sick Leave" && leaveDuration > 7) {
        alert("Sick Leave cannot exceed 1 week.");
        console.log("Sick Leave duration exceeds 1 week.");
        return false;
    }

    // Check maximum duration for Vacation Leave
    if (absenceType === "Vacation Leave" && leaveDuration > 14) {
        console.log("Leave duration for Vacation Leave:", leaveDuration);
        alert("Vacation Leave cannot exceed 14 days.");
        return false;
    }

    // Get the leave credit information
    var leaveCreditElement = document.getElementById("leaveCreditInfo");
    var leaveCredit = parseInt(leaveCreditElement.innerText.split(": ")[1]);

    // Check if leave duration exceeds leave credit
    if (leaveDuration > leaveCredit) {
        alert("Leave duration exceeds available leave credit.");
        console.log("Leave duration exceeds available leave credit.");
        return false;
    }

    // Check if the requested leave overlaps with existing leave requests (excluding "Rejected" ones)
    var leaveRequests = document.querySelectorAll("#leaveRequestsTable tr");
    for (var i = 1; i < leaveRequests.length; i++) { // Start from index 1 to skip table header
        var leaveStartDateParts = leaveRequests[i].cells[0].innerText.split(" ");
        var leaveEndDateParts = leaveRequests[i].cells[1].innerText.split(" ");
        var leaveStartDate = new Date(leaveStartDateParts[1] + " " + leaveStartDateParts[0] + ", " + leaveStartDateParts[2]);
        var leaveEndDate = new Date(leaveEndDateParts[1] + " " + leaveEndDateParts[0] + ", " + leaveEndDateParts[2]);
        var leaveStatus = leaveRequests[i].cells[4].innerText.trim();

        // Skip leave requests with "Rejected" status
        if (leaveStatus === "Rejected") { // Exact case-sensitive comparison
            continue;
        }

        // Check if the requested leave overlaps with any existing leave request
        // if ((start >= leaveStartDate && start <= leaveEndDate) || (end >= leaveStartDate && end <= leaveEndDate)) {
        //     alert("Leave request overlaps with an existing leave request.");
        //     console.log("Leave request overlaps with an existing leave request.");
        //     return false;
        // }
    }

    return true; // Form is valid, proceed with submission
}
</script>
</body>
</html>