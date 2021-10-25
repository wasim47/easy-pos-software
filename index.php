<?php  session_start(); ob_start();
//include('connection.php');
$mesg = "";
$errmsg="";
$_SESSION['curpage']="index";

if($_SESSION['shopid'] != ""){
	header('location:transaction.php');
}else{
	header('location:login.php');
}
?>