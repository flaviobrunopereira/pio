<?php
/*
	* Aqui no index.php é onde tudo começa.
	* Vamos apenas carregar o controlador padrão que no caso é controlador.php
*/
ini_set('max_execution_time', '3000');
require_once 'config/config.php';
$controlador = new Controlador(); // Cria um objeto Controlador
$controlador->index(); // Chama o método index() do controlador
?>