<?php
include 'includes/connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $desiredPosition = $_POST['employeePosition']; // Retrieve the selected position from the form

    $sql = "SELECT * FROM employee_details WHERE employee_username = ? AND employee_password = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        // employee id
        $_SESSION['employee_id'] = $employee['employee_id'];
        // employee position
        $positions = explode(' and ', $employee['employee_position']); // Split the positions based on "and"

        // sales info
        $_SESSION['user_name'] = $employee['employee_username'];
        $_SESSION['name'] = $employee['employee_name'];
        $_SESSION['id'] = $employee['employee_id'];

        // Check if the desired position is one of the user's positions
        if (in_array($desiredPosition, $positions)) {
            $_SESSION['employee_position'] = $desiredPosition; // Store the desired position in the session

            switch ($desiredPosition) {
                case 'HR Officer':
                    header("Location: employeees.php");
                    exit();
                case 'Purchase Order Officer':
                    header("Location: purchase_dashboard.php");
                    exit();
                case 'Finance Officer':
                    header("Location: financeHome.php");
                    exit();
                case 'Sales Officer - Cashier':
                    header("Location: sales/dashboard.php");
                    exit();
                case 'Cashier':
                    header("Location: sales/dashboard.php");
                    exit();
                case 'Inventory Officer':
                    header("Location: inventory_dashboard.php");
                    exit();
            }
        } else {
            $error = "You are not authorized to access this system.";
        }
    } else {
        $error = "Invalid username or password.";
    }
    $stmt->close();
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoTechA</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        Login
                    </div>
                    <div class="card-body">
                        <form id="loginForm" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp" placeholder="Enter username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="employeePosition">Position:</label>
                                <select class="form-control" id="employeePosition" name="employeePosition" required>
                                    <option value="" disabled selected>Select Position</option>
                                    <option value="Purchase Order Officer">Purchase Order Officer</option>
                                    <option value="Inventory Officer">Inventory Officer</option>
                                    <option value="Sales Officer - Cashier">Sales Officer - Cashier</option>
                                    <option value="Finance Officer">Finance Officer</option>
                                    <option value="HR Officer">HR Officer</option>
                                </select>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" id="loginBtn" class="btn btn-primary">Login</button>
                            </div>
                            <?php if (isset($error)) { ?>
                                <div class="text-danger"><?php echo $error; ?></div>
                            <?php } ?>
                        </form>
                        <div class="dtr-link">
                        <h2>For DTR, click the button below</h2>
                        <a href="dtr_newpage.php" class="btn btn-secondary d-block mx-auto">DTR</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="src/js/script.js"></script>
</body>
</html>
