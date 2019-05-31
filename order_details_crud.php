<?php
include_once('check_login.php');
include_once 'database.php';

$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Create
if(isset($_POST['addproduct'])){
	try{
		$stmt = $conn->prepare('INSERT INTO tbl_orderdetails_a162706(FLD_ORDERDETAIL_ID, 
			FLD_ORDER_ID, FLD_PRODUCT_ID, FLD_QUANTITY) VALUES(:did, :oid, :pid, :quantity)');

		$stmt->bindParam(':did', $did, PDO::PARAM_STR);
		$stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
		$stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
		$stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

		$did = uniqid('D', true);
		$oid = $_POST['oid'];
		$pid = $_POST['pid'];
		$quantity = $_POST['quantity'];

		$stmt->execute();
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

//Delete
if(isset($_GET['delete'])){
	try{
		$stmt = $conn->prepare('DELETE FROM tbl_orderdetails_a162706 WHERE FLD_ORDERDETAIL_ID = :did');
		$stmt->bindParam(':did', $did, PDO::PARAM_STR);
		$did = $_GET['delete'];
		$stmt->execute();
		header('Location: order_details.php?oid=' . $_GET['oid']);
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

$conn = null;
?>