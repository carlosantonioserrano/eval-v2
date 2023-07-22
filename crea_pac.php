<?php
    //evitar ataques XSS
    include 'funciones.php';

    if (isset($_POST['submit'])) {

    $resultado = [
        'error' => false,
        'mensaje' => 'Usuario agregado con éxito'
    ];
    
    $config = include 'con_pdo.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        // Código que insertará un paciente
        $paciente = array(
            "nombre"   => $_POST['nombres'],
            "apellido" => $_POST['apellidos'],
            "correo"    => $_POST['correo'],
            "estado"    => 'Activo',
          );
        
        $consultaSQL = "INSERT INTO pacientes (nombres, apellidos, correo, estado)";
        $consultaSQL .= "values (:" . implode(", :", array_keys($paciente)) . ")";
        
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute($paciente);

    } catch(PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
    }
?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Crear_Pac</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

    <!-- Pure CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  </head>
</head>
<body>
    <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Creación de Pacientes en el Sistema Psicouees</h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre">Nombres</label>
            <input type="text" name="nombres" id="nombres" class="form-control" required="">
          </div>
          <div class="form-group">
            <label for="apellido">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" class="form-control" required="">
          </div>
          <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" name="correo" id="email" class="form-control">
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Aceptar">
            <a class="btn btn-primary" href="reg_pac.php">Regresar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
  <?php

?>