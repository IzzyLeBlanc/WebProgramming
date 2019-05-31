<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['type'])){
    header('Location: login.php');
}

function check_privileges(){
    if($_SESSION['type'] == '1'){
        return true;
    }
    else{
        return false;
    }
}
?>