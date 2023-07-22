<?php

  //Recibiendo variables de tétrada 
  $A=$_POST["A"];
  $B=$_POST["B"];
  $C=$_POST["C"];
  $D=$_POST["D"];
 
  //Evaluando la tétrada

  //Verificando campos vacíos
  if($A=="NS" && $B=="NS" && $C=="NS" && $D=="NS") {
    echo '<script> alert ("No ha seleccionado elemenos");</script>';
  }

  //Verificando si existen más de 1 con el signo "más"
  elseif($A=="+" && $B=="+" || $A=="+" && $C=="+" || $A=="+" && $D=="+"
  || $B=="+" && $C=="+" || $B=="+" && $D=="+"
  || $C=="+" && $D=="+") {
    echo '<script> alert ("Solo puede seleccionar una con el signo más en cada grupo");</script>';
  }

  //Verificando si existen más de 1 con el signo "menos"
  elseif($A=="-" && $B=="-" || $A=="-" && $C=="-" || $A=="-" && $D=="-"
  || $B=="-" && $C=="-" || $B=="-" && $D=="-"
  || $C=="-" && $D=="-") {
    echo '<script> alert ("Solo puede seleccionar una con el signo menos en cada grupo");</script>';
  } 

  //Verificando si hace falta seleccionar el "menos"
  elseif($A=="+" && ($B=="NS" && $C=="NS" && $D=="NS")
  || ($B=="+" && ($A=="NS" && $C=="NS" && $D=="NS"))
  || ($C=="+" && ($A=="NS" && $B=="NS" && $D=="NS"))
  || ($D=="+" && ($A=="NS" && $B=="NS" && $C=="NS")))
   {
    echo '<script> alert ("Faltó una selección con menos");</script>';
  }

  //Verificando si hace falta seleccionar el "más"
    elseif($A=="-" && ($B=="NS" && $C=="NS" && $D=="NS")
  || ($B=="-" && ($A=="NS" && $C=="NS" && $D=="NS"))
  || ($C=="-" && ($A=="NS" && $B=="NS" && $D=="NS"))
  || ($D=="-" && ($A=="NS" && $B=="NS" && $C=="NS"))
  ) {
    echo '<script> alert ("Faltó una selección con más");</script>';
  }

  //Si todas las tétradas han sido correctamente seleccionadas, procede a guardar
  else 
  {
    //hacemos la conexion
    $enlace = mysqli_connect("localhost", "root", "", "psicouees");
    if (!$enlace) {
        echo 'falla la conexion';
        die('Could not connect: ' . mysqli_error());
    }
    else{
        //echo 'Conexión Exitosa';

        //quiery almacenar tétrada 
        if ($result = $enlace->query("INSERT INTO ppg (tetrada, A, B, C, D) VALUES ('6','".$A."', '".$B."', '".$C."', '".$D."')")) {
            echo "Registro #1 guardado con Éxito"."<br>";
            echo "<br>";
            mysqli_close($enlace);
            header("Location:ppg7.php");
            exit;
        } else {
            //echo "error";
            die('Error: ' . mysqli_error());
        }
      }
  }
  
  echo "<script>window.location = 'ppg6.php'</script>";
  exit;
  
?>