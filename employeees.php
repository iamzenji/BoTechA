<?php 
include 'includes/connection.php';
include 'includes/header.php';
$sql = "SELECT * FROM employee_details";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee List</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- SweetAlert -->
  <style>
     body, button, input, select, textarea {
        font-family: 'Space Grotesk', sans-serif;
    }
      .modal-title {
        background: #091540;
        padding: 10px;
        color: White;
    }
  .employee {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      border: 1px solid #000000; 
      margin-bottom: 25px;
    }

    .employee img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin-bottom: 10px;
    }


    .employee-container {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 1px solid #000000;
    margin-bottom: 25px;
    cursor: pointer; /* Change cursor to pointer on hover */
}

.employee:hover {
    background-color: #e9ecef; /* Change background color on hover */
    cursor: pointer;
}

.employee-name {
    color: blue; /* Make employee name blue */
}
    



    
  </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-12 mb-4">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmployeeModal">Add Employee</button>
    </div>

    <?php
// Check if $result is not null before using it
if ($result !== false && $result->num_rows > 0) {
    // Loop through each row from the database result
    while ($row = $result->fetch_assoc()) {
        $employee_id = $row['employee_id'];
        $employeeName = $row['employee_name'];
        $position = $row['employee_position'];
        $employeeContact = $row['employee_contact'];
        $employeeUsername = $row['employee_username'];  
        $employeenumber = $row['employee_number']; 
        $employeeEmail = $row['employee_email'];   
        $employeeAddress = $row['employee_address'];   
        $employeeGender = $row['employee_gender'];  
        $employeeAge = $row['employee_age'];  
        $employeeBirthday = $row['employee_birthday'];  
        $employeeHeight = $row['employee_height'];  
        $employeeWeight = $row['employee_weight'];  
        $employeeDate = $row['employee_datestart'];  
        // Output the HTML structure for each employee
        echo '<div class="col-md-4">';
        echo '<div class="employee" onclick="redirectToEmployeeProfile(' . $employee_id . ')">';
        echo '<img src="https://via.placeholder.com/100" alt="' . $employeeName . '">';
        echo '<h3 class="employee-name">' . $employeeName . '</h3>';
        echo '<p>Position: ' . $position . '</p>';
        echo '<p>Employee Contact: ' . $employeeContact . '</p>';
        echo '<p>Employee Username: ' . $employeeUsername . '</p>';
        echo '<p>Employee Number: ' . $employeenumber . '</p>';
        echo '<p>Email: ' . $employeeEmail . '</p>';
        echo '<p>Address: ' . $employeeAddress . '</p>';
        echo '<p>Gender: ' . $employeeGender . '</p>';
        echo '<p>Age: ' . $employeeAge . '</p>';
        echo '<p>Birthday: ' . $employeeBirthday . '</p>';
        echo '<p>Height: ' . $employeeHeight . '</p>';
        echo '<p>Weight: ' . $employeeWeight . '</p>';
        echo '<p>Date Hired: ' . $employeeDate . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "<p>No employees found.</p>";
}
?>

<script>
// JavaScript function to redirect to employee profile page
function redirectToEmployeeProfile(employeeId) {
    window.location.href = 'employeeprof.php?id=' + employeeId;
}
</script>

 
  </div>
</div>

<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <form action="add_employee.php" method="post" id="addEmployeeForm">
        <div class="form-group">
            <label for="employeeNumber">Employee Number</label>
            <input type="text" class="form-control" id="employeeNumber" name="employeeNumber" readonly>
          </div>
          <div class="form-group">
            <label for="employeeName">Employee Name</label>
            <input type="text" class="form-control" id="employeeName" name="employeeName" required>
          </div>

          <div class="form-group">
            <label for="roleType">Role Type</label><br>
            <input type="radio" id="singleRole" name="roleType" value="single" checked> Single Role
            <input type="radio" id="multiRole" name="roleType" value="multi"> Multi Role
          </div>

          <div class="form-group" id="singleRoleDropdown">
            <label for="employeePosition">Position</label>
            <select class="form-control" id="employeePosition" name="employeePosition" required>
                <option value="" disabled selected>Select Position</option>
                <option value="Purchase Order Officer">Purchase Order Officer</option>
                <option value="Inventory Officer">Inventory Officer</option>
                <option value="Sales Officer - Cashier">Sales Officer - Cashier</option>
                <option value="Finance Officer">Finance Officer</option>
                <option value="HR Officer">HR Officer</option>
            </select>
          </div>

          <div class="form-group" id="multiRoleCheckbox" style="display:none;">
            <label for="multiRolePosition">Multi Role Positions</label><br>
            <!-- Replace the placeholders with actual multi-role positions -->
            <div class="form-check">
              <input class="form-check-input multi-role-checkbox" type="checkbox" id="position1" name="multiRolePosition[]" value="Purchase Order Officer">
              <label class="form-check-label" for="position1">Purchase Order Officer</label>
            </div>
            <div class="form-check">
              <input class="form-check-input multi-role-checkbox" type="checkbox" id="position2" name="multiRolePosition[]" value="Inventory Officer">
              <label class="form-check-label" for="position2">Inventory Officer</label>
            </div>
            <div class="form-check">
              <input class="form-check-input multi-role-checkbox" type="checkbox" id="position3" name="multiRolePosition[]" value="Sales Officer - Cashier">
              <label class="form-check-label" for="position3">Sales Officer - Cashier</label>
            </div>
            <div class="form-check">
              <input class="form-check-input multi-role-checkbox" type="checkbox" id="position4" name="multiRolePosition[]" value="Finance Officer">
              <label class="form-check-label" for="position4">Finance Officer</label>
            </div>
            <div class="form-check">
              <input class="form-check-input multi-role-checkbox" type="checkbox" id="position5" name="multiRolePosition[]" value="HR Officer">
              <label class="form-check-label" for="position5">HR Officer</label>
            </div>
          </div>

          <div class="form-group">
            <label for="employeeUsername">Employee Username</label>
            <input type="text" class="form-control" id="employeeUsername" name="employeeUsername" readonly>
            <small id="employeeUsernameHelp" class="form-text text-muted">This is your default username</small>
          </div>

          <div class="form-group">
            <label for="employeePassword">Employee Password</label>
            <input type="password" class="form-control" id="employeePassword" name="employeePassword" readonly>
            <small id="employeePasswordHelp" class="form-text text-muted">This is your default password.</small>
          </div>
          
          <div class="form-group">
            <label for="employeeContact">Employee Contact</label>
            <input type="text" class="form-control" id="employeeContact" name="employeeContact" placeholder="Starts with 09" required>
          </div>

          <div class="form-group">
            <label for="employeeAge">Age</label>
            <input type="number" class="form-control" id="employeeAge" name="employeeAge" min="18" readonly>
          </div>
    
          <div class="form-group">
            <label for="employeeBirthday">Birthday</label>
            <input type="date" class="form-control" id="employeeBirthday" name="employeeBirthday" max="<?php echo date('Y-m-d'); ?>" required>
          </div>
    
          <div class="form-group">
            <label for="employeeEmail">Email</label>
            <input type="email" class="form-control" id="employeeEmail" name="employeeEmail" required>
          </div>
    
          <div class="form-group">
            <label for="employeeAddress">Address</label>
            <input type="text" class="form-control" id="employeeAddress" name="employeeAddress" required>
          </div>
    
          <div class="form-group">
            <label for="employeeGender">Gender</label>
            <select class="form-control" id="employeeGender" name="employeeGender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
          </div>
    
          <div class="form-group">
            <label for="employeeHeight">Height (cm)</label>
            <input type="number" class="form-control" id="employeeHeight" name="employeeHeight" min="1" required>
          </div>
    
          <div class="form-group">
            <label for="employeeWeight">Weight (kg)</label>
            <input type="number" class="form-control" id="employeeWeight" name="employeeWeight" min="1" required>
          </div>
          
          <div class="form-group">
            <label for="employeeDate">Employee Date Hired</label>
            <input type="date" class="form-control" id="employeeDate" name="employeeDate" max="<?php echo date('Y-m-d'); ?>" required>
          </div>
        <button type="submit" class="btn btn-primary" id="addEmployeeButton">Add Employee</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>





$(document).ready(function() {
  

  function validateHeight(height) {
        var minHeight = 100; // Minimum height in centimeters
        var maxHeight = 200; // Maximum height in centimeters
        return height >= minHeight && height <= maxHeight; // Assuming height must be positive and between 100 and 200 cm
    }

    // Function to validate weight
    function validateWeight(weight) {
        var minWeight = 50; // Minimum weight in kilograms
        var maxWeight = 150; // Maximum weight in kilograms
        return weight >= minWeight && weight <= maxWeight; // Assuming weight must be positive and between 50 and 150 kg
    }

    // Event listener for add employee button click
    $('#addEmployeeForm').submit(function(event) {
        var height = $('#employeeHeight').val();
        var weight = $('#employeeWeight').val();
        if (!validateHeight(height)) {
            event.preventDefault(); // Prevent form submission
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Height',
                text: 'Please enter a valid height .'
            });
            return false;
        }
        if (!validateWeight(weight)) {
            event.preventDefault(); // Prevent form submission
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Weight',
                text: 'Please enter a valid weight '
            });
            return false;
        }
    });


  
    


  
});


  
    





