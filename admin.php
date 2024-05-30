<?php
include 'includes/connection.php';
include 'includes/header.php';

if(strlen($_SESSION['employee_id'])===0)
	{	
header('location:login.php');
session_destroy();

}
else{

?>
<div class="main">
    <div class="container mt-5">
        <div class="row">
            <h1>Dashboard</h1>
            <div class="col-md-3">
                <a href="categories.php" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <i class="lni lni-agenda" style="font-size: 70px;"></i>
                            <h5 class="card-title">Categories</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="products.php" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <i class="lni lni-invest-monitor" style="font-size: 70px;"></i>
                            <h5 class="card-title">Stocks</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="media.php" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <i class="lni lni-gallery" style="font-size: 65px;"></i>
                            <h5 class="card-title">Media</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="media.php" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <i class="lni lni-gallery" style="font-size: 65px;"></i>
                            <h5 class="card-title">Media</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="media.php" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <i class="lni lni-gallery" style="font-size: 65px;"></i>
                            <h5 class="card-title">Media</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php } ?>