<?php  
namespace Hcode;

use Rain\Tpl;
use Hcode\DB\Sql;

class Mailer 
{

	private $mail;

	public $email; 
	public $password;
	public $fakename;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{
		$this->email = $this->getInfo()['email'];
		$this->password = $this->getInfo()['pass'];
		$this->fakename = "The GS";

		$path = $_SERVER["DOCUMENT_ROOT"]."/PHP/ecommerce";

		$config = array(//configurando as opções do RainTpl
			
			"tpl_dir"   => $path.'/views/email/',//pasta onde o rain vai procurar os arquivos HTML
			"cache_dir" => $path."/views-cache/",//página de cache onde o rain armazena os templates já com php
			"debug"     => false // set to false to improve the speed
		
		);

		Tpl::configure( $config );//passa as configurações iniciais para a classe Tpl

		// create the Tpl object
		$tpl = new Tpl;//adicionado como atributo da classe para podermos ter acesso em outros 


		foreach ($data as $key => $value) {
			
			$tpl->assign($key, $value);

		}

		//true para ele não jogar na tela
		$html = $tpl->draw($tplName, true);

		//Create a new PHPMailer instance
		$this->mail = new \PHPMailer;
		//Tell PHPMailer to use SMTP
		$this->mail->isSMTP();
		
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$this->mail->SMTPDebug = 0;


		//Set the hostname of the mail server
		$this->mail->Host = 'smtp.gmail.com';
		// use
		// $this->mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6
		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$this->mail->Port = 587;

		$this->mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		//Set the encryption system to use - ssl (deprecated) or tls
		$this->mail->SMTPSecure = 'tls';
		//Whether to use SMTP authentication
		$this->mail->SMTPAuth = true;
		//Username to use for SMTP authentication - use full email address for gmail
		$this->mail->Username = $this->email;
		//Password to use for SMTP authentication
		$this->mail->Password = $this->password;
		//Set who the message is to be sent from
		$this->mail->setFrom($this->email, $this->fakename);
		//Set an alternative reply-to address
		//$this->mail->addReplyTo('replyto@example.com', 'First Last');
		//Set who the message is to be sent to
		$this->mail->addAddress($toAddress, $toName);
		//Set the subject line
		$this->mail->Subject = utf8_decode($subject);
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$this->mail->msgHTML(utf8_decode($html));
		//Replace the plain text body with one created manually
		$this->mail->AltBody = 'Corpo do Email';
		//Attach an image file
		//$this->mail->addAttachment('images/phpmailer_mini.png');
	
	}//construct


	public function getInfo()
	{

		$sql = new Sql();

		$results = $sql->select('CALL sp_getHostEmail()');

		return $results[0];

	}

	public function send()
	{

		return $this->mail->send();

	}


}// Mailer

?>