<?php  session_start(); ob_start();
//include('connection.php');
$mesg = "";
$errmsg="";
session_unset();
header('location:index.php');
/*if($_SESSION['shopid'] != ""){
	header('location:transaction.php');
}else{
	header('location:login.php');
}
*/

?>