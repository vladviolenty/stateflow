<?php
include "../vendor/autoload.php";
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$require = $_SERVER['REQUEST_URI'];

$routes = \Flow\Core\Route::$list;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../");
$dotenv->load();
$request = Request::createFromGlobals();
try{

    foreach ($routes as $route) {
        if($route['route']===$require){
            $method = $route['method'];
            $class = new $route['class']($request);
            /** @var Response $response */
            $response = $class->$method();
            $response->send();
            return;
        }
    }
    throw new Exception("Route not found");
} catch (Exception $e){
    echo json_encode([
        "success"=>false,
        "code"=>$e->getCode(),
        "trace"=>$e->getTrace(),
        "text"=>$e->getMessage()
    ]);
} catch (Error $e){
    echo json_encode([
        "success"=>false,
        "code"=>500,
        "trace"=>$e->getTrace(),
        "text"=>$e->getMessage()
    ]);
}

