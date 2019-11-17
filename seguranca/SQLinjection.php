<?php 

$id = (isset($_GET['id']))? $_GET['id']: 1;// ?id=1 or 1=1 -- 

// if (!is_numeric($id) || $id < 0 ) {

// 	exit('Erro');

// }

if (!filter_var($id, FILTER_VALIDATE_INT)) {

	exit('Erro');

}

$conn = mysqli_connect('localhost','root','Heitor13','php7');

$sql = "SELECT name FROM tb_User WHERE idUser = $id"; // interpolação de variáveis

$exec = mysqli_query($conn,$sql);

while($result = mysqli_fetch_object($exec)){

	echo $result->name.'<br>';

}

?>