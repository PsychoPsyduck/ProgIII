<?php
namespace App\Models\ORM;
use App\Models\PDO\mesa;
use App\Models\PDO\foto;
use App\Models\IApiControler;
use App\Models\AutentificadorJWT;

include_once __DIR__ . '../../modelPDO/mesa.php';
include_once __DIR__ . '../../modelPDO/foto.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class mesaController implements IApiControler
{
    ///Registro de nuevos empleados.
    public function RegistrarMesa($request, $response, $args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];            
        if($codigo != null && $codigo != "" && $codigo != " ") {
            $respuesta = mesa::Registrar($codigo);
        }
        else {
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Codigo vacio.");
        }
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todas las mesas
    public function ListarMesas($request,$response,$args){
        $respuesta = mesa::Listar();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Da de baja una mesa
    public function BajaMesa($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"]; 
        //$codigo = $args["codigo"];
        $respuesta = mesa::Baja($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Actualiza la foto de la mesa
    public function ActualizarFotoMesa($request, $response, $args){
        $parametros = $request->getParsedBody();
        $files = $request->getUploadedFiles();
        $codigoMesa = $parametros["codigo"];
        $foto = $files["foto"];
 
        //Consigo la extensión de la foto.  
        $ext = \foto::ObtenerExtension($foto);
        
        if($ext != "ERROR"){
            //Guardo la foto.
            $rutaFoto = "./Fotos/Mesas/".$codigoMesa.".".$ext;
            \foto::GuardarFoto($foto,$rutaFoto);

            $respuesta = mesa::ActualizarFoto($rutaFoto,$codigoMesa);
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }
        else{
            $respuesta = "Ocurrio un error.";
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }        
    }

    ///Cambio de estado: Con cliente esperando pedido
    public function CambiarEstado_EsperandoPedido($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];
        if($codigo != null && $codigo != "" && $codigo != " ") {
            $respuesta = mesa::EstadoEsperandoPedido($codigo);
        }
        else {
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Codigo vacio.");
        }
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Cambio de estado: Con clientes comiendo
    public function CambiarEstado_Comiendo($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];
        
        if($codigo != null && $codigo != "" && $codigo != " ") {
            $respuesta = mesa::EstadoComiendo($codigo);
        }
        else {
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Codigo vacio.");
        }
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Cambio de estado: Con clientes pagando
    public function CambiarEstado_Pagando($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];
        if($codigo != null && $codigo != "" && $codigo != " ") {
            $respuesta = mesa::EstadoPagando($codigo);
        }
        else {
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Codigo vacio.");
        }
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Cambio de estado: Cerrada
    public function CambiarEstado_Cerrada($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];
        if($codigo != null && $codigo != "" && $codigo != " ") {
            $respuesta = mesa::EstadoCerrada($codigo);
        }
        else {
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Codigo vacio.");
        }
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Calcula el importe final y genera la factura. Finaliza todos los pedidos de la mesa. 
    public function CobrarMesa($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];
        $respuesta = mesa::Cobrar($codigo);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa más usada.
    public function MesaMasUsada($request,$response,$args){
        $respuesta = mesa::MasUsada();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa menos usada.
    public function MesaMenosUsada($request,$response,$args){
        $respuesta = mesa::MenosUsada();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que más facturó
    public function MesaMasFacturacion($request,$response,$args){
        $respuesta = mesa::MasFacturacion();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que menos facturó
    public function MesaMenosFacturacion($request,$response,$args){
        $respuesta = mesa::MenosFacturacion();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que tiene la factura con más importe
    public function MesaConFacturaConMasImporte($request,$response,$args){
        $respuesta = mesa::ConFacturaConMasImporte();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que tiene la factura con menos importe
    public function MesaConFacturaConMenosImporte($request,$response,$args){
        $respuesta = mesa::ConFacturaConMenosImporte();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que tiene la mejor puntuacion
    public function MesaConMejorPuntuacion($request,$response,$args){
        $respuesta = mesa::ConMejorPuntuacion();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Mesa que tiene la peor puntuacion
    public function MesaConPeorPuntuacion($request,$response,$args){
        $respuesta = mesa::ConPeorPuntuacion();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Facturacion entre 2 fechas para una mesa
    public function MesaFacturacionEntreFechas($request,$response,$args){
        $parametros = $request->getParsedBody();
        $codigo = $parametros["codigo"];
        $fecha1 = $parametros["fecha1"];
        $fecha2 = $parametros["fecha2"];
        $respuesta = mesa::FacturacionEntreFechas($codigo,$fecha1,$fecha2);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

}
