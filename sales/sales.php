<?php
require 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SALES</title>
	<link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

	<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/datatables.min.css" rel="stylesheet">

	<script>
		function displayTimeAndDate() {
			const now = new Date();
			let hours = now.getHours();
			const meridiem = hours >= 12 ? 'PM' : 'AM';
			hours = (hours % 12) || 12; // Convert to 12-hour format
			const minutes = now.getMinutes().toString().padStart(2, '0');
			const seconds = now.getSeconds().toString().padStart(2, '0');
			const timeString = `${hours}:${minutes}:${seconds} ${meridiem}`;

			const month = (now.getMonth() + 1).toString().padStart(2, '0');
			const day = now.getDate().toString().padStart(2, '0');
			const year = now.getFullYear();
			const dateString = `${month}/${day}/${year}`;


			var date = document.getElementById('date');
			var time = document.getElementById('time');
			if (time !== null && date !== null) {
				time.textContent = timeString;
				date.textContent = dateString;
			}

		}

		// Update time and date every second
		setInterval(displayTimeAndDate, 1000);

		// Initial display
		displayTimeAndDate();
	</script>
</head>

<body>
	<div class="main-content"><?php include('sidebar.php'); ?>
		<style>
			.nav-pills .nav-link.active,
			.nav-pills .show>.nav-link {
				color: var(--bs-nav-pills-link-active-color);
				background-color: green;
			}

			table.dataTable thead>tr>th.dt-orderable-asc,
			table.dataTable thead>tr>th.dt-orderable-desc,
			table.dataTable thead>tr>td.dt-orderable-asc,
			table.dataTable thead>tr>td.dt-orderable-desc {
				text-align: center;
				background: green;
				width: 10%;

			}

			table.table.dataTable> :not(caption)>*>* {
				text-align: center;
			}
		</style>
		<div class="header">
			<div class="timer">
				<div id="time"></div>
				<div id="date"></div>
			</div>
			<h1><i style="margin: 1rem;" class='bx bx-trending-up bx-tada'></i>SALES</h1>
		</div>
		<div class="dropdown position-absolute top-0 end-0" style="margin: 12px 7px 0 0;">
			<button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
				<i class='bx bx-user'></i>
			</button>
			<ul class="dropdown-menu" style="width: 12vw;">

				<li><span class="dropdown-item-text"><i class='bx bxs-user-circle'></i> <?php echo $_SESSION['name'] ?></span></li>
				<li>
					<hr class="dropdown-divider">
				</li>
				<li><a class="dropdown-item" href="#">Profile</a></li>
				<li><a class="dropdown-item" href="#">Settings</a></li>
				<li>
					<hr class="dropdown-divider">
				</li>
				<li><a class="dropdown-item" href="logout.php">Logout</a></li>
			</ul>
		</div>
		<div>


			<div style="box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);width: 86vw; padding: 1rem 1rem 2rem 1rem; margin: 2rem 2rem 4rem 3rem;">
				<div style="position: absolute;     margin-left: 2rem;">
					<button onclick="location.href='records.php'" type="button" class="btn btn-primary"><i class='bx bxs-report bx-tada'></i>Records</button>
					<button onclick="location.href='disc.php'" type="button" class="btn btn-danger"><i class='bx bxs-discount bx-tada'></i> Discount's</button>
					<button onclick="location.href='item.php'" type="button" class="btn btn-warning"><i class='bx bxs-purchase-tag bx-tada'></i> Item Sales</button>
					<button onclick="location.href='discard.php'" type="button" class="btn btn-secondary"><i class='bx bx-cart-download bx-tada'></i>Canceled Item's</button>

				</div>
				<!-- Nav tabs -->
				<ul class="nav nav-tabs nav-pills justify-content-end" id="pills-tab nav-tab" role="tablist" style="margin: 1rem 1rem 0 1rem;">
					<li class="nav-item">
						<a class="nav-link active" data-bs-toggle="tab" href="#home">YEAR</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#menu1">MONTH</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#menu2">DAY</a>
					</li>
				</ul>

				<?php $cashier = $_SESSION['id']; ?>
				<!-- Tab panes -->
				<div class="tab-content">
					<div id="home" class="container tab-pane active" style="max-width: 1600px;"><br>
						<!-- <h3 style="text-align: center;">YEAR</h3> -->
						<div class="item-map">
							<table class="table table-striped table-hover mapping" style="width: 100%;">
								<thead class="bg-success sticky-top" style="z-index: 0;">
									<tr>
										<th>YEAR</th>
										<th>SALES</th>
										<th>DISCOUNT</th>
										<th>SUB</th>
										<th>PROFIT</th>
										<th>CASH</th>
										<th>GCASH</th>
										<!-- <th>TRANSACTION</th>
										<th>ITEM SOLD</th> -->
									</tr>
								</thead>
								<tbody>
									<?php
									$query =  "SELECT YEAR(date) as year,
									SUM(total_amount) as sales,
									SUM(total_dis) as discount,
									SUM(sub_total) as sub_total,
                                    SUM(sub_total * .15) as profit,
									SUM(CASE WHEN pay_method = 'Cash' THEN total_amount ELSE 0 END) AS cash,
									SUM(CASE WHEN pay_method = 'Gcash' THEN total_amount ELSE 0 END) AS gcash
									FROM transact WHERE cashier_id = $cashier GROUP BY year ORDER BY date ;";
									$query_run = mysqli_query($connection, $query);

									if (mysqli_num_rows($query_run) > 0) {
										foreach ($query_run as $row) {
									?>
											<tr>
												<td><?= $row['year'] ?></td>
												<td>₱ <?= number_format($row['sales'], 2) ?></td>
												<td>₱ <?= number_format($row['discount'], 2) ?></td>
												<td>₱ <?= number_format($row['sub_total'], 2) ?></td>
												<td>₱ <?= number_format($row['profit'], 2) ?></td>
												<td>₱ <?= number_format($row['cash'], 2) ?></td>
												<td>₱ <?= number_format($row['gcash'], 2) ?></td>
											</tr>
									<?php }
									} ?>
								</tbody>
							</table>
						</div>
					</div>
					<div id="menu1" class="container tab-pane fade" style="max-width: 1600px;"><br>


						<div class="item-map">
							<table class="table table-striped table-hover mapping" style="width: 100%;">
								<thead class="bg-success sticky-top" style="z-index: 0;">
									<tr>
										<th>YEAR</th>
										<th>MONTH</th>
										<th>SALES</th>
										<th>DISCOUNT</th>
										<th>SUB</th>
										<th>PROFIT</th>
										<th>CASH</th>
										<th>GCASH</th>

									</tr>
								</thead>
								<tbody>
									<?php
									$query =  " SELECT YEAR(date) as year,
									MONTHNAME(date) AS month,
									SUM(total_amount) as sales,
									SUM(total_dis) as discount,
									SUM(sub_total) as sub_total,
                                    SUM(sub_total * .15) as profit,
									SUM(CASE WHEN pay_method = 'Cash' THEN total_amount ELSE 0 END) AS cash,
									SUM(CASE WHEN pay_method = 'Gcash' THEN total_amount ELSE 0 END) AS gcash
									FROM transact WHERE cashier_id = $cashier GROUP BY MONTH(date), YEAR(date) ORDER BY date;";
									$query_run = mysqli_query($connection, $query);

									if (mysqli_num_rows($query_run) > 0) {
										foreach ($query_run as $row) {
									?>
											<tr>
												<td><?= $row['year'] ?></td>
												<td><?= $row['month'] ?></td>
												<td>₱ <?= number_format($row['sales'], 2) ?></td>
												<td>₱ <?= number_format($row['discount'], 2) ?></td>
												<td>₱ <?= number_format($row['sub_total'], 2) ?></td>
												<td>₱ <?= number_format($row['profit'], 2) ?></td>
												<td>₱ <?= number_format($row['cash'], 2) ?></td>
												<td>₱ <?= number_format($row['gcash'], 2) ?></td>
											</tr>
									<?php }
									} ?>
								</tbody>
							</table>
						</div>
					</div>

					<div id="menu2" class="container tab-pane fade" style="max-width: 1600px;"><br>

						<div class="item-map">
							<table class="table table-striped table-hover mapping" style="width: 100%;">
								<thead class="bg-success sticky-top" style="z-index: 0;">
									<tr>
										<th>YEAR</th>
										<th>MONTH</th>
										<th>DAY</th>
										<th>SALES</th>
										<th>DISCOUNT</th>
										<th>SUB</th>
										<th>PROFIT</th>
										<th>CASH</th>
										<th>GCASH</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$query =  "SELECT YEAR(date) as year,
									MONTHNAME(date) AS month,
									CONCAT(DAY(date),'-',DAYNAME(date) )  AS day,
									SUM(total_amount) as sales,
									SUM(total_dis) as discount,
									SUM(sub_total) as sub_total,
                                    SUM(sub_total * .15) as profit,
									SUM(CASE WHEN pay_method = 'Cash' THEN total_amount ELSE 0 END) AS cash,
									SUM(CASE WHEN pay_method = 'Gcash' THEN total_amount ELSE 0 END) AS gcash
									FROM transact WHERE cashier_id = $cashier GROUP BY DAY(date), MONTH(date), YEAR(date) ORDER BY date;";
									$query_run = mysqli_query($connection, $query);

									if (mysqli_num_rows($query_run) > 0) {
										foreach ($query_run as $row) {
									?>
											<tr>
												<td><?= $row['year'] ?></td>
												<td><?= $row['month'] ?></td>
												<td><?= $row['day'] ?></td>
												<td>₱ <?= number_format($row['sales'], 2) ?></td>
												<td>₱ <?= number_format($row['discount'], 2) ?></td>
												<td>₱ <?= number_format($row['sub_total'], 2) ?></td>
												<td>₱ <?= number_format($row['profit'], 2) ?></td>
												<td>₱ <?= number_format($row['cash'], 2) ?></td>
												<td>₱ <?= number_format($row['gcash'], 2) ?></td>
											</tr>
									<?php }
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/datatables.min.js"></script>
<script>
	new DataTable('.mapping', {
		paging: false,
		info: false,
		layout: {
			topEnd: {
				search: {
					placeholder: 'Type search here'
				}
			}
		},
		layout: {
			topStart: 'buttons'
		},
		buttons: ['excel', 'pdf', 'print'],

	});

	// function() {
	// 	var t = document.getElementsByClassName("s");
	// t.style.width = "300px";
	// }
</script>

</html>