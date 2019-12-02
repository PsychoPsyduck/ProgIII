<?php
    $temp = $_FILES["imagen"]["tmp_name"];
    move_uploaded_file($temp, "./img/imagen2.jpg");

    
?>