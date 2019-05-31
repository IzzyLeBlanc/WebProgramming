<?php
	include_once('check_login.php');

	$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//Create
	if(isset($_POST["create"])){
		try{
			$stmt = $conn->prepare("INSERT INTO tbl_products_a162706(FLD_PRODUCT_ID, 
				FLD_PRODUCT_NAME, FLD_PRICE, FLD_BRAND, FLD_TYPE, FLD_WARRANTYLENGTH,
				FLD_WATTAGE) VALUES (:pid, :name, :price, :brand, :type, :warranty, :watt)");

			$stmt->bindParam(":pid", $pid, PDO::PARAM_STR);
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":price", $price, PDO::PARAM_STR);
			$stmt->bindParam(":brand", $brand, PDO::PARAM_STR);
			$stmt->bindParam(":type", $type, PDO::PARAM_STR);
			$stmt->bindParam(":warranty", $warranty, PDO::PARAM_STR);
			$stmt->bindParam(":watt", $watt, PDO::PARAM_INT);

			$pid = $_POST["pid"];
			$name = $_POST["name"];
			$price = $_POST["price"];
			$brand = $_POST["brand"];
			$type = $_POST["type"];
			$warranty = $_POST["warranty"];
			$watt = $_POST["watt"];

			$stmt->execute();
		}

		catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}

	//Update
	if(isset($_POST["update"])){
		try{
			$stmt = $conn->prepare("UPDATE tbl_products_a162706 SET FLD_PRODUCT_ID = :pid,
				FLD_PRODUCT_NAME = :name, FLD_PRICE = :price, FLD_BRAND = :brand,
				FLD_TYPE = :type, FLD_WARRANTYLENGTH = :warranty, FLD_WATTAGE = :watt
				WHERE FLD_PRODUCT_ID = :oldpid");

			$stmt->bindParam(":pid", $pid, PDO::PARAM_STR);
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":price", $price, PDO::PARAM_STR);
			$stmt->bindParam(":brand", $brand, PDO::PARAM_STR);
			$stmt->bindParam(":type", $type, PDO::PARAM_STR);
			$stmt->bindParam(":warranty", $warranty, PDO::PARAM_STR);
			$stmt->bindParam(":watt", $watt, PDO::PARAM_INT);
			$stmt->bindParam(":oldpid", $oldpid, PDO::PARAM_STR);

			$pid = $_POST["pid"];
			$name = $_POST["name"];
			$price = $_POST["price"];
			$brand = $_POST["brand"];
			$type = $_POST["type"];
			$warranty = $_POST["warranty"];
			$watt = $_POST["watt"];
			$oldpid = $_POST["oldpid"];

			$stmt->execute();

			header("Location: products.php");
		}

		catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}

	//Delete
	if(isset($_GET["delete"])){
		try{
			$stmt = $conn->prepare("DELETE FROM tbl_products_a162706 WHERE FLD_PRODUCT_ID = :pid");

			$stmt->bindParam(":pid", $pid, PDO::PARAM_STR);

			$pid = $_GET["delete"];

			$stmt->execute();

			header("Location: products.php");
		}

		catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}

	//Edit
	if(isset($_GET["edit"])){
		try{
			$stmt = $conn->prepare("SELECT * FROM tbl_products_a162706 WHERE FLD_PRODUCT_ID = :pid");

			$stmt->bindParam(":pid", $pid, PDO::PARAM_STR);

			$pid = $_GET["edit"];

			$stmt->execute();

			$editrow = $stmt->fetch(PDO::FETCH_ASSOC);
		}

		catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}

	$conn = null;
?>