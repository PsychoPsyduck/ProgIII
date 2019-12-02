<?php

    function ListArray($array){
        for($i = 0; $i < count($array); $i++){
            echo $array[$cont]->nombre, "<br/>";
            echo $array[$cont]->apellido, "<br/>";
            echo $array[$cont]->dni, "<br/>";
        }
    }

    function SaveArray($array, $value){
        array_push($array, $value);
    }

    function ModifyArray($array, $value){
        foreach($array as &$arr){
            if($arr->dni == $value->dni){
                $arr->nombre = $value->nombre;
                $arr->apellido = $value->apellido;
                //$arr->dni = $value->dni;
            }
        }
    }

    function DeleteArray($array, $value){
        //sino usar for para obtener el indice
        foreach($array as &$arr){
            if($arr->dni == $value->dni){
                unset($array[array_search($arr->dni, $array->dni)]);//para obtener el indice
            }
        }
    }
?>