$(document).ready(function() {
    // Disable default browser validation
    $('form').attr('novalidate', 'true');

    // Function to show SweetAlert for required fields
    function showRequiredAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Invalid',
            text: 'Please fill out all required fields.',
        });
    }


    function validateAddress(address) {
        // Check if the address has at least 20 characters
        return address.length >= 20;
    }

    // Event listener for "Add Employee" button click
  // Event listener for "Add Employee" button click
$('#addEmployeeModal').on('click', '.btn-primary', function(event) {
    if ($(this).attr('id') === 'addEmployeeButton') {
        // Check for required fields
        var requiredFields = $('#addEmployeeForm').find('[required]');
        var allFieldsFilled = true;
        requiredFields.each(function() {
            if (!$(this).val()) {
                allFieldsFilled = false;
                return false; // Exit the loop early if any required field is empty
            }
        });

        if (!allFieldsFilled) {
            event.preventDefault(); // Prevent form submission
            showRequiredAlert();
            return false; // Exit the function
        }

        // Validate address
        var address = $('#employeeAddress').val();
        if (!validateAddress(address)) {
            event.preventDefault(); // Prevent form submission
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Address',
                text: 'Please enter a valid Philippine address with a minimum of 20 characters.'
            });
            return false; // Exit the function
        }
    }
});


    // Function to validate contact number
    function validateContactNumber(contactNumber) {
        // Check if the contact number starts with "09" and has exactly 11 digits
        return /^09\d{9}$/.test(contactNumber);
    }

    // Event listener for form submission
    $('form').submit(function(event) {
        // Check for required fields
        var requiredFields = $(this).find('[required]');
        var allFieldsFilled = true;
        requiredFields.each(function() {
            if (!$(this).val()) {
                allFieldsFilled = false;
                return false; // Exit the loop early if any required field is empty
            }
        });

        
        if (!allFieldsFilled) {
            event.preventDefault();
            showRequiredAlert();
            return; 
        }

        // Validate contact number
        var contactNumber = $('#employeeContact').val();
        if (!validateContactNumber(contactNumber)) {
            event.preventDefault(); // Prevent form submission if contact number is invalid
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Contact Number',
                text: 'Contact number must start with "09" and have 11 digits.',
            });
            return; 
        }

        
