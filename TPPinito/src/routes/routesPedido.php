<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\pedidoController;

include_once __DIR__ . '/../../src/app/modelORM/pedido.php';
include_once __DIR__ . '/../../src/app/modelORM/pedidoController.php';

return function (App $app) {
    $container = $app->getContainer();
     $app->group('/pedido', function () {   
         
        $this->post('/registrar', pedidoController::class . ':RegistrarPedido')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarMozo')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->delete('/cancelarPedido', pedidoController::class . ':CancelarPedido')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\EmpleadoMiddleware::class . ':ValidarMozo')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/listarTodos', pedidoController::class . ':ListarTodosLosPedidos')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/listarCancelados', pedidoController::class . ':ListarTodosLosPedidosCancelados')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/listarTodosPorFecha', pedidoController::class . ':ListarTodosLosPedidosPorFecha')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/listarPorMesa', pedidoController::class . ':ListarTodosLosPedidosPorMesa');

        $this->get('/listarActivos', pedidoController::class . ':ListarPedidosActivos')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/tomarPedido', pedidoController::class . ':TomarPedidoPendiente')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\PedidoMiddleware::class . ':ValidarTomarPedido')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/listoParaServir', pedidoController::class . ':InformarPedidoListoParaServir')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\PedidoMiddleware::class . ':ValidarInformarListoParaServir')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/servir', pedidoController::class . ':ServirPedido')
        ->add(\OperacionMiddleware::class . ':SumarOperacionAEmpleado')
        ->add(\PedidoMiddleware::class . ':ValidarServir')
        ->add(\EmpleadoMiddleware::class . ':ValidarMozo')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->post('/tiempoRestante', pedidoController::class . ':TiempoRestantePedido');

        $this->get('/listarFueraDelTiempoEstipulado', pedidoController::class . ':ListarPedidosFueraDelTiempoEstipulado')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/MasVendido', pedidoController::class . ':LoMasVendido')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');

        $this->get('/MenosVendido', pedidoController::class . ':LoMenosVendido')
        ->add(\EmpleadoMiddleware::class . ':ValidarSocio')
        ->add(\EmpleadoMiddleware::class . ':ValidarToken');  
    });
};