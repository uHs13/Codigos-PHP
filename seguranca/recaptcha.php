<?php 





?>
<!DOCTYPE html>
<html>
<head>
	<title>Recaptcha</title>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
	<main>
		
		<form action='cadastro.php' method='POST'>
			<div class="g-recaptcha" data-sitekey="6LcLqqQUAAAAAFsEe31K58knEBVCzTAHqVx8xhZR"></div>
			<input type="text" name="email">
			<button>Enviar</button>

		</form>

	</main>
</body>
</html>
