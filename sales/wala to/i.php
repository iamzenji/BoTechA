<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Botecha</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            width: 90%;
            max-width: 400px;
            min-height: 310px;
            padding: 20px;
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #512da8;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container input {
            background-color: #eee;
            border: none;
            margin: 8px 0;
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 8px;
            width: 100%;
            outline: none;
        }

        .container button {
            background-color: #512da8;
            color: #fff;
            padding: 10px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 20px;
            cursor: pointer;
        }

        .container button:hover {
            background-color: #5d4ccf;
        }

        .container .error {
            background: #F2DEDE;
            color: #A94442;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }

        @media screen and (max-width: 500px) {
            .container {
                border-radius: 0;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>POS Log In</h1>
    <form action="auth.php" method="POST">
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <input type="text" name="uname" placeholder="User Name">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>