<!DOCTYPE html>
<html>
<head>
	<title>List Users</title>
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
	<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
	
	<link rel='stylesheet'  href='../css/listUsers.css'>
	

</head>
<body>

	<main>
		
		<?php 

		include_once "../config/Autoloader.php";
		Autoloader::register();

		echo "<table class='table  w-50 p-3 text-center'>";
		echo"<thead >";
		echo"<tr>";
		echo"<th class='text-white'>Name</th>";
		echo"<th class='text-white'>E-Mail</th>";
		echo"<th class='text-white'>CPF</th>";
		echo"</tr>";
		echo"</thead>";
		echo"<tbody>";
		$file = new Arquivo('../file/users.csv','r+');

		$users = $file->readCsv();



		foreach ($users as $key => $user) {

			echo "<tr>";

			foreach ($user as $key => $value) {


				echo "<td>".$value."</td>";

			}

			echo "</tr>";


		}

		echo "</tbody>";

		echo "</table>";

		?>

	
		<section class='option-box'>

			<a href="../index.html">Voltar</a>			


		</section>

</main>

</body>
</html>


