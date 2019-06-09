<?php 

// Para poder usar o Autoloader temos que incluir o arquivo onde ele está...
require_once "config/Autoloader.php";
Autoloader::register();


/*
$sql = new Sql();

$dataSet = $sql->select("select idUsuario,login,pass,dtRegister from usuario");

echo json_encode($dataSet);
*/


/*Carrega um usuário específico
$user = new Usuario();

$user->loadById(4);

echo $user;
*/


/* Carrega todos os usuários cadastrados 
$users = Usuario::getUsers();

echo json_encode($users);
*/

/* Retorna os dados do usuário de acrodo com o login
$user = Usuario::search('dmx');

echo json_encode($user);
*/

/*Retorna os dados de um usuário se o login e a senha passadas como parâmetro estiverem corretas

$user = new Usuario();

$user->login('Vialpando','varrios');

echo $user;

*/

/*(Inserindo um novo usuário 
$user = new Usuario('Big Smoke','followthedmantraincj');

$user->insert();

echo $user;
*/

/* Atualizando dados de um usuário 
$user = new Usuario();
$user->loadById(15);
$user->update('Heitor','1313');

echo $user;
*/

/* Excluindo um usuario
$user = new Usuario();

$user->loadById(16);

$user->delete();

echo $user;
*/

?>