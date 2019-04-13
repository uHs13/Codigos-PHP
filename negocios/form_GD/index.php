<!DOCTYPE html>
<html>
<head>
	<title>Report Form</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500" rel="stylesheet">
	<link rel="stylesheet" href="css/index.css">
</head>
<body>

	<main>

		<section class='img-container'>
			


		</section>
		

		<section class='form-container'>

			<h3>Registro de Ocorrência</h3>

			<form method='POST' action='php/buildReport.php' target='_blank'>
				
				<input type="text" name="reporting_officer" placeholder="Oficial" required>

				<input type="text" name="officer" placeholder="Registro" required>

				<textarea name='incident' placeholder="Incidente"></textarea>

				<button>Enviar</button>

			</form>

		</section>

	</main>

</body>
</html>