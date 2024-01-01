<?php
include "../vendor/autoload.php";
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$require = $_SERVER['REQUEST_URI'];

/** @var list<array{route:non-empty-string,class:class-string,method:non-empty-string}> $routes */
$routes = [
    [
        "route"=>"/api/id/checkIssetClient",
        "class"=> Flow\Id\Web\Auth::class,
        "method"=>"checkIssetClient"
    ],
    [
        "route"=>"/api/id/register",
        "class"=> Flow\Id\Web\Auth::class,
        "method"=>"register"
    ],
    [
        "route"=>"/api/id/passwordAuth",
        "class"=> Flow\Id\Web\Auth::class,
        "method"=>"passwordAuth"
    ],
    [
        "route"=>"/api/id/checkAuth",
        "class"=> Flow\Id\Web\Dashboard::class,
        "method"=>"checkAuth"
    ],
    [
        "route"=>"/api/id/getBasicInfo",
        "class"=> Flow\Id\Web\Dashboard::class,
        "method"=>"getBasicInfo"
    ],
    [
        "route"=>"/api/id/killSession",
        "class"=> Flow\Id\Web\Profile\Sessions::class,
        "method"=>"killSession"
    ],
    [
        "route"=>"/api/id/session/get",
        "class"=> Flow\Id\Web\Profile\Sessions::class,
        "method"=>"get"
    ],
    [
        "route"=>"/api/id/writeMeta",
        "class"=> Flow\Id\Web\Dashboard::class,
        "method"=>"writeMetaInfo"
    ],
    [
        "route"=>"/api/id/email/get",
        "class"=> Flow\Id\Web\Profile\Email::class,
        "method"=>"getEmailList"
    ],
    [
        "route"=>"/api/id/email/getItem",
        "class"=> Flow\Id\Web\Profile\Email::class,
        "method"=>"getEmailItem"
    ],
    [
        "route"=>"/api/id/email/add",
        "class"=> Flow\Id\Web\Profile\Email::class,
        "method"=>"addNewEmail"
    ],
    [
        "route"=>"/api/id/email/delete",
        "class"=> Flow\Id\Web\Profile\Email::class,
        "method"=>"deleteEmail"
    ],
    [
        "route"=>"/api/id/phone/get",
        "class"=> Flow\Id\Web\Profile\Phones::class,
        "method"=>"get"
    ],
    [
        "route"=>"/api/id/phone/getItem",
        "class"=> Flow\Id\Web\Profile\Phones::class,
        "method"=>"getItem"
    ],
    [
        "route"=>"/api/id/phone/add",
        "class"=> Flow\Id\Web\Profile\Phones::class,
        "method"=>"add"
    ],
    [
        "route"=>"/api/id/phone/delete",
        "class"=> Flow\Id\Web\Profile\Phones::class,
        "method"=>"delete"
    ],
    [
        "route"=>"/api/workflow/getOrgList",
        "class"=> Flow\Workflow\Web::class,
        "method"=>"getOrgList"
    ],
    [
        "route"=>"/api/workflow/createOrg",
        "class"=> Flow\Workflow\Web::class,
        "method"=>"createOrg"
    ],

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

