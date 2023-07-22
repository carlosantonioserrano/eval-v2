<?php
	$enlace = mysqli_connect("localhost", "root", "", "psicouees");
    if (!$enlace) {
        echo 'falla la conexion';
        die('Could not connect: ' . mysqli_error());
    }
    else{
        //echo 'Conexión Exitosa';
      }
?>
