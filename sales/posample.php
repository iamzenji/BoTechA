<?php

require 'connect.php';

$total = 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CASHIER</title>
	<link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

	<style>
        @media print {
            body * {
                visibility: hidden;
            }

            .modal1,
            .modal1 * {
                visibility: visible;
                margin-top: auto;
            }

            .modal #resibo .resibo {
                line-height: .9rem;
                font-size: 1.5rem;
            }

            .resibos {
                font-size: 20px;
                margin-left: 3rem;
                width: 35rem;
                page-break-inside: auto;
                line-height: 1rem;
            }

            .modal1 #haha table {
                margin-right: 4rem;
                font-size: 22px;
                width: 35rem;
                margin-left: 0rem;
                line-height: 1rem;
            }

            @page {
                size: A5 portrait;
            }
        }
    </style>

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

            var date =  document.getElementById('date');
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
		<div class="">
			<div class="header">
				<div class="timer">
					<div id="time"></div>
					<div id="date"></div>
				</div>
				<div class="dropdown position-absolute top-0 end-0" style="margin: 12px 7px 0 0;">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-user'></i> 
                    </button>
                    <ul class="dropdown-menu" style="width: 12vw;">
                    
                        <li><span class="dropdown-item-text"><i class='bx bxs-user-circle' ></i> <?php echo $_SESSION['name'] ?></span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
				<h1><i style="margin: 1rem;" class='bx bxs-basket bx-tada bx-rotate-270'></i> POS</h1>
			</div>
			<!-- sell item -->
			<div class="wrap" id="wrap">
				<div class="row">
				<table id="laman" class="table table-striped table-hover display compact" style="width:100%">
						<thead style=" background-color: rgb(165, 245, 245);">
							<tr>
								<th style="text-align: center;">Category</th>
								<th style="text-align: center;">Brand</th>
								<th style="text-align: center;">Type</th>
								<th style="text-align: center;">Dosage</th>
								<th style="text-align: center;">Position</th>
								<th style="text-align: center;">Piece</th>
								<th style="text-align: center;">Pack</th>
							</tr>
						</thead>
						<tbody>
							<?php
							
							$query =  "SELECT * FROM `inventory` LEFT JOIN item_mapping on inventory_id = item_mapping.item_id;";
							$query_run = mysqli_query($connection, $query);

							if (mysqli_num_rows($query_run) > 0) {
								foreach ($query_run as $row) {
							?>
									<tr>
										<td><?= $row['category'] ?> </td>
										<td><?= $row['brand'] ?></td>
										<td><?= $row['type'] ?> </td>
										<td><?= $row['unit'] ?> </td>
										<td><?php
											if ($row['shelves'] == null) {
												echo "N/A";
											} else {
												echo $row['shelves'] . '-' . $row['row'] . $row['colum'];
											}
											?></td>
										<td style="text-align: right;"> ₱ <?php $price = $row['unit_cost'] + ($row['unit_cost'] * .15); echo number_format($price); ?>
											<button type="button" value="<?= $row['inventory_id'] ?>" class="addPiece btn btn-warning btn-sm">+</button>
										</td>
										<td style="text-align: right;"> ₱ <?php $price = $row['price_pack'] + ($row['price_pack'] * .15); echo number_format($price); ?>
											<button type="button" value="<?= $row['inventory_id'] ?>" class="addPack btn btn-success btn-sm">+</button>
										</td>
									</tr>
							<?php }
							} ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- cart -->

			<section class="cart">
				<!-- <div class="table-responsive"> -->
				<table class="table" style="width:100%" id="laman_cart">
					<thead class="table-success sticky-top" style="z-index: 0;">
						<th>Name</th>
						<th>Price</th>
						<th colspan="2">Quantity</th>
						<th>Total-Price</th>
						<td>Action</td>
					</thead>
					<tbody>
						<?php
						$query =  "SELECT * FROM cart_sales CROSS JOIN inventory on cart_sales.item_id = inventory_id ;";
						$query_run = mysqli_query($connection, $query);
						if (mysqli_num_rows($query_run) > 0) { ?>
							<?php foreach ($query_run as $row) : ?>
								<tr id="<?php echo $row["cart_id"]; ?>">
									<td><?php echo $row['category'] . " " .  $row['brand'] . " " .  $row['type'] . " " .  $row['unit']; ?></td>
									<td> ₱ <?php if ($row['scale'] == "piece") {
												$price = $row['unit_cost'] + ($row['unit_cost'] * .15);
												echo number_format($price);
											} else if ($row['scale'] == "pack") {
												$price = $row['price_pack'] + ($row['price_pack'] * .15);
												echo number_format($price);
											} ?></td>
									<td><?php echo $row["scale"]; ?></td>
									<td><input type="number" data-role="update" data-id="<?php echo $row['cart_id']; ?>" value="<?= $row['qty']; ?>" min="1" style=" width:60px;"></td>
									<td> ₱ <?php echo $sub_total = round($price) * $row['qty']; ?></td>
									<td><button type="button" data-id="<?php echo $row['cart_id']; ?>" value="<?= $row['cart_id'] ?>" class="del btn btn-danger btn-sm"><i class='bx bxs-trash'></i></button></td>
									<?php $id = $row['cart_id']; ?>
								</tr>
							<?php $total = $total + $sub_total;
							endforeach; ?>
							<input type="hidden" name="" id="Total" value="<?php echo $total; ?>">
						<?php } ?>
					</tbody>
				</table>
				<!-- </div> -->
			</section>

			<!-- to check out -->
			<section class="checkout">
				<div class="card" style="text-align:center; width: 20vw; ">
					<div class="card-body">
						<input type="radio" class="btn-lg btn-check" onclick="hide()" name="options-outlined" id="success-outlined" autocomplete="off" checked>
						<label class="btn btn-lg btn-outline-success" for="success-outlined">Cash</label>
						<input type="radio" class="btn-lg btn-check" onclick="hide()" name="options-outlined" id="danger-outlined" autocomplete="off">
						<label class="btn btn-lg btn-outline-info" for="danger-outlined">G-Cash</label>
						<br><br>
						<div style="display: ruby-text;">
							<label for="dis">Discount : </label>
							<select name="discounted" id="dis">
								<option selected value="0">--- select discount ---</option>
								<option value=".05">Senior</option>
								<option value=".1">PWD</option>
							</select>

							<div id="inputcash" style="display: flex; margin:1rem;">
								<label for="cash">Cash :</label>
								<input type="number" placeholder="please input cash" id="cash" name="cash" min="0" style="margin-left:.2rem; ">
							</div>
							<div id="check" style="display: none; margin:1rem;">
								<label for="checks">already transfered? </label>
								<input type="checkbox" name="" id="checks" onclick="mycheck()">

							</div>
						</div>
						<button type="button" id="cout" class="btn btn-primary" disabled data-bs-toggle="modal" data-bs-target="#myModal" style="width:  90%;">CheckOut</button>
					</div>
				</div>
				<div style="margin-left: 1rem;">
					<div id="con"><button style="width: 15vw; margin-bottom:2rem; margin-top:1.6rem;" id="deleted" class="btn btn-danger btn-lg">Remove all</button></div>
					<div id="total">
						<h6>Total : ₱ <?php echo $total; ?></h6>
						<h6 id="h6dis">Discount : ₱ 0 </h6>
						<h6 id="h6amount">Amount : ₱ <?php echo $total; ?></h6>
						<input type="hidden" name="" id="amount" value="<?php echo $total; ?>">
					</div>
				</div>
			</section>
		</div>
	</div>



	<!-- The Modal -->
	<div class="modal modal-sm" id="myModal" data-bs-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal body -->
				<div id="resibo" class="modal1 modal-body text-center" style="font-family: Helvetica; font-size: 12px; line-height: .5px;">

					<img src="logo.png" class="rounded-circle img-thumbnail" style="width: 50px;border: 1px solid black;">
					<div class="resibo" style="margin-top: 1rem;">
						<p>Bo-Tech-A</p>
						<p><?php date_default_timezone_set('Asia/Manila');
							echo date("Y-F-d h:i a"); ?></p>
						<p>Cashier : <?php echo $_SESSION['name']; ?></p>
						<?php
						$t = "BTA-" . $_SESSION['id'];
						$i = 0;
						$tr = $t . "/00" . $i;
						$transact = "SELECT transact_no FROM `transact` ORDER BY id ASC;";
						$result = $connection->query($transact);
						if (mysqli_num_rows($result) > 0) {
							while ($row = $result->fetch_assoc()) {
								if ($tr == $row['transact_no']) {
									$i++;
									$tr = $t . "/00" . $i;
								} 
							}
						} ?>
						<p>Transact# : <?php echo $tr; ?></p>
						<p id="pmet">Payment Method : </p>
						<br>
					</div>
					<div style="font-size: 10px; line-height: .7rem;">
						<table class="table table-sm table-borderless resibos" style="text-align: center; ">
							<thead>
								<th style="text-align: left;">Name</th>
								<th colspan="2">Quantity</th>
								<th colspan="2">Amount</th>
							</thead>
							<tbody>
								<?php $total = 0; ?>
								<?php
								$select_cart = mysqli_query($connection, "SELECT * FROM cart_sales CROSS JOIN inventory on cart_sales.item_id = inventory_id;");

								if (mysqli_num_rows($select_cart) > 0) {
									while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
								?>

										<tr>
											<td style="text-align: left;"><?php echo $fetch_cart['category'] . " " .  $fetch_cart['brand'] . " " .  $fetch_cart['type'] . " " .  $fetch_cart['unit']; ?>
											
											<?php if ($fetch_cart['scale'] == "piece") {
												$price = $fetch_cart['unit_cost'] + ($fetch_cart['unit_cost'] * .15);
											} else if ($fetch_cart['scale'] == "pack") {
												$price = $fetch_cart['price_pack'] + ($fetch_cart['price_pack'] * .15);
											} ?>
											

											<td colspan="2"><?php echo "$fetch_cart[qty]" . '/' . "$fetch_cart[scale]"; ?> </td>
											<td colspan="2">₱ <?php $sub_total = round($price) * $fetch_cart['qty']; echo number_format($sub_total); ?></td>
										</tr>
								<?php

										$total += $sub_total;
									};
								};
								?>

							</tbody>
						</table>
					</div>
					<div id="haha" style="font-size: 12px;text-align: right; font-weight: bold; width: 15rem; line-height:.6rem; ">
						<table class="table table-sm table-borderless">
							<tr>
								<td>Discount-Type</td>
								<td colspan="2">---------</td>
								<td id="disctype"></td>
							</tr>
							<tr>
								<td>Total-Discount</td>
								<td colspan="2">---------</td>
								<td id="disc"></td>
							</tr>

							<tr>
								<td>Sub-Total</td>
								<td colspan="2">---------</td>
								<td id="sub-tot"></td>
							</tr>
							<tr>
								<td>Total-Amount</td>
								<td colspan="2">---------</td>
								<td id="grand_tot"></td>
							</tr>
							<tr>
								<td>Cash</td>
								<td colspan="2">---------</td>
								<td id="bayaded"></td>
							</tr>
							<tr>
								<td>Change</td>
								<td colspan="2">---------</td>
								<td id="sukli"></td>
							</tr>
						</table>
					</div>

					<input type="hidden" id="tr" value="<?php echo $tr; ?>">
					<input type="hidden" id="cashier" value="<?php echo $_SESSION['id']; ?>">
					<input type="hidden" id="paym">
					<input type="hidden" id="sub">
					<input type="hidden" id="disco">
					<input type="hidden" id="distype">
					<input type="hidden" id="tot">
					<input type="hidden" id="cas">
					<input type="hidden" id="change">

				</div>

				<!-- Modal footer -->
				<div class="modal-footer">

					<button id="print" class="btn bg-info">print</button>
					<!-- <a href="#" id="save" class="btn btn-primary">Update</a> -->
					<button type="button" id="save" class="btn btn-success">done</button>
				</div>

			</div>
		</div>
	</div>

