<?php
    Include 'practicaClase.php';
    Include 'Clases\persona.php';

    echo "Hola PHP <br/>";

    $nombre = "Nicolas";

    //Saluda($nombre);

    $Persona = new Persona('Nicolas', 'Sande', '37954192');

    $Persona->Saludar();
?>