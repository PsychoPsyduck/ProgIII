<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
// use Slim\Factory\AppFactory;

require_once 'vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

// $app = AppFactory::create();
$app = new \Slim\App(["settings" => $config]);

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