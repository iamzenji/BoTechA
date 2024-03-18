<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

?>
    <div class="container mt-5">
        <div class="col-md-8">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>
                            <h2>Add Discounted Product</h2>
                        </strong>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form method="post" action="add_product.php" class="clearfix">
                                <div class="form-group">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="product-category">
                                                <option value="">Select Product</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="lni lni-shopping-basket"></i>
                                                </span>
                                                <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p>&#x20B1;</p>
                                                </span>
                                                <input type="number" class="form-control" name="selling-price" placeholder="Selling Price">
                                                <span class="input-group-addon">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="add_product" class="btn btn-primary">Add product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>