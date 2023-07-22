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
  <script src="plugins/chart.js/Chart.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/chart.js"></script>
  <script src="plugins/chart.js/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>

  <!-- Estilo del gráfico -->
  <link rel="stylesheet" href="style_grafico.css">
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
  $consulta1 = "SELECT * FROM num_prueba WHERE id_prueba =" . $id;

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
    <h2 class="mt-4">Mostrando la Prueba # <?= escapar($num['id_prueba'])?></h2>
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

    $consulta2 = "SELECT * FROM ppg WHERE id_prueba =" . $id;
    $consulta3 = "SELECT * FROM ipg WHERE id_prueba =" . $id;
    $consulta4 = "SELECT * FROM num_prueba WHERE id_prueba =" . $id;

    $sentencia2 = $conexion->prepare($consulta2);
    $sentencia2->execute();

    $sentencia3 = $conexion->prepare($consulta3);
    $sentencia3->execute();

    $sentencia4 = $conexion->prepare($consulta4);
    $sentencia4->execute();

    $p_ppg = $sentencia2->fetchAll();
    $p_ipg = $sentencia3->fetchAll();
    $tabla_puntajes = $sentencia4->fetchAll();

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

    <div class="row">
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
                      <td align="center"><?php echo escapar($fila_p["id_prueba"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["tetrada"]); ?></td>
                      <td><?php echo escapar($fila_p["A"]); ?></td>
                      <td><?php echo escapar($fila_p["B"]); ?></td>
                      <td><?php echo escapar($fila_p["C"]); ?></td>
                      <td><?php echo escapar($fila_p["D"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["ascendencia"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["responsabilidad"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["estab_emocion"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["sociabilidad"]); ?></td>
                      <td align="center"><?php echo escapar($fila_p["autoestima"]); ?></td>
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
                      <td align="center"><?php echo escapar($fila_i["id_prueba"]); ?></td>
                      <td><?php echo escapar($fila_i["tetrada"]); ?></td>
                      <td><?php echo escapar($fila_i["A"]); ?></td>
                      <td><?php echo escapar($fila_i["B"]); ?></td>
                      <td><?php echo escapar($fila_i["C"]); ?></td>
                      <td><?php echo escapar($fila_i["D"]); ?></td>
                      <td align="center"><?php echo escapar($fila_i["cautela"]); ?></td>
                      <td align="center"><?php echo escapar($fila_i["originalidad"]); ?></td>
                      <td align="center"><?php echo escapar($fila_i["comprension"]); ?></td>
                      <td align="center"><?php echo escapar($fila_i["vitalidad"]); ?></td>
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

      <!-- columna derecha -->
      <section class="col-lg-5 connectedSortable">
        <h4 class="m-0">Gráfico de Resultados</h4>
        <div class="card">
          <div class="card-body">
            <div class="chart">
                <canvas id="grafica" style="height:250px"></canvas>
            </div>
          </div>
        </div>
        <h4 class="m-0">Tabla Puntajes</h4>
        <table class="table" id="tabla_puntajes">
          <thead>
            <tr>
              <th>Id Prueba</th>
              <th>Asc</th>
              <th>Res</th>
              <th>Est</th>
              <th>Soc</th>
              <th>Aut</th>
              <th>Cau</th>
              <th>Ori</th>
              <th>Com</th>
              <th>Vit</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($tabla_puntajes && $sentencia4->rowCount() > 0) {
              foreach ($tabla_puntajes as $fila_p) {
                ?>
                <tr>
                  <td align="center"><?php echo escapar($fila_p["id_prueba"]); ?></td>
                  <td align="center"><?php echo escapar($fila_p["ascendencia"]); ?></td>
                  <td align="center"><?php echo escapar($fila_p["res"]); ?></td>
                  <td align="center"><?php echo escapar($fila_p["est"]); ?></td>
                  <td align="center"><?php echo escapar($fila_p["soc"]); ?></td>
                  <td align="center"><?php echo escapar($fila_p["aut"]); ?></td>
                  <td align="center"><?php echo escapar($fila_p["cau"]); ?></td>
                  <td align="center"><?php echo escapar($fila_p["ori"]); ?></td>
                  <td align="center"><?php echo escapar($fila_p["com"]); ?></td>
                  <td align="center"><?php echo escapar($fila_p["vit"]); ?></td>
                </tr>
                <?php
              }
            }
            ?>
          <tbody>
        </table>
        <!-- Haciendo el comparativo puntaje vrs. percentil -->
        <div class="card-body">

          <!-- Evaluando los puntos de ascendencia -->
          <?php
            
            $puntos_asc = escapar($fila_p["ascendencia"]);

            //consultamos la tabla de baremos
            $consulta5 = "SELECT * FROM h_adulto WHERE puntaje =". $puntos_asc;

            $sentencia5 = $conexion->prepare($consulta5);
            $sentencia5->execute();
            $fila = $sentencia5->fetch();
            $percentil_asc = escapar($fila["ascendencia"]);
          ?>
          <h4 class="m-0">Ascendencia => Percentil <?php echo $percentil_asc;?></h4>
          <?php
            if($percentil_asc <= 45){echo 'Nivel Bajo:<br> El sujeto es poco participativo y toma un rol pasivo dentro del grupo social, presentando poca autoconfianza, delegando la toma de decisiones y pudiendo depender de los consejos de otros.';}
            elseif(50 <= $percentil_asc && $percentil_asc <=75){echo 'Nivel Medio:<br> La persona se presenta como alguien medianamente participativo que podría tomar roles tanto activos como pasivos, también siendo capaz de tomar decisiones, pero pudiendo verse influenciado por las ideas u opiniones de otros.';}
            else{echo 'Nivel Alto:<br> El individuo se muestra dominante y activo en los grupos o situaciones donde deba interactuar con otros, mostrándose seguro de sí mismo, auto afirmativo en sus relaciones interpersonales y tomando decisiones propias sin la influencia de terceros.';}
          ?>
          <hr>
          
          <!-- Evaluando los puntos en responsabilidad -->
          <?php
            $puntos_res = escapar($fila_p["res"]);

            //consultamos la tabla de baremos
            $consulta6 = "SELECT * FROM h_adulto WHERE puntaje =". $puntos_res;

            $sentencia6 = $conexion->prepare($consulta6);
            $sentencia6->execute();
            $fila = $sentencia6->fetch();
            $percentil_res = escapar($fila["res"]);
          ?>
          <h4 class="m-0">Responsabilidad => Percentil <?php echo $percentil_res;?></h4>
          <?php
            if($percentil_res <= 45){echo 'Nivel Bajo:<br> El individuo es alguien inconstante y que no persevera en las actividades que realiza, por lo que no es considerado por otros como alguien confiable que genere seguridad en los demás.';}
            elseif(50 <= $percentil_res && $percentil_res <=75){echo 'Nivel Medio:<br> La constancia y perseverancia de la persona se verá condicionada por factores como el nivel de interés que presente en la tarea a desarrollar, por lo que es percibido por otros como alguien medianamente confiable pero que no genera seguridad.';}
            else{echo 'Nivel Alto:<br> El sujeto es una persona constante y perseverante en las tareas que realiza aun cuando estas puedan no ser de su interés. Asimismo, se presenta como alguien en quien los demás pueden confiar.';}
          ?>
          <hr>
          
          <!-- Evaluando los puntos en estabilidad -->
          <?php
            $puntos_est = escapar($fila_p["est"]);

            //consultamos la tabla de baremos
            $consulta7 = "SELECT * FROM h_adulto WHERE puntaje =". $puntos_est;

            $sentencia7 = $conexion->prepare($consulta7);
            $sentencia7->execute();
            $fila = $sentencia7->fetch();
            $percentil_est = escapar($fila["est"]);
          ?>
          <h4 class="m-0">Estabilidad Emocional => Percentil <?php echo $percentil_est;?></h4>
          <?php
            if($percentil_est <= 45){echo 'Nivel Bajo:<br> El sujeto es alguien desequilibrado, hipersensible y nervioso que suele presentar tanto preocupaciones constantes como tensión nerviosa, baja tolerancia a la frustración y un ajuste emocional deficiente.';}
            elseif(50 <= $percentil_est && $percentil_est <=75){echo 'Nivel Medio:<br> El individuo es alguien ansioso que presenta constantes preocupaciones pero que es capaz de ajustar su respuesta emocional, presentando a su vez tolerancia a la frustración.';}
            else{echo 'Nivel Alto:<br> La persona se presenta como alguien equilibrado y tranquilo con alta tolerancia a la frustración, con un ajuste emocional adecuado y una ausencia de hipersensibilidad y ansiedad.';}
          ?>
          <hr>

          <!-- Evaluando los puntos en sociabilidad -->
          <?php
            $puntos_soc = escapar($fila_p["soc"]);

            //consultamos la tabla de baremos
            $consulta8 = "SELECT * FROM h_adulto WHERE puntaje =". $puntos_soc;

            $sentencia8 = $conexion->prepare($consulta8);
            $sentencia8->execute();
            $fila = $sentencia8->fetch();
            $percentil_soc = escapar($fila["soc"]);
          ?>
          <h4 class="m-0">Sociabilidad => Percentil <?php echo $percentil_soc;?></h4>
          <?php
            if($percentil_soc <= 45){echo 'Nivel Bajo:<br> El individuo no disfruta de las interacciones sociales por lo que procura mantenerlas al mínimo, pudiendo llegar a la evitación total del contacto con otros.';}
            elseif(50 <= $percentil_soc && $percentil_soc <=75){echo 'Nivel Medio:<br> El sujeto podría ser capaz de relacionarse con otros efectivamente a pesar de no disfrutar enteramente las interacciones sociales, manteniéndolas a niveles intermedios.';}
            else{echo 'Nivel Alto:<br> La persona disfruta de relacionarse con otros, buscando activamente interactuar con aquellos que lo rodeen.';}
          ?>
          <hr>
        
          <!-- Evaluando los puntos en cautela -->
          <?php
            $puntos_cau = escapar($fila_p["cau"]);

            //consultamos la tabla de baremos
            $consulta9 = "SELECT * FROM h_adulto WHERE puntaje =". $puntos_cau;

            $sentencia9 = $conexion->prepare($consulta9);
            $sentencia9->execute();
            $fila = $sentencia9->fetch();
            $percentil_cau = escapar($fila["cau"]);
          ?>
          <h4 class="m-0">Cautela => Percentil <?php echo $percentil_cau;?></h4>
          <?php
            if($percentil_cau <= 45){echo 'Nivel Bajo:<br> La persona es alguien impulsivo que toma decisiones sin analizar a fondo las posibles consecuencias de estas, arriesgándose y aventurándose en el desenlace de los eventos.';}
            elseif(50 <= $percentil_cau && $percentil_cau <=75){echo 'Nivel Medio:<br> El sujeto es alguien precavido pero capaz de tomar decisiones luego de analizar superficial y brevemente las consecuencias de sus elecciones.';}
            else{echo 'Nivel Alto:<br> El individuo es alguien precavido en la toma de decisiones, analizando los pros y contras de manera cuidadosa, evitando arriesgarse o decidir de manera impulsiva.';}
          ?>
          <hr>
          
          <!-- Evaluando los puntos en originalidad -->
          <?php
            $puntos_ori = escapar($fila_p["ori"]);

            //consultamos la tabla de baremos
            $consulta10 = "SELECT * FROM h_adulto WHERE puntaje =". $puntos_ori;

            $sentencia10 = $conexion->prepare($consulta10);
            $sentencia10->execute();
            $fila = $sentencia10->fetch();
            $percentil_ori = escapar($fila["ori"]);
          ?>
          <h4 class="m-0">Originalidad => Percentil <?php echo $percentil_ori;?></h4>
          <?php
            if($percentil_ori <= 45){echo 'Nivel Bajo:<br> El individuo se presenta como alguien poco curioso a quien no le interesa desempeñar tareas intelectualmente laboriosas y complicadas.';}
            elseif(50 <= $percentil_ori && $percentil_ori <=75){echo 'Nivel Medio:<br> La persona es alguien curioso, pero con una inclinación limitada hacia el desarrollo de actividades o tareas desafiantes que requieran de un análisis riguroso para su solución.';}
            else{echo 'Nivel Alto:<br> El sujeto es alguien que disfruta de desempeñar tareas difíciles y desafiantes, mostrándose intelectualmente curioso, e inclinándose por planear y solucionar cuestiones complicadas.';}
          ?>
          <hr>
          
          <!-- Evaluando los puntos en comprensión -->
          <?php
            $puntos_com = escapar($fila_p["com"]);

            //consultamos la tabla de baremos
            $consulta11 = "SELECT * FROM h_adulto WHERE puntaje =". $puntos_com;

            $sentencia11 = $conexion->prepare($consulta11);
            $sentencia11->execute();
            $fila = $sentencia11->fetch();
            $percentil_com = escapar($fila["com"]);
          ?>
          <h4 class="m-0">Comprensión => Percentil <?php echo $percentil_com;?></h4>
          <?php
            if($percentil_com <= 45){echo 'Nivel Bajo:<br> El individuo es alguien intolerante e impaciente quien no deposita su confianza en otros, mostrándose incomprensivo ante las situaciones o necesidades de los demás.';}
            elseif(50 <= $percentil_com && $percentil_com <=75){echo 'Nivel Medio:<br> El sujeto se muestra como una persona comprensiva y paciente ante ciertas situaciones, pero pudiendo mostrarse intolerante en incomprensivo ante otros escenarios.';}
            else{echo 'Nivel Alto:<br> La persona es tolerante, paciente y comprensiva, depositando su fe y confianza en los demás.';}
          ?>
          <hr>
          
          <!-- Evaluando los puntos en vitalidad -->
          <?php
            $puntos_vit = escapar($fila_p["vit"]);

            //consultamos la tabla de baremos
            $consulta12 = "SELECT * FROM h_adulto WHERE puntaje =". $puntos_vit;

            $sentencia12 = $conexion->prepare($consulta12);
            $sentencia12->execute();
            $fila = $sentencia12->fetch();
            $percentil_vit = escapar($fila["vit"]);
          ?>
          <h4 class="m-0">Vitalidad => Percentil <?php echo $percentil_vit;?></h4>
          <?php
            if($percentil_vit <= 45){echo 'Nivel Bajo:<br> El individuo es alguien con poca vitalidad, energía e impulso, desempeñando sus tareas lentamente por tanto teniendo un nivel de eficiencia menor al de los demás.';}
            elseif(50 <= $percentil_vit && $percentil_vit <=75){echo 'Nivel Medio:<br> La persona puede mostrar un nivel de energía moderado, trabajando a un ritmo promedio, manteniéndose dentro de los estándares comunes.';}
            else{echo 'Nivel Alto:<br> El sujeto se muestra enérgico y con gran vigor, actuando y trabajando con rapidez, considerándose más eficiente que los demás.';}
          ?>
          <hr>
          
          <!-- Evaluando los puntos en autoestima -->
          <?php
            $puntos_aut = escapar($fila_p["aut"]);

            //consultamos la tabla de baremos
            $consulta13 = "SELECT * FROM h_adulto WHERE puntaje =". $puntos_aut;

            $sentencia13 = $conexion->prepare($consulta13);
            $sentencia13->execute();
            $fila = $sentencia13->fetch();
            $percentil_aut = escapar($fila["aut"]);
          ?>
          <h4 class="m-0">Autoestima => Percentil <?php echo $percentil_aut;?></h4>
          <?php
            if($percentil_aut <= 45){echo 'Nivel Bajo:<br> El individuo se caracteriza por ser inseguro de sí mismo, actuando reacio en la toma de decisiones, necesitando del apoyo de otros para hacer elecciones.';}
            elseif(50 <= $percentil_aut && $percentil_aut <=75){echo 'Nivel Medio:<br> El sujeto es alguien seguro de sí mismo, capaz de tomar decisiones por sí mismo, pero muchas veces tomando en cuenta las opiniones y creencias de otros para hacer una elección.';}
            else{echo 'Nivel Alto:<br> La persona es alguien seguro de sí mismo, capaz de tomar decisiones por sí mismo, buscando activamente solucionar problemáticas y actuando bajo sus propias creencias y valores.';}
          ?>
        </div>

        
        </section>
    </div>
  </div>
</section>

<!-- llamada del gráfico -->
<?php
  $query = $conexion->prepare("SELECT ascendencia, res, est, soc, aut, cau, ori, com, vit FROM num_prueba WHERE id_prueba=". $id);
  $query->execute();
  $row = $query->fetch();

  $ascendencia = $row[0];
  $res = $row[1];
  $est = $row[2];
  $soc = $row[3];
  $aut = $row[4];
  $cau = $row[5];
  $ori = $row[6];
  $com = $row[7];
  $vit = $row[8];
?>

<script>
  // Obtener una referencia al elemento canvas del DOM
  const $grafica = document.querySelector("#grafica");
  // Las etiquetas son las que van en el eje X. 
  const etiquetas = ["Ascendencia", "Responsabilidad", "Estabilidad", "Sociabilidad","Autoestima","Cautela","Originalidad","Comprensión","Vitalidad"]
  // Declaramos los datos.
  const datosPruebas = {
    label: "Resultados",
    data: ["<?php echo $ascendencia; ?>",
    "<?php echo $res; ?>",
    "<?php echo $est; ?>",
    "<?php echo $soc; ?>",
    "<?php echo $aut; ?>",
    "<?php echo $cau; ?>",
    "<?php echo $ori; ?>",
    "<?php echo $com; ?>",
    "<?php echo $vit; ?>"], 
    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
    borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
    borderWidth: 1,// Ancho del borde
  };
  new Chart($grafica, {
      type: 'line',// Tipo de gráfica
      data: {
          labels: etiquetas,
          datasets: [
            datosPruebas,
              // Aquí más datos...
          ]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }],
          },
      }
  });

</script>

</body>
