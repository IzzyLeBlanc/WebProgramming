<?php
include_once('check_login.php');

$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Create
if(isset($_POST['create'])){
	try{
		$stmt = $conn->prepare('INSERT INTO tbl_customer_a162706(FLD_CUSTOMER_ID,
			FLD_CUSTOMER_NAME, FLD_PHONE_NO) VALUES (:cid, :name, :phone)');

		$stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

		$cid = $_POST['cid'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];

		$stmt->execute();
	}
	catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
}

//Update
if(isset($_POST['update'])){
	try{
		$stmt = $conn->prepare('UPDATE tbl_customer_a162706 SET FLD_CUSTOMER_ID = :cid,
			FLD_CUSTOMER_NAME = :name, FLD_PHONE_NO = :phone WHERE FLD_CUSTOMER_ID = :oldcid');

		$stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
		$stmt->bindParam(':oldcid', $oldcid, PDO::PARAM_STR);

		$cid = $_POST['cid'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$oldcid = $_POST['oldcid'];	

		$stmt->execute();

		header('Location: customers.php');
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

//Delete
if(isset($_GET['delete'])){
	try{
		$stmt = $conn->prepare('DELETE FROM tbl_customer_a162706 WHERE FLD_CUSTOMER_ID = :cid');
		$stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
		$cid = $_GET['delete'];
		$stmt->execute();
		header('Location: customers.php');
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

//Edit
if(isset($_GET['edit'])){
	try{
		$stmt = $conn->prepare('SELECT * FROM tbl_customer_a162706 WHERE FLD_CUSTOMER_ID = :cid');
		$stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
		$cid = $_GET['edit'];
		$stmt->execute();
		$editrow = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

$conn = null;

?>