<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shift Schedule</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
         body, button, input, select, textarea {
        font-family: 'Space Grotesk', sans-serif;
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
            background-color: #f2f2f2;
        }
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
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
    <h2>Shift Schedule</h2>
    <table>
        <thead>
            <tr>
                <th>Effective Date</th>
                <th>Created Date</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
             <!-- PHP code to fetch shift records from the database -->
            <?php
            // Include database connection file
            session_start();
            include 'includes/connection.php';
            
            //Get Employee ID from Session

            $employee_id = $_SESSION['employee_id'];

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
                    echo "<a href='view_shift_employee.php?id=" . $row['id'] . "'>View</a>";
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
</body>
</html>