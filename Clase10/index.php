<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT; //https://github.com/firebase/php-jwt ver
// use Slim\Factory\AppFactory;

require_once 'vendor/autoload.php';
include_once './Clases/Log.php';


// $log = new Log($metodo, date("d-m-Y (H:i:s)", time()),$_SERVER['SERVER_ADDR']);
// Guardar($log,$pathLog);

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$mwUno = function($request, $response, $next) {
    
    $response->getBody()->write('Antes ');

    $response = $next($request, $response);

    $response->getBody()->write(' Despues');

    return $response;
};


// $app = AppFactory::create();
$app = new \Slim\App(["settings" => $config]);

$app->add($mwUno);

$app->group("/usuarios", function() {
    $this->get('/saludar', function ($request, $response) {
        $response->getBody()->write("HOLA!");
        return $response;
    });
    $this->get('[/]', function ($request, $response) {
        $response->getBody()->write("GET => Hello world!");
        return $response;
    });
    $this->post('[/]', function ($request, $response) {
        $response->getBody()->write("POST => Hello world!");
        return $response;
    });
    $this->put('[/]', function ($request, $response) {
        $response->getBody()->write("PUT => Hello world!");
        return $response;
    });
    $this->delete('[/]', function ($request, $response) {
        $response->getBody()->write("DELETE => Hello world!");
        return $response;
    });
});


$app->run();