<?php

session_start();

//toda vez que verificar o login e a senha reinicie a sessão
session_destroy();

session_start();

session_regenerate_id();

echo session_id();

?>