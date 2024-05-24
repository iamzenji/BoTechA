<?php
// Include database connection file
include 'includes/connection.php';
include 'includes/header.php';

?>
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
        }

        .table-checkbox {
            text-align: center;
            width: 7%;
            vertical-align: middle;
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

                if(isset($_GET['id'])) {
                    $employee_id = $_GET['id'];

                    // Retrieve the name of the logged-in employee
                    if(isset($_SESSION['employee_id'])) {
                        $logged_in_employee_id = $_SESSION['employee_id'];
                        $sql_employee_name = "SELECT employee_name FROM employee_details WHERE employee_id = $logged_in_employee_id";
                        $result_employee_name = $connection->query($sql_employee_name);
                        if ($result_employee_name->num_rows > 0) {
                            $row_employee_name = $result_employee_name->fetch_assoc();
                            $logged_in_employee_name = $row_employee_name['employee_name'];
                        }
                    } else {
                        // Handle the case where $_SESSION['employee_id'] is not set
                        $logged_in_employee_name = ''; // Set a default value or handle the error accordingly
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
                } else {
                    // Handle the case where $_GET['id'] is not set
                    echo "<tr><td colspan='4'>No employee ID provided</td></tr>";
                }

                // Close database connectionection
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
                    <form action="add_shift.php?id=<?php echo $employee_id; ?>" method="post" id="addShiftForm"> <!-- Added id attribute to the form -->
                        <div class="form-group">
                            <label for="effective_date">Effective Date:</label>
                            <input type="date" id="effective_date" name="effective_date" min="<?php echo date('Y-m-d'); ?>" class="form-control" required>

                        </div>
                        <div class="form-group">
                            <label for="created_by">Created By:</label>
                            <!-- Display the name of the logged-in employee -->
                            <input type="text" id="created_by" name="created_by" class="form-control" value="<?php echo $logged_in_employee_name; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Day</th>
                                        <th>Time In</th>
                                        <th>Break Out</th>
                                        <th>Break In</th>
                                        <th>Time Out</th>
                                        <th>Broken Time In</th>
                                        <th>Broken Break Out</th>
                                        <th>Broken Break In</th>
                                        <th>Broken Time Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

                                    // Pass the days array to JavaScript by encoding it as JSON
                                    echo '<script>';
                                    echo 'var days = ' . json_encode($days) . ';';
                                    echo '</script>';
                                    foreach ($days as $index => $day) {
                                        echo "<tr>";
                                        echo "<td class='table-checkbox'><input type='checkbox' name='days[$index]' value='$day' onchange='toggleTimeInputs(this)' class='form-check-input'></td>";
                                        echo "<td>$day</td>";
                                        echo "<td><input type='time' id='time_in_$index' name='time_in[$index]' class='form-control' onchange='toggleBrokenTimeInputs($index)' disabled></td>";
                                        echo "<td><input type='time' id='break_out_$index' name='break_out[$index]' class='form-control' onchange='toggleBrokenTimeInputs($index)' disabled></td>";
                                        echo "<td><input type='time' id='break_in_$index' name='break_in[$index]' class='form-control' onchange='toggleBrokenTimeInputs($index)' disabled></td>";
                                        echo "<td><input type='time' id='time_out_$index' name='time_out[$index]' class='form-control' onchange='toggleBrokenTimeInputs($index)' disabled></td>";
                                        echo "<td><input type='time' id='broken_time_in_$index' name='broken_time_in[$index][]' class='form-control' disabled></td>";
                                        echo "<td><input type='time' id='broken_break_out_$index' name='broken_break_out[$index][]' class='form-control' disabled></td>";
                                        echo "<td><input type='time' id='broken_break_in_$index' name='broken_break_in[$index][]' class='form-control' disabled></td>";
                                        echo "<td><input type='time' id='broken_time_out_$index' name='broken_time_out[$index][]' class='form-control' disabled></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary" id="addShiftBtn" onclick="return validateForm()">Add Shift</button> <!-- Call the validateForm function when the form is submitted -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>







function toggleAddShiftButton() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        var addButton = document.getElementById('addShiftBtn');
        var anyCheckboxChecked = false;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                anyCheckboxChecked = true;
            }
        });

        addButton.disabled = !anyCheckboxChecked;
    }

    // Call the toggleAddShiftButton function whenever a checkbox state changes
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', toggleAddShiftButton);
    });

    // Initially call the function to set the initial state of the button
    toggleAddShiftButton();








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
       // Function to toggle time inputs based on checkbox state
function toggleTimeInputs(checkbox) {
    var row = checkbox.parentNode.parentNode;
    var timeInputs = row.querySelectorAll('input[type="time"]');
    var index = Array.from(row.parentNode.children).indexOf(row) - 1; // Get the index of the row
    timeInputs.forEach(function(input) {
        if (!checkbox.checked) {
            input.disabled = true; // Disable all inputs if the checkbox is unchecked
        } else {
            var inputIndex = input.id.match(/\d+/)[0]; // Extract the index from the input id
            if (input.id.includes(index) || input.id.includes('broken')) {
                input.disabled = false; // Enable inputs related to the selected day or broken times
            } else {
                input.disabled = true; // Disable inputs not related to the selected day
            }
        }
    });
}


        // Function to validate essential time fields for all days
        function validateForm() {
    var days = <?php echo json_encode($days); ?>; // Retrieve the PHP array of days
    var isValid = true;

    // Iterate through each day
    days.forEach(function(day, index) {
        var checkbox = document.querySelector('input[name="days[' + index + ']"][value="' + day + '"]');
        if (!checkbox.checked) {
            // If the checkbox for this day is not checked, skip validation
            return;
        }

        var timeIn = document.getElementById('time_in_' + index);
        var breakOut = document.getElementById('break_out_' + index);
        var breakIn = document.getElementById('break_in_' + index);
        var timeOut = document.getElementById('time_out_' + index);
        var brokenTimeIn = document.getElementById('broken_time_in_' + index);
        var brokenBreakOut = document.getElementById('broken_break_out_' + index);
        var brokenBreakIn = document.getElementById('broken_break_in_' + index);
        var brokenTimeOut = document.getElementById('broken_time_out_' + index);

        // Check if any of the main time fields are empty
        if (timeIn.value === '' || breakOut.value === '' || breakIn.value === '' || timeOut.value === '') {
            alert('Please fill in all essential time-related fields for ' + day + '.');
            isValid = false; // Set isValid to false if any day's fields are invalid
            return; // Exit the loop if any day's fields are invalid
        }

        // Check if any of the broken time fields are filled
        var anyBrokenTimeFilled = brokenTimeIn.value !== '' || brokenBreakOut.value !== '' || brokenBreakIn.value !== '' || brokenTimeOut.value !== '';

        // If any broken time field is filled, ensure all broken time fields are filled
        if (anyBrokenTimeFilled && (brokenTimeIn.value === '' || brokenBreakOut.value === '' || brokenBreakIn.value === '' || brokenTimeOut.value === '')) {
            alert('Once one of the broken time-related fields is filled for ' + day + ', all broken time fields must be completed.');
            isValid = false; // Set isValid to false if any day's fields are invalid
            return; // Exit the loop if any day's fields are invalid
        }
    });

    return isValid; // Allow form submission if all days' fields are valid
}

    </script>
</body>

</html>