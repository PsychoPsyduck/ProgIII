<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\empleadoController;

include_once __DIR__ . '/../../src/app/modelORM/empleado.php';
include_once __DIR__ . '/../../src/app/modelORM/empleadoController.php';

return function (App $app) {
    $container = $app->getContainer();
     $app->group('/empleado', function () {   
         
        $this->post('/login', empleadoController::class . ':LoginEmpleado');

        $this->post('/registrarEmpleado', empleadoController::class . ':RegistrarEmpleado')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/listar', empleadoController::class . ':ListarEmpleados')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->delete('/{id}', empleadoController::class . ':BajaEmpleado')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->delete('/suspender/{id}', empleadoController::class . ':SuspenderEmpleado')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/modificar', empleadoController::class . ':ModificarEmpleado')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/cambiarClave', empleadoController::class . ':CambiarClaveEmpleado')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/cantidadOperacionesPorSector', empleadoController::class . ':ObtenerCantidadOperacionesPorSector')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/cantidadOperacionesEmpleadosPorSector', empleadoController::class . ':ObtenerCantidadOperacionesEmpleadosPorSector')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/listarEntreFechasLogin', empleadoController::class . ':ListarEmpleadosEntreFechasLogin')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/listarEntreFechasRegistro', empleadoController::class . ':ListarEmpleadosEntreFechasRegistro')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');
    });
};