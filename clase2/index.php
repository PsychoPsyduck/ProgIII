<?php
    Include '.\Clases\persona.php';
    //Include '.\Clases\alumno.php';
    
    $arrays = array(1,2,3);
    $alumnos = array(new Persona("Juan", "Perez", 37954192));
    $cont = 0;

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        foreach($arrays as &$array){
            echo $array, "<br/>";
        }

        foreach($arrays as &$array){
            echo $alumnos[$cont]->nombre, "<br/>";
            $cont + 1;
        }
    }
    else if($_SERVER["REQUEST_METHOD"] == "POST"){
        array_push($arrays, 2);
        foreach($arrays as &$array){
            echo $array, "<br/>";
        }

        //x-www-form-urlencoded
        array_push($alumnos, new Persona($_POST["nombre"], $_POST["apellido"], $_POST["dni"]));
        foreach($alumnos as &$alumno){
            echo $alumno->nombre, "<br/>";
        }
    }
?>