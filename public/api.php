<?php
include "../vendor/autoload.php";

ini_set("display_errors",1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$require = $_SERVER['REQUEST_URI'];

/** @var list<array{route:string,class:class-string,method:string}> $routes */
$routes = [
    [
        "route"=>"/api/id/checkIssetClient",
        "class"=> \Flow\Id\Web\Auth::class,
        "method"=>"checkIssetClient"
    ],
    [
        "route"=>"/api/id/register",
        "class"=> \Flow\Id\Web\Auth::class,
        "method"=>"register"
    ],
    [
        "route"=>"/api/id/passwordAuth",
        "class"=> \Flow\Id\Web\Auth::class,
        "method"=>"passwordAuth"
    ],
    [
        "route"=>"/api/id/checkAuth",
        "class"=> \Flow\Id\Web\Dashboard::class,
        "method"=>"checkAuth"
    ],
    [
        "route"=>"/api/id/email/get",
        "class"=> \Flow\Id\Web\Profile\Email::class,
        "method"=>"getEmailList"
    ],
    [
        "route"=>"/api/id/email/getItem",
        "class"=> \Flow\Id\Web\Profile\Email::class,
        "method"=>"getEmailItem"
    ],
    [
        "route"=>"/api/id/email/add",
        "class"=> \Flow\Id\Web\Profile\Email::class,
        "method"=>"addNewEmail"
    ],
    [
        "route"=>"/api/id/email/delete",
        "class"=> \Flow\Id\Web\Profile\Email::class,
        "method"=>"deleteEmail"
    ]
];


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
        "text"=>$e->getMessage()
    ]);
} catch (Error $e){
    echo json_encode([
        "success"=>false,
        "code"=>500,
        "text"=>$e->getMessage()
    ]);
}

