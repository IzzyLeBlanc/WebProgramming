<?php
include_once('check_login.php');
include_once 'database.php';

$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Create
if(isset($_POST['create'])){
	try{
		$stmt = $conn->prepare('INSERT INTO tbl_orders_a162706(FLD_ORDER_ID,
			FLD_CUSTOMER_ID, FLD_STAFF_ID) VALUES(:oid, :cid, :sid)');

		$stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
		$stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
		$stmt->bindParam(':sid', $sid, PDO::PARAM_STR);

		$oid = uniqid('O', true);
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];

		$stmt->execute();
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

//Update
if(isset($_POST['update'])){
	try{
		$stmt = $conn->prepare('UPDATE tbl_orders_a162706 SET FLD_CUSTOMER_ID = :cid, 
			FLD_STAFF_ID = :sid WHERE FLD_ORDER_ID = :oid');

		$stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
		$stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
		$stmt->bindParam(':oid', $oid, PDO::PARAM_STR);

		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$oid = $_POST['oid'];

		$stmt->execute();

		header('Location: orders.php');
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

//Delete
if(isset($_GET['delete'])){
	try{
		$stmt = $conn->prepare('DELETE FROM tbl_orders_a162706 WHERE FLD_ORDER_ID = :oid');
		$stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
		$oid = $_GET['delete'];
		$stmt->execute();
		header('Location: orders.php');
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

if(isset($_GET['edit'])){
	try{
		$stmt = $conn->prepare('SELECT * FROM tbl_orders_a162706 WHERE FLD_ORDER_ID = :oid');
		$stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
		$oid = $_GET['edit'];
		$stmt->execute();
		$editrow = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

$conn = null;
?>