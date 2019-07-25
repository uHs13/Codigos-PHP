<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!DOCTYPE html>
<html>
<head>
	<title>Recaptcha</title>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class='m-3'>
	<main>
		
		<form action='cadastro.php' method='POST'>
			<div class="g-recaptcha" data-sitekey="6LcLqqQUAAAAAFsEe31K58knEBVCzTAHqVx8xhZR"></div>
			<div class='form-group'>
				<input type="text" name="email" class='form-control mt-2' style='width: 250px;' placeholder='Email'>
				<button class='btn btn-success mt-1'>Enviar</button>
			</div>
			

		</form>

	</main>
</body>
</html>
