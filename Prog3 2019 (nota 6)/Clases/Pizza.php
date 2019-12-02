<?php

class Pizza
{
    public $id;
    public $precio;
    public $tipo;
    public $cantidad;
    public $sabores;
    public $foto1;
    public $foto2;

    function __construct($id,$precio,$tipo, $cantidad, $sabores, $foto1,$foto2)
    {
        $this->id = $id;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
        $this->sabores = $sabores;
        $this->foto1 = $foto1;
        $this->foto2 = $foto2;
    }
}
function AltaPizza($pizza, $path, &$ErrorAlta)
{    
    $noExiste = PizzaNoExiste($pizza, $path);
    if ($noExiste) {
        Guardar($pizza, $path);
        return true;
    } else {
            $ErrorAlta = ' Error : Pizza ya cargada en nuestra base';
        return false;
    }
}
function PizzaNoExiste($pizza, $path)
{
    $lectura = Leer($path, $arraylectura);
    if ($lectura) {
        for ($i = 0; $i < count($arraylectura); $i++) {
            if ($pizza->id == $arraylectura[$i]["id"])
                return false;
        }
    }
    return true;
}
function PizzaBuscar($sabores,$tipo,$path, &$respuesta,&$error)
{
    $error='';
    $lectura = Leer($path, $arraylectura);
    if ($lectura) {
        for ($i = 0; $i < count($arraylectura); $i++) {
            if ($sabores == $arraylectura[$i]["sabores"] && $tipo == $arraylectura[$i]["tipo"]){
                $respuesta= 'Hay ' . $arraylectura[$i]["cantidad"] . ' en stock';
                return true;
            }
        }
    }
    if($error == '')
        $error='No se encontro';
    return false;
}
function PizzaBuscar2($sabores,$tipo,$path, &$id, &$precio, &$stock,&$error)
{
    $error='';
    $lectura = Leer($path, $arraylectura);
    if ($lectura) {
        for ($i = 0; $i < count($arraylectura); $i++) {
            if ($sabores == $arraylectura[$i]["sabores"] && $tipo == $arraylectura[$i]["tipo"]){
                $stock= $arraylectura[$i]["cantidad"];
                $id = $arraylectura[$i]["id"];
                $precio = $arraylectura[$i]["precio"];
                return true;
            }
        }
    }
    if($error == '')
        $error='No se encontro';
    return false;
}
function PizzaBuscarId($id, $path, &$Pizza,&$error)
{
    $error='';
    $lectura = Leer($path, $arraylectura);
    if ($lectura) {
        for ($i = 0; $i < count($arraylectura); $i++) {
            if ($id == $arraylectura[$i]["id"] ){
                $Pizza=new Pizza($arraylectura[$i]["id"],$arraylectura[$i]["precio"],
                                    $arraylectura[$i]["tipo"],$arraylectura[$i]["cantidad"],
                                    $arraylectura[$i]["sabores"],
                                    $arraylectura[$i]["foto1"],$arraylectura[$i]["foto2"]);
                return true;
            }
        }
    }
    $error='El id no existe';
    return false;
}