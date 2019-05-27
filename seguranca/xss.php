<form method="POST">
	<input type="text" name="a">
	<button>Send</button>
</form>
<?php 


if($_SERVER['REQUEST_METHOD'] === "POST"){

	echo strip_tags($_POST['a']);

}



?>