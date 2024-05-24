<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shift Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

// Check if the shift ID is provided in the URL
if (isset($_GET['id'])) {
    // Get the shift ID from the URL
    $shift_id = $_GET['id'];
    $employee_id = $_GET['employeeid'];

}
?>
    <div id="editShiftModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="window.location.href='shiftManager.php?id=<?php echo $employee_id; ?>'">&times;</span>
            <h3>Edit Shift Details</h3>
            <form action="update_shift.php?id=<?php echo $employee_id; ?>" method="post">
                <input type="hidden" name="shift_id" value="<?php echo $_GET['id']; ?>">
                <table>
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Time In</th>
                            <th>Break Out</th> <!-- Add Break Out column -->
                            <th>Break In</th> <!-- Add Break In column -->
                            <th>Time Out</th>
                            <th>Broken Time In</th> <!-- Add Broken Time In column -->
                            <th>Broken Time Out</th> <!-- Add Broken Time Out column -->
                            <th>Broken Break Out</th> <!-- Add Broken Break Out column -->
                            <th>Broken Break In</th> <!-- Add Broken Break In column -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Query to fetch shift details from the database
                            $sql = "SELECT * FROM shiftdetails WHERE shift_id = $shift_id"; 

                            // Execute the query
                            $result = $connection->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['day'] . "</td>";
                                    echo "<input type='hidden' name='day[]' value='" . $row['day'] . "'>"; // Hidden input for day
                                    echo "<input type='hidden' name='shift_id[]' value='" . $shift_id . "'>"; // Hidden input for shift_id
                                    echo "<td><input type='time' name='time_in[]' value='" . ($row['time_in'] !== null ? $row['time_in'] : '') . "' class='form-control'></td>";
                                    echo "<td><input type='time' name='break_out[]' value='" . ($row['break_out'] !== null ? $row['break_out'] : '') . "' class='form-control'></td>";
                                    echo "<td><input type='time' name='break_in[]' value='" . ($row['break_in'] !== null ? $row['break_in'] : '') . "' class='form-control'></td>";
                                    echo "<td><input type='time' name='time_out[]' value='" . ($row['time_out'] !== null ? $row['time_out'] : '') . "' class='form-control'></td>";

                                    // Check if there are broken schedules
                                    if (!empty($row['broken_time_in'])) {
                                        $broken_time_in = explode(',', $row['broken_time_in']);
                                        $broken_time_out = explode(',', $row['broken_time_out']);
                                        $broken_break_out = explode(',', $row['broken_break_out']);
                                        $broken_break_in = explode(',', $row['broken_break_in']);

                                        // Display broken schedules within the same row
                                        for ($i = 0; $i < count($broken_time_in); $i++) {
                                            echo "<td><input type='time' name='broken_time_in[" . $row['day'] . "][]' value='" . ($broken_time_in[$i] !== null ? $broken_time_in[$i] : '') . "' class='form-control'></td>";
                                            echo "<td><input type='time' name='broken_time_out[" . $row['day'] . "][]' value='" . ($broken_time_out[$i] !== null ? $broken_time_out[$i] : '') . "' class='form-control'></td>";
                                            echo "<td><input type='time' name='broken_break_out[" . $row['day'] . "][]' value='" . ($broken_break_out[$i] !== null ? $broken_break_out[$i] : '') . "' class='form-control'></td>";
                                            echo "<td><input type='time' name='broken_break_in[" . $row['day'] . "][]' value='" . ($broken_break_in[$i] !== null ? $broken_break_in[$i] : '') . "' class='form-control'></td>";
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
                        ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Update Shift</button>
            </form>
        </div>
    </div>

    <!-- Script to close the modal when clicking outside of it -->
    <script>
        var modal = document.getElementById('editShiftModal');
        window.onclick = function(event) {
            if (event.target == modal) {
                window.location.href='shiftManager.php?id=<?php echo $employee_id; ?>'; // Redirect to shift_manager.php when clicking outside modal
            }
        }
    </script>
</body>
</html>