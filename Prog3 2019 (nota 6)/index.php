<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
// use Slim\Factory\AppFactory;

require_once 'vendor/autoload.php';
include_once './Clases/Pizza.php';
include_once './Clases/Venta.php';
include_once './Clases/Funciones.php';
include_once './Clases/Log.php';
$pathPizza= './pizzas.json';
$pathBackup= './img/backup/';
$pathLog= './log.json';
$pathImagenes= './img/fotos/';
$metodo = $_SERVER["REQUEST_METHOD"];
$log = new Log($metodo, date("d-m-Y (H:i:s)", time()),$_SERVER['SERVER_ADDR']);
Guardar($log,$pathLog);

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

// $app = AppFactory::create();
$app = new \Slim\App(["settings" => $config]);

$app->group("/pizzas", function() {
    $this->get('/saludar', function ($request, $response) {
        $response->getBody()->write("HOLA!");
        return $response;
    });
    $this->get('[/]', function ($request, $response) {
        if(PizzaBuscar($_GET['sabores'], $_GET['tipo'], './pizzas.json', $respuesta, $error ))
            echo json_encode($respuesta);
        else
            echo json_encode($error);
        // $response->getBody()->write("GET => Hello world!");
        // return $response;
    });
    $this->post('[/]', function ($request, $response) {
        if (tratarImagen1($foto1,'./img/fotos/')&&tratarImagen2($foto2,'./img/fotos/')){
            $pizza= new Pizza($_POST["id"],$_POST["precio"],$_POST["tipo"],$_POST["cantidad"],$_POST["sabores"],
                                    $foto1,$foto2);
            if(AltaPizza($pizza,'./pizzas.json',$error))
                echo json_encode('pizza guardada correctamente');
            else
                echo json_encode($error);
        }else{
            echo json_encode('Erorr al guardar las fotos');
        }
    });
    $this->post('/modificar', function ($request, $response) {
        if(PizzaBuscarId($_POST["id"],'./pizzas.json',$pizza,$error)){
            if(BackupImagen1($foto1,'./img/fotos/','./img/backup/',$pizza->foto1)){
                if(BackupImagen2($foto2,'./img/fotos/','./img/backup/',$pizza->foto2)){
                    $pizz= new Pizza($_POST["id"],$_POST["precio"],$_POST["tipo"],$_POST["cantidad"],$_POST["sabores"],
                    $foto1,$foto2);
                }else
                    $pizz= new Pizza($_POST["id"],$_POST["precio"],$_POST["tipo"],$_POST["cantidad"],$_POST["sabores"],
                    $foto1,$foto2);
            }else
            {
                if(BackupImagen2($foto2,'./img/fotos/','./img/backup/',$pizza->foto2)){
                    $pizz= new Pizza($_POST["id"],$_POST["precio"],$_POST["tipo"],$_POST["cantidad"],$_POST["sabores"],
                    $foto1,$foto2);
                }else
                    $pizz= new Pizza($_POST["id"],$_POST["precio"],$_POST["tipo"],$_POST["cantidad"],$_POST["sabores"],
                    $foto1,$foto2);
            }
            Modificar($pizz,'./pizzas.json');
            echo json_encode('Modificacion correcta');
        }else
            echo json_encode($error);

        // $response->getBody()->write("PUT => Hello world!");
        // return $response;
    });
    $this->delete('[/]', function ($request, $response) {
        $response->getBody()->write("DELETE => Hello world!");
        return $response;
    });
});

$app->group("/ventas", function() {
    $this->post('[/]', function ($request, $response) {
        if(PizzaBuscar2($_POST['sabores'], $_POST['tipo'], './pizzas.json', $id, $precio, $stock,$error)){
            $venta = new Venta($_POST['id'],$_POST['email'], $_POST['sabores'], $_POST['tipo'], $_POST['cantidad'], $precio);
            if(AltaVenta($venta,'./ventas.json',$error2)){
                echo json_encode('venta guardada correctamente');

                if(PizzaBuscarId($id,'./pizzas.json',$pizza,$error)){
                    $usu= new Pizza($pizza->id,$pizza->precio,$pizza->tipo,$pizza->cantidad,$pizza->sabores,
                    $pizza->foto1,$pizza->foto2);
                }
                ModificarCantidad($usu,'./pizzas.json');
                echo json_encode('Modificacion de pizza correcta');
            }else {
                echo json_encode($error2);
            }
        }else {
            echo json_encode($error);
        }
    });
});


$app->run();