<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holiday</title>
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
            background-color: #3943ac;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Holidays</h2>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Offset Date</th>
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
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No holidays found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
