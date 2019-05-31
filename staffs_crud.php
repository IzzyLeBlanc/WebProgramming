<?php
include_once('check_login.php');

$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Create
if(isset($_POST['create'])){
	if($_POST['pw'] == $_POST['retypepw'] && ($_POST['position'] == '1' || $_POST['position'] == '2')){
		try{
			$stmt = $conn->prepare('INSERT INTO tbl_staff_a162706(FLD_STAFF_ID, FLD_STAFF_PASSWORD,
				FLD_STAFF_NAME, FLD_TYPE) VALUES(:sid, :pw, :name, :position)');

			$stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
			$stmt->bindParam(':pw', $pw, PDO::PARAM_STR);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':position', $position, PDO::PARAM_STR);

			$sid = $_POST['sid'];
			$pw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
			$name = $_POST['name'];
			$position = $_POST['position'];

			$stmt->execute();
		}
		catch(PDOException $e){
			echo 'Error: ' . $e->getMessage();
		}
	}
	else{
		header('Location: staffs.php');
	}
}

//Update
if(isset($_POST['update'])){
	if(isset($_POST['oldpw']) && ($_POST['position'] == '1' || $_POST['position'] == '2')){
		try{
			$stmt = $conn->prepare('SELECT * FROM TBL_STAFF_A162706 WHERE FLD_STAFF_ID = :oldsid');
			$stmt->bindParam(':oldsid', $oldsid, PDO::PARAM_STR);
			$oldsid = $_POST['oldsid'];
			$stmt->execute();
			$verify = $stmt->fetch(PDO::FETCH_ASSOC);

			if(password_verify($_POST['oldpw'], $verify['FLD_STAFF_PASSWORD'])){
				if(isset($_POST['pw']) && $_POST['pw'] != ""){
					if($_POST['pw'] == $_POST['retypepw']){
						$stmt = $conn->prepare('UPDATE tbl_staff_a162706 SET FLD_STAFF_ID = :sid, FLD_STAFF_PASSWORD = :pw,
						FLD_STAFF_NAME = :name, FLD_TYPE = :position WHERE FLD_STAFF_ID = :oldsid');

						$stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
						$stmt->bindParam(':pw', $pw, PDO::PARAM_STR);
						$stmt->bindParam(':name', $name, PDO::PARAM_STR);
						$stmt->bindParam(':position', $position, PDO::PARAM_STR);
						$stmt->bindParam(':oldsid', $oldsid, PDO::PARAM_STR);

						$sid = $_POST['sid'];
						$pw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
						$name = $_POST['name'];
						$position = $_POST['position'];
						$oldsid = $_POST['oldsid'];

						$stmt->execute();
					}

					else{
						header('Location: staffs.php?edit=' . $_POST['oldname'] . '&pw=wrong');
					}
				}
				else{
					$stmt = $conn->prepare('UPDATE tbl_staff_a162706 SET FLD_STAFF_ID = :sid,
					FLD_STAFF_NAME = :name, FLD_TYPE = :position WHERE FLD_STAFF_ID = :oldsid');

					$stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
					$stmt->bindParam(':name', $name, PDO::PARAM_STR);
					$stmt->bindParam(':position', $position, PDO::PARAM_STR);
					$stmt->bindParam(':oldsid', $oldsid, PDO::PARAM_STR);

					$sid = $_POST['sid'];
					$name = $_POST['name'];
					$position = $_POST['position'];
					$oldsid = $_POST['oldsid'];

					$stmt->execute();
				}
			}
			else{
				header('Location: staffs.php?edit=' . $_POST['oldname'] . '&stuff=wrong');
			}
		}
		catch(PDOException $e){
			echo 'Error: ' . $e->getMessage();
		}
	}
	else{
		header('Location: staffs.php?edit=' . $_POST['oldname'] . '&stuff=wrong');
	}
}

//Delete
if(isset($_GET['delete'])){
	try{
		$stmt = $conn->prepare('DELETE FROM tbl_staff_a162706 WHERE FLD_STAFF_ID = :sid');
		$stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
		$sid = $_GET['delete'];
		$stmt->execute();
		header('Location: staffs.php');
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

//Edit
if(isset($_GET['edit'])){
	try{
		$stmt = $conn->prepare('SELECT * FROM tbl_staff_a162706 WHERE FLD_STAFF_ID = :sid');
		$stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
		$sid = $_GET['edit'];
		$stmt->execute();
		$editrow = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e){
		echo 'Error: ' . $e->getMessage();
	}
}

$conn = null;
?>