</body>

<!-- sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
<script>
	new DataTable('#laman', {
		scrollCollapse: true,
		scrollY: '70vh',
		paging: false,
		info: false,
		layout: {
			topEnd: {
				search: {
					placeholder: 'Type search here'
				}
			}
		}

	});
</script>

<script>
	// for print
	const printbtn = document.getElementById('print');

	printbtn.addEventListener('click', function() {
		window.print();
	})

	// save transact

	// $(document).ready(function() {
	$('#save').click(function() {
		var tr = $('#tr').val();
		var cashier = $('#cashier').val();
		var paym = $('#paym').val();
		var sub = $('#sub').val();
		var dis = $('#disco').val();
		var dist = $('#distype').val();
		var tot = $('#tot').val();
		var cas = $('#cas').val();
		var change = $('#change').val();
		$.ajax({
			type: "POST",
			url: "code.php",
			data: {
				cashier: cashier,
				sub: sub,
				paym: paym,
				dis: dis,
				dist: dist,
				tot: tot,
				tr: tr,
				cas: cas,
				change: change
			},
			success: function(response) {
				console.log(response);
				$('#laman_cart').load(location.href + " #laman_cart");
				$('#total').load(location.href + " #total");
				$('#myForm').load(location.href + " #myForm");
				$('#resibo').load(location.href + " #resibo");
				document.getElementById("success-outlined").checked = true
				document.getElementById("checks").checked = false
				document.getElementById("dis").value = "0";
				document.getElementById('check').style.display = 'none';
				document.getElementById('inputcash').style.display = 'block';
				document.getElementById("cash").value = "";
				$('#myModal').modal('toggle');
				document.getElementById("cout").disabled = true;
			}
		});
	});
	// });


	// g-cash or cash
	function hide() {
		var checkBox = document.getElementById("checks");
		let sub = Number.parseInt(document.getElementById('Total').value);

		if (sub == 0) {
			checkBox.disabled == true;
		} else {
			checkBox.disabled == false;
		}

		var radio = document.getElementById("danger-outlined");
		if (radio.checked == true) {

			document.getElementById('inputcash').style.display = 'none';
			document.getElementById("cash").value = "";
			document.getElementById("cas").value = "";
			document.getElementById("change").value = "";
			document.getElementById('pmet').innerHTML = "Payment Method :  GCash";
			document.getElementById("paym").value = "GCash";
			document.getElementById('check').style.display = 'block';
			document.getElementById("dis").value = "0";

			document.getElementById('h6dis').innerHTML = "Discount :  ₱ 0";
			document.getElementById('h6amount').innerHTML = "Amount : ₱ " + document.getElementById('Total').value;
			document.getElementById('amount').value = document.getElementById('Total').value;
			// document.getElementById("cout").disabled = false;
		} else {
			document.getElementById('inputcash').style.display = 'block';
			document.getElementById("paym").value = "Cash";
			document.getElementById('check').style.display = 'none';
			document.getElementById('pmet').innerHTML = "Payment Method :  Cash";
			document.getElementById("cout").disabled = true;
			document.getElementById("checks").checked = false;
			document.getElementById("dis").value = "0";

			document.getElementById('h6dis').innerHTML = "Discount :  ₱ 0";
			document.getElementById('h6amount').innerHTML = "Amount : ₱ " + document.getElementById('Total').value;
			document.getElementById('amount').value = document.getElementById('Total').value;
		}
	}

	function mycheck() {
		// Get the checkbox
		var checkBox = document.getElementById("checks");

		// If the checkbox is checked,
		let sub = Number.parseInt(document.getElementById('amount').value);

		if (checkBox.checked == true && sub != 0) {
			document.getElementById("cout").disabled = false;
		} else {
			document.getElementById("cout").disabled = true;
		}

	}


	$('#dis').change(function() {
		let sub = Number.parseInt(document.getElementById('Total').value);
		let dis = $('#dis').val() * sub;
		let grand = sub - dis;

		document.getElementById('h6dis').innerHTML = "Discount :  ₱ " + dis.toFixed(2);
		document.getElementById('h6amount').innerHTML = "Amount : ₱ " + grand.toFixed(2);
		document.getElementById('amount').value = grand.toFixed(2);
	})

	$(document).on('click', '#cout', function() {
		let a = document.getElementById('Total').value;
		let sub = Number.parseInt(a);
		let dis = $('#dis').val() * sub;


		let grand = sub - dis;
		let cash = document.getElementById('cash').value;
		let n = Number.parseInt(cash);
		let change = n - grand;
		var type = "";
		if ($('#dis').val() == .05) {
			type = "Senior";
		} else if ($('#dis').val() == .1) {
			type = "PWD";
		} else {
			type = "None";
		}

		// lage modal
		document.getElementById('disctype').innerHTML = type;
		document.getElementById('disc').innerHTML = "₱ " + dis.toFixed(2);
		document.getElementById('sub-tot').innerHTML = "₱ " + sub.toFixed(2);
		document.getElementById('grand_tot').innerHTML = "₱ " + grand.toFixed(2);

		if (Number.isNaN(n) == true) {
			document.getElementById('bayaded').innerHTML = "₱ 0.0";
			document.getElementById('sukli').innerHTML = "₱ 0.0";

		} else {
			document.getElementById('bayaded').innerHTML = "₱ " + n.toFixed(2);
			document.getElementById('sukli').innerHTML = "₱ " + change.toFixed(2);
		}


		// lage db 

		document.getElementById("distype").value = type;
		document.getElementById("disco").value = dis.toFixed(2);
		document.getElementById("tot").value = grand.toFixed(2);
		document.getElementById("sub").value = sub.toFixed(2);
		if (Number.isNaN(n) == true) {
			document.getElementById("cas").value = 0;
			document.getElementById("change").value = 0;
		} else {
			document.getElementById("cas").value = n.toFixed(2);
			document.getElementById("change").value = change.toFixed(2);
		}
	})

	$(document).on('keyup', '#cash', function() {

		let cash = $(this).val();
		let presyu = document.getElementById('amount').value;

		let n = Math.round(presyu);

		if (n > cash) {
			document.getElementById("cout").disabled = true;
		} else {
			document.getElementById("cout").disabled = false;
			document.getElementById("paym").value = "Cash";
			document.getElementById('pmet').innerHTML = "Payment Method :  Cash";
		}

	})


	// delete item on cart

	function removeitem(del) {
		var tr = $('#tr').val();
		var cashier = $('#cashier').val();
		(async () => {
			const {
				value: reason
			} = await Swal.fire({
				background: "#ebd1d2",
				confirmButtonColor: "#41B06E",
				cancelButtonColor: "#d33",
				confirmButtonText: "ok",
				title: "Select reason validation",
				input: "select",
				inputOptions: {
					Reasons: {
						aa: "Change of Mind",
						bb: "Wrong Item",
						cc: "Don't Want to Buy Anymore",

					},
				},
				inputPlaceholder: "Select a reason",
				showCancelButton: true,
				inputValidator: (value) => {
					return new Promise((resolve) => {
						if (value != "") {
							$.ajax({
								url: 'code.php',
								type: 'post',
								data: {
									del: del,
									tr: tr,
									cashier: cashier,
									values: value
								},
								success: function(response) {

									$('#laman_cart').load(location.href + " #laman_cart");
									$('#total').load(location.href + " #total");
									$('#resibo').load(location.href + " #resibo");
									$('#myForm').load(location.href + " #myForm");
									// $('#con').load(location.href + " #con");
									document.getElementById("success-outlined").checked = true
									document.getElementById("checks").checked = false
									document.getElementById("dis").value = "0";
									document.getElementById('check').style.display = 'none';
									document.getElementById('inputcash').style.display = 'block';
								}
							});
							resolve();
							Swal.fire({
								background: "#ebd1d2",
								showCancelButton: false,
								showConfirmButton: false,
								icon: "success",
								title: "Item Removed...",
								timer: 800
							});



						} else {
							resolve("You need to select reason");
						}
					});
				}
			});
		})()
	}
	$(document).on('click', '.del', function() {
		let del = $(this).val();
		if (document.getElementById('Total').value != null) {
			Swal.fire({
				title: "Are you sure to remove the item?",
				text: "You won't be able to revert this!",
				icon: "warning",
				background: "#ebd1d2",
				showCancelButton: true,
				showConfirmButton: true,
				confirmButtonColor: "#41B06E",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, Remove it!"
			}).then((result) => {
				if (result.isConfirmed) {
					removeitem(del)
				}
			});
		}
	});




	// delete all data on cart

	function remove() {
		var tr = $('#tr').val();
		var cashier = $('#cashier').val();
		(async () => {
			const {
				value: reason
			} = await Swal.fire({
				background: "#ebd1d2",
				confirmButtonColor: "#41B06E",
				cancelButtonColor: "#d33",
				confirmButtonText: "ok",
				title: "Select reason validation",
				input: "select",
				inputOptions: {
					Reasons: {
						aa: "Change of Mind",
						bb: "Wrong Items",
						cc: "Don't Want to Buy Anymore",

					},
				},
				inputPlaceholder: "Select a reason",
				showCancelButton: true,
				inputValidator: (value) => {
					return new Promise((resolve) => {
						if (value != "") {
							$.ajax({
								url: 'code.php',
								type: 'post',
								data: {
									tr: tr,
									cashier: cashier,
									value: value
								},
								success: function(response) {

									$('#laman_cart').load(location.href + " #laman_cart");
									$('#total').load(location.href + " #total");
									$('#resibo').load(location.href + " #resibo");
									$('#myForm').load(location.href + " #myForm");
									document.getElementById("success-outlined").checked = true
									document.getElementById("checks").checked = false
									document.getElementById("cout").disabled = true;
									document.getElementById("dis").value = "0";
									document.getElementById('check').style.display = 'none';
									document.getElementById('inputcash').style.display = 'block';

								}
							});
							resolve();
							Swal.fire({
								background: "#ebd1d2",
								showCancelButton: false,
								showConfirmButton: false,
								icon: "success",
								title: "Items Removed...",
								timer: 800
							});



						} else {
							resolve("You need to select reason");
						}
					});
				}
			});
		})()
	}

	$('#deleted').click(function() {
		if (document.getElementById('Total').value != null) {
			Swal.fire({
				title: "Are you sure to remove all items?",
				text: "You won't be able to revert this!",
				icon: "warning",
				background: "#ebd1d2",
				showCancelButton: true,
				showConfirmButton: true,
				confirmButtonColor: "#41B06E",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, remove it!"
			}).then((result) => {
				if (result.isConfirmed) {
					remove()
				}
			});
		}
	})



	// add piece
	$(document).on('click', '.addPiece', function() {
		var adding = $(this).val();
		//alert(adding);
		$.ajax({
			type: "GET",
			url: "code.php?adding=" + adding,
			success: function(response) {
				var res = jQuery.parseJSON(response);
				if (res.status == 422) {
					$('#laman_cart').load(location.href + " #laman_cart");
					$('#total').load(location.href + " #total");
					$('#resibo').load(location.href + " #resibo");
					document.getElementById("success-outlined").checked = true
					document.getElementById("checks").checked = false
					document.getElementById("dis").value = "0";
					document.getElementById('check').style.display = 'none';
					document.getElementById('inputcash').style.display = 'block';
					const Toast = Swal.mixin({
						toast: true,
						position: "top-end",
						showConfirmButton: false,
						timer: 1000,

					});
					Toast.fire({
						background: "#94FFD8",
						icon: "success",
						title: res.message
					});
				} else if (res.status == 200) {
					$('#laman_cart').load(location.href + " #laman_cart");
					$('#total').load(location.href + " #total");
					$('#resibo').load(location.href + " #resibo");

					const Toast = Swal.mixin({
						toast: true,
						position: "top-end",
						showConfirmButton: false,
						timer: 1000,

					});
					Toast.fire({
						background: "#FFF9D0",
						icon: "warning",
						title: res.message
					});
				}
			}
		});
	});


	// add pack
	$(document).on('click', '.addPack', function() {
		var adding_pack = $(this).val();
		//alert(adding);
		$.ajax({
			type: "GET",
			url: "code.php?adding_pack=" + adding_pack,
			success: function(response) {
				var res = jQuery.parseJSON(response);
				if (res.status == 422) {
					$('#laman_cart').load(location.href + " #laman_cart");
					$('#total').load(location.href + " #total");;
					$('#resibo').load(location.href + " #resibo");
					document.getElementById("success-outlined").checked = true
					document.getElementById("checks").checked = false
					document.getElementById("dis").value = "0";
					document.getElementById('check').style.display = 'none';
					document.getElementById('inputcash').style.display = 'block';
					const Toast = Swal.mixin({
						toast: true,
						position: "top-end",
						showConfirmButton: false,
						timer: 1000,

					});
					Toast.fire({
						background: "#94FFD8",
						icon: "success",
						title: res.message
					});
				} else if (res.status == 200) {
					$('#laman_cart').load(location.href + " #laman_cart");
					$('#total').load(location.href + " #total");
					$('#resibo').load(location.href + " #resibo");
					const Toast = Swal.mixin({
						toast: true,
						position: "top-end",
						showConfirmButton: false,
						timer: 1000,

					});
					Toast.fire({
						background: "#FFF9D0",
						icon: "warning",
						title: res.message
					});
				}
			}
		});
	});


	// update qty

	$(document).on('change', 'input[data-role="update"]', function() {

		const id = $(this).data('id');
		const q = $(this).val();
		const data = {
			id: id,
			upt: q
		}

		$.ajax({
			url: 'code.php',
			type: 'post',
			data: data,
			success: function(response) {

				$('#laman_cart').load(location.href + " #laman_cart");
				$('#total').load(location.href + " #total");
				$('#resibo').load(location.href + " #resibo");
				document.getElementById("cash").value = "";
				document.getElementById("cout").disabled = true;
			}
		});
	});
</script>

</html>