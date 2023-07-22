<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <title>Prueba PPG-IPG</title>
  
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

  <?php
  include 'header.php';
  ?>
</head>
<body class="hold-transition sidebar-mini">
 
<div class="wrapper"> 
  
  <h1 align="center">Prueba PPG-IPG</h1><br>
    <h5 style="margin-left: 50px">
      Dispone 38 grupos o tétradas. No se detenga demasiado tiempo en seleccionar, simplemente responda conforme a su personalidad.
    </h5>
    <section class="content">
      <div class="container-fluid">
        <!-- Formulario -->
        <form method="post" action='enviar1.php'>
          <!-- Tétadra #1 -->
        <div class="card card-default">
          <div class="card-header" style="background-color: rgb(152, 200, 255)";>
            <label align="center">Grupo 1</label>
          </div>
          <div class="card-body">
          <table class="default" width="40%" align="center">
            <tr style="background-color: rgb(152, 200, 255);">
              <td><strong>A. </strong>Tiene don de gentes en reuniones sociales.</td>
              <td>
                <div class="col-md-13">
                  <select class="form-control select" style="width: 100%;" name="A">
                    <option selected="selected" value="NS">No seleccionado</option>
                    <option value="+">+</option>
                    <option value="-">-</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td><strong>B. </strong>Le falta confianza en si mismo.</td>
              <td>
              <div class="col-md-13">
                  <select class="form-control select" style="width: 100%;" name="B">
                    <option selected="selected" value="NS">No seleccionado</option>
                    <option value="+">+</option>
                    <option value="-">-</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr style="background-color: rgb(152, 200, 255);">
              <td><strong>C. </strong>Es minucioso en todo lo que hace.</td>
              <td>
              <div class="col-md-13">
                  <select class="form-control select" style="width: 100%;" name="C">
                    <option selected="selected" value="NS">No seleccionado</option>
                    <option value="+">+</option>
                    <option value="-">-</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td><strong>D. </strong>Tiene cierta tendencia a dejarse llevar por sus sentimientos.</td>
              <td>
                <div class="col-md-13">
                  <select class="form-control select" style="width: 100%;" name="D">
                    <option selected="selected" value="NS">No seleccionado</option>
                    <option value="+">+</option>
                    <option value="-">-</option>
                  </select>
                </div>
              </td>
            </tr>
          </table>            
        </div>
        </div>
          <!-- Fin Tétadra #1 -->       
      </div>
      <div align="center">
        <button type="submit" class="btn btn-block btn-primary" value="Enviar" style="width: 10%;", style="float:center;">Siguiente</submit>
      </div>
      </form>
      <!-- /.container-fluid -->
    </section>
    <?php
      // declaramos el valor de las variable vacías
      $A = $B = $C = $D = "NS";
    ?>

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
