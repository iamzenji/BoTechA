<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holidays</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .custom-table th,
        .custom-table td {
            padding: 8px;
            text-align: left;
        }

        .custom-table th {
            background-color: #3943ac;
            color: white;
        }

        .modal-title {
            background: #091540;
            padding: 5px 10px;
            color: white;
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

        /* Adjustments for layout */
        .btn-add-holiday {
            margin-bottom: 20px;
        }

        /* Ensure table lines are visible */
        .custom-table {
            border-collapse: collapse;
            width: 100%;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid black;
        }

        /* Adjust table container width */
        .table-container {
            width: 80%;
            /* Adjust as needed */
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Heading -->
        <h2 class="page-heading">Holidays</h2>

        <!-- Button to trigger modal -->
        <div class="table-container">
            <button type="button" class="btn btn-primary btn-add-holiday" data-toggle="modal" data-target="#addHolidayModal">Add Holiday</button>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Offset Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Display holidays fetched from the database -->
                    <?php
                    // Include database connection file
                    include 'includes/connection.php';

                    // Query to fetch holidays
                    $sql = "SELECT * FROM holiday";
                    $result = $connection->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Convert date to DateTime object
                            $holiday_date = new DateTime($row['date']);
                            // Get the day name
                            $day_name = $holiday_date->format('l');

                            echo "<tr>";
                            echo "<td>" . $row['date'] . " ($day_name)</td>";
                            echo "<td>" . $row['title'] . "</td>";
                            echo "<td>" . $row['offset_date'] . "</td>";
                            echo "<td>";
                            // Edit button
                            echo "<a href='edit_holiday.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a> ";
                            // Delete button with confirmation modal
                            echo "<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteConfirmationModal" . $row['id'] . "'>Delete</button>";
                            // Delete confirmation modal
                            echo "<div class='modal fade' id='deleteConfirmationModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='deleteConfirmationModalLabel" . $row['id'] . "' aria-hidden='true'>";
                            echo "<div class='modal-dialog' role='document'>";
                            echo "<div class='modal-content'>";
                            echo "<div class='modal-header'>";
                            echo "<h5 class='modal-title' id='deleteConfirmationModalLabel" . $row['id'] . "'>Delete Holiday</h5>";
                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                            echo "<span aria-hidden='true'>&times;</span>";
                            echo "</button>";
                            echo "</div>";
                            echo "<div class='modal-body'>";
                            echo "Are you sure you want to delete this holiday?";
                            echo "</div>";
                            echo "<div class='modal-footer'>";
                            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                            echo "<a href='delete_holiday.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No holidays found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addHolidayModal" tabindex="-1" role="dialog" aria-labelledby="addHolidayModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHolidayModalLabel">Add Holiday</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_holiday.php" method="post">
                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="date" id="date" name="date" required><br><br>
                        </div>
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" id="title" name="title" required><br><br>
                        </div>
                        <div class="form-group">
                            <label for="details">Details:</label>
                            <input type="text" id="details" name="details" required><br><br>
                        </div>
                        <div class="form-group">
                            <label for="offset_date">Offset Date:</label>
                            <input type="date" id="offset_date" name="offset_date" required><br><br>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Holiday</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript to set the value of offset date -->
    <script>
        // Get the date input field
        const dateInput = document.getElementById('date');
        // Get the offset date input field
        const offsetDateInput = document.getElementById('offset_date');

        // Add event listener to date input field
        dateInput.addEventListener('change', function() {
            // Set the value of offset date input field to match the selected date
            offsetDateInput.value = this.value;
        });
    </script>
</body>

</html>