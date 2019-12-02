<?php
namespace App\Models\ORM;
use App\Models\PDO\menu;
use App\Models\IApiControler;
use App\Models\AutentificadorJWT;

include_once __DIR__ . '../../modelPDO/menu.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class menuController implements IApiControler
{
    ///Registro de nuevas comidas
    public function RegistrarComida($request, $response, $args){
        $parametros = $request->getParsedBody();
        $nombre = $parametros["nombre"];  
        $precio = $parametros["precio"];  
        $sector = $parametros["sector"];            

        $respuesta = menu::Registrar($nombre,$precio,$sector);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Modificacion del menu
    public function ModificarComida($request, $response, $args){
        $parametros = $request->getParsedBody();
        $id = $parametros["id"]; 
        $nombre = $parametros["nombre"];  
        $precio = $parametros["precio"];  
        $sector = $parametros["sector"];            

        $respuesta = menu::Modificar($id,$nombre,$precio,$sector);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Lista el menú
    public function ListarMenu($request,$response,$args){
        $respuesta = menu::Listar();
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    ///Da de baja una comida
    public function BajaMenu($request,$response,$args){
        $parametros = $request->getParsedBody();
        $id = $parametros["id"]; 
        $respuesta = menu::Baja($id);
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

}
