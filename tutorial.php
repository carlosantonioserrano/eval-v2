<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <title>Tutorial</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="./plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="./plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="./plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="./plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="./plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="./plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <style>
    body {margin:100;}
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
<body class="hold-transition sidebar-mini">
  
<div class="wrapper">
  <div style="padding:10px;margin-top:50px" >
    <ul a>
      <li><a href="index.html">Inicio</a></li>
      <li><a class="active" href="tutorial.php">Tutorial</a></li>
      <li><a href="login_prueba.php">Ir a Prueba PPG-IPG</a></li>
    </ul>
  </div>
  <h1 align="center">Tutorial Prueba PPG-IPG</h1><br>
  <h5 style="margin-left: 30px">
    A continuación encontrará cuatro afirmaciones de las cuales seleccionará la que más se acerca a su personalidad con el signo "más" (+), y también deberá seleccionar aquella que menos se acerque a su personalidad con el signo "menos" (-).
  </h5><br>
  <p style="margin-left: 30px">• Recuerde que no puede seleccionar dos o más con el signo mas (+).</br>
  • No puede seleccionar dos o más con el signo menos (-).</br>
  • No deberá dejar el grupo sin ninguna selección.</p>

  <section class="content">
      <div class="container-fluid">
        <!-- Formulario -->
        <form method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
          <!--$_SERVER["PHP_SELF"] envía los datos del formulario a la página misma-->
        <div class="card card-default">
          <div class="card-body">
            <table class="default" width="40%" align="center">
              <tr style="background-color: rgb(255, 253, 152);">
                <td><strong>A.</strong> Tiene un apetito excelente.</td>
                <td>
                  <div class="col-md-13">
                    <select class="form-control select1A" style="width: 100%;" name="A">
                      <option selected="selected" value="NS">No seleccionado</option>
                      <option value="+">+</option>
                      <option value="-">-</option>
                    </select>
                  </div>
                </td>
              </tr>
              <tr>
                <td><strong>B.</strong> Se pone enfermo con frecuencia.</td>
                <td>
                  <div class="col-md-13">
                    <select class="form-control select1B" style="width: 100%;" name="B">
                      <option selected="selected" value="NS">No seleccionado</option>
                      <option value="+">+</option>
                      <option value="-">-</option>
                    </select>
                  </div>
                </td>
              </tr>
              <tr style="background-color: rgb(255, 253, 152);">
                <td><strong>C.</strong> Lleva una alimentación equilibrada.</td>
                <td>
                  <div class="col-md-13">
                    <select class="form-control select1C" style="width: 100%;" name="C">
                      <option selected="selected" value="NS">No seleccionado</option>
                      <option value="+">+</option>
                      <option value="-">-</option>
                    </select>
                  </div>
                </td>
              </tr>
              <tr>
                <td><strong>D. </strong>No hace suficiente ejercicio.</td>
                <td>
                  <div class="col-md-13">
                      <select class="form-control select1D" style="width: 100%;" name="D">
                        <option selected="selected" value="NS">No seleccionado</option>
                        <option value="+">+</option>
                        <option value="-">-</option>
                      </select>
                    </div>
                </td>
              </tr>
            </table>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        
      </div>
      <div align="center">
      <button type="submit" class="btn btn-block btn-primary" value="Enviar" style="width: 10%;", style="float:center;">Enviar</submit>
      </div>
    </form> 
      <!-- /.container-fluid -->
    </section>

    <?php
      // declaramos el valor de las variable vacías
      $A = $B = $C = $D = "NS";

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $A = test_input($_POST["A"]);
      $B = test_input($_POST["B"]);
      $C = test_input($_POST["C"]);
      $D = test_input($_POST["D"]);
      }

      function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
      }
    ?>

    <?php
        if($A=="NS" && $B=="NS" && $C=="NS" && $D=="NS"){
            echo '<script> alert ("Recuerde: No pueden quedar elemenos sin seleccionar");</script>';
        }

        elseif($A=="+" && $B=="+" || $A=="+" && $C=="+" || $A=="+" && $D=="+"
         || $B=="+" && $C=="+" || $B=="+" && $D=="+"
         || $C=="+" && $D=="+"){
            echo '<script> alert ("Solo puede seleccionar una con el signo más en cada grupo");</script>';
        }

        elseif($A=="-" && $B=="-" || $A=="-" && $C=="-" || $A=="-" && $D=="-"
        || $B=="-" && $C=="-" || $B=="-" && $D=="-"
        || $C=="-" && $D=="-"){
            echo '<script> alert ("Solo puede seleccionar una con el signo menos en cada grupo");</script>';
        }

        elseif($A=="+" && ($B=="NS" && $C=="NS" && $D=="NS")
        || ($B=="+" && ($A=="NS" && $C=="NS" && $D=="NS"))
        || ($C=="+" && ($A=="NS" && $B=="NS" && $D=="NS"))
        || ($D=="+" && ($A=="NS" && $B=="NS" && $C=="NS"))
        ){
            echo '<script> alert ("Faltó una selección con menos");</script>';
        }

        elseif($A=="-" && ($B=="NS" && $C=="NS" && $D=="NS")
        || ($B=="-" && ($A=="NS" && $C=="NS" && $D=="NS"))
        || ($C=="-" && ($A=="NS" && $B=="NS" && $D=="NS"))
        || ($D=="-" && ($A=="NS" && $B=="NS" && $C=="NS"))
        ){
            echo '<script> alert ("Faltó una selección con más");</script>';
        }
        
        else{
        echo '<script> alert ("Exitosamente Finalizado, ahora puedes pasar a realizar tu prueba");</script>';
            
        //echo "El valor seleccionado en la opción A es ".$A. "<br>";
        //echo 'El valor seleccionado en la opción B es '.$B. '<br>';
        //echo 'El valor seleccionado en la opción C es '.$C. '<br>';
        //echo 'El valor seleccionado en la opción D es '.$D. '<br>';
        }
    
    ?>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="../../plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->

</body>
</html>
