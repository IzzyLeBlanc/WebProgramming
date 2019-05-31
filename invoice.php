<?php
include_once('check_login.php');
include_once('database.php');

try{
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $conn->prepare('SELECT * FROM tbl_orders_a162706, tbl_orderdetails_a162706,
		tbl_staff_a162706, tbl_customer_a162706 
		WHERE tbl_orders_a162706.FLD_STAFF_ID=tbl_staff_a162706.FLD_STAFF_ID
		AND tbl_orders_a162706.FLD_CUSTOMER_ID = tbl_customer_a162706.FLD_CUSTOMER_ID
		AND tbl_orders_a162706.FLD_ORDER_ID = tbl_orderdetails_a162706.FLD_ORDER_ID
		AND tbl_orders_a162706.FLD_ORDER_ID = :oid');
	$stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
	$oid = $_GET['oid'];
	$stmt->execute();
	$readrow = $stmt->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
	echo 'Error: ' . $e->getMessage();
}
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Uncle Bear's Power Tools - Invoice</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div class="row">
		<div class="col-xs-6 text-center">
			<br>
			<img src="logo.jpg" width="40%" height="40%">
		</div>
		<div class="col-xs-6 text-right">
			<h1>INVOICE</h1>
			<h5>Order ID: <?php echo $readrow['FLD_ORDER_ID'];?></h5>
			<h5>Date: <?php echo date('d M Y');?></h5>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Uncle Bear's Power Tools</h4>
				</div>
				<div class="panel-body">
					<p>
					Amazon Rainforest<br>
					Brazil<br>
					</p>
				</div>
			</div>
		</div>
		<div class="col-xs-5 col-xs-offset-2 text-right">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Customer: <?php echo $readrow['FLD_CUSTOMER_ID'] . ' ' . $readrow['FLD_CUSTOMER_NAME'];?></h4>
				</div>
				<div class="panel-body">
					<p>
					Address 1<br>
					Address 2<br>
					Postcode City<br>
					State<br>
				</div>
			</div>
		</div>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Product</th>
				<th class="text-right">Quantity</th>
				<th class="text-right">Price(RM)/unit</th>
				<th class="text-right">Total(RM)</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$grandtotal = 0;
		$counter = 1;
		try{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare('SELECT * FROM tbl_orderdetails_a162706, tbl_products_a162706
				WHERE tbl_orderdetails_a162706.FLD_PRODUCT_ID = tbl_products_a162706.FLD_PRODUCT_ID
				AND FLD_ORDER_ID = :oid');
			$stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
			$oid = $_GET['oid'];
			$stmt->execute();
			$result = $stmt->fetchAll();
		}
		catch(PDOException $e){
			echo 'Error: ' . $e->getMessage();
		}
		foreach($result as $detailrow){?>
			<tr>
				<td><?php echo $counter;?></td>
				<td><?php echo $detailrow['FLD_PRODUCT_NAME'];?></td>
				<td class="text-right"><?php echo $detailrow['FLD_QUANTITY'];?></td>
				<td class="text-right"><?php echo $detailrow['FLD_PRICE'];?></td>
				<td class="text-right"><?php echo $detailrow['FLD_PRICE']*$detailrow['FLD_QUANTITY'];?></td>
			</tr>
		<?php
		$grandtotal = $grandtotal + $detailrow['FLD_PRICE']*$detailrow['FLD_QUANTITY'];
		$counter++;
		}
		?>
			<tr>
				<td colspan="4" class="text-right">Grand Total</td>
				<td class="text-right"><?php echo $grandtotal;?></td>
			</tr>
		</tbody>
	</table>
	<div class="row">
		<div class="col-xs-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Bank Details</h4>
				</div>
				<div class="panel-body">
					<p>Your Name</p>
					<p>Bank Name</p>
					<p>SWIFT: </p>
					<p>Account Number: </p>
					<p>IBAN: </p>
				</div>
			</div>
		</div>
		<div class="col-xs-7">
			<div class="span7">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Contact Details</h4>
					</div>
					<div class="panel-body">
						<p>Staff: <?php echo $readrow['FLD_STAFF_ID'] . ' ' . $readrow['FLD_STAFF_NAME'];?></p>
						<p><br></p>
						<p><br></p>
						<p>Computer-generated invoice. No signature is required.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>