<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\userController;

include_once __DIR__ . '/../../src/app/modelORM/user.php';
include_once __DIR__ . '/../../src/app/modelORM/userController.php';

return function (App $app) {
    $container = $app->getContainer();

     $app->group('/users', function () {   
         
        $this->get('/',userController::class . ':traerTodos');

        $this->post('/new',userController::class . ':CargarUno')->add(Middleware::class . ":log");

        $this->post('/logIn',userController::class . ':IniciarSesion')->add(Middleware::class . ":log");
        
        $this->post('/modificar',userController::class . ':ModificarUno');
    });

};