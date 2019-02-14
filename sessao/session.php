<?php 
session_start();
if(isset($_SESSION)){
	header('Location:mostranomeSession.php');
}else{
$_SESSION = array();
}
 ?>