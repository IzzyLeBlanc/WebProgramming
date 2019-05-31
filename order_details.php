<?php
include_once('check_login.php');
include_once 'order_details_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Uncle Bear's Power Tools - Order Details</title>

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
	<?php include_once 'nav_bar.php';
	
	try{
		$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare('SELECT * FROM tbl_orders_a162706, tbl_staff_a162706,
			tbl_customer_a162706 WHERE tbl_orders_a162706.FLD_STAFF_ID = 
			tbl_staff_a162706.FLD_STAFF_ID AND tbl_orders_a162706.FLD_CUSTOMER_ID =
			tbl_customer_a162706.FLD_CUSTOMER_ID AND FLD_ORDER_ID = :oid');
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
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Order Details</strong></div>
					<div class="panel-body">
						Below are the details of the order.
					</div>
					<table class="table">
						<tr>
							<td class="col-xs-4 col-sm-4 col-md-4"><strong>Order ID</strong></td>
							<td><?php echo $readrow['FLD_ORDER_ID'];?></td>
						</tr>
						<tr>
							<td class="col-xs-4 col-sm-4 col-md-4"><strong>Staff ID</strong></td>
							<td><?php echo $readrow['FLD_STAFF_ID'];?></td>
						</tr>
						<tr>
							<td class="col-xs-4 col-sm-4 col-md-4"><strong>Customer ID</strong></td>
							<td><?php echo $readrow['FLD_CUSTOMER_ID'];?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
				<div class="page-header">
					<h2>Add an product</h2>
				</div>
				<form action="order_details.php?oid=<?php echo $_GET['oid'];?>" method="post" class="form-horizontal" name="frmorder" id="forder">
					<div class="form-group">
						<label for="prd" class="col-sm-3 control-label">Product</label>
						<div class="col-sm-9">
							<select name="pid" class="form-control" id="prd" required>
								<option value="">Please select</option>
								<?php
								try{
									$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
									$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$stmt = $conn->prepare('SELECT * FROM tbl_products_a162706');
									$stmt->execute();
									$result = $stmt->fetchAll();
								}
								catch(PDOException $e){
									echo 'Error: ' . $e->getMessage();
								}
								foreach($result as $productrow){?>
									<option value="<?php echo $productrow['FLD_PRODUCT_ID'];?>"><?php echo $productrow['FLD_PRODUCT_NAME'];?></option>
								<?php
								}
								$conn = null;
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="qty" class="col-sm-3 control-label">Quantity</label>
						<div class="col-sm-9">
							<input type="number" name="quantity" class="form-control" id="qty" min="1">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<input type="hidden" name="oid" value="<?php echo $readrow['FLD_ORDER_ID'];?>">
							<button class="btn btn-default" type="submit" name="addproduct" onsubmit="return validateForm();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add Product</button>
							<button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span>Clear</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
				<div class="page-header">
					<h2>Products in this Order</h2>
				</div>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Order Detail ID</th>
							<th>Product</th>
							<th>Quantity</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						try{
							$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
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
							<td><?php echo $detailrow['FLD_ORDERDETAIL_ID'];?></td>
							<td><?php echo $detailrow['FLD_PRODUCT_NAME'];?></td>
							<td><?php echo $detailrow['FLD_QUANTITY'];?></td>
							<td>
								<a href="order_details.php?oid=<?php echo $_GET['oid'];?>&delete=<?php echo $detailrow['FLD_ORDERDETAIL_ID'];?>" onclick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
							</td>
						</tr>
						<?php
						}
						$conn = null;
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
				<a href="invoice.php?oid=<?php echo $_GET['oid'];?>" target="_blank" role="button" class="btn btn-primary btn-lg btn-block">Generate Invoice</a>
			</div>
		</div>
	</div>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
</body>
</html>

<script type="text/javascript">
	function validateForm(){
		var x = document.forms['frmorder']['pid'].value;
		var y = document.forms['frmorder']['quantity'].value;
		//var x = document.getElementById('prd').value;
		//var y = document.getElementById('quantity').value;
		if(x == null || x == ""){
			alert('Product must be selected');
			document.forms['frmorder']['pid'].focus();
			//document.getELementById('pid').focus();
			return false;
		}
		if(y == null || y == ""){
			alert('Quantity must be filled out');
			document.forms['frmoder']['qty'].focus();
			//document.getElementById('qty').focus();
			return false;
		}

		return true;
	}
</script>