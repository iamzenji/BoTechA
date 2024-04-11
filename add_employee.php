<?php
include 'includes/connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $employeeName = $_POST['employeeName'];
    $employeePosition = $_POST['employeePosition'];
    $employeeContact = $_POST['employeeContact'];
    $employeeDate = $_POST['employeeDate'];
    $employeeUsername = $_POST['employeeUsername'];
    $employeePassword = $_POST['employeePassword'];

    // Prepare the SQL statement
    $sql = "INSERT INTO employee_details (employee_name, employee_position, employee_contact, employee_datestart, employee_username, employee_password) 
            VALUES ('$employeeName', '$employeePosition', '$employeeContact', '$employeeDate', '$employeeUsername', '$employeePassword')";

    // Execute the SQL statement
    if ($connection->query($sql) === TRUE) {
        // Display success message using JavaScript modal
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    var modal = document.getElementById("myModal");
                    var okButton = document.getElementById("okButton");

                    modal.style.display = "block";

                    okButton.onclick = function() {
                        modal.style.display = "none";
                        window.location.href = "employeees.php";
                    }

                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                            window.location.href = "employeees.php";
                        }
                    }
                });
            </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

// Close the database connection
$connection->close();
?>

<div id="myModal" class="modal">


    <div class="modal-content">
        <p>Employee Added Successfully!</p>
        <button id="okButton">OK</button>
    </div>

</div>