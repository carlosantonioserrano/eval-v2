<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <title>Calificar</title>
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <div style="padding:10px;margin-top:10px" >
    <ul a>
      <li><a class="active" href="panel_admin.php">Regresar</a></li>
    </ul>
  </div>
  <style>
    #tabla_num_prueba tr:nth-child(even){background-color: #CDE6FF;}

    #tabla_num_prueba tr:hover {background-color: #ddd;}

    #tabla_num_prueba th {
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
  <!-- Funcion Activar botón -->
  <script>
    function toggleButton()
    {
        var chequear = document.getElementById('$row["estado"];').value;
        if (chequear) {
            document.getElementById('submitButton').disabled = false;
        } else {
            document.getElementById('submitButton').disabled = true;
        }
    }
  </script>
</head>
<body class="hold-transition sidebar-mini">

<div class="container">
    <div style="padding:10px;margin-top:50px" >
    </div>
    <h2 align="center">Calificación de Prueba PPG-IPG</h2><br>
    <h5 style="margin-left: 30px">
      La tabla presenta el estado de las pruebas. En ello veremos 4 leyendas:<br>
      a- "Finalizado" => pueden calificarse.<br>
      b- "No finalizado" - El paciente abandonó la prueba y pueden borrarse.<br>
      c- "En proceso" - El paciente se encuentra desarrollando la prueba.<br>
      d- "Activado" - El paciente aún no ha iniciado la prueba.<br>
    </h5><br>
      <div>  
      </div>

    <?php
      //hacemos la conexion
      include 'funciones.php';

      $error = false;
      $config = include 'con_pdo.php';

      try {
      $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
      $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

      $consultaSQL = "SELECT * FROM exam_number";

      $sentencia = $conexion->prepare($consultaSQL);
      $sentencia->execute();

      $pruebas = $sentencia->fetchAll();

      } catch(PDOException $error) {
      $error= $error->getMessage();
      }
    ?>

  </div>

<div class="container" >
  <div class="row">
    <div class="col-md-12" >
      <table class="table" id="tabla_num_prueba">
        <thead>
          <tr>
            <th>Id Prueba</th>
            <th>Id Paciente</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($pruebas && $sentencia->rowCount() > 0) {
            foreach ($pruebas as $fila) {
              ?>
              <tr>
                <td align="center"><?php echo escapar($fila["id"]); ?></td>
                <td><?php echo escapar($fila["patient_id"]); ?></td>
                <td><?php echo escapar($fila["status"]); ?></td>
                <td>
                <a href="<?= 'calificar.php?id=' . escapar($fila["id"]) ?>" . >✏️Calificar</a>
                <a href="<?= 'borrar_prueba.php?id=' . escapar($fila["id"]) ?>" onclick="return confirm('¿Está seguro de Borrar la prueba?');">🗑️Borrar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>

</body>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</html>
        