<?php
// Include database connection file
include 'includes/connection.php';

// Start or resume session to access session variables
session_start();

// Check if employee ID is available in session
if(isset($_SESSION['employee_id'])) {
    $employee_id = $_SESSION['employee_id'];

    // Check if it's a POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if it's a request to file a leave
        if (isset($_POST["request_form"])) {
            // Validate and sanitize form inputs
            $reason = $_POST['reason'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $absence_type = $_POST['absence_type'];

            // Handle file upload only if the absence type is not "Emergency Leave"
            if ($absence_type !== "Emergency Leave" && $absence_type !== "Vacation Leave" ) {
                $file_name = $_FILES['sick_leave_evidence']['name'];
                $file_tmp = $_FILES['sick_leave_evidence']['tmp_name'];
                $file_type = $_FILES['sick_leave_evidence']['type'];
                $file_size = $_FILES['sick_leave_evidence']['size'];

                // Specify the directory to store uploaded files
                $upload_directory = "includes/pictures/uploads"; // Adjust this directory path as needed

                // Check if file was uploaded successfully
                if (is_uploaded_file($file_tmp)) {
                    // Move the uploaded file to the upload directory
                    $target_file = $upload_directory . basename($file_name);
                    if (move_uploaded_file($file_tmp, $target_file)) {
                        // Insert data into the database
                        $sql = "INSERT INTO request_leave (employee_id, start_date, end_date, reason, absence_type, file_name, file_type, file_path) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("ssssssss", $employee_id, $start_date, $end_date, $reason, $absence_type, $file_name, $file_type, $target_file);

                        // Execute the query
                        if ($stmt->execute()) {
                            // Return success message
                            echo "<script>alert('Leave Filed Successfully!'); window.location.href = 'request_leave.php';</script>";
                        } else {
                            // Handle database insertion error
                            echo "Error: " . $connection->error;
                        }
                        $stmt->close();
                    } else {
                        echo "File upload failed.";
                    }
                }
            } else {
                // Insert data into the database without file upload for "Emergency Leave"
                $sql = "INSERT INTO request_leave (employee_id, start_date, end_date, reason, absence_type) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("sssss", $employee_id, $start_date, $end_date, $reason, $absence_type);

                // Execute the query
                if ($stmt->execute()) {
                    // Return success message
                    echo "<script>alert('Leave Filed Successfully!'); window.location.href = 'request_leave.php';</script>";
                } else {
                    // Handle database insertion error
                    echo "Error: " . $connection->error;
                }
                $stmt->close();
            }
        }
        // Check if it's a request to reject a leave
        elseif (isset($_POST["reject"])) {
            // If the request is to reject a leave request
            $leave_id = $_POST['leave_id'];
            
            // Fetching leave duration for the rejected request
            $sql_leave_duration = "SELECT DATEDIFF(end_date, start_date) AS leave_duration FROM request_leave WHERE id = ?";
            $stmt_leave_duration = $connection->prepare($sql_leave_duration);
            $stmt_leave_duration->bind_param("i", $leave_id);
            $stmt_leave_duration->execute();
            $result_leave_duration = $stmt_leave_duration->get_result();

            if ($result_leave_duration->num_rows > 0) {
                $row_leave_duration = $result_leave_duration->fetch_assoc();
                $leave_duration = $row_leave_duration['leave_duration'];

                // Revert the leave credit deduction for the rejected leave request
                $sql_revert_credit = "UPDATE employee_details SET employee_leave_credit = employee_leave_credit + ? WHERE employee_id = ?";
                $stmt_revert_credit = $connection->prepare($sql_revert_credit);
                $stmt_revert_credit->bind_param("ss", $leave_duration, $employee_id);
                if ($stmt_revert_credit->execute()) {
                    // Update the status of the leave request to "rejected"
                    $sql_update_status = "UPDATE request_leave SET status = 'Rejected' WHERE id = ?";
                    $stmt_update_status = $connection->prepare($sql_update_status);
                    $stmt_update_status->bind_param("i", $leave_id);
                    if ($stmt_update_status->execute()) {
                        echo "<script>alert('Leave Request Rejected!'); window.location.href = 'request_leave_manager.php';</script>";
                    } else {
                        echo "Error updating leave request status: " . $connection->error;
                    }
                    $stmt_update_status->close();
                } else {
                    echo "Error reverting leave credit: " . $connection->error;
                }
                $stmt_revert_credit->close();
            } else {
                echo "Error fetching leave duration: " . $connection->error;
            }
            $stmt_leave_duration->close();
        }

        elseif (isset($_POST["approve"])) {
            // If the request is to approve a leave request
            $leave_id = $_POST['leave_id'];
            
            // Update the status of the leave request to "approved"
            $sql_update_status = "UPDATE request_leave SET status = 'Approved' WHERE id = ?";
            $stmt_update_status = $connection->prepare($sql_update_status);
            $stmt_update_status->bind_param("i", $leave_id);
            if ($stmt_update_status->execute()) {
                echo "<script>alert('Leave Request Approved!'); window.location.href = 'request_leave_manager.php';</script>";
            } else {
                echo "Error updating leave request status: " . $connection->error;
            }
            $stmt_update_status->close();
        } elseif (isset($_POST["view_evidence"])) {
            // If the request is to view evidence
            $leave_id = $_POST['leave_id'];
            
                // Retrieve file content from the database
                $sql_retrieve_file = "SELECT file_name, file_type, file_content FROM request_leave WHERE id = ?";
                $stmt_retrieve_file = $connection->prepare($sql_retrieve_file);
                $stmt_retrieve_file->bind_param("i", $leave_id);
                $stmt_retrieve_file->execute();
                $result_retrieve_file = $stmt_retrieve_file->get_result();
            
                if ($result_retrieve_file->num_rows > 0) {
                    $row_retrieve_file = $result_retrieve_file->fetch_assoc();
                    $file_name = $row_retrieve_file['file_name'];
                    $file_type = $row_retrieve_file['file_type'];
                    $file_content = $row_retrieve_file['file_content'];
            
                    // Set the appropriate header for the file type
                    header("Content-type: ".$file_type);
                    // Set the appropriate header for file display
                    header("Content-Disposition: inline; filename=".$file_name);
            
                    // Output the file content
                    echo base64_decode($file_content);
                } else {
                    echo "File not found.";
                }
                $stmt_retrieve_file->close();
            }
        }
    }
 // Add this closing brace    

// Query to retrieve leave credit based on employee ID
$sql_leave_credit = "SELECT employee_leave_credit FROM employee_details WHERE employee_id = ?";
$stmt_leave_credit = $connection->prepare($sql_leave_credit);
$stmt_leave_credit->bind_param("s", $employee_id);
$stmt_leave_credit->execute();
$result_leave_credit = $stmt_leave_credit->get_result();

// Check if leave credit is found
if ($result_leave_credit->num_rows > 0) {
    // Fetch leave credit information
    $row_leave_credit = $result_leave_credit->fetch_assoc();
    $leave_credit = $row_leave_credit['employee_leave_credit'];

    // Output leave credit information
    echo "Leave Credit: " . $leave_credit;
} else {
    echo "No leave credit found for the provided user.";
}

// Close statement
$stmt_leave_credit->close();

// Close database connectionection
$connection->close();
?>