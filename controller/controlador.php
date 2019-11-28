<?php
/*
	* O Controller � respons�vel por receber as requisi��es do usu�rio.
	* Al�m disso o Controller tamb�m faz as comunica��es com o Model e a View
*/



require_once 'model/modelo.php'; // Carrega o arquivo modelo.php
class Controlador {

    // Normalmente o m�todo padr�o dos controladores � chamado de index
    public function index() {
        $modelo = new Modelo(); // Cria um objeto Modelo
        $mensagem = $modelo->getMensagem(); // Chama o m�todo getMensagem() do modelo
        require_once 'view/view.php'; // Carrega o arquivo view.php
    }


    public function list_students() {
        $students = new PioRest(); // Cria um objeto Modelo
        $estudantes = $students->getStudents(); // Chama o m�todo getMensagem() do modelo
       // require_once 'view/view.php'; // Carrega o arquivo view.php

    }



    public function list_courses() {
        $courses = new PioRest(); // Cria um objeto Modelo
        $cursos = $courses->getCourses(); // Chama o m�todo getMensagem() do modelo
      //  require_once 'view/view.php'; // Carrega o arquivo view.php

    }


    public function courses() {
        $courses = new PioRest(); // Cria um objeto Modelo
        $cursos = $courses->getCourses(); // Chama o m�todo getMensagem() do modelo
        require_once 'view/courses.php'; // Carrega o arquivo view.php

    }

}
?>