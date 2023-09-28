<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
    <style>
      #tabla_pac tr:nth-child(even){background-color: #CDE6FF;}

      #tabla_pac tr:hover {background-color: #ddd;}

      #tabla_pac th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #509BE6;
      color: white;
      }
      ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
        position: fixed;
        top: 0;
        width: 100%;
      }

      li {
        float: left;
      }

      li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
      }

      li a:hover:not(.active) {
        background-color: #111;
      }

      .active {
        background-color: #1d138c;
      }
    </style>
  </head>
<body>
  <?php
    include 'funciones.php';

    $error = false;
    $config = include 'con_pdo.php';

    try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    if (isset($_POST['apellidos'])) {
        $consultaSQL = "SELECT * FROM patients WHERE last_name LIKE '%" . $_POST['last_name'] . "%'";
    } else {
        $consultaSQL = "SELECT id,first_name,last_name, DATE_FORMAT(birthdate,'%d-%m-%Y') AS birthdate ,email,status FROM patients";
    }

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    $pacientes = $sentencia->fetchAll();

    } catch(PDOException $error) {
    $error= $error->getMessage();
    }

    $titulo = isset($_POST['last_name']) ? 'Lista de Pacientes (' . $_POST['last_name'] . ')' : 'Lista de Pacientes';
  ?>

  <?php
    if ($error) {
  ?>
    <div class="container mt-2">
        <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
            <?= $error ?>
            </div>
        </div>
        </div>
    </div>
        
    <?php
        }
    ?>
    
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="crea_pac.php" class="btn btn-primary mt-4">Agregar Paciente</a>
      <a href="panel_admin.php" class="btn btn-primary mt-4">Regresar</a>
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="apellido" name="apellidos" placeholder="Buscar por apellido" class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Buscar</button>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table" id="tabla_pac">
        <thead>
          <tr>
            <th>Id Paciente</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Fecha de Nacimiento</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($pacientes && $sentencia->rowCount() > 0) {
            foreach ($pacientes as $fila) {
              ?>
              <tr>
                <td align="center"><?php echo escapar($fila["id"]); ?></td>
                <td><?php echo escapar($fila["first_name"]); ?></td>
                <td><?php echo escapar($fila["last_name"]); ?></td>
                <td><?php echo escapar($fila["birthdate"]); ?></td>
                <td><?php echo escapar($fila["email"]); ?></td>
                <td><?php echo escapar($fila["status"]); ?></td>
                <td>
                  <a href="<?= 'borrar_pac.php?id=' . escapar($fila["id"]) ?>" onclick="return confirm('¿Está seguro de Borrar un paciente?');">🗑️Borrar</a>
                  <a href="<?= 'edit_pac.php?id=' . escapar($fila["id"]) ?>" . >✏️Editar</a>
                  <a href="<?= 'activar2.php?id=' . escapar($fila["id"]) ?>" . >📜Activar Prueba PPG-IPG</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>