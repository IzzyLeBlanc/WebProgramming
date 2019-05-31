<?php
include_once('check_login.php');
include_once('database.php');
if(check_privileges()){
	include_once "products_crud.php";
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Uncle Bear's Power Tools - Products</title>
	
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
	<?php if(check_privileges()){?>
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      			<div class="page-header">
        			<h2>Create New Product</h2>
      			</div>
      			<form action="products.php" method="post" class="form-horizontal">
				 	<div class="form-group">
          				<label for="productid" class="col-sm-3 control-label">Product ID</label>
          				<div class="col-sm-9">
							<input class="form-control" id="productid" name="pid" type="text" placeholder="Product ID" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_ID'];?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="productname" class="col-sm-3 control-label">Name</label>
						<div class="col-sm-9">
							<input class="form-control" id="productname" name="name" type="text" placeholder="Product Name" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_NAME'];?>" required>
						</div>
					</div>
					<div class="form-group">
          				<label for="productprice" class="col-sm-3 control-label">Price</label>
          				<div class="col-sm-9">
							<input class="form-control" id="productprice" name="price" type="text" placeholder="Product Price" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRICE'];?>" required>
						</div>
					</div>
					<div class="form-group">
         				<label for="productbrand" class="col-sm-3 control-label">Brand</label>
          				<div class="col-sm-9">
							<select id="productbrand" name="brand" class="form-control" required>
								<option value="">Please select</option>
								<option value="Black & Decker" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Black & Decker") echo "selected";?>>Black & Decker</option>
								<option value="Bosch" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Bosch") echo "selected";?>>Bosch</option>
								<option value="Briggs and Stratton" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Briggs and Stratton") echo "selected";?>>Briggs and Stratton</option>
								<option value="Daewoo" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Daewoo") echo "selected";?>>Daewoo</option>
								<option value="Dewalt" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Dewalt") echo "selected";?>>Dewalt</option>
								<option value="Electrolux" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Electrolux") echo "selected";?>>Electrolux</option>
								<option value="Hitachi" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Hitachi") echo "selected";?>>Hitachi</option>
								<option value="Husqvarna" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Husqvarna") echo "selected";?>>Husqvarna</option>
								<option value="Karcher" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Karcher") echo "selected";?>>Karcher</option>
								<option value="Khind" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Khind") echo "selected";?>>Khind</option>
								<option value="Makita" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Makita") echo "selected";?>>Makita</option>
								<option value="Maxpro" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Maxpro") echo "selected";?>>Maxpro</option>
								<option value="Midea" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Midea") echo "selected";?>>Midea</option>
								<option value="Panasonic" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Panasonic") echo "selected";?>>Panasonic</option>
								<option value="Philips" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Philips") echo "selected";?>>Philips</option>
								<option value="Singer" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Singer") echo "selected";?>>Singer</option>
								<option value="Stanley" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Stanley") echo "selected";?>>Stanley</option>
								<option value="Steanel" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Steanel") echo "selected";?>>Steanel</option>
								<option value="Steel Power" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Steel Power") echo "selected";?>>Steel Power</option>
								<option value="STHLL" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "STHLL") echo "selected";?>>STHLL</option>
								<option value="Worx" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Worx") echo "selected";?>>Worx</option>
								<option value="Xugel" <?php if(isset($_GET["edit"])) if($editrow["FLD_BRAND"] == "Xugel") echo "selected";?>>Xugel</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="producttype" class="col-sm-3 control-label">Type</label>
						<div class="col-sm-9">
							<select class="form-control" id="producttype" name="type" required>
								<option value="">Please select</option>
								<option value="Chain Saw" <?php if(isset($_GET["edit"])) if($editrow["FLD_TYPE"] == "Chain Saw") echo "checked";?>>Chain Saw</option>
								<option value="Drill" <?php if(isset($_GET["edit"])) if($editrow["FLD_TYPE"] == "Drill") echo "checked";?>>Drill</option>
								<option value="Heat Gun" <?php if(isset($_GET["edit"])) if($editrow["FLD_TYPE"] == "Heat Gun") echo "checked";?>>Heat Gun</option>
								<option value="Iron" <?php if(isset($_GET["edit"])) if($editrow["FLD_TYPE"] == "Iron") echo "checked";?>>Iron</option>
								<option value="Lawn Mower" <?php if(isset($_GET["edit"])) if($editrow["FLD_TYPE"] == "Lawn Mower") echo "checked";?>>Lawn Mower</option>
								<option value="Pressure Washer" <?php if(isset($_GET["edit"])) if($editrow["FLD_TYPE"] == "Pressure Washer") echo "checked";?>>Pressure Washer</option>
								<option value="Sander" <?php if(isset($_GET["edit"])) if($editrow["FLD_TYPE"] == "Sander") echo "checked";?>>Sander</option>
								<option value="Sewing Machine" <?php if(isset($_GET["edit"])) if($editrow["FLD_TYPE"] == "Sewing Machine") echo "checked";?>>Sewing Machine</option>
								<option value="Table Saw" <?php if(isset($_GET["edit"])) if($editrow["FLD_TYPE"] == "Table Saw") echo "checked";?>>Table Saw</option>
								<option value="Vacuum Cleaner" <?php if(isset($_GET["edit"])) if($editrow["FLD_TYPE"] == "Vacuum Cleaner") echo "checked";?>>Vacuum Cleaner</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="productwarranty" class="col-sm-3 control-label">Warranty Length</label>
						<div class="col-sm-9">
							<input class="form-control" id="productwarranty" type="text" name="warranty" placeholder="Product Warranty" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_WARRANTYLENGTH'];?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="productwattage" class="col-sm-3 control-label">Wattage</label>
						<div class="col-sm-9">
							<input class="form-control" id="productwattage" name="watt" type="number" placeholder="Product Wattage" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_WATTAGE'];?>" min="0" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
						<?php 
						if(isset($_GET["edit"])){?>
							<input type="hidden" name="oldpid" value="<?php echo $editrow['FLD_PRODUCT_ID'];?>">
							<button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>Update</button>
						<?php }

						else{?>
							<button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Create</button>
						<?php }?>	
							<button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span>Clear</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php }?>
		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
				<a href="product_catalogue.php"><button class="btn btn-primary">Catalogue</button></a>
				<a href="product_search.php"><button class="btn btn-primary">Search</button></a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
				<div class="page-header">
					<h2>Products List</h2>
     			</div>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Product ID</th>
							<th>Name</th>
							<th>Price</th>
							<th>Brand</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
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
								$stmt = $conn->prepare("SELECT * FROM tbl_products_a162706 LIMIT $start_from, $per_page");
								$stmt->execute();
								$result = $stmt->fetchAll();
							}

							catch(PDOException $e){
								echo "Error: " . $e->getMessage();
							}

							foreach($result as $readrow){?>
							<tr>
								<td><?php echo $readrow["FLD_PRODUCT_ID"];?></td>
								<td><?php echo $readrow["FLD_PRODUCT_NAME"];?></td>
								<td><?php echo $readrow["FLD_PRICE"];?></td>
								<td><?php echo $readrow["FLD_BRAND"];?></td>
								<td>
									<a href="product_details.php?pid=<?php echo $readrow['FLD_PRODUCT_ID'];?>" class="btn btn-warning btn-xs">Details</a>
								<?php if(check_privileges()){ ?>
									<a href="products.php?edit=<?php echo $readrow['FLD_PRODUCT_ID'];?>" class="btn btn-success btn-xs">Edit</a>
									<a href="products.php?delete=<?php echo $readrow['FLD_PRODUCT_ID'];?>" 
										onclick="return confirm('Are you sure you want to delete this?');" class="btn btn-danger btn-xs">Delete</a>
								<?php } ?>
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
						$stmt = $conn->prepare('SELECT * FROM TBL_PRODUCTS_A162706');
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
						<li><a href="products.php?page=<?php echo $page - 1;?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
					<?php }
					for($i = 1; $i <= $total_pages; $i++){
						if($i == $page){
							echo '<li class="active"><a href="products.php?page=' . $i . '">' . $i . '</a></li>';
						}
						else{
							echo '<li><a href="products.php?page=' . $i . '">' . $i . '</a></li>';
						}
					}
					if($total_pages == $page){ ?>
						<li class="disabled"><span aria-hidden="true">»</span></li>
					<?php } else{ ?>
						<li><a href="products.php?page=<?php echo $page + 1;?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
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