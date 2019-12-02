<?php
namespace App\Models\ORM;
use App\Models\PDO\pedido;
use App\Models\IApiControler;
use App\Models\AutentificadorJWT;

include_once __DIR__ . '../../modelPDO/pedido.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class pedidoController implements IApiControler
{
    ///Registro de nuevos pedidos.
    public function RegistrarPedido($request, $response, $args){
        $parametros = $request->getParsedBody();
        $id_mesa = $parametros["id_mesa"];        
        $id_menu  = $parametros["id_menu"];
        $nombre_cliente = $parametros["cliente"];
        
        $token = $request->getHeader('Token')[0];
        $id_mozo = AutentificadorJWT::ObtenerID($token);    

        $respuesta = pedido::Registrar($id_mesa,$id_menu,$id_mozo,$nombre_cliente);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los pedidos
    public function ListarTodosLosPedidos($request,$response,$args){
        $respuesta = pedido::ListarTodos();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los pedidos por Fecha
    public function ListarTodosLosPedidosPorFecha($request,$response,$args){
        $parametros = $request->getParsedBody();
        $fecha = $parametros["fecha"];  
        $respuesta = pedido::ListarTodosPorFecha($fecha);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los pedidos por mesa
    public function ListarTodosLosPedidosPorMesa($request,$response,$args){
        $parametros = $request->getParsedBody();
        $mesa = $parametros["codigo"];
        $respuesta = pedido::ListarPorMesa($mesa);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los pedidos activos. Muestra los que correspondan según el perfil.
    public function ListarPedidosActivos($request,$response,$args){
        $token = $request->getHeader('Token')[0];
        $id_empleado = AutentificadorJWT::ObtenerID($token);
        $sector = AutentificadorJWT::ObtenerTipo($token);
        $respuesta = pedido::ListarActivosPorSector($sector,$id_empleado);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todos los pedidos cancelados
    public function ListarTodosLosPedidosCancelados($request,$response,$args){
        $respuesta = pedido::ListarCancelados();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Cancela un pedido.
    public function CancelarPedido($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];
        $respuesta = pedido::Cancelar($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    //Uno de los empleados toma el pedido para prepararlo, agregando un tiempo estimado de preparación.
    public function TomarPedidoPendiente($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];  
        $minutosEstimados = $parametros["minutosEstimados"];  
        $token = $request->getHeader('Token')[0];
        $id_encargado = AutentificadorJWT::ObtenerID($token);
        $respuesta = pedido::TomarPedido($codigo,$id_encargado,$minutosEstimados);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Se informa que el pedido está listo para servir.
    public function InformarPedidoListoParaServir($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];  
        $respuesta = pedido::InformarListoParaServir($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Devuelve el tiempo restante
    public function TiempoRestantePedido($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];
        $respuesta = pedido::TiempoRestante($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Servir Pedido
    public function ServirPedido($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];  
        $respuesta = pedido::Servir($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lo menos vendido
    public function LoMenosVendido($request,$response,$args){
        $respuesta = pedido::MenosVendido();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lo más vendido
    public function LoMasVendido($request,$response,$args){
        $respuesta = pedido::MasVendido();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    //Lista los pedidos fuera del tiempo estipulado.
    public function ListarPedidosFueraDelTiempoEstipulado($request,$response,$args){
        $respuesta = pedido::ListarFueraDelTiempoEstipulado();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

}
