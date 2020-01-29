<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use GuzzleHttp\Exception\ClientException;

// temporary to debug should be on a another section
// controllers only to store
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Para converter para controllers só para desenvolvimento

$router->get('/api/', function () use ($router){
    return "ping";
});

// testes de token
$router->get('/api/ping', ['middleware' => 'auth' , function () use ($router){
    return "pong";
}]);

# Código para gerar nova chave
//$router->get('/key', function() {
//    return \Illuminate\Support\Str::random(32);
//});

# Chamadas diretas a api
$router->get('/live/students', function(Illuminate\Http\Request $request) use ($router) {
    $client = new \GuzzleHttp\Client();
    $url = env("PIO_URL") . '/asservices/rest/v1/studentservice/retrieveouenrolledstudents';
    $username = env("PIO_USERNAME");
    $password = env("PIO_PASSWORD");
    $body = array(
        'ou' => "ISCAC",
        'lectiveYear' => "201920"
        );

    $options= array(
        'auth' => [
            $username,
            $password
        ],
        'headers'  => ['content-type' => 'application/json', 'charset' => 'utf-8', 'Accept' => 'application/json'],
        'json' => $body,
        'debug' => false,
        'verify' =>false
    );

    try {
        $query = $client->post($url, $options);
        if($request->wantsJSON()){return response()->json($query->getBody());
        }

        echo $query->getBody();
    } catch (ClientException $e) {
        echo $e->getRequest() . "\n";
        echo "Erro";
    }
});


$router->get('/api/students', function() use ($router) {
    $results = app('db')->select("SELECT * FROM pio.student_detail");
    echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
});


$router->get('/api/student/{id:[0-9]{10}}', function($id = null) {
    $detail = DB::table("student_detail")->where('numSGA', $id)->first();
    $contact = DB::table("student_contact")->where('numInt', $detail->numInt)->first();
    $academic = DB::table("student_academic")->where('numSGA', $id)->first();
    $merged = array_merge((array)$detail, (array)$contact);
    $merged = array_merge((array)$merged, (array)$academic);
    return json_encode($merged, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
});

$router->get('/api/teacher/{id:[0-9]{2,6}}', function($id = null) {
    $teacher = DB::table("employeedetails")->where('employeeNumber', $id)->first();
    return json_encode($teacher, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
});

// Populate DB
$router->get('/updateStudents', 'DataController@updateStudents');
//$router->get('/listStudents', 'DataController@listStudents');
$router->get('/listStudents', 'JsonController@listStudents');
$router->get('/listTeachers', 'JsonController@listTeachers');


// Rota temporária apenas para testes
$router->get('/listTeachers2', 'JsonController@listTeachers2');
$router->get('/listEmployees2', 'JsonController@listEmployees2');
$router->get('/listCourses', 'JsonController@listCourses');
// Fim de testes



$router->get('/listEmployees', 'JsonController@listEmployees');
$router->get('/uniqueStudents', 'DataController@detailStudents');
$router->get('/retrieveTeachers', 'DataController@retrieveTeachers');
