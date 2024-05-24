<?php
date_default_timezone_set('Asia/Manila');
// Include database connection file
include 'includes/connection.php';

// Initialize employee number
$employeeNumber = '';

// Check if employee number is provided in the URL
if(isset($_GET['employeeNumber'])) {
    $employeeNumber = $_GET['employeeNumber'];

    // Query to find the employee_id based on employee_number
    $sql_find_employee = "SELECT employee_id FROM employee_details WHERE employee_number = ?";
    $stmt_find_employee = $connection->prepare($sql_find_employee);
    $stmt_find_employee->bind_param("s", $employeeNumber);
    $stmt_find_employee->execute();
    $result_find_employee = $stmt_find_employee->get_result();

    // If employee is found, set the employee_id variable
    if ($result_find_employee->num_rows > 0) {
        $row = $result_find_employee->fetch_assoc();
        $employee_id = $row['employee_id'];

        // Get the current day of the week (e.g., "Monday", "Tuesday", etc.)
        $currentDayOfWeek = date('l'); // 'l' format gives the full textual representation of the day of the week

        // Check if there is a shift schedule for each day of the week
        $daysOfWeek = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $shiftExists = array();
        foreach ($daysOfWeek as $day) {
            $sql_check_shift = "SELECT * FROM shiftdetails WHERE employee_id = ? AND day = ?";
            $stmt_check_shift = $connection->prepare($sql_check_shift);
            $stmt_check_shift->bind_param("is", $employee_id, $day);
            $stmt_check_shift->execute();
            $result_check_shift = $stmt_check_shift->get_result();
            $shiftExists[$day] = ($result_check_shift->num_rows > 0) ? true : false;
        }

        // Check if there are records for the current date and time_in, time_out, break_out, and break_in
        $currentDate = date('Y-m-d');
        $sql_check_records = "SELECT 
                                COUNT(CASE WHEN time_in IS NOT NULL THEN 1 END) AS timeIn,
                                COUNT(CASE WHEN time_out IS NOT NULL THEN 1 END) AS timeOut,
                                COUNT(CASE WHEN break_out IS NOT NULL THEN 1 END) AS breakOut,
                                COUNT(CASE WHEN break_in IS NOT NULL THEN 1 END) AS breakIn
                            FROM dtrrevised 
                            WHERE employee_id = ? AND date = ?";
        $stmt_check_records = $connection->prepare($sql_check_records);
        $stmt_check_records->bind_param("ss", $employee_id, $currentDate);
        $stmt_check_records->execute();
        $result_check_records = $stmt_check_records->get_result();

        // Check if there are records for the current date of broken time in, time out, break out, and break in
        $sql_check_broken_records = "SELECT 
                                        COUNT(CASE WHEN broken_time_in IS NOT NULL THEN 1 END) AS brokenTimeIn,
                                        COUNT(CASE WHEN broken_time_out IS NOT NULL THEN 1 END) AS brokenTimeOut,
                                        COUNT(CASE WHEN broken_break_out IS NOT NULL THEN 1 END) AS brokenBreakOut,
                                        COUNT(CASE WHEN broken_break_in IS NOT NULL THEN 1 END) AS brokenBreakIn
                                    FROM dtrrevised 
                                    WHERE employee_id = ? AND date = ?";
        $stmt_check_broken_records = $connection->prepare($sql_check_broken_records);
        $stmt_check_broken_records->bind_param("ss", $employee_id, $currentDate);
        $stmt_check_broken_records->execute();
        $result_check_broken_records = $stmt_check_broken_records->get_result();

        if ($result_check_records->num_rows > 0) {
            // Records exist for the current date and time_in, time_out, break_out, and break_in
            $row = $result_check_records->fetch_assoc();
            $recordsExist = array(
                'timeIn' => $row['timeIn'] > 0,
                'timeOut' => $row['timeOut'] > 0,
                'breakOut' => $row['breakOut'] > 0,
                'breakIn' => $row['breakIn'] > 0
            );
        } else {
            // No records found for the current date and time_in, time_out, break_out, and break_in
            $recordsExist = array(
                'timeIn' => false,
                'timeOut' => false,
                'breakOut' => false,
                'breakIn' => false
            );
        }

        if ($result_check_broken_records->num_rows > 0) {
            // Records exist for the current date of broken time in, time out, break out, and break in
            $row = $result_check_broken_records->fetch_assoc();
            $brokenRecordsExist = array(
                'brokenTimeIn' => $row['brokenTimeIn'] > 0,
                'brokenTimeOut' => $row['brokenTimeOut'] > 0,
                'brokenBreakOut' => $row['brokenBreakOut'] > 0,
                'brokenBreakIn' => $row['brokenBreakIn'] > 0
            );
        } else {
            // No records found for the current date of broken time in, time out, break out, and break in
            $brokenRecordsExist = array(
                'brokenTimeIn' => false,
                'brokenTimeOut' => false,
                'brokenBreakOut' => false,
                'brokenBreakIn' => false
            );
        }

        // Check if the employee has records for time in, break out, break in, time out, broken time in, broken break out, broken break in, and broken time out in the shiftdetails table
        $sql_check_shift_records = "SELECT 
                                        COUNT(CASE WHEN time_in IS NOT NULL THEN 1 END) AS shiftTimeIn,
                                        COUNT(CASE WHEN time_out IS NOT NULL THEN 1 END) AS shiftTimeOut,
                                        COUNT(CASE WHEN break_out IS NOT NULL THEN 1 END) AS shiftBreakOut,
                                        COUNT(CASE WHEN break_in IS NOT NULL THEN 1 END) AS shiftBreakIn,
                                        COUNT(CASE WHEN broken_time_in IS NOT NULL THEN 1 END) AS shiftBrokenTimeIn,
                                        COUNT(CASE WHEN broken_time_out IS NOT NULL THEN 1 END) AS shiftBrokenTimeOut,
                                        COUNT(CASE WHEN broken_break_out IS NOT NULL THEN 1 END) AS shiftBrokenBreakOut,
                                        COUNT(CASE WHEN broken_break_in IS NOT NULL THEN 1 END) AS shiftBrokenBreakIn
                                    FROM shiftdetails 
                                    WHERE employee_id = ? AND day = ?";
        $stmt_check_shift_records = $connection->prepare($sql_check_shift_records);
        $stmt_check_shift_records->bind_param("is", $employee_id, $currentDayOfWeek);
        $stmt_check_shift_records->execute();
        $result_check_shift_records = $stmt_check_shift_records->get_result();

        if ($result_check_shift_records->num_rows > 0) {
            // Records exist for the employee in the shiftdetails table for the current day
            $row = $result_check_shift_records->fetch_assoc();
            $shiftRecordsExist = array(
                'timeIn' => $row['shiftTimeIn'] > 0,
                'timeOut' => $row['shiftTimeOut'] > 0,
                'breakOut' => $row['shiftBreakOut'] > 0,
                'breakIn' => $row['shiftBreakIn'] > 0,
                'brokenTimeIn' => $row['shiftBrokenTimeIn'] > 0,
                'brokenTimeOut' => $row['shiftBrokenTimeOut'] > 0,
                'brokenBreakOut' => $row['shiftBrokenBreakOut'] > 0,
                'brokenBreakIn' => $row['shiftBrokenBreakIn'] > 0
            );
        } else {
            // No records found for the employee in the shiftdetails table for the current day
            $shiftRecordsExist = array(
                'timeIn' => false,
                'timeOut' => false,
                'breakOut' => false,
                'breakIn' => false,
                'brokenTimeIn' => false,
                'brokenTimeOut' => false,
                'brokenBreakOut' => false,
                'brokenBreakIn' => false
            );
        }

        // Return JSON response
        echo json_encode(array(
            'notFound' => false,
            'shifts' => array(
                'Monday' => $shiftExists['Monday'] ?? false,
                'Tuesday' => $shiftExists['Tuesday'] ?? false,
                'Wednesday' => $shiftExists['Wednesday'] ?? false,
                'Thursday' => $shiftExists['Thursday'] ?? false,
                'Friday' => $shiftExists['Friday'] ?? false,
                'Saturday' => $shiftExists['Saturday'] ?? false,
                'Sunday' => $shiftExists['Sunday'] ?? false
            ),
            'recordsExist' => $recordsExist,
            'brokenRecordsExist' => $brokenRecordsExist,
            'shiftRecordsExist' => $shiftRecordsExist
        ));
    } else {
        // If employee is not found, return notFound as true
        echo json_encode(array(
            'notFound' => true,
            'shifts' => array(
                'Monday' => false,
                'Tuesday' => false,
                'Wednesday' => false,
                'Thursday' => false,
                'Friday' => false,
                'Saturday' => false,
                'Sunday' => false
            ),
            'recordsExist' => array(
                'timeIn' => false,
                'timeOut' => false,
                'breakOut' => false,
                'breakIn' => false
            ),
            'brokenRecordsExist' => array(
                'brokenTimeIn' => false,
                'brokenTimeOut' => false,
                'brokenBreakOut' => false,
                'brokenBreakIn' => false
            ),
            'shiftRecordsExist' => array(
                'timeIn' => false,
                'timeOut' => false,
                'breakOut' => false,
                'breakIn' => false,
                'brokenTimeIn' => false,
                'brokenTimeOut' => false,
                'brokenBreakOut' => false,
                'brokenBreakIn' => false
            )
        ));
    }
} else {
    // If employee number is not provided, return false for all actions
    echo json_encode(array(
        'notFound' => true,
        'shifts' => array(
            'Monday' => false,
            'Tuesday' => false,
            'Wednesday' => false,
            'Thursday' => false,
            'Friday' => false,
            'Saturday' => false,
            'Sunday' => false
        ),
        'recordsExist' => array(
            'timeIn' => false,
            'timeOut' => false,
            'breakOut' => false,
            'breakIn' => false
        ),
        'brokenRecordsExist' => array(
            'brokenTimeIn' => false,
            'brokenTimeOut' => false,
            'brokenBreakOut' => false,
            'brokenBreakIn' => false
        ),
        'shiftRecordsExist' => array(
            'timeIn' => false,
            'timeOut' => false,
            'breakOut' => false,
            'breakIn' => false,
            'brokenTimeIn' => false,
            'brokenTimeOut' => false,
            'brokenBreakOut' => false,
            'brokenBreakIn' => false
        )
    ));
}

// Close prepared statements if they are not null
if(isset($stmt_find_employee)) {
    $stmt_find_employee->close();
}
if(isset($stmt_check_shift)) {
    $stmt_check_shift->close();
}
if(isset($stmt_check_records)) {
    $stmt_check_records->close();
}
if(isset($stmt_check_broken_records)) {
    $stmt_check_broken_records->close();
}
if(isset($stmt_check_shift_records)) {
    $stmt_check_shift_records->close();
}

// Close database connection
$connection->close();
?>