    <?php

    // session_start();
    include 'includes/connection.php';
    include 'includes/header.php';

    if (strlen($_SESSION['employee_id']) === 0) {
        header('location:login.php');
        session_destroy();
    } else {

    ?>
        <div class="wrapper">
            <div class="main p-3">
                <div class="text-left">
                    <h1 class="head"> Welcome to Purchase Order Management</h1>
                    <hr>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="script.js"></script>
        <script type="text/javascript">
            const hamBurger = document.querySelector(".toggle-btn");

            hamBurger.addEventListener("click", function() {
                document.querySelector("#sidebar").classList.toggle("expand");
            });
        </script>

    <?php } ?>