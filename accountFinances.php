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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounting and Finances</title>
    <link rel="stylesheet" href="style.css">

    <!-- Line Graph -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(lineChart);

        function lineChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses'],
                ['2004', 6000, 22400],
                ['2005', 12334, 34460],
                ['2006', 14334, 21120],
                ['2007', 137312, 34540],
                ['2008', 137312, 34540],
                ['2009', 137312, 34540]
            ]);

            var options = {
                title: 'Kapangitan ko',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Saimon', 11],
                ['Pie', 2],
                ['Chart', 2],
                ['Works', 2],
                ['Yay', 7]
            ]);

            var options = {
                title: 'Most Sold Product',
                pieHole: 0.5,
                height: 500
            };

            var chart = new google.visualization.PieChart(document.getElementById('donut_chart'));
            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <section class="finance-container">
        <div class="right-window">
            <section class="right-window-container">
                <div class="box">
                    <div class="box-title">
                        <p>Sales</p>
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_111_105)">
                                <path d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                <path d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                <path d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                            </g>
                            <defs>
                                <clipPath id="clip0_111_105">
                                    <rect width="24" height="24" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <div id="curve_chart"></div>
                    <div class="box-content">
                        <div class="box-content-left">
                            <div id="donut_chart"></div>
                        </div>
                        <div class="box-content-right">
                            <p>Total Sales Revenue:</p>
                            <p>Most Sold Product:</p>
                            <p>lorem ipsum ahafhdsjkghksjbn:</p>
                        </div>

                    </div>

                </div>
                <!-- Payroll -->
                <div class="box">
                    <div class="box-title">
                        <p>Payroll</p>
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_111_105)">
                                <path d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                <path d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                <path d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                            </g>
                            <defs>
                                <clipPath id="clip0_111_105">
                                    <rect width="24" height="24" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <table class="finances-color-table payroll-table">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Position</th>
                                <th>Date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>marco</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>marco</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>marco</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>marco</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>marco</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>marco</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>marco</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- Expenses and Utilities -->
                <div class="box">
                    <div class="box-title">
                        <p>Expenses and Utilities</p>
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_111_105)">
                                <path d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                <path d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                <path d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                            </g>
                            <defs>
                                <clipPath id="clip0_111_105">
                                    <rect width="24" height="24" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>


                    <table class="finances-color-table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Rent</th>
                                <th>Electricity</th>
                                <th>Water</th>
                                <th>Supplies</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>march</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>march</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>march</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>march</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>march</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>march</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>march</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Inventory -->
                <div class="box">
                    <div class="box-title">
                        <p>Inventory</p>
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_111_105)">
                                <path d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                <path d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                <path d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                            </g>
                            <defs>
                                <clipPath id="clip0_111_105">
                                    <rect width="24" height="24" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <table class="finances-color-table">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Date Bought</th>
                                <th>Expiry Date</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- TOR -->
                <div class="box">
                    <div class="box-title">
                        <p>Transactions and Overall Revenue</p>
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_111_105)">
                                <path d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                <path d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                <path d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                            </g>
                            <defs>
                                <clipPath id="clip0_111_105">
                                    <rect width="24" height="24" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <table class="finances-color-table">
                        <thead>
                            <tr>
                                <th>Transaction Id</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Transaction</th>
                                <th>Employee</th>
                                <th>Total Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>001</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>002</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>003</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>004</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>005</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>006</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>007</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </section>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
            <script src="script.js"></script>
            <script src="https://kit.fontawesome.com/67c4787375.js" crossorigin="anonymous"></script>
</body>

</html>

<?php } ?>