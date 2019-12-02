<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\cd;
use App\Models\cdApi;



return function (App $app) {
    $container = $app->getContainer();

    // Rutas PDO
    $routes = require __DIR__ . '/../src/routes/routesPDO.php';
    $routes($app);
    
    // Rutas ORM
    $routes = require __DIR__ . '/../src/routes/routesORM.php';
    $routes($app);

    // Rutas JWT
    $routes = require __DIR__ . '/../src/routes/routesJWT.php';
    $routes($app);

    // Rutas Empleado
    $routes = require __DIR__ . '/../src/routes/routesEmpleado.php';
    $routes($app);

    // Rutas Mesa
    $routes = require __DIR__ . '/../src/routes/routesMesa.php';
    $routes($app);

    // Rutas Menu
    $routes = require __DIR__ . '/../src/routes/routesMenu.php';
    $routes($app);

    // Rutas Pedido
    $routes = require __DIR__ . '/../src/routes/routesPedido.php';
    $routes($app);

    // Rutas Encuesta
    $routes = require __DIR__ . '/../src/routes/routesEncuesta.php';
    $routes($app);

    // Rutas Factura
    $routes = require __DIR__ . '/../src/routes/routesFactura.php';
    $routes($app);


    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        // $container->get('logger')->addCritical('Hey, a critical log entry!');
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

};
