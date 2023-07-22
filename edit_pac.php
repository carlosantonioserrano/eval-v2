<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>

<?php
    //evitar ataques XSS
    include 'funciones.php';
    
    $config = include 'con_pdo.php';
    
    $resultado = [
      'error' => false,
      'mensaje' => ''
    ];
    
    if (!isset($_GET['id'])) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'El paciente no se encuentra Registrado';
    }
    
    if (isset($_POST['submit'])) {
      try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
        $paciente = [
          "id_paciente" => $_GET['id'],
          "nombres"    => $_POST['nombres'],
          "apellidos"  => $_POST['apellidos'],
          "fecha_nac"  => $_POST['fecha_nac'],
          "correo"     => $_POST['correo'],
          "estado"      => $_POST['estado']
        ];
        
        $consultaSQL = "UPDATE pacientes SET
            nombres = :nombres,
            apellidos = :apellidos,
            fecha_nac = :fecha_nac,
            correo = :correo,
            estado = :estado
            WHERE id_paciente = :id_paciente";
        
        $consulta = $conexion->prepare($consultaSQL);
        $consulta->execute($paciente);
        }

      catch(PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
        }
    }
    
    try {
      $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
      $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        
      $id = $_GET['id'];
      $consultaSQL = "SELECT * FROM pacientes WHERE id_paciente =" . $id;
    
      $sentencia = $conexion->prepare($consultaSQL);
      $sentencia->execute();
    
      $paciente = $sentencia->fetch(PDO::FETCH_ASSOC);
    
      if (!$paciente) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado el paciente';
      }
    } 
    
    catch(PDOException $error) {
      $resultado['error'] = true;
      $resultado['mensaje'] = $error->getMessage();
    }
?>

<?php
if ($resultado['error']) {
?>
      <div class="container mt-2">
        <div class="row">
          <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
              <?= $resultado['mensaje'] ?>
            </div>
          </div>
        </div>
      </div>
      
<?php
    }
?>
    
<?php
    if (isset($_POST['submit']) && !$resultado['error']) {
?>
      <div class="container mt-2">
        <div class="row">
          <div class="col-md-12">
            <div class="alert alert-success" role="alert">
              El paciente ha sido actualizado correctamente
            </div>
          </div>
        </div>
      </div>
<?php
    }
?>
    
    <?php
    if (isset($paciente) && $paciente) {
      ?>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="mt-4">Editando el paciente <?= escapar($paciente['nombres']) . ' ' . escapar($paciente['apellidos'])  ?></h2>
            <hr>
            <form method="post">
              <div class="form-group">
                <label for="nombre">Nombres</label>
                <input type="text" name="nombres" id="nombres" value="<?= escapar($paciente['nombres']) ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="apellido">Apellidos</label>
                <input type="text" name="apellidos" id="apellidos" value="<?= escapar($paciente['apellidos']) ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" name="correo" id="correo" value="<?= escapar($paciente['correo']) ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="fecha">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nac" id="fecha_nac" value="<?= escapar($paciente['fecha_nac']) ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="estado">Estado</label>
                <select class="form-control select1D" style="width: 100%;" name="estado">
                        <option selected="selected" value="<?= escapar($paciente['estado']) ?>"><?= escapar($paciente['estado']) ?></option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                </select> 
              </div>
              <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
                <a class="btn btn-primary" href="reg_pac.php">Regresar al inicio</a>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php
    }
    ?>

</body>
