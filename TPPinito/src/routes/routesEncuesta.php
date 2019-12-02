<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\encuestaController;

include_once __DIR__ . '/../../src/app/modelORM/encuesta.php';
include_once __DIR__ . '/../../src/app/modelORM/encuestaController.php';

return function (App $app) {
    $container = $app->getContainer();
     $app->group('/encuesta', function () {   
         
        $this->post('/registrar', encuestaController::class . ':RegistrarEncuesta')
        ->add(\EncuestaMiddleware::class . ':ValidarEncuesta');

        $this->get('/listar', encuestaController::class . ':ListarEncuestas')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/listarEntreFechas', encuestaController::class . ':ListarEncuestasEntreFechas')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken'); 
    });
};