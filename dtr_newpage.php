<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DTR Record</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="./src/js/sweetalert.min.js"></script>

  <style>
        body,
        button,
        input,
        select,
        textarea {
            font-family: 'Space Grotesk', sans-serif;
        }
    body {
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
    }
    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h3 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
            background: #091540;
            padding: 10px;
            color: White;
            text-align: center; 
        }
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    label {
        font-weight: bold;
        margin-bottom: 10px;
    }
    input[type="number"] {
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 100%;
        margin-bottom: 10px;
    }
    button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
    }
    button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }
    
</style>
</head>
<body>
<div class="container">
    <h3>DTR Records</h3>
    <form action="record_time_newpage.php" method="post">
        <label for="employeeNumber">Employee Number:</label>
        <input type="number" id="employeeNumber" name="employeeNumber" required><br><br>

        <!-- Check button -->
        <button type="button" onclick="checkRecords()">Check Records</button>

        <!-- Time In button -->
        <button type="submit" name="time_in" class="btn btn-primary" disabled>Time In</button>
        <!-- Time Out button -->
        <button type="submit" name="time_out" class="btn btn-primary" disabled>Time Out</button>
        <!-- Break Out button -->
        <button type="submit" name="break_out" class="btn btn-primary" disabled>Break Out</button>
        <!-- Break In button -->
        <button type="submit" name="break_in" class="btn btn-primary" disabled>Break In</button>
        <!-- Broken Time In button -->
    <button type="button" name="broken_time_in" class="btn btn-primary" disabled onclick="submitForm('broken_time_in')">Broken Time In</button>
    <!-- Broken Break Out button -->
    <button type="button" name="broken_break_out" class="btn btn-primary" disabled onclick="submitForm('broken_break_out')">Broken Break Out</button>
    <!-- Broken Break In button -->
    <button type="button" name="broken_break_in" class="btn btn-primary" disabled onclick="submitForm('broken_break_in')">Broken Break In</button>
    <!-- Broken Time Out button -->
    <button type="button" name="broken_time_out" class="btn btn-primary" disabled onclick="submitForm('broken_time_out')">Broken Time Out</button>

    </form>
</div>
<script>
     function checkRecords() {
    // Retrieve the employee number
    var employeeNumber = document.getElementById('employeeNumber').value;

                // Check if the employee number is empty
                if(employeeNumber.trim() === "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please enter the employee number.'
                });
                return;
            }

    // AJAX request to check records
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var result = JSON.parse(xhr.responseText);

                // Check if employee is not found
                if (result.notFound) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Employee not found.'
                            });
                            return;
                        }

                // Check if already timed out and no broken schedule
                if (result.recordsExist.timeOut && !result.brokenRecordsExist.brokenTimeIn && !result.brokenRecordsExist.brokenBreakOut && !result.brokenRecordsExist.brokenBreakIn && !result.brokenRecordsExist.brokenTimeOut) {
                     Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: "You have already timed out for today and you don't have a broken schedule."
                            });
                            return;
                }

                // Check if any shift exists for the employee
                var hasShift = false;
                for (var day in result.shifts) {
                    if (result.shifts.hasOwnProperty(day) && result.shifts[day]) {
                        hasShift = true;
                        break;
                    }
                }

                // If no shift exists for any day
                if (!hasShift) {
                    // Disable all buttons
                    disableButtons();
                    // Show alert message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No shift exists for the employee. Create one first.'
                    });
                    return;
                } 

                // Enable or disable Time In button based on record existence
                var timeInButton = document.getElementsByName("time_in")[0];
                timeInButton.disabled = result.recordsExist.timeIn || !result.shiftRecordsExist.timeIn;

                // Enable or disable Break Out button based on record existence and time in status
                var breakOutButton = document.getElementsByName("break_out")[0];
                breakOutButton.disabled = result.recordsExist.breakOut || !result.shiftRecordsExist.breakOut || !result.recordsExist.timeIn;

                // Enable or disable Break In button based on record existence, time in status, and break out status
                var breakInButton = document.getElementsByName("break_in")[0];
                breakInButton.disabled = result.recordsExist.breakIn || !result.shiftRecordsExist.breakIn || !result.recordsExist.timeIn || !result.recordsExist.breakOut;

                // Enable or disable Time Out button based on record existence and break in status
                var timeOutButton = document.getElementsByName("time_out")[0];
                timeOutButton.disabled = result.recordsExist.timeOut || !result.shiftRecordsExist.timeOut || !result.recordsExist.timeIn || !result.recordsExist.breakOut || !result.recordsExist.breakIn;

                // Enable or disable Broken buttons based on record existence and other statuses
                enableBrokenButtons(result);
            } else {
                // Handle AJAX error
                alert("Error fetching employee records. Please try again later.");
            }
        }
    };
    xhr.open("GET", "check_records.php?employeeNumber=" + employeeNumber, true);
    xhr.send();
}



function disableButtons() {
    // Disable all buttons except the "Check Records" button
    var buttons = document.querySelectorAll("button:not([onclick='checkRecords()'])");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].disabled = true;
    }
}





function enableBrokenButtons(result) {
    var brokenButtons = document.querySelectorAll("[name^='broken_']");
    brokenButtons.forEach(function(button) {
        var buttonName = button.getAttribute("name");
        switch (buttonName) {
            case "broken_time_in":
                button.disabled = !result.recordsExist.timeOut || result.brokenRecordsExist.brokenTimeIn || !result.shiftRecordsExist.brokenTimeIn;
                break;
            case "broken_break_out":
                button.disabled = !result.brokenRecordsExist.brokenTimeIn || result.brokenRecordsExist.brokenBreakOut || result.brokenRecordsExist.brokenTimeOut || !result.shiftRecordsExist.brokenBreakOut;
                break;
            case "broken_break_in":
                button.disabled = !result.brokenRecordsExist.brokenBreakOut || result.brokenRecordsExist.brokenBreakIn || !result.shiftRecordsExist.brokenBreakIn;
                break;
            case "broken_time_out":
                button.disabled = !result.brokenRecordsExist.brokenTimeIn || result.brokenRecordsExist.brokenTimeOut || (result.brokenRecordsExist.brokenBreakOut && !result.brokenRecordsExist.brokenBreakIn) || !result.shiftRecordsExist.brokenTimeOut;
                break;
            default:
                button.disabled = true;
                break;
        }
    });
}



    




function submitForm(buttonName) {
    var form = document.getElementById("recordForm");
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = buttonName;
    input.value = "1";
    form.appendChild(input);
    form.submit();
}

    </script>
</head>
</body>
</html>