// Validate email
var emailValue = $('#employeeEmail').val();
var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if (!emailRegex.test(emailValue)) {
    event.preventDefault(); // Prevent form submission if email is invalid
    Swal.fire({
        icon: 'warning',
        title: 'Invalid Email Address',
        text: 'Please enter a valid email address for Email.',
    });
    return; // Exit the function to prioritize showing the invalid email alert
}


        // Check if multi-role is selected and at least two positions are chosen
        if ($('input[type=radio][name=roleType]:checked').val() === 'multi') {
            if ($('.multi-role-checkbox:checked').length < 2) {
                event.preventDefault(); // Prevent form submission
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid',
                    text: 'Please select at least two positions for multi-role'
                });
            }
        }
    });

  
});





$(document).ready(function() {
    // Function to calculate age based on birthday
    function calculateAge(birthday) {
        var today = new Date();
        var birthDate = new Date(birthday);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    // Event listener for birthday input field
    $('#employeeBirthday').on('change', function() {
        var birthday = $(this).val();
        var age = calculateAge(birthday);
        $('#employeeAge').val(age); // Update the age input field
    });

    // Initial calculation of age based on default birthday value
    var defaultBirthday = $('#employeeBirthday').val();
    var defaultAge = calculateAge(defaultBirthday);
    $('#employeeAge').val(defaultAge); // Update the age input field initially


    $('#employeeBirthday').on('change', function() {
        var birthday = $(this).val();
        var age = calculateAge(birthday);
        if (age < 18 || age > 60) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Age',
                text: 'Age must be between 18 and 60 years.'
            });
            // Clear the age field
            $('#employeeAge').val('');
        } else {
            $('#employeeAge').val(age); // Update the age input field
        }
    });



});








  $(document).ready(function() {
    // Function to generate a random string for employee number
    function generateRandomEmployeeNumber() {
        var length = 6; // Adjust the length of the employee number as needed
        var charset = "0123456789";
        var result = "";
        for (var i = 0; i < length; i++) {
            result += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        return result;
    }

 


    // Show/hide position dropdown or checkboxes based on radio button selection
    $('input[type=radio][name=roleType]').change(function() {
        if (this.value === 'single') {
            $('#singleRoleDropdown').show();
            $('#multiRoleCheckbox').hide();
            $('#employeePosition').prop('required', true); // Make employeePosition required for Single Role
        } else if (this.value === 'multi') {
            $('#singleRoleDropdown').hide();
            $('#multiRoleCheckbox').show();
            $('#employeePosition').prop('required', false); // Remove required attribute for Multi Role
        }
    });

    // Generate random username and password and set them as readonly
    $('#addEmployeeModal').on('shown.bs.modal', function() {
        var username = generateRandomString();
        var password = generateRandomString();
        $('#employeeUsername').val(username).prop('readonly', true);
        $('#employeePassword').val(password).prop('readonly', true);
    });

    // Check if more than one checkbox is selected for multi-role positions
  

    // Generate random employee number when modal is shown
    $('#addEmployeeModal').on('shown.bs.modal', function() {
        var employeeNumber = generateRandomEmployeeNumber();
        $('#employeeNumber').val(employeeNumber); // Set the generated number to the input field
    });
});

// Function to generate a random string
function generateRandomString() {
    var length = 8;
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    var result = "";
    for (var i = 0; i < length; i++) {
        result += charset.charAt(Math.floor(Math.random() * charset.length));
    }
    return result;
}
</script>


</body>
</html>