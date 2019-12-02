<?php

class Venta
{
    public $id;
    public $email;
    public $sabores;
    public $tipo;
    public $cantidad;
    public $precio;

    function __construct($id, $email,$sabores, $tipo, $cantidad, $precio)
    {
        $this->id = $id;
        $this->email = $email;
        $this->sabores = $sabores;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
    }
}
function AltaVenta($venta, $path, &$ErrorAlta)
{    
    $noExiste = VentaNoExiste($venta, $path);
    if ($noExiste) {
        Guardar($venta, $path);
        return true;
    } else {
            $ErrorAlta = ' Error : Venta ya cargada en nuestra base';
        return false;
    }
}
function VentaNoExiste($venta, $path)
{
    $lectura = Leer($path, $arraylectura);
    if ($lectura) {
        for ($i = 0; $i < count($arraylectura); $i++) {
            if ($venta->id == $arraylectura[$i]["id"])
                return false;
        }
    }
    return true;
}
// function PizzaBuscar($sabores,$tipo,$path, &$respuesta,&$error)
// {
//     $error='';
//     $lectura = Leer($path, $arraylectura);
//     if ($lectura) {
//         for ($i = 0; $i < count($arraylectura); $i++) {
//             if ($sabores == $arraylectura[$i]["sabores"] && $tipo == $arraylectura[$i]["tipo"]){
//                 $respuesta= 'Hay ' . $arraylectura[$i]["cantidad"] . ' en stock';
//                 return true;
//             }
//         }
//     }
//     if($error == '')
//         $error='No se encontro';
//     return false;
// }
// function PizzaBuscarId($id, $path, &$Pizza,&$error)
// {
//     $error='';
//     $lectura = Leer($path, $arraylectura);
//     if ($lectura) {
//         for ($i = 0; $i < count($arraylectura); $i++) {
//             if ($id == $arraylectura[$i]["id"] ){
//                 $Pizza=new Pizza($arraylectura[$i]["id"],$arraylectura[$i]["precio"],
//                                     $arraylectura[$i]["tipo"],$arraylectura[$i]["cantidad"],
//                                     $arraylectura[$i]["sabores"],
//                                     $arraylectura[$i]["foto1"],$arraylectura[$i]["foto2"]);
//                 return true;
//             }
//         }
//     }
//     $error='El id no existe';
//     return false;
// }