<?php 
	

if($_SERVER['REQUEST_METHOD'] === "POST" ){
	
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);//retira as verificações SSL
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//^^^^ 
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(//função do PHP que tranforma um array em uma queryString
		'secret'=>'6LcLqqQUAAAAAC8E5cDGD8BG3W5Uh4i0zNOjS7Of',
		'response'=>$_POST['g-recaptcha-response'],
		'remoteip'=>$_SERVER['REMOTE_ADDR']
	)));

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//server devolve a informação
							//passando true para ele ser um array ( sem isso ele vira um objeto )
	$recaptcha = json_decode(curl_exec($ch),true);

	curl_close($ch);//fecha a conexão

	var_dump($recaptcha);

	if($recaptcha['success']){

		echo "

			<script>alert('OK')</script>

		";

	} else {

		header('Location: recaptcha.php');

	}


}


?>