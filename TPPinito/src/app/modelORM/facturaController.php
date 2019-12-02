<?php
namespace App\Models\ORM;
use App\Models\PDO\factura;
use App\Models\IApiControler;
use App\Models\AutentificadorJWT;

include_once __DIR__ . '../../modelPDO/factura.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class facturaController implements IApiControler
{
    ///Publica las facturas a pdf.
    public function ListarVentasPDF($request,$response,$args){
        //$respuesta = factura::ListarPDF();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    } 

    ///Publica las facturas a excel.
    public function ListarVentasExcel($request,$response,$args){
        $respuesta = factura::ListarExcel();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    } 

    ///Lista todas las facturas entre las fechas
    public function ListarFacturasEntreFechas($request,$response,$args){
        $parametros = $request->getParsedBody();
        $fecha1 = $parametros["fecha1"];
        $fecha2 = $parametros["fecha2"];
        $respuesta = factura::ListarEntreFechas($fecha1,$fecha2);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    } 

}
