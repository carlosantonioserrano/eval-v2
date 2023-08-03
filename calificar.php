<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Calificar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <style>
    #tabla_ppg tr:nth-child(even){background-color: #CDE6FF;}
    #tabla_ipg tr:nth-child(even){background-color: #CDE6FF;}
    #tabla_puntajes tr:nth-child(even){background-color: #CDE6FF;}

    #tabla_ppg tr:hover {background-color: #ddd;}
    #tabla_ipg tr:hover {background-color: #ddd;}
    #tabla_puntajes tr:hover {background-color: #ddd;}

    #tabla_ppg th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #509BE6;
    color: white;
    }
    #tabla_ipg th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #509BE6;
    color: white;
    }
    #tabla_puntajes th {
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
  <div style="padding:10px;margin-top:10px" >
    <ul a>
      <li><a class="active" href="panel_admin.php">Regresar</a></li>
    </ul>
  </div>
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.js"></script>
  <!-- ChartJS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/chart.js"></script>
  <script src="plugins/chart.js/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>

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
  $resultado['mensaje'] = 'La prueba no existe';
}

//conectamos y extraemos el número de la prueba a mostrar en tablas
try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
  
  //obteniendo el número de la prueba
  $id = $_GET['id'];
  $consulta1 = "SELECT * FROM exam_number WHERE id =" . $id;

  $sentencia1 = $conexion->prepare($consulta1);
  $sentencia1->execute();

  $num = $sentencia1->fetch(PDO::FETCH_ASSOC);

  if (!$num) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado la prueba';
  }

} catch(PDOException $error) {
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
          La calificación ha finalizado satisfactoriamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($num) && $num) {
  ?>
  
  <div class="container" style="padding:20px;margin-top:5px">
    <h2 style="text-align:center" class="mt-4">Mostrando la Prueba # <?= escapar($num['id'])?></h2>
    <hr>
  </div>
  
  <?php
}
?>

<div class="container">
  <h4 style="margin-left: 30px">
    Al presionar el botón "Iniciar Calificación" comenzará el proceso de cálculo, suma, comparación y desarrollo de gráfica de los resultados.<br><br>
    Por favor espere hasta que finalice.
  </h4><br>
  
  <!-- Haciendo las conexión para mostrar las tablas -->
  <?php
    try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $consulta2 = "SELECT * FROM ppg WHERE exam_number_id =" . $id;
    $consulta3 = "SELECT * FROM ipg WHERE exam_number_id =" . $id;

    $sentencia2 = $conexion->prepare($consulta2);
    $sentencia2->execute();

    $sentencia3 = $conexion->prepare($consulta3);
    $sentencia3->execute();

    $p_ppg = $sentencia2->fetchAll();
    $p_ipg = $sentencia3->fetchAll();

    } catch(PDOException $error) {
    $error= $error->getMessage();
    }
  ?>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12" align="center">
        <a href="calificar2.php?num_prueba=<?php echo $id;?>" class="btn btn-primary mt-4">Iniciar Calificación</a>
      </div>
    </div>
    <hr>
    <div class="row" >
      <!-- columna izq -->
      <section class="col-lg-7 connectedSortable">
        <div class="container-fluid">
          <h4 class="m-0">Tabla PPG</h4>
        </div>
        <div class="card">
          <div class="card-body">
            <table class="table" id="tabla_ppg">
              <thead>
                <tr>
                  <th>Id Prueba</th>
                  <th>Tétrada</th>
                  <th>A</th>
                  <th>B</th>
                  <th>C</th>
                  <th>D</th>
                  <th>Ascendencia</th>
                  <th>Responsabilidad</th>
                  <th>Estabilidad Emocional</th>
                  <th>Sociabilidad</th>
                  <th>Autoestima</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($p_ppg && $sentencia2->rowCount() > 0) {
                  foreach ($p_ppg as $fila_p) {
                    ?>
                    <tr>
                      <td align="center"><?php echo escapar($fila_p["exam_number_id"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["tetrad"]); ?></td>
                      <td><?php echo escapar($fila_p["A"]); ?></td>
                      <td><?php echo escapar($fila_p["B"]); ?></td>
                      <td><?php echo escapar($fila_p["C"]); ?></td>
                      <td><?php echo escapar($fila_p["D"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["ascendancy"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["responsibility"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["emotional"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["sociability"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["self_esteem"]); ?></td>
                    </tr>
                    <?php
                  }
                }
                ?>
              <tbody>
            </table>
          </div>
        </div>
        <div class="container-fluid">
          <h4 class="m-0">Tabla IPG</h4>
        </div>
        <div class="card">
          <div class="card-body">
            <table class="table" id="tabla_ipg">
              <thead>
                <tr>
                  <th>Id Prueba</th>
                  <th>Tétrada</th>
                  <th>A</th>
                  <th>B</th>
                  <th>C</th>
                  <th>D</th>
                  <th>Cautela</th>
                  <th>Originalidad</th>
                  <th>Comprensión</th>
                  <th>Vitalidad</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($p_ipg && $sentencia3->rowCount() > 0) {
                  foreach ($p_ipg as $fila_i) {
                    ?>
                    <tr>
                      <td align="center"><?php echo escapar($fila_i["exam_number_id"]); ?></td>
                      <td><?php echo escapar($fila_i["tetrad"]); ?></td>
                      <td><?php echo escapar($fila_i["A"]); ?></td>
                      <td><?php echo escapar($fila_i["B"]); ?></td>
                      <td><?php echo escapar($fila_i["C"]); ?></td>
                      <td><?php echo escapar($fila_i["D"]); ?></td>
                      <td align="center"><?php echo escapar($fila_i["caution"]); ?></td>
                      <td align="center"><?php echo escapar($fila_i["originality"]); ?></td>
                      <td align="center"><?php echo escapar($fila_i["comprehension"]); ?></td>
                      <td align="center"><?php echo escapar($fila_i["vitality"]); ?></td>
                    </tr>
                    <?php
                  }
                }
                ?>
              <tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>
</section>
</body>
