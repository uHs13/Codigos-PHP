<?php 

require_once 'config/Autoloader.php';

Autoloader::register();

/*
$user = new UsuarioDB();

$usuarios = UsuarioDB::search('Vialpando');
//O método search retorna um array de arrays, logo temos que fazer um foreach para percorrer cada usuário encontrado e montar o objeto com os valores;


foreach($usuarios as $data){

	
	$user->setUserData($data);	
	//monta um objeto UsuarioDB com os dados retornados do banco


}

$file = new Arquivo('file/first.txt','a+');

//Adiciona o objeto no arquivo
$file->write($user);
*/
/*
$sql = new Sql();
$file = new Arquivo('file/users.csv','w+');
*/

// $Db_csv = new Db_csv('file/users.csv','w+','select idUsuario,login,pass,dtRegister from usuario');
//Dir::createDir('_res');

//$arq = new Arquivo('_exclude/teste.csv','w');

//$arq->createSeveral('_exclude',array('teste1.txt','teste2.txt','teste3.txt','teste4.txt'));

/*	removendo um diretório com arquivos ( Somente Arquivos ) dentro
$dir = new Dir();


$dir->removeDir('_exclude');
*/

/* lendo um csv 
$file = new Arquivo('file/users.csv','a+');



$json = json_encode($file->readCsv());

echo $json;
*/

// $arq = new Arquivo('_res/racionais.jpg','r+');
// $arq->showImage

 //Upload de arquivos 

//Guarda qual o tipo da solicitação enviada


/* Como trabalha o parse_url

$url = 'https://pages.stolaf.edu/americanmusic/wp-content/uploads/sites/593/2018/05/ice-cube-and-nwa.jpg';

$parse = parse_url($url);

echo json_encode($parse);

*/


/*Movendo arquivos

Arquivo::swapFilePath('folder_01/teste.txt','folder_02');

*/



?>


