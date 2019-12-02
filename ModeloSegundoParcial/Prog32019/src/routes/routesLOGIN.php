<?php

use App\Models\ORM\listadoController;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\userController;

include_once __DIR__ . '/../../src/app/modelORM/user.php';
include_once __DIR__ . '/../../src/app/modelORM/userController.php';
include_once __DIR__ . '/../../src/app/modelPDO/listadoController.php';

return function (App $app) {
    $container = $app->getContainer();

     $app->group('/login', function () {   

        $this->post('/',userController::class . ':IniciarSesion')->add(Middleware::class . ":log");
    });

    $app->group('/ingreso', function () {   

        $this->put('/ingresoUsuario',userController::class . ':ingresoUsuario')->add(Middleware::class . ":log")->add(Middleware::class . ":validarToken")->add(Middleware::class . ":log");

        $this->get('/mostrarAdmin',listadoController::class . ':traerUltimosIngresos')->add(Middleware::class . ":log")->add(Middleware::class . ":validarToken");
    
        $this->get('/mostrar',listadoController::class . ':TraerUno')->add(Middleware::class . ":log")->add(Middleware::class . ":validarToken");

    });
    $app->group('/egreso', function () {   

        $this->put('/egresoUsuario',userController::class . ':egresoUsuario')->add(Middleware::class . ":log")->add(Middleware::class . ":validarToken")->add(Middleware::class . ":log");
    });


};