<?php
include_once('database.php');

$staff_id = $_POST['staff_id'];
$pw = $_POST['password'];

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT * FROM TBL_STAFF_A162706 WHERE FLD_STAFF_ID = :sid');
    $stmt->bindParam(':sid', $staff_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    echo 'Error: ' . $e->getMessage();
}

$hash = $result['FLD_STAFF_PASSWORD'];

session_start();
$_SESSION['status'] = 'failed';

if(password_verify($pw, $hash)){
    $_SESSION['type'] = $result['FLD_TYPE'];
    $_SESSION['name'] = $result['FLD_STAFF_NAME'];
    $_SESSION['status'] = 'success';
}

header('Location: index.php');
?>
