<?php
include 'includes/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Success</title>

  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
            body,
        button,
        input,
        select,
        textarea {
            font-family: 'Space Grotesk', sans-serif;
        }
    
    .modal {
        display: none; 
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
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    width: 60%;
    max-width: 500px;
    text-align: center;
}
.modal-content p {
    margin-bottom: 15px;
    font-size: 16px;
    color: #333;
}
.modal-content strong {
    font-weight: bold;
    color: #007bff;
}
.modal-content button {
    padding: 10px 20px;
    margin-top: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.modal-content button:hover {
    background-color: #0056b3;
}
    
</style>
</head>
<body>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $employeeName = $_POST['employeeName'];
    $employeeContact = $_POST['employeeContact'];
    $employeeDate = $_POST['employeeDate'];
    $employeeUsername = $_POST['employeeUsername'];
    $employeePassword = $_POST['employeePassword'];

    // Check if roleType is single or multi
    if ($_POST['roleType'] === 'single') {
        $employeePosition = $_POST['employeePosition']; // Get single role position
    } elseif ($_POST['roleType'] === 'multi') {
        // For multi-role, concatenate selected positions with 'and'
        $multiRolePositions = $_POST['multiRolePosition'];
        $employeePosition = implode(' and ', $multiRolePositions);
    }

    // New fields
    $employeeNumber = $_POST['employeeNumber'];
    $employeeAge = $_POST['employeeAge'];
    $employeeBirthday = $_POST['employeeBirthday'];
    $employeeEmail = $_POST['employeeEmail'];
    $employeeAddress = $_POST['employeeAddress'];
    $employeeGender = $_POST['employeeGender'];
    $employeeHeight = $_POST['employeeHeight'];
    $employeeWeight = $_POST['employeeWeight'];

      // Prepare the SQL statement
      $sql = "INSERT INTO employee_details (employee_number, employee_name, employee_position, employee_contact, employee_datestart, employee_username, employee_password, employee_age, employee_birthday, employee_email, employee_address, employee_gender, employee_height, employee_weight ) 
      VALUES ('$employeeNumber','$employeeName', '$employeePosition', '$employeeContact', '$employeeDate', '$employeeUsername', '$employeePassword', '$employeeAge', '$employeeBirthday', '$employeeEmail', '$employeeAddress', '$employeeGender', '$employeeHeight' , '$employeeWeight')";

// Execute the SQL statement
if ($connection->query($sql) === TRUE) {
  // Insert additional values into employee_salary table
  $sql_insert_salary = "INSERT INTO employee_salary (employee_id, insurance, sss, pag_ibig, tax, pay_per_hour) 
                        VALUES ('$connection->insert_id', 1000, 250, 350, 1000, 20)";
  $connection->query($sql_insert_salary);


        // Display success message using JavaScript modal
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    var modal = document.getElementById("myModal");
                    var okButton = document.getElementById("okButton");
                    var username = "' . $employeeUsername . '";
                    var password = "' . $employeePassword . '";
                    var employeeNumber = "' . $employeeNumber . '";

                    modal.style.display = "block";

                    // Copy username to clipboard
                    var usernameButton = document.getElementById("copyUsername");
                    usernameButton.onclick = function() {
                        copyToClipboard(username);
                    }

                    // Copy password to clipboard
                    var passwordButton = document.getElementById("copyPassword");
                    passwordButton.onclick = function() {
                        copyToClipboard(password);
                    }

                    // Copy employee number to clipboard
                    var employeeNumberButton = document.getElementById("copyEmployeeNumber");
                    employeeNumberButton.onclick = function() {
                        copyToClipboard(employeeNumber);
                    }

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

                function copyToClipboard(text) {
                    var tempInput = document.createElement("input");
                    tempInput.value = text;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempInput);
                }
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
    <p>Employee Added Successfully! Please Take Down Your Account Details</p>
    <p>Employee Number: <strong><?php echo $employeeNumber; ?></strong></p>
    <button id="copyEmployeeNumber">Copy Employee Number</button><br>
    <p>Default Username: <strong><?php echo $employeeUsername; ?></strong></p>
    <button id="copyUsername">Copy Username</button><br>
    <p>Default Password: <strong><?php echo $employeePassword; ?></strong></p>
    <button id="copyPassword">Copy Password</button><br>
    <button id="okButton">OK</button>
  </div>

</div>

</body>
</html>