<?php
    Include 'persona.php';

    class Alumno extends Persona{
        public $legajo;
        public $cuatrimestre;

        function __construct($legajo, $cuatrimestre){
            parent::__construct($nombre, $apellido, $dni );
            $legajo->legajo = $legajo;
            $cuatrimestre->cuatrimestre = $cuatrimestre;
        }
    }

?>