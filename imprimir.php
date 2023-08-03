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

    h2 {text-align: center;}
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
    <h2  class="mt-4">Resultados de la Prueba # <?= escapar($num['id'])?></h2>
  </div>
  <?php
}
?>

<!-- Haciendo las conexión para mostrar las tablas -->
<?php
  try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $consulta4 = "SELECT * FROM exam_number WHERE id =" . $id;

  $sentencia4 = $conexion->prepare($consulta4);
  $sentencia4->execute();

  $tabla_puntajes = $sentencia4->fetchAll();

  } catch(PDOException $error) {
  $error= $error->getMessage();
  }
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12" align="center">
        <a href="imprimir.phm?num_prueba=<?php echo $id;?>" class="btn btn-primary mt-4">Imprimir Resultados</a>
      </div>
    </div>
  <hr>
    <div class="row">
      <section class="col-lg-6 connectedSortable">
        <h4 class="m-0">Gráfico de Resultados</h4>
          <div class="card">
            <div class="card-body">
              <div class="chart">
                  <canvas id="grafica" style="height:250px"></canvas>
              </div>
            </div>
          </div>
      </section>
      <section class="col-lg-6 connectedSortable">
        <br><br>
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
                  <td align="center"><?php echo escapar($fila_p["id"]); ?></td>
                  <td align="center"><?php echo escapar($fila_p["ascendancy"]); ?></td>
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
        <hr>
      
        <!-- Haciendo el comparativo puntaje vrs. percentil -->
        <!-- Extrayendo sexo y fecha de nacimiento -->
        <?php
          $num_paciente = 5;
          $consulta5 = "SELECT * FROM patients WHERE id =" . $num_paciente;
          $sentencia5 = $conexion->prepare($consulta5);
          $sentencia5->execute();
          $paciente = $sentencia5->fetch(PDO::FETCH_ASSOC);
          $sexo = escapar($paciente["gender"]);
          $f_nac = escapar($paciente["birthdate"]);
                    
          //calculando la edad
          $f_actual = Date("d-m-Y h:i:s");
          $f1  = new DateTime("$f_nac");
          $f2 = new DateTime($f_actual);
          $intervalo = $f1->diff($f2);
          //presentando la edad del paciente
          echo "Edad del paciente: ".$intervalo->y . " años, " . $intervalo->m." meses, ".$intervalo->d." dias, " . $intervalo->h . " horas, " . $intervalo->i . " minutos";
          echo "<br>";
          echo "Fecha de la prueba: ".$f_actual."";
          echo "<hr>";
        ?>
      </section>
      <hr>
        <!-- Con el sexo y edad, seleccionamos el baremo -->
        <div class="card-body">
        <?php
          if($sexo == 'H'){
            if($intervalo->y < 18){
              //echo "es hombre-adolescente";
              ?>
              <!-- Evaluando los puntos de ascendencia -->
              <?php
                $puntos_asc = escapar($fila_p["ascendancy"]);

                //consultamos la tabla de baremos
                $consulta6 = "SELECT * FROM m_teens WHERE score =". $puntos_asc;

                $sentencia6 = $conexion->prepare($consulta6);
                $sentencia6->execute();
                $fila = $sentencia6->fetch();
                $percentil_asc = escapar($fila["ascendancy"]);
              ?>
              <h4 class="m-0">Ascendencia => Percentil <?php echo $percentil_asc;?></h4>
              <?php
                if($percentil_asc <= 45){echo 'Nivel Bajo:<br> El sujeto es poco participativo y toma un rol pasivo dentro del grupo social, presentando poca autoconfianza, delegando la toma de decisiones y pudiendo depender de los consejos de otros.';}
                elseif(50 <= $percentil_asc && $percentil_asc <=75){echo 'Nivel Medio:<br> La persona se presenta como alguien medianamente participativo que podría tomar roles tanto activos como pasivos, también siendo capaz de tomar decisiones, pero pudiendo verse influenciado por las ideas u opiniones de otros.';}
                else{echo 'Nivel Alto:<br> El individuo se muestra dominante y activo en los grupos o situaciones donde deba interactuar con otros, mostrándose seguro de sí mismo, auto afirmativo en sus relaciones interpersonales y tomando decisiones propias sin la influencia de terceros.';}
              ?>

              <!-- Evaluando los puntos en responsabilidad -->
              <?php
                $puntos_res = escapar($fila_p["res"]);

                //consultamos la tabla de baremos
                $consulta7 = "SELECT * FROM m_teens WHERE score =". $puntos_res;
    
                $sentencia7 = $conexion->prepare($consulta7);
                $sentencia7->execute();
                $fila = $sentencia7->fetch();
                $percentil_res = escapar($fila["res"]);
              ?>
              <hr>
              <h4 class="m-0">Responsabilidad => Percentil <?php echo $percentil_res;?></h4>
              <?php
                if($percentil_res <= 45){echo 'Nivel Bajo:<br> El individuo es alguien inconstante y que no persevera en las actividades que realiza, por lo que no es considerado por otros como alguien confiable que genere seguridad en los demás.';}
                elseif(50 <= $percentil_res && $percentil_res <=75){echo 'Nivel Medio:<br> La constancia y perseverancia de la persona se verá condicionada por factores como el nivel de interés que presente en la tarea a desarrollar, por lo que es percibido por otros como alguien medianamente confiable pero que no genera seguridad.';}
                else{echo 'Nivel Alto:<br> El sujeto es una persona constante y perseverante en las tareas que realiza aun cuando estas puedan no ser de su interés. Asimismo, se presenta como alguien en quien los demás pueden confiar.';}
              ?>

              <!-- Evaluando los puntos en estabilidad -->
              <?php
                $puntos_est = escapar($fila_p["est"]);

                //consultamos la tabla de baremos
                $consulta8 = "SELECT * FROM m_teens WHERE score =". $puntos_est;

                $sentencia8 = $conexion->prepare($consulta8);
                $sentencia8->execute();
                $fila = $sentencia8->fetch();
                $percentil_est = escapar($fila["est"]);
              ?>
              <hr>
              <h4 class="m-0">Estabilidad Emocional => Percentil <?php echo $percentil_est;?></h4>
              <?php
                if($percentil_est <= 45){echo 'Nivel Bajo:<br> El sujeto es alguien desequilibrado, hipersensible y nervioso que suele presentar tanto preocupaciones constantes como tensión nerviosa, baja tolerancia a la frustración y un ajuste emocional deficiente.';}
                elseif(50 <= $percentil_est && $percentil_est <=75){echo 'Nivel Medio:<br> El individuo es alguien ansioso que presenta constantes preocupaciones pero que es capaz de ajustar su respuesta emocional, presentando a su vez tolerancia a la frustración.';}
                else{echo 'Nivel Alto:<br> La persona se presenta como alguien equilibrado y tranquilo con alta tolerancia a la frustración, con un ajuste emocional adecuado y una ausencia de hipersensibilidad y ansiedad.';}
              ?>

              <!-- Evaluando los puntos en sociabilidad -->
              <?php
                $puntos_soc = escapar($fila_p["soc"]);

                //consultamos la tabla de baremos
                $consulta9 = "SELECT * FROM m_teens WHERE score =". $puntos_soc;

                $sentencia9 = $conexion->prepare($consulta9);
                $sentencia9->execute();
                $fila = $sentencia9->fetch();
                $percentil_soc = escapar($fila["soc"]);
              ?>
              <hr>
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
                $consulta10 = "SELECT * FROM m_teens WHERE score =". $puntos_cau;

                $sentencia10 = $conexion->prepare($consulta10);
                $sentencia10->execute();
                $fila = $sentencia10->fetch();
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
                $consulta11 = "SELECT * FROM m_teens WHERE score =". $puntos_ori;

                $sentencia11 = $conexion->prepare($consulta11);
                $sentencia11->execute();
                $fila = $sentencia11->fetch();
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
                $consulta12 = "SELECT * FROM m_teens WHERE score =". $puntos_com;

                $sentencia12 = $conexion->prepare($consulta12);
                $sentencia12->execute();
                $fila = $sentencia12->fetch();
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
                $consulta13 = "SELECT * FROM m_teens WHERE score =". $puntos_vit;

                $sentencia13 = $conexion->prepare($consulta13);
                $sentencia13->execute();
                $fila = $sentencia13->fetch();
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
                $consulta14 = "SELECT * FROM m_teens WHERE score =". $puntos_aut;

                $sentencia14 = $conexion->prepare($consulta14);
                $sentencia14->execute();
                $fila = $sentencia14->fetch();
                $percentil_aut = escapar($fila["aut"]);
              ?>
              <h4 class="m-0">Autoestima => Percentil <?php echo $percentil_aut;?></h4>
              <?php
                if($percentil_aut <= 45){echo 'Nivel Bajo:<br> El individuo se caracteriza por ser inseguro de sí mismo, actuando reacio en la toma de decisiones, necesitando del apoyo de otros para hacer elecciones.';}
                elseif(50 <= $percentil_aut && $percentil_aut <=75){echo 'Nivel Medio:<br> El sujeto es alguien seguro de sí mismo, capaz de tomar decisiones por sí mismo, pero muchas veces tomando en cuenta las opiniones y creencias de otros para hacer una elección.';}
                else{echo 'Nivel Alto:<br> La persona es alguien seguro de sí mismo, capaz de tomar decisiones por sí mismo, buscando activamente solucionar problemáticas y actuando bajo sus propias creencias y valores.';}
            }
            else{
              //echo "es hombre-adulto";
              ?>
              <!-- Evaluando los puntos de ascendencia -->
              <?php
                $puntos_asc = escapar($fila_p["ascendancy"]);

                //consultamos la tabla de baremos
                $consulta15 = "SELECT * FROM m_adults WHERE score =". $puntos_asc;

                $sentencia15 = $conexion->prepare($consulta15);
                $sentencia15->execute();
                $fila = $sentencia15->fetch();
                $percentil_asc = escapar($fila["ascendancy"]);
              ?>
              <h4 class="m-0">Ascendencia => Percentil <?php echo $percentil_asc;?></h4>
              <?php
                if($percentil_asc <= 45){echo 'Nivel Bajo:<br> El sujeto es poco participativo y toma un rol pasivo dentro del grupo social, presentando poca autoconfianza, delegando la toma de decisiones y pudiendo depender de los consejos de otros.';}
                elseif(50 <= $percentil_asc && $percentil_asc <=75){echo 'Nivel Medio:<br> La persona se presenta como alguien medianamente participativo que podría tomar roles tanto activos como pasivos, también siendo capaz de tomar decisiones, pero pudiendo verse influenciado por las ideas u opiniones de otros.';}
                else{echo 'Nivel Alto:<br> El individuo se muestra dominante y activo en los grupos o situaciones donde deba interactuar con otros, mostrándose seguro de sí mismo, auto afirmativo en sus relaciones interpersonales y tomando decisiones propias sin la influencia de terceros.';}
              ?>

              <!-- Evaluando los puntos en responsabilidad -->
              <?php
                $puntos_res = escapar($fila_p["res"]);

                //consultamos la tabla de baremos
                $consulta16 = "SELECT * FROM m_adults WHERE score =". $puntos_res;
    
                $sentencia16 = $conexion->prepare($consulta16);
                $sentencia16->execute();
                $fila = $sentencia16->fetch();
                $percentil_res = escapar($fila["res"]);
              ?>
              <hr>
              <h4 class="m-0">Responsabilidad => Percentil <?php echo $percentil_res;?></h4>
              <?php
                if($percentil_res <= 45){echo 'Nivel Bajo:<br> El individuo es alguien inconstante y que no persevera en las actividades que realiza, por lo que no es considerado por otros como alguien confiable que genere seguridad en los demás.';}
                elseif(50 <= $percentil_res && $percentil_res <=75){echo 'Nivel Medio:<br> La constancia y perseverancia de la persona se verá condicionada por factores como el nivel de interés que presente en la tarea a desarrollar, por lo que es percibido por otros como alguien medianamente confiable pero que no genera seguridad.';}
                else{echo 'Nivel Alto:<br> El sujeto es una persona constante y perseverante en las tareas que realiza aun cuando estas puedan no ser de su interés. Asimismo, se presenta como alguien en quien los demás pueden confiar.';}
              ?>

              <!-- Evaluando los puntos en estabilidad -->
              <?php
                $puntos_est = escapar($fila_p["est"]);

                //consultamos la tabla de baremos
                $consulta17 = "SELECT * FROM m_adults WHERE score =". $puntos_est;

                $sentencia17 = $conexion->prepare($consulta17);
                $sentencia17->execute();
                $fila = $sentencia17->fetch();
                $percentil_est = escapar($fila["est"]);
              ?>
              <hr>
              <h4 class="m-0">Estabilidad Emocional => Percentil <?php echo $percentil_est;?></h4>
              <?php
                if($percentil_est <= 45){echo 'Nivel Bajo:<br> El sujeto es alguien desequilibrado, hipersensible y nervioso que suele presentar tanto preocupaciones constantes como tensión nerviosa, baja tolerancia a la frustración y un ajuste emocional deficiente.';}
                elseif(50 <= $percentil_est && $percentil_est <=75){echo 'Nivel Medio:<br> El individuo es alguien ansioso que presenta constantes preocupaciones pero que es capaz de ajustar su respuesta emocional, presentando a su vez tolerancia a la frustración.';}
                else{echo 'Nivel Alto:<br> La persona se presenta como alguien equilibrado y tranquilo con alta tolerancia a la frustración, con un ajuste emocional adecuado y una ausencia de hipersensibilidad y ansiedad.';}
              ?>

              <!-- Evaluando los puntos en sociabilidad -->
              <?php
                $puntos_soc = escapar($fila_p["soc"]);

                //consultamos la tabla de baremos
                $consulta18 = "SELECT * FROM m_adults WHERE score =". $puntos_soc;

                $sentencia18 = $conexion->prepare($consulta18);
                $sentencia18->execute();
                $fila = $sentencia18->fetch();
                $percentil_soc = escapar($fila["soc"]);
              ?>
              <hr>
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
                $consulta19 = "SELECT * FROM m_adults WHERE score =". $puntos_cau;

                $sentencia19 = $conexion->prepare($consulta19);
                $sentencia19->execute();
                $fila = $sentencia19->fetch();
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
                $consulta20 = "SELECT * FROM m_adults WHERE score =". $puntos_ori;

                $sentencia20 = $conexion->prepare($consulta20);
                $sentencia20->execute();
                $fila = $sentencia20->fetch();
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
                $consulta21 = "SELECT * FROM m_adults WHERE score =". $puntos_com;

                $sentencia21 = $conexion->prepare($consulta21);
                $sentencia21->execute();
                $fila = $sentencia21->fetch();
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
                $consulta22 = "SELECT * FROM m_adults WHERE score =". $puntos_vit;

                $sentencia22 = $conexion->prepare($consulta22);
                $sentencia22->execute();
                $fila = $sentencia22->fetch();
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
                $consulta23 = "SELECT * FROM m_adults WHERE score =". $puntos_aut;

                $sentencia23 = $conexion->prepare($consulta23);
                $sentencia23->execute();
                $fila = $sentencia23->fetch();
                $percentil_aut = escapar($fila["aut"]);
              ?>
              <h4 class="m-0">Autoestima => Percentil <?php echo $percentil_aut;?></h4>
              <?php
                if($percentil_aut <= 45){echo 'Nivel Bajo:<br> El individuo se caracteriza por ser inseguro de sí mismo, actuando reacio en la toma de decisiones, necesitando del apoyo de otros para hacer elecciones.';}
                elseif(50 <= $percentil_aut && $percentil_aut <=75){echo 'Nivel Medio:<br> El sujeto es alguien seguro de sí mismo, capaz de tomar decisiones por sí mismo, pero muchas veces tomando en cuenta las opiniones y creencias de otros para hacer una elección.';}
                else{echo 'Nivel Alto:<br> La persona es alguien seguro de sí mismo, capaz de tomar decisiones por sí mismo, buscando activamente solucionar problemáticas y actuando bajo sus propias creencias y valores.';}
            }
          }
          
          else{
            if($intervalo->y <18){
              //echo "es mujer-adolescente";
              ?>
              <!-- Evaluando los puntos de ascendencia -->
              <?php
                $puntos_asc = escapar($fila_p["ascendancy"]);

                //consultamos la tabla de baremos
                $consulta24 = "SELECT * FROM w_teens WHERE score =". $puntos_asc;

                $sentencia24 = $conexion->prepare($consulta24);
                $sentencia24->execute();
                $fila = $sentencia24->fetch();
                $percentil_asc = escapar($fila["ascendancy"]);
              ?>
              <h4 class="m-0">Ascendencia => Percentil <?php echo $percentil_asc;?></h4>
              <?php
                if($percentil_asc <= 45){echo 'Nivel Bajo:<br> El sujeto es poco participativo y toma un rol pasivo dentro del grupo social, presentando poca autoconfianza, delegando la toma de decisiones y pudiendo depender de los consejos de otros.';}
                elseif(50 <= $percentil_asc && $percentil_asc <=75){echo 'Nivel Medio:<br> La persona se presenta como alguien medianamente participativo que podría tomar roles tanto activos como pasivos, también siendo capaz de tomar decisiones, pero pudiendo verse influenciado por las ideas u opiniones de otros.';}
                else{echo 'Nivel Alto:<br> El individuo se muestra dominante y activo en los grupos o situaciones donde deba interactuar con otros, mostrándose seguro de sí mismo, auto afirmativo en sus relaciones interpersonales y tomando decisiones propias sin la influencia de terceros.';}
              ?>

              <!-- Evaluando los puntos en responsabilidad -->
              <?php
                $puntos_res = escapar($fila_p["res"]);

                //consultamos la tabla de baremos
                $consulta25 = "SELECT * FROM w_teens WHERE score =". $puntos_res;
    
                $sentencia25 = $conexion->prepare($consulta25);
                $sentencia25->execute();
                $fila = $sentencia25->fetch();
                $percentil_res = escapar($fila["res"]);
              ?>
              <hr>
              <h4 class="m-0">Responsabilidad => Percentil <?php echo $percentil_res;?></h4>
              <?php
                if($percentil_res <= 45){echo 'Nivel Bajo:<br> El individuo es alguien inconstante y que no persevera en las actividades que realiza, por lo que no es considerado por otros como alguien confiable que genere seguridad en los demás.';}
                elseif(50 <= $percentil_res && $percentil_res <=75){echo 'Nivel Medio:<br> La constancia y perseverancia de la persona se verá condicionada por factores como el nivel de interés que presente en la tarea a desarrollar, por lo que es percibido por otros como alguien medianamente confiable pero que no genera seguridad.';}
                else{echo 'Nivel Alto:<br> El sujeto es una persona constante y perseverante en las tareas que realiza aun cuando estas puedan no ser de su interés. Asimismo, se presenta como alguien en quien los demás pueden confiar.';}
              ?>

              <!-- Evaluando los puntos en estabilidad -->
              <?php
                $puntos_est = escapar($fila_p["est"]);

                //consultamos la tabla de baremos
                $consulta26 = "SELECT * FROM w_teens WHERE score =". $puntos_est;

                $sentencia26 = $conexion->prepare($consulta26);
                $sentencia26->execute();
                $fila = $sentencia26->fetch();
                $percentil_est = escapar($fila["est"]);
              ?>
              <hr>
              <h4 class="m-0">Estabilidad Emocional => Percentil <?php echo $percentil_est;?></h4>
              <?php
                if($percentil_est <= 45){echo 'Nivel Bajo:<br> El sujeto es alguien desequilibrado, hipersensible y nervioso que suele presentar tanto preocupaciones constantes como tensión nerviosa, baja tolerancia a la frustración y un ajuste emocional deficiente.';}
                elseif(50 <= $percentil_est && $percentil_est <=75){echo 'Nivel Medio:<br> El individuo es alguien ansioso que presenta constantes preocupaciones pero que es capaz de ajustar su respuesta emocional, presentando a su vez tolerancia a la frustración.';}
                else{echo 'Nivel Alto:<br> La persona se presenta como alguien equilibrado y tranquilo con alta tolerancia a la frustración, con un ajuste emocional adecuado y una ausencia de hipersensibilidad y ansiedad.';}
              ?>

              <!-- Evaluando los puntos en sociabilidad -->
              <?php
                $puntos_soc = escapar($fila_p["soc"]);

                //consultamos la tabla de baremos
                $consulta27 = "SELECT * FROM w_teens WHERE score =". $puntos_soc;

                $sentencia27 = $conexion->prepare($consulta27);
                $sentencia27->execute();
                $fila = $sentencia27->fetch();
                $percentil_soc = escapar($fila["soc"]);
              ?>
              <hr>
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
                $consulta28 = "SELECT * FROM w_teens WHERE score =". $puntos_cau;

                $sentencia28 = $conexion->prepare($consulta28);
                $sentencia28->execute();
                $fila = $sentencia28->fetch();
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
                $consulta29 = "SELECT * FROM w_teens WHERE score =". $puntos_ori;

                $sentencia29 = $conexion->prepare($consulta29);
                $sentencia29->execute();
                $fila = $sentencia29->fetch();
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
                $consulta30 = "SELECT * FROM w_teens WHERE score =". $puntos_com;

                $sentencia30 = $conexion->prepare($consulta30);
                $sentencia30->execute();
                $fila = $sentencia30->fetch();
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
                $consulta31 = "SELECT * FROM w_teens WHERE score =". $puntos_vit;

                $sentencia31 = $conexion->prepare($consulta31);
                $sentencia31->execute();
                $fila = $sentencia31->fetch();
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
                $consulta32 = "SELECT * FROM w_teens WHERE score =". $puntos_aut;

                $sentencia32 = $conexion->prepare($consulta32);
                $sentencia32->execute();
                $fila = $sentencia32->fetch();
                $percentil_aut = escapar($fila["aut"]);
              ?>
              <h4 class="m-0">Autoestima => Percentil <?php echo $percentil_aut;?></h4>
              <?php
                if($percentil_aut <= 45){echo 'Nivel Bajo:<br> El individuo se caracteriza por ser inseguro de sí mismo, actuando reacio en la toma de decisiones, necesitando del apoyo de otros para hacer elecciones.';}
                elseif(50 <= $percentil_aut && $percentil_aut <=75){echo 'Nivel Medio:<br> El sujeto es alguien seguro de sí mismo, capaz de tomar decisiones por sí mismo, pero muchas veces tomando en cuenta las opiniones y creencias de otros para hacer una elección.';}
                else{echo 'Nivel Alto:<br> La persona es alguien seguro de sí mismo, capaz de tomar decisiones por sí mismo, buscando activamente solucionar problemáticas y actuando bajo sus propias creencias y valores.';}
            }
            else{
              //echo "es mujer-adulta";
              ?>
              <!-- Evaluando los puntos de ascendencia -->
              <?php
                $puntos_asc = escapar($fila_p["ascendancy"]);

                //consultamos la tabla de baremos
                $consulta33 = "SELECT * FROM w_adults WHERE score =". $puntos_asc;

                $sentencia33 = $conexion->prepare($consulta33);
                $sentencia33->execute();
                $fila = $sentencia33->fetch();
                $percentil_asc = escapar($fila["ascendancy"]);
              ?>
              <h4 class="m-0">Ascendencia => Percentil <?php echo $percentil_asc;?></h4>
              <?php
                if($percentil_asc <= 45){echo 'Nivel Bajo:<br> El sujeto es poco participativo y toma un rol pasivo dentro del grupo social, presentando poca autoconfianza, delegando la toma de decisiones y pudiendo depender de los consejos de otros.';}
                elseif(50 <= $percentil_asc && $percentil_asc <=75){echo 'Nivel Medio:<br> La persona se presenta como alguien medianamente participativo que podría tomar roles tanto activos como pasivos, también siendo capaz de tomar decisiones, pero pudiendo verse influenciado por las ideas u opiniones de otros.';}
                else{echo 'Nivel Alto:<br> El individuo se muestra dominante y activo en los grupos o situaciones donde deba interactuar con otros, mostrándose seguro de sí mismo, auto afirmativo en sus relaciones interpersonales y tomando decisiones propias sin la influencia de terceros.';}
              
              ?>

              <!-- Evaluando los puntos en responsabilidad -->
              <?php
                $puntos_res = escapar($fila_p["res"]);

                //consultamos la tabla de baremos
                $consulta34 = "SELECT * FROM w_adults WHERE score =". $puntos_res;
    
                $sentencia34 = $conexion->prepare($consulta34);
                $sentencia34->execute();
                $fila = $sentencia34->fetch();
                $percentil_res = escapar($fila["res"]);
              ?>
              <hr>
              <h4 class="m-0">Responsabilidad => Percentil <?php echo $percentil_res;?></h4>
              <?php
                if($percentil_res <= 45){echo 'Nivel Bajo:<br> El individuo es alguien inconstante y que no persevera en las actividades que realiza, por lo que no es considerado por otros como alguien confiable que genere seguridad en los demás.';}
                elseif(50 <= $percentil_res && $percentil_res <=75){echo 'Nivel Medio:<br> La constancia y perseverancia de la persona se verá condicionada por factores como el nivel de interés que presente en la tarea a desarrollar, por lo que es percibido por otros como alguien medianamente confiable pero que no genera seguridad.';}
                else{echo 'Nivel Alto:<br> El sujeto es una persona constante y perseverante en las tareas que realiza aun cuando estas puedan no ser de su interés. Asimismo, se presenta como alguien en quien los demás pueden confiar.';}
              ?>

              <!-- Evaluando los puntos en estabilidad -->
              <?php
                $puntos_est = escapar($fila_p["est"]);

                //consultamos la tabla de baremos
                $consulta35 = "SELECT * FROM w_adults WHERE score =". $puntos_est;

                $sentencia35 = $conexion->prepare($consulta35);
                $sentencia35->execute();
                $fila = $sentencia35->fetch();
                $percentil_est = escapar($fila["est"]);
              ?>
              <hr>
              <h4 class="m-0">Estabilidad Emocional => Percentil <?php echo $percentil_est;?></h4>
              <?php
                if($percentil_est <= 45){echo 'Nivel Bajo:<br> El sujeto es alguien desequilibrado, hipersensible y nervioso que suele presentar tanto preocupaciones constantes como tensión nerviosa, baja tolerancia a la frustración y un ajuste emocional deficiente.';}
                elseif(50 <= $percentil_est && $percentil_est <=75){echo 'Nivel Medio:<br> El individuo es alguien ansioso que presenta constantes preocupaciones pero que es capaz de ajustar su respuesta emocional, presentando a su vez tolerancia a la frustración.';}
                else{echo 'Nivel Alto:<br> La persona se presenta como alguien equilibrado y tranquilo con alta tolerancia a la frustración, con un ajuste emocional adecuado y una ausencia de hipersensibilidad y ansiedad.';}
              ?>

              <!-- Evaluando los puntos en sociabilidad -->
              <?php
                $puntos_soc = escapar($fila_p["soc"]);

                //consultamos la tabla de baremos
                $consulta36 = "SELECT * FROM w_adults WHERE score =". $puntos_soc;

                $sentencia36 = $conexion->prepare($consulta36);
                $sentencia36->execute();
                $fila = $sentencia36->fetch();
                $percentil_soc = escapar($fila["soc"]);
              ?>
              <hr>
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
                $consulta37 = "SELECT * FROM w_adults WHERE score =". $puntos_cau;

                $sentencia37 = $conexion->prepare($consulta37);
                $sentencia37->execute();
                $fila = $sentencia37->fetch();
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
                $consulta38 = "SELECT * FROM w_adults WHERE score =". $puntos_ori;

                $sentencia38 = $conexion->prepare($consulta38);
                $sentencia38->execute();
                $fila = $sentencia38->fetch();
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
                $consulta39 = "SELECT * FROM w_adults WHERE score =". $puntos_com;

                $sentencia39 = $conexion->prepare($consulta39);
                $sentencia39->execute();
                $fila = $sentencia39->fetch();
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
                $consulta40 = "SELECT * FROM w_adults WHERE score =". $puntos_vit;

                $sentencia40 = $conexion->prepare($consulta40);
                $sentencia40->execute();
                $fila = $sentencia40->fetch();
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
                $consulta41 = "SELECT * FROM w_adults WHERE score =". $puntos_aut;

                $sentencia41 = $conexion->prepare($consulta41);
                $sentencia41->execute();
                $fila = $sentencia41->fetch();
                $percentil_aut = escapar($fila["aut"]);
              ?>
              <h4 class="m-0">Autoestima => Percentil <?php echo $percentil_aut;?></h4>
              <?php
                if($percentil_aut <= 45){echo 'Nivel Bajo:<br> El individuo se caracteriza por ser inseguro de sí mismo, actuando reacio en la toma de decisiones, necesitando del apoyo de otros para hacer elecciones.';}
                elseif(50 <= $percentil_aut && $percentil_aut <=75){echo 'Nivel Medio:<br> El sujeto es alguien seguro de sí mismo, capaz de tomar decisiones por sí mismo, pero muchas veces tomando en cuenta las opiniones y creencias de otros para hacer una elección.';}
                else{echo 'Nivel Alto:<br> La persona es alguien seguro de sí mismo, capaz de tomar decisiones por sí mismo, buscando activamente solucionar problemáticas y actuando bajo sus propias creencias y valores.';}
            }
          }
            ?>
        </div>
    </div>
  </div>
</section>

<!-- llamada del gráfico -->
<?php
  $query = $conexion->prepare("SELECT ascendancy, res, est, soc, aut, cau, ori, com, vit FROM exam_number WHERE id=". $id);
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
