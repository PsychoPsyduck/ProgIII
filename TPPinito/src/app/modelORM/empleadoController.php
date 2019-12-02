<?php
namespace App\Models\ORM;
use App\Models\PDO\empleado;
use App\Models\IApiControler;
use App\Models\AutentificadorJWT;

include_once __DIR__ . '../../modelPDO/empleado.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class empleadoController implements IApiControler
{
    ///Logueo de empleados.
    public function LoginEmpleado($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $usuario = $parametros["usuario"];
        $clave = $parametros["clave"];
        $retorno = empleado::Login($usuario, $clave);

        if ($retorno["tipo_empleado"] != "") {
            $datos = $usuario.$retorno["tipo_empleado"].$retorno["ID_Empleado"].$retorno["nombre_empleado"];
            $token = AutentificadorJWT::CrearToken($datos, $retorno["ID_Empleado"], $retorno["tipo_empleado"]);
            empleado::ActualizarFechaLogin($retorno["ID_Empleado"]);
            $respuesta = array("Estado" => "OK", "Mensaje" => "Logueado exitosamente.", "Token" => $token, "Nombre_Empleado" => $retorno["nombre_empleado"]);
        } else {
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Usuario o clave invalidos.");
        }
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }   

    ///Registro de nuevos empleados.
    public function RegistrarEmpleado($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $usuario = $parametros["usuario"];
        $clave = $parametros["clave"];
        $nombre = $parametros["nombre"];
        $tipo = $parametros["tipo"];


        $respuesta = empleado::Registrar($usuario, $clave, $nombre, $tipo);
        $newResponse = $response->withJson($respuesta, 200);
        
        return $newResponse;
    }

    ///Modifica un empleado
    public function ModificarEmpleado($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $usuario = $parametros["usuario"];
        $id = $parametros["id"];
        $nombre = $parametros["nombre"];
        $tipo = $parametros["tipo"];

        $respuesta = empleado::Modificar($id, $usuario, $nombre, $tipo);
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }

    ///Lista todos los empleados
    public function ListarEmpleados($request, $response, $args)
    {
        $respuesta = empleado::Listar();
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }

    ///Da de baja un empleado.
    public function BajaEmpleado($request, $response, $args)
    {
        $id = $args["id"];
        $respuesta = empleado::Baja($id);
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }

    ///Suspende un empleado.
    public function SuspenderEmpleado($request, $response, $args)
    {
        $id = $args["id"];
        $respuesta = empleado::Suspender($id);
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }

    ///Cambiar contraseña
    public function CambiarClaveEmpleado($request, $response, $args)
    {
        $token = $request->getHeader('Token')[0];
        $id = AutentificadorJWT::ObtenerID($token);

        $parametros = $request->getParsedBody();
        $clave = $parametros["clave"];
        
        $respuesta = empleado::CambiarClave($id, $clave);
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }

    ///Cantidad de operaciones de todos por sector
    public function ObtenerCantidadOperacionesPorSector($request, $response, $args)
    {
        $respuesta = empleado::CantidadOperacionesPorSector();
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }

    ///Cantidad de operaciones de todos por sector
    public function ObtenerCantidadOperacionesEmpleadosPorSector($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $sector = $parametros["sector"];
        $respuesta = empleado::CantidadOperacionesEmpleadosPorSector($sector);
        $newResponse = $response->withJson($respuesta, 200);
        return $newResponse;
    }

    ///Lista todos los empleados entre las fechas de login
    public function ListarEmpleadosEntreFechasLogin($request,$response,$args){
        $parametros = $request->getParsedBody();
        $fecha1 = $parametros["fecha1"];
        $fecha2 = $parametros["fecha2"];
        $respuesta = empleado::ListarEntreFechasLogin($fecha1,$fecha2);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    } 

    ///Lista todos los empleados entre las fechas de registro
    public function ListarEmpleadosEntreFechasRegistro($request,$response,$args){
        $parametros = $request->getParsedBody();
        $fecha1 = $parametros["fecha1"];
        $fecha2 = $parametros["fecha2"];
        $respuesta = empleado::ListarEntreFechasRegistro($fecha1,$fecha2);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    } 
}