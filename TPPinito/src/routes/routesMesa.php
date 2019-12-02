<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\mesaController;

include_once __DIR__ . '/../../src/app/modelORM/mesa.php';
include_once __DIR__ . '/../../src/app/modelORM/mesaController.php';

return function (App $app) {
    $container = $app->getContainer();
     $app->group('/mesa', function () {   
         
        $this->post('/registrar', mesaController::class . ':RegistrarMesa')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/listar', mesaController::class . ':ListarMesas')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');
        
        $this->delete('/{codigo}', mesaController::class . ':BajaMesa')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/foto', mesaController::class . ':ActualizarFotoMesa')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarMozo')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/estadoEsperando', mesaController::class . ':CambiarEstado_EsperandoPedido')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarMozo')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/estadoComiendo', mesaController::class . ':CambiarEstado_Comiendo')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarMozo')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/estadoPagando', mesaController::class . ':CambiarEstado_Pagando')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarMozo')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/estadoCerrada', mesaController::class . ':CambiarEstado_Cerrada')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/cobrar', mesaController::class . ':CobrarMesa')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/MasUsada', mesaController::class . ':MesaMasUsada')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/MenosUsada', mesaController::class . ':MesaMenosUsada')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/MasFacturacion', mesaController::class . ':MesaMasFacturacion')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/MenosFacturacion', mesaController::class . ':MesaMenosFacturacion')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/ConFacturaConMasImporte', mesaController::class . ':MesaConFacturaConMasImporte')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/ConFacturaConMenosImporte', mesaController::class . ':MesaConFacturaConMenosImporte')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/ConMejorPuntuacion', mesaController::class . ':MesaConMejorPuntuacion')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/ConPeorPuntuacion', mesaController::class . ':MesaConPeorPuntuacion')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/FacturacionEntreFechas', mesaController::class . ':MesaFacturacionEntreFechas')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken'); 
    });
};