<?php 

$gangsta = array();

array_push($gangsta, array('nome'=>'Ice Cube','affiliation'=>'NWA'));
array_push($gangsta, array('nome'=>'Dr.Dre','affiliation'=>'NWA'));
array_push($gangsta, array('nome'=>'WC','affiliation'=>'Westside Connection'));

//print_r($gangsta[0]['affiliation']); printar arrays
//print_r($gangsta[1]);
echo json_encode($gangsta);
echo "<br><br>";

$json = '[{"nome":"Ice Cube","affiliation":"NWA"},{"nome":"Dr.Dre","affiliation":"NWA"},{"nome":"WC","affiliation":"Westside Connection"}]';

$dado = json_decode($json,true);//se nao passar true vira objeto

var_dump($dado);

?>