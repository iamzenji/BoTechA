<?php 
session_start(); 
include "connect.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{
		
		$sql = "SELECT * FROM `employee_details` WHERE employee_username ='$uname' AND  employee_password ='$pass' AND employee_position LIKE '%Cashier%';";

		$result = mysqli_query($connection, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['employee_username'] === $uname && $row['employee_password'] === $pass) {
            	$_SESSION['user_name'] = $row['employee_username'];
            	$_SESSION['name'] = $row['employee_name'];
            	$_SESSION['id'] = $row['employee_id'];
            	header("Location: dashboard.php");
		        exit();
            }else{
				header("Location: index.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location: index.php?error=Incorect User name or password");
	        exit();
		}
	}
	
}else{
	header("Location: index.php");
	exit();
}