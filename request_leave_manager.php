<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Requests</title>
    <link rel="stylesheet" href="styles.css">
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
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 10px;
            margin-top: 20px;
            color: #333;
            background: #091540;
            padding: 10px;
            color: White;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            color: white;
            background-color: #8FA8FF;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        button {
            padding: 6px 10px;
            cursor: pointer;
        }

        button[name='approve'] {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        button[name='reject'] {
            background-color: #f44336;
            color: white;
            border: none;
        }

        button[name='view_evidence'] {
            background-color: #007bff;
            color: white;
            border: none;
        }

        button:hover {
            opacity: 0.8;
        }

    </style>
</head>
<body>
<div class="container">
    <?php
    session_start();
    // Include database connection file
    include 'includes/connection.php';

    // Retrieve all leave requests with employee names from the database
    $sql_pending = "SELECT request_leave.*, employee_details.employee_name FROM request_leave 
                    INNER JOIN employee_details ON request_leave.employee_id = employee_details.employee_id 
                    WHERE request_leave.status = 'Pending'
                    ORDER BY request_leave.id";
    $result_pending = $connection->query($sql_pending);

    $sql_approved = "SELECT request_leave.*, employee_details.employee_name FROM request_leave 
                     INNER JOIN employee_details ON request_leave.employee_id = employee_details.employee_id 
                     WHERE request_leave.status = 'Approved'
                     ORDER BY request_leave.id";
    $result_approved = $connection->query($sql_approved);

    $sql_rejected = "SELECT request_leave.*, employee_details.employee_name FROM request_leave 
                     INNER JOIN employee_details ON request_leave.employee_id = employee_details.employee_id 
                     WHERE request_leave.status = 'Rejected'
                     ORDER BY request_leave.id";
    $result_rejected = $connection->query($sql_rejected);

    // Function to display leave requests
function displayLeaveRequests($result, $status)
{
    if ($result->num_rows > 0) {
        echo "<h2>{$status} Leave Requests</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Employee Name</th><th>From</th><th>To</th><th>Types of Leave</th><th>Reason</th><th>Status</th><th>Action</th></tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['employee_name'] . "</td>";
            echo "<td>" . date('F j, Y', strtotime($row['start_date'])) . "</td>"; // Format date
            echo "<td>" . date('F j, Y', strtotime($row['end_date'])) . "</td>"; // Format date
            echo "<td>" . $row['absence_type'] . "</td>";
            echo "<td>" . $row['reason'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";

            if ($status == 'Pending') {
                // Display approve and reject buttons for pending requests
                echo "<td>";
                echo "<form action='request_leave_database.php' method='post' onsubmit='return confirmAction(\"approve\")'>";
                echo "<input type='hidden' name='leave_id' value='{$row['id']}'>";
                echo "<button type='submit' name='approve'>Approve</button>";
                echo "</form>";
                echo "<form action='request_leave_database.php' method='post' onsubmit='return confirmAction(\"reject\")'>";
                echo "<input type='hidden' name='leave_id' value='{$row['id']}'>";
                echo "<button type='submit' name='reject'>Reject</button>";
                echo "</form>";
                if ($row['absence_type'] == 'Sick Leave' || $row['absence_type'] == 'Maternity Leave' || $row['absence_type'] == 'Paternity Leave' ) {
                    // Display view evidence button for sick leave requests
                    echo "<form action='retrieve_image.php' method='GET'>";
                    echo "<input type='hidden' name='leave_id' value='{$row['id']}'>";
                    echo "<button type='submit' name='view_evidence'>View Evidence</button>";
                    echo "</form>";
                }
                echo "</td>";
            } else {
                echo "<td>N/A</td>";
            }

            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>{$status} Leave Requests</h2>";
        echo "No {$status} Leave Requests found.";
    }
}
    

    // Display leave requests for each status
    displayLeaveRequests($result_pending, 'Pending');
    displayLeaveRequests($result_approved, 'Approved');
    displayLeaveRequests($result_rejected, 'Rejected');

    // Close database connectionection
    $connection->close();
    ?>

<script>
    function confirmAction(action) {
        var actionText = action === "approve" ? "approve" : "reject";
        return confirm("Are you sure you want to " + actionText + " this leave request?");
    }
</script>

</div>
</body>
</html>
