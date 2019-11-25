<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cdApi;
use App\Models\ORM\usuario;
use App\Models\AutentificadorJWT;

include_once __DIR__ . '/../../src/app/modelORM/Usuario.php';
include_once __DIR__ . '/../../src/middleware.php';
include_once __DIR__ . '/../../src/app/modelAPI/AutentificadorJWT.php';

return function (App $app) {
    $container = $app->getContainer();
    $app->group('/login', function () {

        ///++++++++++++++++++++++Login de usuarios++++++++++++++++++++++++++++++++++++++++++////

        $this->post('/log', function ($req, $res, $args) {
            if ($req->getParsedBody()['nombre'] != null &&  $req->getParsedBody()['clave'] != null) {
                $nombre = $req->getParsedBody()['nombre'];
                $clave = $req->getParsedBody()['clave'];
                $usu = usuario::where('nombre',$nombre)->get()->toArray();
                if(count($usu)==1 && $usu[0]['clave'] == $clave){
                    $token = AutentificadorJWT::CrearToken($usu[0]);
                    $res->getBody()->write('Usuario logeado. Su token es ' . $token);
                }else
                $res->getBody()->write('Usuario o contraseña incorrecta');
            }else
            $res->getBody()->write('Debe ingresar usuario y contraseña');
            return $res;
        });
    });
};