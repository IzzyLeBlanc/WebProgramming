<?php
include_once('check_login.php');
include_once('database.php');
try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT * FROM TBL_PRODUCTS_A162706');
    $stmt->execute();
    $result = $stmt->fetchAll();
}
catch(PDOException $e){
    echo 'Error: ' . $e->getMessage();
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
    <?php 
	include_once 'nav_bar.php';
	
	//Read
	$per_page = 3;
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}
	else{
	    $page = 1;
	}
	$start_from = ($page - 1) * $per_page;
	if(isset($_POST['keyword'])){
		$keyword = $_POST['keyword'];
	}
	else if(isset($_GET['keyword'])){
		$keyword = $_GET['keyword'];
	}

	try{
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(isset($keyword)){
			$sql = 'SELECT * FROM tbl_products_a162706 WHERE FLD_PRODUCT_ID LIKE "%' . $keyword . '%"'; 
			$sql = $sql . 'OR FLD_PRODUCT_NAME LIKE "%' . $keyword . '%" OR ';
			$sql = $sql . 'FLD_TYPE LIKE "%' . $keyword . '%" LIMIT ' . $start_from . ',' . $per_page;
			$stmt = $conn->prepare($sql);
		} else{
			$stmt = $conn->prepare("SELECT * FROM tbl_products_a162706 LIMIT :start_from, :per_page");
			$stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
			$stmt->bindParam(':per_page', $per_page, PDO::PARAM_INT);
		}
		$stmt->execute();
		$result = $stmt->fetchAll();
    }
    catch(PDOException $e){
        echo 'Error: ' . $e->getMessage();
    }
    ?>
    <div class="container-fluid">
        <div class="row">
        <?php foreach($result as $product){ ?>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a href="product_details.php?pid=<?php echo $product['FLD_PRODUCT_ID'];?>">
                    <img src="products/<?php echo $product['FLD_PRODUCT_ID'];?>.jpg" alt="<?php echo $product['FLD_PRODUCT_NAME'];?>" style="height: 450px, width: 450px">
                    </a>
                    <div class="caption">
                        <h3><?php echo $product['FLD_PRODUCT_NAME'];?></h3>
						<h4><?php echo $product['FLD_PRODUCT_ID'];?></h4>
						<h4><?php echo $product['FLD_TYPE'];?></h4>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
        <div class="row">
			<div class="col-xs-12 col-sm-10 col-md-8">
				<nav>
					<ul class="pagination">
					<?php
					try{
						$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						if(isset($keyword)){
							$sql = 'SELECT * FROM tbl_products_a162706 WHERE FLD_PRODUCT_ID LIKE "%' . $keyword . '%" OR ';
							$sql = $sql . 'FLD_PRODUCT_NAME LIKE "%' . $keyword . '%" OR FLD_TYPE LIKE "%' . $keyword . '%"';
							$stmt = $conn->prepare($sql);
						}
						else{
							$stmt = $conn->prepare('SELECT * FROM TBL_PRODUCTS_A162706');
						}
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
					<?php } else{ 
						if(isset($keyword)){?>
						<li><a href="product_catalogue.php?page=<?php echo $page - 1;?>&keyword=<?php echo $keyword;?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
						<?php } else{ ?>
						<li><a href="product_catalogue.php?page=<?php echo $page - 1;?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
						<?php }?>
					<?php }
					for($i = 1; $i <= $total_pages; $i++){
						if($i == $page){
							if(isset($keyword)){
								echo '<li class="active"><a href="product_catalogue.php?page=' . $i . '&keyword=' . $keyword . '">' . $i . '</a></li>';
							} else{ 
								echo '<li class="active"><a href="product_catalogue.php?page=' . $i . '">' . $i . '</a></li>';
							}
						}
						else{
							if(isset($keyword)){
								echo '<li><a href="product_catalogue.php?page=' . $i . '&keyword=' . $keyword . '">' . $i . '</a></li>';
							}
							else{
								echo '<li><a href="product_catalogue.php?page=' . $i . '">' . $i . '</a></li>';
							}
						}
					}
					if($total_pages == $page){ ?>
						<li class="disabled"><span aria-hidden="true">»</span></li>
					<?php } else{ 
						if(isset($keyword)){?>
						<li><a href="product_catalogue.php?page=<?php echo $page + 1;?>&keyword=<?php echo $keyword;?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
						<?php } else{ ?>
						<li><a href="product_catalogue.php?page=<?php echo $page + 1;?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
						<?php } 
					} ?>
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
