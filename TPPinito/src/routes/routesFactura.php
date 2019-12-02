<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\facturaController;

include_once __DIR__ . '/../../src/app/modelORM/factura.php';
include_once __DIR__ . '/../../src/app/modelORM/facturaController.php';

return function (App $app) {
    $container = $app->getContainer();
     $app->group('/factura', function () {
         
        $this->get('/listarVentasPDF', facturaController::class . ':ListarVentasPDF')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/listarVentasExcel', facturaController::class . ':ListarVentasExcel')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/listarEntreFechas', facturaController::class . ':ListarFacturasEntreFechas')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken'); 
    });
};