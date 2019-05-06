<?php  

require_once("vendor/autoload.php");

// namespace
use Rain\Tpl;

// config
$config = array(
    "tpl_dir"       => "templates/simple/",//diretorio de templates
    "cache_dir"     => "cache/"//diretório de cache
);

Tpl::configure( $config );//variável com as configurações do raintpl

// Add PathReplace plugin (necessary to load the CSS with path replace)
Tpl::registerPlugin( new Tpl\Plugin\PathReplace() );

// create the Tpl object
$tpl = new Tpl;

// assign a variable
$tpl->assign( "name", "Named Namer" );
$tpl->assign( "age", "35" );
$tpl->assign( "birth", "08/07/1984" );

// assign an array
$tpl->assign( "random", array( "Listen music", "watch videos", "Work", "study", "sleep", "listen music again", "chapter 4, verse 3" ) );

// draw the template
$tpl->draw( "simple_template" );//nome do arquivo com o template. Por padrão procura por .html

?>

