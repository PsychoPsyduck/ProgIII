<?php
namespace App\Models\ORM;
use App\Models\PDO\encuesta;
use App\Models\IApiControler;
use App\Models\AutentificadorJWT;

include_once __DIR__ . '../../modelPDO/encuesta.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class encuestaController implements IApiControler
{
    ///Registro de nueva encuesta.
    public function RegistrarEncuesta($request, $response, $args){
        $parametros = $request->getParsedBody();
        $puntuacionMesa = $parametros["puntuacionMesa"];
        $codigoMesa = $parametros["codigoMesa"];
        $puntuacionRestaurante = $parametros["puntuacionRestaurante"];
        $puntuacionMozo = $parametros["puntuacionMozo"];
        $puntuacionCocinero = $parametros["puntuacionCocinero"];
        $comentario = $parametros["comentario"];
        
        $respuesta = encuesta::Registrar($puntuacionMesa,$codigoMesa,$puntuacionRestaurante,$puntuacionMozo,$puntuacionCocinero,$comentario);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Listar encuestas
    public function ListarEncuestas($request,$response,$args){
        $respuesta = encuesta::Listar();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista todas las encuestas entre las fechas
    public function ListarEncuestasEntreFechas($request,$response,$args){
        $parametros = $request->getParsedBody();
        $fecha1 = $parametros["fecha1"];
        $fecha2 = $parametros["fecha2"];
        $respuesta = encuesta::ListarEntreFechas($fecha1,$fecha2);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    } 

}
