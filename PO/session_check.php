<?php
function check_session() {
    // Start session
    session_start();
    
    // Check if the user is not logged in
    if (!isset($_SESSION['user_name']) || !isset($_SESSION['id'])) {
        // Redirect to the login page
        header("Location: login.php");
        exit();
    }
}
?>

