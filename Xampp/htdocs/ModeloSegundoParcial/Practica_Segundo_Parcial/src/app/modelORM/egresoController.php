<?php

namespace App\Models\ORM;

use App\Models\ORM\Egreso;

include_once __DIR__ . '/egreso.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class egresoController
{
  public function TraerTodos($request, $response, $args)
  {
    //return cd::all()->toJson();
    $todosLosCds = cd::all();
    $newResponse = $response->withJson($todosLosCds, 200);
    return $newResponse;
  }
  public function TraerUno($request, $response, $args)
  {
    //complete el codigo
    $newResponse = $response->withJson("sin completar", 200);
    return $newResponse;
  }

  public function CargarUno($request, $response, $args)
  {
    $newResponse = $response->withJson("sin completar", 200);
    return $newResponse;
  }

}
