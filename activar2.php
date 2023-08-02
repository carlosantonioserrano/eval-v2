<?php
  include 'conexion.php';
  if ($result = $enlace->query("INSERT INTO exam_number (status) VALUES ('Activado')")) {
    //echo "Registro guardado con Éxito"."<br>";
    $ultimo_id = mysqli_insert_id($enlace);
    echo "<script>
    alert('Se ha Activado una nueva prueba con el número $ultimo_id.')
    
  </script>";
    mysqli_close($enlace);
  }
  else {
    //echo "error";
    die('Error: ' . mysqli_error());
  }
 
  echo "<script>window.location = 'calificar_prueba.php'</script>";
  exit;
?>
     