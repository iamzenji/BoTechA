<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shift Management</title>
    <!-- Bootstrap CSS -->
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

        .custom-table th,
        .custom-table td {
            border: 1px solid black;
            padding: 8px;
            /* Adjusted padding */
            text-align: left;
        }

        .custom-table th {
            background-color: #3943ac;
            color: white;
        }

        .modal-title {
            background: #091540;
            padding: 10px;
            color: white;
        }

        .modal-dialog {
            max-width: 45%;
            /* Adjust the modal width */
        }

        .table-checkbox {
            text-align: center;
            width: 7%;
            /* Adjust the width as needed */
            vertical-align: middle;
            /* Center checkboxes vertically */
        }

        .table-checkbox input[type="checkbox"] {
            margin: 0 auto;
            display: block;
        }

        .btn-container {
            margin-bottom: 10px;
        }

        /* Custom styles for heading */
        .page-heading {
            font-size: 2rem;
            color: #3943ac;
            margin-bottom: 20px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="page-heading">Shift</h1>
        <div class="btn-container">
            <!-- Button to trigger add shift modal -->
            <button type="button" class="btn btn-primary" onclick="toggleAddShiftModal()">Add Shift</button>
        </div>
        <!-- Table to display existing shifts -->
        <table class="table custom-table">
            <thead>
                <tr>
                    <th class="text-white bg-primary">Effective Date</th>
                    <th class="text-white bg-primary">Created Date</th>
                    <th class="text-white bg-primary">Created By</th>
                    <th class="text-white bg-primary">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP code to fetch shift records from the database -->
                <?php
                // Include database connection file
                include 'includes/connection.php';
                session_start();

                // Check if the user's position is "HR Officer"
                if (!isset($_SESSION['employee_position']) || $_SESSION['employee_position'] !== 'HR Officer') {
                    header("Location: unauthorized.php");
                    exit();
                }

                if (isset($_GET['id'])) {
                    $employee_id = $_GET['id'];
                }

                // Query to fetch shift records
                $sql = "SELECT * FROM shift WHERE employee_id = $employee_id";
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['effective_date'] . "</td>";
                        echo "<td>" . $row['created_date'] . "</td>";
                        echo "<td>" . $row['created_by'] . "</td>";
                        echo "<td>";
                        // View button
                        echo "<a href='view_shift.php?id=" . $row['id'] . "&employeeid=" . $employee_id . "' class='btn btn-info'>View</a>";
                        // Edit button
                        echo "<a href='edit_shift.php?id=" . $row['id'] . "&employeeid=" . $employee_id . "' class='btn btn-primary'>Edit</a>";
                        // Delete button with modal confirmation
                        echo "<button class='btn btn-danger' onclick='showDeleteConfirmation(" . $row['id'] . ", $employee_id)'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No shifts found</td></tr>";
                }
                // Close database connection
                $connection->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="modal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <a href="shiftManager.php?id=<?php echo $employee_id; ?>" class="close">&times;</a>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this shift?</p>
                </div>
                <div class="modal-footer">
                    <a href="shiftManager.php?id=<?php echo $employee_id; ?>" class="btn btn-secondary">Cancel</a>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Shift Modal -->
    <div id="addShiftModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Shift Details</h5>
                    <!-- Replace button with anchor tag -->
                    <a href="shiftManager.php?id=<?php echo $employee_id; ?>" class="close">&times;</a>
                </div>
                <div class="modal-body" style="max-height: auto; overflow-y: auto;">
                    <form action="add_shift.php?id=<?php echo $employee_id; ?>" method="post">
                        <div class="form-group">
                            <label for="effective_date">Effective Date:</label>
                            <input type="date" id="effective_date" name="effective_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="created_by">Created By:</label>
                            <input type="text" id="created_by" name="created_by" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Day</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

                                    foreach ($days as $day) {
                                        echo "<tr>";
                                        echo "<td class='table-checkbox'><input type='checkbox' name='days[]' value='$day' onchange='toggleTimeInputs(this)' class='form-check-input'></td>";
                                        echo "<td>$day</td>";
                                        echo "<td><input type='time' name='time_in[]' class='form-control' disabled></td>"; // Corrected name attribute
                                        echo "<td><input type='time' name='time_out[]' class='form-control' disabled></td>"; // Corrected name attribute
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Shift</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <script>
        // Function to toggle Add Shift modal
        function toggleAddShiftModal() {
            var modal = document.getElementById('addShiftModal');
            if (modal.style.display === 'block') {
                modal.style.display = 'none';
            } else {
                modal.style.display = 'block';
            }
        }

        // Function to show delete confirmation modal
        function showDeleteConfirmation(shiftId, employeeId) {
            var modal = document.getElementById('deleteConfirmationModal');
            modal.style.display = 'block';

            // Set the delete button's onclick event handler to pass the shiftId and employeeId
            document.getElementById('confirmDeleteBtn').onclick = function() {
                // Redirect to delete_shift.php with the shiftId and employeeId parameters
                window.location.href = 'delete_shift.php?id=' + shiftId + '&employee_id=' + employeeId;
            };
        }

        // Function to toggle time inputs based on checkbox state
        function toggleTimeInputs(checkbox) {
            var row = checkbox.parentNode.parentNode;
            var timeInputs = row.querySelectorAll('input[type="time"]');
            timeInputs.forEach(function(input) {
                input.disabled = !checkbox.checked;
            });
        }
    </script>
</body>

</html>