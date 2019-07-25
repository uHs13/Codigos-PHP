<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<form method="POST" style='margin: 10px 10px;'>
	<input type="text" name="a" style='width: 400px;' class='form-control'>
	<button class='btn btn-primary mt-2'>Enviar</button>
</form>

<div style='margin: 10px 10px' class='mt-3'>  

	<?php 


	if($_SERVER['REQUEST_METHOD'] === "POST"){

		echo strip_tags($string);

	}


	?>

</div>

