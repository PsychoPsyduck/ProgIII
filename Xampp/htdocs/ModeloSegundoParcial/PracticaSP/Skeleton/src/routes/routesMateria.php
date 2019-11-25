<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cd;
use App\Models\ORM\cdApi;
use App\Models\ORM\materia;

include_once __DIR__ . '/../../src/app/modelORM/Materia.php';
include_once __DIR__ . '/../../src/app/modelORM/cdControler.php';

return function (App $app) {
  $container = $app->getContainer();

    $app->group('/mater', function () {   
        
    $this->post('/materia', function ($request, $response, $args) {
      //return cd::all()->toJson();
      $datos= $request->getParsedBody(); 
        
      $materia = new materia();

      $materia->nombre=$datos['nombre'];
      $materia->cuatrimestre= $datos['cuatrimestre'];
      $materia->cupo=$datos['cupo'];
    //   $materia->save();
    
    //   $newResponse = $response->withJson($materia, 200);
    //   return $newResponse;
      try {
        $materia->save();
        $response->getBody()->write('Alta Existosa. Datos de la materia: ' . $materia);
      } catch (Exception $e) {
          $response->getBody()->write('La materia ya existe');
      }
      return $response;
    });

    // $this->post('/modificar', function ($req, $res, $args) {
    //   $usu = usuario::where('nombre', $req->getParsedBody()['usuario'])->get();
    //   if (count($usu) == 1) {
    //       $usu[0]->email = $req->getParsedBody()['email'];
    //       $usu[0]->clave = $req->getParsedBody()['clave'];
    //       $usu[0]->tipo = $req->getParsedBody()['tipo'];
    //       $usu[0]->nombre = $req->getParsedBody()['nombre'];
    //       $usu[0]->foto = $req->getParsedBody()['foto'];
    //       $usu[0]->idMateria = $req->getParsedBody()['idMateria'];
    //       $usu[0]->save();
    //       $res->getBody()->write('Modificacion Existosa. Datos del usuario : ' . $usu);
    //   } else {
    //       $res->getBody()->write('Usuario no existente');
    //   }
    //   return $res;
    // });

    // $this->get('/mostrar', function ($req, $res, $args) {
    //   $usu = usuario::all();
    //   return $res->withJson($usu);
    // });


    // $this->post('/baja', function ($req, $res, $args) {
    //   $usu = usuario::where('nombre', $req->getParsedBody()['usuario'])->get()->toArray();
    //   if (count($usu) == 1) {
    //       $usu[0]->forceDelete();
    //       $res->getBody()->write('Baja Exitosa');
    //   } else
    //       $res->getBody()->write('Usuario no existente');
    //   return $res;
    // });


  })
    ->add(middle::class . ':logGuardar')
    ->add(middle::class . ':autorizadoAdmin')
    ->add(middle::class . ':validarToken');
};