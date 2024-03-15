<?php include 'connect.php';?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    <title>Botecha</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form method="post">
                <h1>Log In</h1>

    
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Password">
           
                <button> <a href="dashboard.php">Sign In</a></button>
                
            </form>
            <?php
            if(isset($_POST['submit'])){
                
            }
            ?>
            
        </div>
    </div>


    <script src="script.js"></script>
</body>

</html>


