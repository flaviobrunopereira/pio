<?php
// header('Content-Type: text/html; charset=utf-8');
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

use Illuminate\Database\Eloquent\Model;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Para converter para controllers só para desenvolvimento

$router->get('/api/ping', function () use ($router){
    return "ping";
});

# Código para gerar nova chave
#$router->get('/key', function() {
#    return \Illuminate\Support\Str::random(32);
#});

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

$router->get('/update_db', ['middleware' => 'IPAddresses', function(Illuminate\Http\Request $request) use ($router) {


}]);


$router->get('/read_db', function() use ($router) {
    $results = app('db')->select("SELECT * FROM pio.migrations");
    echo json_encode($results);
});


$router->get('/read_db_facade', function() use ($router) {
     $results = app('db')->select("SELECT * FROM pio.migrations");
    echo json_encode($results);
});

// Populate DB
$router->get('/updateStudents', 'DataController@updateStudents');
//$router->get('/listStudents', 'DataController@listStudents');
$router->get('/listStudents','JsonController@listStudents');

$router->get('/uniqueStudents', 'DataController@detailStudents');
$router->get('/retrieveTeachers', 'DataController@retrieveTeachers');
