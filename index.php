<?php
/*
	* Aqui no index.php � onde tudo come�a.
	* Vamos apenas carregar o controlador padr�o que no caso � controlador.php
*/
ini_set('max_execution_time', '3000');
require_once 'config/config.php';
$controlador = new Controlador(); // Cria um objeto Controlador
$controlador->index(); // Chama o m�todo index() do controlador
?>