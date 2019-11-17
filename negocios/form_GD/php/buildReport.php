<?php 

require_once "Autoloader.php";
Autoloader::register();

if($_SERVER['REQUEST_METHOD'] === "POST" ){



		if(isset($_POST['reporting_officer']) && $_POST['reporting_officer'] != " "){

			if(isset($_POST['officer']) && $_POST['officer'] != " "){

				if(isset($_POST['incident']) && $_POST['incident'] != " "){

					$GD = new GD();

					$GD->buildReport(rand(1313,2389),$_POST['reporting_officer'],$_POST['officer'],trim($_POST['incident']));

				}

			}

		}

	

	


	


}


?>