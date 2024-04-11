<?php
// Include database connection file
include 'includes/connection.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if shift ID is provided in the form data
    if (isset($_POST['shift_id']) && is_array($_POST['shift_id']) && isset($_POST['day']) && is_array($_POST['day'])) {
        // Prepare SQL statement for updating shift details
        $sql = "UPDATE shiftdetails SET time_in = ?, time_out = ? WHERE shift_id = ? AND day = ?";
        $stmt = $connection->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssis", $time_in, $time_out, $shift_id, $day);

        // Loop through the provided time-in, time-out, shift_id, and day values
        for ($i = 0; $i < count($_POST['shift_id']); $i++) {
            // Get time-in, time-out, shift_id, and day values for the current iteration
            $time_in = $_POST['time_in'][$i];
            $time_out = $_POST['time_out'][$i];
            $shift_id = $_POST['shift_id'][$i];
            $day = $_POST['day'][$i];

            // Execute the SQL statement
            if (!$stmt->execute()) {
                echo "Error updating shift details for $day: " . $connection->error;
            }
        }

        // Close prepared statement
        $stmt->close();

        // Display success message using JavaScript modal
        echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Success</title>
                    <style>
                        /* Modal styles */
                        .modal {
                            display: block; 
                            position: fixed; 
                            z-index: 1; 
                            left: 0;
                            top: 0;
                            width: 100%; 
                            height: 100%; 
                            overflow: auto; 
                            background-color: rgba(0,0,0,0.4); 
                        }

                        .modal-content {
                            background-color: #fefefe;
                            margin: 15% auto;
                            padding: 20px;
                            border: 1px solid #888;
                            width: 80%;
                            text-align: center;
                        }

                        #okButton {
                            padding: 10px 20px;
                            background-color: #007bff;
                            color: white;
                            border: none;
                            cursor: pointer;
                        }
                    </style>
                </head>
                <body>
                    <div id="myModal" class="modal">
                        <div class="modal-content">
                            <p>Shift details updated successfully!</p>
                            <button id="okButton">OK</button>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var okButton = document.getElementById("okButton");

                            okButton.onclick = function() {
                                window.location.href = "shiftManager.php";
                            }
                        });
                    </script>
                </body>
                </html>';
        exit; // Terminate the script to prevent further execution
    } else {
        echo "Shift ID or day is missing or not provided as an array.";
    }
} else {
    echo "Invalid request.";
}

// Close database connectionection
$connection->close();
