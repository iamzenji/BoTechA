<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Image Display</title>
<style>
  body {
    margin: 0;
    padding: 0;
    background-color: #f0f8ff; /* Sky blue background color */
  }
  .header {
    text-align: center;
    margin: 20px 0;
    padding: 20px 0;
    background-color: #87ceeb; /* Sky blue background color */
    color: #fff; /* White text color */
  }
  .image-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 800px; /* Adjust as needed */
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fff; /* White background color */
    margin-bottom: 20px;
  }
  .image-container img {
    max-width: calc(100% - 40px); /* Subtract padding from max-width */
    max-height: calc(100vh - 200px); /* Subtract padding and container margin from max-height */
    margin: 0 auto;
  }
  .file-name {
    margin-top: 10px;
    font-size: 16px;
  }
</style>
</head>
<body>

<div class="header">
  <h2>Uploaded Evidence</h2>
</div>

<?php
// Include database connection file
include 'includes/connection.php';

// Check if leave_id is provided in the URL
if (isset($_GET['leave_id'])) {
    // Retrieve leave_id from URL parameters
    $leave_id = $_GET['leave_id'];

    // Retrieve file path and name from the database based on the leave_id
    $sql_retrieve_file = "SELECT file_path, file_name FROM request_leave WHERE id = ?";
    $stmt_retrieve_file = $connection->prepare($sql_retrieve_file);
    $stmt_retrieve_file->bind_param("i", $leave_id);
    $stmt_retrieve_file->execute();
    $result_retrieve_file = $stmt_retrieve_file->get_result();

    // Check if file_path and file_name are retrieved
    if ($result_retrieve_file->num_rows > 0) {
        // Fetch file path and name
        $row_retrieve_file = $result_retrieve_file->fetch_assoc();
        $file_path = $row_retrieve_file['file_path'];
        $file_name = $row_retrieve_file['file_name'];

        // Output container and image
        echo "<div class='image-container'>";
        
        // Check if the file exists
        if (file_exists($file_path)) {
            // Output the file content
            echo "<img src='$file_path' alt='Uploaded Image'>";
        } else {
            // File not found
            echo "File not found: $file_path<br>";
        }
        
        // Output file name
        echo "<div class='file-name'>$file_name</div>";

        // Close image container
        echo "</div>";
    } else {
        // File details not retrieved
        echo "File details not retrieved from the database.<br>";
    }

    // Close prepared statement
    $stmt_retrieve_file->close();
} else {
    // Leave ID not provided
    echo "Leave ID not provided.";
}

// Close database connectionection
$connection->close();
?>

</body>
</html>
