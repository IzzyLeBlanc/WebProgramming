<?php
include_once('check_login.php');
include_once 'orders_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Uncle Bear's Power Tools - Orders</title>
	
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
	<?php include_once 'nav_bar.php';?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
				<div class="page-header">
					<h2>Create New Order</h2>
				</div>
				<form action="orders.php" method="post" class="form-horizontal">
					<div class="form-group">
						<label for="orderid" class="col-sm-3 control-label">Order ID</label>
						<div class="col-sm-9">
							<input class="form-control" id="orderid" type="text" name="oid" placeholder="Order ID" readonly value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_ORDER_ID'];?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="staffid" class="col-sm-3 control-label">Staff ID</label>
						<div class="col-sm-9">
							<select name="sid" class="form-control" required>
								<?php
								try{
									$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
									$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

									$stmt = $conn->prepare('SELECT * FROM tbl_staff_a162706');
									$stmt->execute();
									$result = $stmt->fetchAll();
								}
								catch(PDOException $e){
									echo 'Error: ' . $e->getMessage();
								}
								echo '<option value="">Select</option>';
								foreach($result as $staffrow){
								if((isset($_GET['edit'])) && $editrow['FLD_STAFF_ID'] == $staffrow['FLD_STAFF_ID']){?>
								<option value="<?php echo $staffrow['FLD_STAFF_ID'];?>" selected><?php echo $staffrow['FLD_STAFF_NAME'];?></option>
								<?php
								}
								else{ ?>
								<option value="<?php echo $staffrow['FLD_STAFF_ID'];?>"><?php echo $staffrow['FLD_STAFF_NAME'];?></option>
								<?php
								}
								}
								$conn = null;
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="customerid" class="col-sm-3 control-label">Customer ID</label>
						<div class="col-sm-9">
							<select name="cid" class="form-control" required>
								<?php
								try{
									$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
									$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

									$stmt = $conn->prepare('SELECT * FROM tbl_customer_a162706');
									$stmt->execute();
									$result = $stmt->fetchAll();
								}
								catch(PDOException $e){
									echo 'Error: ' . $e->getMessage();
								}
								echo '<option value="">Select</option>';
								foreach($result as $custrow){
								if((isset($_GET['edit'])) && $editrow['FLD_CUSTOMER_ID'] == $custrow['FLD_CUSTOMER_ID']){
									?>
								<option value="<?php echo $custrow['FLD_CUSTOMER_ID'];?>" selected><?php echo $custrow['FLD_CUSTOMER_NAME'];?></option>
								<?php
								}
								else{ ?>
								<option value="<?php echo $custrow['FLD_CUSTOMER_ID'];?>"><?php echo $custrow['FLD_CUSTOMER_NAME'];?></option>
								<?php
								}
								}
								$conn = null;
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
						<?php if(isset($_GET['edit'])){ ?>
							<button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>Update</button>
						<?php } else{ ?>
							<button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Create</button>
						<?php } ?>
							<button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span>Clear</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
				<div class="page-header">
					<h2>Order List</h2>
				</div>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Order ID</th>
							<th>Staff ID</th>
							<th>Customer ID</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						/*$per_page = 5;
						if(isset($_GET['page'])){
							$page = $_GET['page'];
						}
						else{
							$page = 1;
						}
						$start_from = ($page - 1) * $per_page;
						try{
							$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
							$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

							$sql = 'SELECT * FROM tbl_orders_a162706, tbl_staff_a162706, tbl_customer_a162706 WHERE ';
							$sql = $sql . 'tbl_orders_a162706.FLD_STAFF_ID = tbl_staff_a162706.FLD_STAFF_ID and ';
							$sql = $sql . 'tbl_orders_a162706.FLD_CUSTOMER_ID = tbl_customer_a162706.FLD_CUSTOMER_ID';
							$stmt = $conn->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetchAll();
						}
						catch(PDOException $e){
							echo 'Error: ' . $e->getMessage();
						}*/
						//Read
						$per_page = 5;
						if(isset($_GET['page'])){
							$page = $_GET['page'];
						}
						else{
							$page = 1;
						}
						$start_from = ($page - 1) * $per_page;
						try{
							$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
							$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$sql = 'SELECT * FROM tbl_orders_a162706, tbl_staff_a162706, tbl_customer_a162706 WHERE ';
							$sql = $sql . 'tbl_orders_a162706.FLD_STAFF_ID = tbl_staff_a162706.FLD_STAFF_ID and ';
							$sql = $sql . 'tbl_orders_a162706.FLD_CUSTOMER_ID = tbl_customer_a162706.FLD_CUSTOMER_ID ';
							$sql = $sql . 'LIMIT :start_from, :per_page';
							$stmt = $conn->prepare($sql);
							$stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
							$stmt->bindParam(':per_page', $per_page, PDO::PARAM_INT);
							$stmt->execute();
							$result = $stmt->fetchAll();
						}

						catch(PDOException $e){
							echo "Error: " . $e->getMessage();
						}
						foreach($result as $orderrow){?>
						<tr>
							<td><?php echo $orderrow['FLD_ORDER_ID'];?></td>
							<td><?php echo $orderrow['FLD_STAFF_ID'];?></td>
							<td><?php echo $orderrow['FLD_CUSTOMER_ID'];?></td>
							<td>
								<a href="order_details.php?oid=<?php echo $orderrow['FLD_ORDER_ID'];?>" class="btn btn-warning btn-xs">Details</a>
								<a href="orders.php?edit=<?php echo $orderrow['FLD_ORDER_ID'];?>" class="btn btn-success btn-xs">Edit</a>
								<a href="orders.php?delete=<?php echo $orderrow['FLD_ORDER_ID'];?>" class="btn btn-danger btn-xs">Delete</a>
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
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
				<nav>
					<ul class="pagination">
					<?php
					try{
						$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sql = 'SELECT * FROM tbl_orders_a162706, tbl_staff_a162706, tbl_customer_a162706 WHERE ';
							$sql = $sql . 'tbl_orders_a162706.FLD_STAFF_ID = tbl_staff_a162706.FLD_STAFF_ID and ';
							$sql = $sql . 'tbl_orders_a162706.FLD_CUSTOMER_ID = tbl_customer_a162706.FLD_CUSTOMER_ID';
							$stmt = $conn->prepare($sql);
						$stmt->execute();
						$result = $stmt->fetchAll();
						$total_records = count($result);
					}
					catch(PDOException $e){
						echo 'Error: ' . $e->getMessage();
					}
					$total_pages = ceil($total_records / $per_page);
					
					if ($page == 1){ ?>
						<li class="disabled"><span aria-hidden="true">«</span></li>
					<?php } else{ ?>
						<li><a href="orders.php?page=<?php echo $page - 1;?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
					<?php }
					for($i = 1; $i <= $total_pages; $i++){
						if($i == $page){
							echo '<li class="active"><a href="orders.php?page=' . $i . '">' . $i . '</a></li>';
						}
						else{
							echo '<li><a href="orders.php?page=' . $i . '">' . $i . '</a></li>';
						}
					}
					if($total_pages == $page){ ?>
						<li class="disabled"><span aria-hidden="true">»</span></li>
					<?php } else{ ?>
						<li><a href="orders.php?page=<?php echo $page + 1;?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
					<?php } ?>
					</ul>
				</nav>
			</div>
		</div>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
</body>
</html>