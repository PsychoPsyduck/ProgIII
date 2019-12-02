<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\menuController;

include_once __DIR__ . '/../../src/app/modelORM/menu.php';
include_once __DIR__ . '/../../src/app/modelORM/menuController.php';

return function (App $app) {
    $container = $app->getContainer();
     $app->group('/menu', function () {   
         
        $this->post('/registrar', menuController::class . ':RegistrarComida')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/modificar', menuController::class . ':ModificarComida')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/listar', menuController::class . ':ListarMenu')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/bajaMenu', menuController::class . ':BajaMenu')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken'); 

    });
};