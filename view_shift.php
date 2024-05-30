<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Shift Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body, button, input, select, textarea {
            font-family: 'Space Grotesk', sans-serif;
        }
        /* Modal styles */
        .modal {
            display: block; /* Displayed by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #3943ac;
            color: white;
        }
    </style>
</head>
<body>
    <?php
    // Include database connection file
    include 'includes/connection.php';

    // Get the employee ID from the URL
    $employee_id = $_GET['employeeid'];
    ?>
    <div id="viewShiftModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
          <span class="close" onclick="closeModal('<?php echo $employee_id; ?>')">&times;</span>
            <h3>View Shift Details</h3>
            <form>
                <table>
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Time In</th>
                            <th>Break Out</th> <!-- Add Break Out column -->
                            <th>Break In</th> <!-- Add Break In column -->
                            <th>Time Out</th>
                            <th>Broken Time In</th>
                            <th>Broken Time Out</th>
                            <th>Broken Break Out</th>
                            <th>Broken Break In</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
    // Get the shift ID from the URL
    $shift_id = $_GET['id'];

    // Query to fetch shift details from the database
    $sql = "SELECT * FROM shiftdetails WHERE shift_id = $shift_id"; 

    // Execute the query
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
       // Output data of each row
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['day'] . "</td>";
    echo "<td><input type='time' value='" . ($row['time_in'] !== null ? $row['time_in'] : '') . "' disabled></td>";
    echo "<td><input type='time' value='" . ($row['break_out'] !== null ? $row['break_out'] : '') . "' disabled></td>";
    echo "<td><input type='time' value='" . ($row['break_in'] !== null ? $row['break_in'] : '') . "' disabled></td>";
    echo "<td><input type='time' value='" . ($row['time_out'] !== null ? $row['time_out'] : '') . "' disabled></td>";

    // Check if there are broken schedules
    if (!empty($row['broken_time_in'])) {
        $broken_time_in = explode(',', $row['broken_time_in']);
        $broken_time_out = explode(',', $row['broken_time_out']);
        $broken_break_out = explode(',', $row['broken_break_out']);
        $broken_break_in = explode(',', $row['broken_break_in']);

        // Display broken schedules within the same row
        for ($i = 0; $i < count($broken_time_in); $i++) {
            echo "<td><input type='time' value='" . ($broken_time_in[$i] !== null ? $broken_time_in[$i] : '') . "' disabled></td>";
            echo "<td><input type='time' value='" . ($broken_time_out[$i] !== null ? $broken_time_out[$i] : '') . "' disabled></td>";
            echo "<td><input type='time' value='" . ($broken_break_out[$i] !== null ? $broken_break_out[$i] : '') . "' disabled></td>";
            echo "<td><input type='time' value='" . ($broken_break_in[$i] !== null ? $broken_break_in[$i] : '') . "' disabled></td>";
        }
    } else {
        // If there are no broken schedules, fill the remaining cells with empty ones
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
    }

    echo "</tr>";
}

    } else {
        echo "<tr><td colspan='9'>No shift details found for this shift</td></tr>";
    }

    // Close database connectionection
    $connection->close();
    ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <!-- Script to close the modal when clicking outside of it or clicking the close button -->
    <script>
        var modal = document.getElementById('viewShiftModal');
        window.onclick = function(event) {
            if (event.target == modal) {
                window.location.href='shiftManager.php?id=<?php echo $employee_id; ?>'; // Redirect to shift_management.php when clicking outside modal
            }
        }

        function closeModal(employeeId) {
            window.location.href='shiftManager.php?id=' + employeeId; // Redirect to shift_management.php when clicking close button
        }
    </script>
</body>
</html>