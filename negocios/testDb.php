<?php 
//NÃO CRIAR ARQUIVOS QUE VÃO USAR O AUTOLOADER DENTRO DE SUBPASTA DE PASTA. EX.: DENTRO DA phpDbItens.
require_once "../config/Autoloader.php";

Autoloader::register();

//CONEXÃO MYSQL DIRETA
/*$var = new ConexaoBD('127.0.0.1','root','','php7');//Banco MYSQL;

$var->toTable();

//Como o bootstrap é incluido no arquivo ConexaoBD.php podemos utilizá-lo aqui;
echo "<a href='../negocios' class='btn btn-outline-warning text-secondary' style='margin-left:45%;margin-top:13px;'>Voltar</a>";
*/


//CONEXAO PDO
//dbname,host,user,pass;
$var = new BdPdo('php7','127.0.0.1','root','');

$var->deleteUser(4);
$var->userstoTable();

echo "<a href='../negocios' class='btn btn-outline-warning text-secondary ' style='margin-left:45%;margin-top:13px;'>Voltar</a>";


?>