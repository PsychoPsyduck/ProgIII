<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\Ingreso;
use App\Models\ORM\Egreso;
use App\Models\ORM\cd;
use App\Models\ORM\cdApi;
use App\Models\ORM\usuario;
use App\Models\AutentificadorJWT;

include_once __DIR__ . '/../../src/app/modelORM/Usuario.php';
include_once __DIR__ . '/../../src/app/modelORM/cdControler.php';

return function (App $app) {
  $container = $app->getContainer();

    $app->group('/user', function () {   
        
    $this->post('/usuario', function ($request, $response, $args) {
      //return cd::all()->toJson();
      $datos= $request->getParsedBody(); 
      $archivos = $request->getUploadedFiles();
      
        
      $usu = new usuario();

      $usu->email=$datos['email'];
      $usu->clave= $datos['clave'];
      $usu->tipo=$datos['tipo'];
      $usu->nombre=$datos['nombre'];
      //$usu->foto=$datos['foto'];
      $usu->idMateria=$datos['idMateria'];

      //FotoUno
      $extension = $archivos["foto"]->getClientFilename();
      $extension = explode(".", $extension);
      $filenameUno = "./images/users/" . $usu->email . "1." . $extension[1];
      $archivos["foto"]->moveTo($filenameUno);
      $usu->foto =  $filenameUno;
      //FotoDos
      // $extension = $archivos["fotoDos"]->getClientFilename();
      // $extension = explode(".", $extension);
      // $filenameDos = "./images/users/" . $usu->email . "2." . $extension[1];
      // $archivos["fotoDos"]->moveTo($filenameDos);
      // $usu->fotoDos =  $filenameDos;

      // $a->save();
    
      // $newResponse = $response->withJson($a, 200);
      // return $newResponse;
      try {
        $usu->save();
        $response->getBody()->write('Alta Existosa. Datos del usuario : ' . $usu);
      } catch (Exception $e) {
          $response->getBody()->write('El usuario ya existe');
      }
      return $response;
    });

    $this->post('/modificar', function ($req, $res, $args) {
      $usu = usuario::where('nombre', $req->getParsedBody()['usuario'])->get();
      if (count($usu) == 1) {
          $usu[0]->email = $req->getParsedBody()['email'];
          $usu[0]->clave = $req->getParsedBody()['clave'];
          $usu[0]->tipo = $req->getParsedBody()['tipo'];
          $usu[0]->nombre = $req->getParsedBody()['nombre'];
          $usu[0]->foto = $req->getParsedBody()['foto'];
          $usu[0]->idMateria = $req->getParsedBody()['idMateria'];
          $usu[0]->save();
          $res->getBody()->write('Modificacion Existosa. Datos del usuario : ' . $usu);
      } else {
          $res->getBody()->write('Usuario no existente');
      }
      return $res;
    });

    $this->get('/mostrar', function ($req, $res, $args) {
      $usu = usuario::all();
      return $res->withJson($usu);
    });


    $this->post('/baja', function ($req, $res, $args) {
      $usu = usuario::where('nombre', $req->getParsedBody()['usuario'])->get()->toArray();
      if (count($usu) == 1) {
          $usu[0]->forceDelete();
          $res->getBody()->write('Baja Exitosa');
      } else
          $res->getBody()->write('Usuario no existente');
      return $res;
    });

    

  });

  $app->group('/ingreso', function () {   

    $this->post('/ingreso', function ($request, $response, $args) {
      $token = $request->getHeader("token")[0];
      $data = AutentificadorJWT::ObtenerData($token);
      $ingreso = new Ingreso;
      $ingreso->usuario = $data->email;
      $ingreso->legajo = $data->legajo;
      //Asi obtengo el ultimo Ingreso::where("usuario", "=", $data->email)->latest('created_at')->get()->first()->toArray();
      $contadorIngresos = Ingreso::where("usuario", "=", $data->email)->select('created_at')->get()->toArray();
      $contadorEgresos = Egreso::where("usuario", "=", $data->email)->select('created_at')->get()->toArray();
      if(count($contadorEgresos) == count($contadorIngresos))
      {
        $ingreso->save();
        $newResponse = $response->withJson("Usuario ingresado correctamente", 200);
      }
      else
      {
        $newResponse = $response->withJson("El usuario ya tiene una sesion iniciada", 200);
      }
      return $newResponse; 
    });

    $this->post('/egreso', function ($request, $response, $args) {
      $token = $request->getHeader("token")[0];
      $data = AutentificadorJWT::ObtenerData($token);
      $egreso = new Egreso;
      $egreso->usuario = $data->email;
      $egreso->legajo = $data->legajo;
      //Asi obtengo el ultimo Ingreso::where("usuario", "=", $data->email)->latest('created_at')->get()->first()->toArray();
      $contadorIngresos = Ingreso::where("usuario", "=", $data->email)->select('created_at')->get()->toArray();
      $contadorEgresos = Egreso::where("usuario", "=", $data->email)->select('created_at')->get()->toArray();
      //No se puede egresar un usuario si no existe un ingreso previo o si la cantidad de ingresos es menor a la de egresos
      if(count($contadorIngresos) == 0 || count($contadorIngresos) <= count($contadorEgresos))
      {
        $newResponse = $response->withJson("No se puede egresar el usuario", 200);
      }
      else{
        $egreso->save();
        $newResponse = $response->withJson("Usuario egresado correctamente", 200);
      }
      return $newResponse;
    });

  });
};