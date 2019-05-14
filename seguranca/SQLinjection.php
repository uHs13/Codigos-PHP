<?php 

$id = (isset($_GET['id']))? $_GET['id']: 1;// ?id=1 or 1=1 -- 

if(!is_numeric($id) || strlen($id) > 3 ){
	exit('Err number 171');
}

$conn = mysqli_connect('localhost','root','','php7');

$sql = "select name from fakeuser where idFakeUser = $id"; // interpolação de variáveis

$exec = mysqli_query($conn,$sql);

while($result = mysqli_fetch_object($exec)){

	echo $result->name.'<br>';

}






?>