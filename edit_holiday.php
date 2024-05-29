<?php
// Include database connection file
include 'includes/connection.php';

// Initialize variables
$holiday_id = $date = $title = $details = $offset_date = '';

// Check if the holiday ID is provided in the URL
if (isset($_GET['id'])) {
    // Get the holiday ID from the URL
    $holiday_id = $_GET['id'];

    // Fetch the holiday details from the database based on the provided ID
    $sql = "SELECT * FROM holiday WHERE id = $holiday_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the holiday details
        $row = $result->fetch_assoc();
        $date = $row['date'];
        $title = $row['title'];
        $details = $row['details'];
        $offset_date = $row['offset_date'];
    } else {
        echo "Holiday not found.";
        exit();
    }
} else {
    echo "Holiday ID is missing.";
    exit();
}

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $new_date = $_POST['date'];
    $new_title = $_POST['title'];
    $new_details = $_POST['details'];
    $new_offset_date = $_POST['offset_date'];

    // Update the holiday details in the database
    $sql_update = "UPDATE holiday SET date = '$new_date', title = '$new_title', details = '$new_details', offset_date = '$new_offset_date' WHERE id = $holiday_id";

    if ($conn->query($sql_update) === TRUE) {
        // Redirect to the holidays page after successful update
        header("Location: holidayManager.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Holiday</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Add your CSS styles here */
        body,
        button,
        input,
        select,
        textarea {
            font-family: 'Space Grotesk', sans-serif;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>Edit Holiday</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $holiday_id; ?>" method="post">
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" class="form-control" value="<?php echo $date; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo $title; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="details">Details:</label>
                        <input type="text" id="details" name="details" class="form-control" value="<?php echo $details; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="offset_date">Offset Date:</label>
                        <input type="date" id="offset_date" name="offset_date" class="form-control" value="<?php echo $offset_date; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Holiday</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>