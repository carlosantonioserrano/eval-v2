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
  
  //Recibiendo los valores de las variables
  if (!isset($_GET['num_prueba'])) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'La prueba no se encuentra Registrada';
  }

  //Recibimos el valor del numero de la prueba
  $num_prueba = $_GET['num_prueba'];
  
//---------EVALUANDO TÉTRADA #1---------
//lectura de tetrada #1 en tabla ppg
try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $tetrada = 1;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //declaro la funcion datos para la tabla ppg
  function datos_ppg(){
    global $nuevo_dato, $num_prueba, $tetrada, $asc, $res, $est, $soc, $auto;
    $nuevo_dato = [
      "id"         => $num_prueba,
      "tetrad"     => $tetrada,
      "ascendancy" => $asc,
      "responsibility" => $res,
      "emotional"  => $est,
      "sociability"  => $soc,
      "self_esteem" => $auto
    ];
  }

  //declaro funcion update para tabla ppg
  function actualiza_ppg(){
    global $consultaSQL;
    $consultaSQL = "UPDATE ppg SET
    ascendancy = :ascendancy,
    responsibility = :responsibility,
    emotional = :emotional,
    sociability = :sociability,
    self_esteem = :self_esteem
    WHERE tetrad = :tetrad AND exam_number_id = :id"; 
  }

  //declaro la funcion datos para la tabla ipg
  function datos_ipg(){
    global $nuevo_dato, $num_prueba, $tetrada, $cau, $ori, $com, $vit;
    $nuevo_dato = [
      "id"         => $num_prueba,
      "tetrada"     => $tetrada,
      "cautela"     => $cau,
      "originalidad" => $ori,
      "comprension"  => $com,
      "vitalidad"  => $vit
    ];
  }

  //declaro funcion update para tabla ipg
  function actualiza_ipg(){
    global $consultaSQL;
    $consultaSQL = "UPDATE ipg SET
    caution = :cautela,
    originality = :originalidad,
    comprehension = :comprension,
    vitality = :vitalidad
    WHERE tetrad = :tetrada AND exam_number_id = :id"; 
  }

  //Realizando cálculos para la tétrada #1 en la categoría ascendencia
  if($B=="+"){$asc=0;}
  elseif($B=="-")
    { $t2=1;
    if($A=="+") {$t1=1;}
    else {$t1=2;}
    $asc=$t1+$t2;
    }
  else{$t2=0;
    if($A=="+") {$t1=1;}
    else {$t1=2;}
    $asc=$t1+$t2;
    }
  
  //Realizando cálculos para la tétrada #1 en la categoría responsabilidad
  if($C=="-"){$res=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $res=$t1+$t2;
    }
  else{$t1=0;
    if($D=="-"){$t2=1;}
    else{$t2=2;}
    $res=$t1+$t2;}

  //Realizando cálculos para la tétrada #1 en la categoría estab_emocional
  if($D=="+"){$est=0;}
  elseif($D=="-"){$est=3;}
  else{$est=2;}

  //Realizando cálculos para la tétrada #1 en la categoría sociabilidad
  if($A=="-"){$soc=0;}
  elseif($A=="+"){$soc=3;}
  else{$soc=2;}

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #1
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}
     
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}

//---------EVALUANDO TÉTRADA #2---------
//lectura de tetrada #2 en tabla ppg
try {
  $tetrada = 2;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #2 en la categoría ascendencia
  if($B=="-"){$asc=0;}
  elseif($B=="+"){$asc=3;}
  else{$asc=2;}
  
  //Realizando cálculos para la tétrada #2 en la categoría responsabilidad
  if($C=="+"){$res=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $res=$t1+$t2;
    }
  else{
    if($D=="+"){$res=1;}
    else{$res=2;}
  }

  //Realizando cálculos para la tétrada #2 en la categoría estab_emocional
  if($B=="-"){$est=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $est=$t1+$t2;
    }
  else{
    if($A=="-"){$est=1;}
    else{$est=2;}
  }

  //Realizando cálculos para la tétrada #2 en la categoría sociabilidad
  if($A=="+"){$soc=0;}
  elseif($A=="-"){$soc=3;}
  else{$soc=2;}

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #2
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}
     
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}

//---------EVALUANDO TÉTRADA #3---------
//lectura de tetrada #3 en tabla ppg
try {
  $tetrada = 3;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #3 en la categoría ascendencia
  if($B=="-"){$asc=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $asc=$t1+$t2;
    }
  else{
    if($A=="-"){$asc=1;}
    else{$asc=2;}
  }
  
  //Realizando cálculos para la tétrada #3 en la categoría responsabilidad
  if($D=="-"){$res=0;}
  elseif($D=="+"){$res=3;}
  else{$res=2;}

  //Realizando cálculos para la tétrada #3 en la categoría estab_emocional
  if($A=="+"){$est=0;}
  elseif($A=="-"){$est=3;}
  else{$est=2;}

  //Realizando cálculos para la tétrada #3 en la categoría sociabilidad
  if($C=="+"){$soc=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $soc=$t1+$t2;
    }
  else{
    if($D=="+"){$soc=1;}
    else{$soc=2;}
  }

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #3
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}
     
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}

//---------EVALUANDO TÉTRADA #4---------
//lectura de tetrada #4 en tabla ppg
try {
  $tetrada = 4;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #4 en la categoría ascendencia
  if($C=="+"){$acs=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $asc=$t1+$t2;
    }
  else{
    if($D=="+"){$asc=1;}
    else{$asc=2;}
  }
  
  //Realizando cálculos para la tétrada #4 en la categoría responsabilidad
  if($B=="+"){$res=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $res=$t1+$t2;
    }
  else{
    if($A=="+"){$res=1;}
    else{$res=2;}
  }

  //Realizando cálculos para la tétrada #4 en la categoría estab_emocional
  if($D=="-"){$est=0;}
  elseif($D=="+"){$est=3;}
  else{$est=2;}

  //Realizando cálculos para la tétrada #4 en la categoría sociabilidad
  if($A=="-"){$soc=0;}
  elseif($A=="+"){$soc=3;}
  else{$soc=2;}

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #4
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}
     
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #5---------
//lectura de tetrada #5 en tabla ppg
try {
  $tetrada = 5;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #5 en la categoría ascendencia
  if($A=="-"){$asc=0;}
  elseif($A=="+"){$asc=3;}
  else{$asc=2;}
  
  //Realizando cálculos para la tétrada #5 en la categoría responsabilidad
  if($D=="-"){$res=0;}
  elseif($D=="+"){$res=3;}
  else{$res=2;}

  //Realizando cálculos para la tétrada #5 en la categoría estab_emocional
  if($C=="+"){$est=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $est=$t1+$t2;
    }
  else{
    if($D=="+"){$est=1;}
    else{$est=2;}
  }

  //Realizando cálculos para la tétrada #5 en la categoría sociabilidad
  if($B=="+"){$soc=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $soc=$t1+$t2;
    }
  else{
    if($A=="+"){$soc=1;}
    else{$soc=2;}
  }

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #5
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}
     
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #6---------
//lectura de tetrada #6 en tabla ppg
try {
  $tetrada = 6;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #6 en la categoría ascendencia
  if($D=="-"){$asc=0;}
  elseif($D=="+"){$asc=3;}
  else{$asc=2;}
  
  //Realizando cálculos para la tétrada #6 en la categoría responsabilidad
  if($B=="+"){$res=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $res=$t1+$t2;
    }
  else{
    if($A=="+"){$res=1;}
    else{$res=2;}
  }

  //Realizando cálculos para la tétrada #6 en la categoría estab_emocional
  if($C=="-"){$est=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $est=$t1+$t2;
    }
  else{
    if($D=="-"){$est=1;}
    else{$est=2;}
  }

  //Realizando cálculos para la tétrada #6 en la categoría sociabilidad
  if($A=="+"){$soc=0;}
  elseif($A=="-"){$soc=3;}
  else{$soc=2;}

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #6
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}
     
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #7---------
//lectura de tetrada #7 en tabla ppg
try {
  $tetrada = 7;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #7 en la categoría ascendencia
  if($C=="+"){$asc=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $asc=$t1+$t2;
    }
  else{
    if($D=="+"){$asc=1;}
    else{$asc=2;}
  }
  
  //Realizando cálculos para la tétrada #7 en la categoría responsabilidad
  if($A=="-"){$res=0;}
  elseif($A=="+"){$res=3;}
  else{$res=2;}

  //Realizando cálculos para la tétrada #7 en la categoría estab_emocional
  if($B=="+"){$est=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $est=$t1+$t2;
    }
  else{
    if($A=="+"){$est=1;}
    else{$est=2;}
  }

  //Realizando cálculos para la tétrada #7 en la categoría sociabilidad
  if($D=="-"){$soc=0;}
  elseif($D=="+"){$soc=3;}
  else{$soc=2;}

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #7
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}
     
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #8---------
//lectura de tetrada #8 en tabla ppg
try {
  $tetrada = 8;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #8 en la categoría ascendencia
  if($A=="-"){$asc=0;}
  elseif($A=="+"){$asc=3;}
  else{$asc=2;}
  
  //Realizando cálculos para la tétrada #8 en la categoría responsabilidad
  if($B=="-"){$res=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $res=$t1+$t2;
    }
  else{
    if($A=="-"){$res=1;}
    else{$res=2;}
  }

  //Realizando cálculos para la tétrada #8 en la categoría estab_emocional
  if($D=="+"){$est=0;}
  elseif($D=="-"){$est=3;}
  else{$est=2;}

  //Realizando cálculos para la tétrada #8 en la categoría sociabilidad
  if($C=="+"){$soc=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $soc=$t1+$t2;
    }
  else{
    if($D=="+"){$soc=1;}
    else{$soc=2;}
  }

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #8
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #9---------
//lectura de tetrada #9 en tabla ppg
try {
  $tetrada = 9;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #9 en la categoría ascendencia
  if($B=="-"){$asc=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $asc=$t1+$t2;
    }
  else{
    if($A=="-"){$asc=1;}
    else{$asc=2;}
  }
  
  //Realizando cálculos para la tétrada #9 en la categoría responsabilidad
  if($C=="-"){$res=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $res=$t1+$t2;
    }
  else{
    if($D=="-"){$res=1;}
    else{$res=2;}
  }

  //Realizando cálculos para la tétrada #9 en la categoría estab_emocional
  if($D=="+"){$est=0;}
  elseif($D=="-"){$est=3;}
  else{$est=2;}

  //Realizando cálculos para la tétrada #9 en la categoría sociabilidad
  if($A=="+"){$soc=0;}
  elseif($A=="-"){$soc=3;}
  else{$soc=2;}

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #9
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #10---------
//lectura de tetrada #10 en tabla ppg
try {
  $tetrada = 10;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #10 en la categoría ascendencia
  if($A=="-"){$asc=0;}
  elseif($A=="+"){$asc=3;}
  else{$asc=2;}
  
  //Realizando cálculos para la tétrada #10 en la categoría responsabilidad
  if($C=="-"){$res=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $res=$t1+$t2;
    }
  else{
    if($D=="-"){$res=1;}
    else{$res=2;}
  }

  //Realizando cálculos para la tétrada #10 en la categoría estab_emocional
  if($B=="+"){$est=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $est=$t1+$t2;
    }
  else{
    if($A=="+"){$est=1;}
    else{$est=2;}
  }

  //Realizando cálculos para la tétrada #10 en la categoría sociabilidad
  if($D=="+"){$soc=0;}
  elseif($D=="-"){$soc=3;}
  else{$soc=2;}

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #10
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #11---------
//lectura de tetrada #11 en tabla ppg
try {
  $tetrada = 11;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #11 en la categoría ascendencia
  if($B=="-"){$asc=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $asc=$t1+$t2;
    }
  else{
    if($A=="-"){$asc=1;}
    else{$asc=2;}
  }
  
  //Realizando cálculos para la tétrada #11 en la categoría responsabilidad
  if($D=="-"){$res=0;}
  elseif($D=="+"){$res=3;}
  else{$res=2;}

  //Realizando cálculos para la tétrada #11 en la categoría estab_emocional
  if($A=="+"){$est=0;}
  elseif($A=="-"){$est=3;}
  else{$est=2;}

  //Realizando cálculos para la tétrada #11 en la categoría sociabilidad
  if($C=="+"){$soc=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $soc=$t1+$t2;
    }
  else{
    if($D=="+"){$soc=1;}
    else{$soc=2;}
  }

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #11
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #12---------
//lectura de tetrada #12 en tabla ppg
try {
  $tetrada = 12;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #12 en la categoría ascendencia
  if($A=="+"){$asc=0;}
  elseif($A=="-"){$asc=3;}
  else{$asc=2;}
  
  //Realizando cálculos para la tétrada #12 en la categoría responsabilidad
  if($B=="+"){$res=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $res=$t1+$t2;
    }
  else{
    if($A=="+"){$res=1;}
    else{$res=2;}
  }

  //Realizando cálculos para la tétrada #12 en la categoría estab_emocional
  if($C=="-"){$est=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $est=$t1+$t2;
    }
  else{
    if($D=="-"){$est=1;}
    else{$est=2;}
  }

  //Realizando cálculos para la tétrada #12 en la categoría sociabilidad
  if($D=="-"){$soc=0;}
  elseif($D=="+"){$soc=3;}
  else{$soc=2;}

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #12
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #13---------
//lectura de tetrada #13 en tabla ppg
try {
  $tetrada = 13;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #13 en la categoría ascendencia
  if($D=="-"){$asc=0;}
  elseif($D=="+"){$asc=3;}
  else{$asc=2;}
  
  //Realizando cálculos para la tétrada #13 en la categoría responsabilidad
  if($B=="+"){$res=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $res=$t1+$t2;
    }
  else{
    if($A=="+"){$res=1;}
    else{$res=2;}
  }

  //Realizando cálculos para la tétrada #13 en la categoría estab_emocional
  if($A=="-"){$est=0;}
  elseif($A=="+"){$est=3;}
  else{$est=2;}

  //Realizando cálculos para la tétrada #13 en la categoría sociabilidad
  if($C=="+"){$soc=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $soc=$t1+$t2;
    }
  else{
    if($D=="+"){$soc=1;}
    else{$soc=2;}
  }

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #13
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #14---------
//lectura de tetrada #14 en tabla ppg
try {
  $tetrada = 14;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #14 en la categoría ascendencia
  if($B=="+"){$asc=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $asc=$t1+$t2;
    }
  else{
    if($A=="+"){$asc=1;}
    else{$asc=2;}
  }
  
  //Realizando cálculos para la tétrada #14 en la categoría responsabilidad
  if($D=="-"){$res=0;}
  elseif($D=="+"){$res=3;}
  else{$res=2;}

  //Realizando cálculos para la tétrada #14 en la categoría estab_emocional
  if($C=="+"){$est=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $est=$t1+$t2;
    }
  else{
    if($D=="+"){$est=1;}
    else{$est=2;}
  }

  //Realizando cálculos para la tétrada #14 en la categoría sociabilidad
  if($A=="-"){$soc=0;}
  elseif($A=="+"){$soc=3;}
  else{$soc=2;}

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #14
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #15---------
//lectura de tetrada #15 en tabla ppg
try {
  $tetrada = 15;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #15 en la categoría ascendencia
  if($A=="-"){$asc=0;}
  elseif($A=="+"){$asc=3;}
  else{$asc=2;}
  
  //Realizando cálculos para la tétrada #15 en la categoría responsabilidad
  if($D=="-"){$res=0;}
  elseif($D=="+"){$res=3;}
  else{$res=2;}

  //Realizando cálculos para la tétrada #15 en la categoría estab_emocional
  if($C=="+"){$est=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $est=$t1+$t2;
    }
  else{
    if($D=="+"){$est=1;}
    else{$est=2;}
  }

  //Realizando cálculos para la tétrada #15 en la categoría sociabilidad
  if($B=="+"){$soc=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $soc=$t1+$t2;
    }
  else{
    if($A=="+"){$soc=1;}
    else{$soc=2;}
  }

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #15
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #16---------
//lectura de tetrada #16 en tabla ppg
try {
  $tetrada = 16;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #16 en la categoría ascendencia
  if($D=="+"){$asc=0;}
  elseif($D=="-"){$asc=3;}
  else{$asc=2;}
  
  //Realizando cálculos para la tétrada #16 en la categoría responsabilidad
  if($B=="+"){$res=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $res=$t1+$t2;
    }
  else{
    if($A=="+"){$res=1;}
    else{$res=2;}
  }

  //Realizando cálculos para la tétrada #16 en la categoría estab_emocional
  if($A=="-"){$est=0;}
  elseif($A=="+"){$est=3;}
  else{$est=2;}

  //Realizando cálculos para la tétrada #16 en la categoría sociabilidad
  if($C=="-"){$soc=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $soc=$t1+$t2;
    }
  else{
    if($D=="-"){$soc=1;}
    else{$soc=2;}
  }

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #16
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #17---------
//lectura de tetrada #17 en tabla ppg
try {
  $tetrada = 17;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #17 en la categoría ascendencia
  if($D=="-"){$asc=0;}
  elseif($D=="+"){$asc=3;}
  else{$asc=2;}
  
  //Realizando cálculos para la tétrada #17 en la categoría responsabilidad
  if($A=="-"){$res=0;}
  elseif($A=="+"){$res=3;}
  else{$res=2;}

  //Realizando cálculos para la tétrada #17 en la categoría estab_emocional
  if($C=="+"){$est=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $est=$t1+$t2;
    }
  else{
    if($D=="+"){$est=1;}
    else{$est=2;}
  }

  //Realizando cálculos para la tétrada #17 en la categoría sociabilidad
  if($B=="+"){$soc=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $soc=$t1+$t2;
    }
  else{
    if($A=="+"){$soc=1;}
    else{$soc=2;}
  }

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #17
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #18---------
//lectura de tetrada #18 en tabla ppg
try {
  $tetrada = 18;
  $consultaSQL = "SELECT * FROM ppg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #18 en la categoría ascendencia
  if($C=="+"){$asc=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $asc=$t1+$t2;
    }
  else{
    if($D=="+"){$asc=1;}
    else{$asc=2;}
  }
  
  //Realizando cálculos para la tétrada #18 en la categoría responsabilidad
  if($A=="-"){$res=0;}
  elseif($A=="+"){$res=3;}
  else{$res=2;}

  //Realizando cálculos para la tétrada #18 en la categoría estab_emocional
  if($B=="+"){$est=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $est=$t1+$t2;
    }
  else{
    if($A=="+"){$est=1;}
    else{$est=2;}
  }
  
  //Realizando cálculos para la tétrada #18 en la categoría sociabilidad
  if($D=="-"){$soc=0;}
  elseif($D=="+"){$soc=3;}
  else{$soc=2;}

  $auto = $asc + $res + $est + $soc;

  //Actualizando el valor de ascendencia, responsabilidad, estabilidad emocional, sociabilidad y autoestima en tétrada #18
  try {
    //Preparamos los valores
    datos_ppg();

    //Hacemos la consulta
    actualiza_ppg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}

//-----SUMANDO CADA CATEGORIA DE TABLA PPG-----
$select=$conexion->prepare("SELECT SUM(ascendancy) AS ascendancy, SUM(responsibility) AS res, SUM(emotional) AS est, SUM(sociability) AS soc, SUM(self_esteem) AS aut FROM ppg WHERE exam_number_id = '{$num_prueba}'") ;
$select->execute();
foreach ($select as $row)

//Actualizando el valor total final en la tabla num_prueba
try {
  //Preparamos los valores
  $nuevo_dato = [
    "id_prueba"  => $num_prueba,
    "ascendencia" => $row[0],
    "res" =>  $row[1],
    "est" =>  $row[2],
    "soc" =>  $row[3],
    "aut" =>  $row[4]
  ];

  //Hacemos la consulta
  $consultaSQL = "UPDATE exam_number SET
  ascendancy = :ascendencia,
  res = :res,
  est = :est,
  soc = :soc,
  aut = :aut
  WHERE id = :id_prueba";

  $consulta = $conexion->prepare($consultaSQL);
  $consulta->execute($nuevo_dato);
}
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
  }


//---------EVALUANDO TÉTRADA #19---------
//lectura de tetrada #19 en tabla ipg
try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $tetrada = 19;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #19 en la categoría cautela
  if($D=="-"){$cau=0;}
  elseif($D=="+"){$cau=3;}
  else{$cau=2;}
  
  //Realizando cálculos para la tétrada #19 en la categoría originalidad
  if($A=="-"){$ori=0;}
  elseif($A=="+"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #19 en la categoría comprensión
  if($C=="+"){$com=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $com=$t1+$t2;
    }
  else{
    if($D=="+"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #19 en la categoría vitalidad
  if($B=="+"){$vit=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $vit=$t1+$t2;
    }
  else{
    if($A=="+"){$vit=1;}
    else{$vit=2;}
  }

  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #19
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}

//---------EVALUANDO TÉTRADA #20---------
//lectura de tetrada #20 en tabla ipg
try {
  $tetrada = 20;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #20 en la categoría cautela
  if($D=="+"){$cau=0;}
  elseif($D=="-"){$cau=3;}
  else{$cau=2;}
  
  //Realizando cálculos para la tétrada #20 en la categoría originalidad
  if($C=="-"){$ori=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $ori=$t1+$t2;
    }
  else{
    if($D=="-"){$ori=1;}
    else{$ori=2;}
  }

  //Realizando cálculos para la tétrada #20 en la categoría comprensión
  if($A=="-"){$com=0;}
  elseif($A=="+"){$com=3;}
  else{$com=2;}
    
  //Realizando cálculos para la tétrada #20 en la categoría vitalidad
  if($B=="+"){$vit=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $vit=$t1+$t2;
    }
  else{
    if($A=="+"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #20
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #21---------
//lectura de tetrada #21 en tabla ipg
try {
  $tetrada = 21;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #21 en la categoría cautela
  if($D=="+"){$cau=0;}
  elseif($D=="-"){$cau=3;}
  else{$cau=2;}
  
  //Realizando cálculos para la tétrada #21 en la categoría originalidad
  if($C=="+"){$ori=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $ori=$t1+$t2;
    }
  else{
    if($D=="+"){$ori=1;}
    else{$ori=2;}
  }

  //Realizando cálculos para la tétrada #21 en la categoría comprensión
  if($B=="-"){$com=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $com=$t1+$t2;
    }
  else{
    if($A=="-"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #21 en la categoría vitalidad
  if($A=="-"){$vit=0;}
  elseif($A=="+"){$vit=3;}
  else{$vit=2;}
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #21
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #22---------
//lectura de tetrada #22 en tabla ipg
try {
  $tetrada = 22;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #22 en la categoría cautela
  if($C=="-"){$cau=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $cau=$t1+$t2;
    }
  else{
    if($D=="-"){$cau=1;}
    else{$cau=2;}
  }
  
  //Realizando cálculos para la tétrada #22 en la categoría originalidad
  if($A=="-"){$ori=0;}
  elseif($A=="+"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #22 en la categoría comprensión
  if($D=="+"){$com=0;}
  elseif($D=="-"){$com=3;}
  else{$com=2;}
    
  //Realizando cálculos para la tétrada #22 en la categoría vitalidad
  if($B=="+"){$vit=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $vit=$t1+$t2;
    }
  else{
    if($A=="+"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #22
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #23---------
//lectura de tetrada #23 en tabla ipg
try {
  $tetrada = 23;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #23 en la categoría cautela
  if($C=="-"){$cau=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $cau=$t1+$t2;
    }
  else{
    if($D=="-"){$cau=1;}
    else{$cau=2;}
  }
  
  //Realizando cálculos para la tétrada #23 en la categoría originalidad
  if($A=="-"){$ori=0;}
  elseif($A=="+"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #23 en la categoría comprensión
  if($D=="+"){$com=0;}
  elseif($D=="-"){$com=3;}
  else{$com=2;}
    
  //Realizando cálculos para la tétrada #23 en la categoría vitalidad
  if($B=="+"){$vit=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $vit=$t1+$t2;
    }
  else{
    if($A=="+"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #23
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #24---------
//lectura de tetrada #24 en tabla ipg
try {
  $tetrada = 24;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #24 en la categoría cautela
  if($A=="+"){$cau=0;}
  elseif($A=="-"){$cau=3;}
  else{$cau=2;}
  
  //Realizando cálculos para la tétrada #24 en la categoría originalidad
  if($D=="-"){$ori=0;}
  elseif($D=="+"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #24 en la categoría comprensión
  if($B=="+"){$com=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $com=$t1+$t2;
    }
  else{
    if($A=="+"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #24 en la categoría vitalidad
  if($C=="-"){$vit=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $vit=$t1+$t2;
    }
  else{
    if($D=="-"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #24
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #25---------
//lectura de tetrada #25 en tabla ipg
try {
  $tetrada = 25;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #25 en la categoría cautela
  if($B=="+"){$cau=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $cau=$t1+$t2;
    }
  else{
    if($A=="+"){$cau=1;}
    else{$cau=2;}
  }
    
  //Realizando cálculos para la tétrada #25 en la categoría originalidad
  if($D=="+"){$ori=0;}
  elseif($D=="-"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #25 en la categoría comprensión
  if($A=="-"){$com=0;}
  elseif($A=="+"){$com=3;}
  else{$com=2;}
    
  //Realizando cálculos para la tétrada #25 en la categoría vitalidad
  if($C=="-"){$vit=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $vit=$t1+$t2;
    }
  else{
    if($D=="-"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #25
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #26---------
//lectura de tetrada #26 en tabla ipg
try {
  $tetrada = 26;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #26 en la categoría cautela
  if($B=="+"){$cau=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $cau=$t1+$t2;
    }
  else{
    if($A=="+"){$cau=1;}
    else{$cau=2;}
  }
  
  //Realizando cálculos para la tétrada #26 en la categoría originalidad
  if($D=="-"){$ori=0;}
  elseif($D=="+"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #26 en la categoría comprensión
  if($C=="-"){$com=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $com=$t1+$t2;
    }
  else{
    if($D=="-"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #26 en la categoría vitalidad
  if($A=="+"){$vit=0;}
  elseif($A=="-"){$vit=3;}
  else{$vit=2;}
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #26
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #27---------
//lectura de tetrada #27 en tabla ipg
try {
  $tetrada = 27;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #27 en la categoría cautela
  if($A=="-"){$cau=0;}
  elseif($A=="+"){$cau=3;}
  else{$cau=2;}
  
  //Realizando cálculos para la tétrada #27 en la categoría originalidad
  if($C=="+"){$ori=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $ori=$t1+$t2;
    }
  else{
    if($D=="+"){$ori=1;}
    else{$ori=2;}
  }

  //Realizando cálculos para la tétrada #27 en la categoría comprensión
  if($B=="+"){$com=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $com=$t1+$t2;
    }
  else{
    if($A=="+"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #27 en la categoría vitalidad
  if($D=="-"){$ori=0;}
  elseif($D=="+"){$ori=3;}
  else{$ori=2;}
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #27
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #28---------
//lectura de tetrada #28 en tabla ipg
try {
  $tetrada = 28;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #28 en la categoría cautela
  if($C=="-"){$cau=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $cau=$t1+$t2;
    }
  else{
    if($D=="-"){$cau=1;}
    else{$cau=2;}
  }
  
  //Realizando cálculos para la tétrada #28 en la categoría originalidad
  if($D=="+"){$ori=0;}
  elseif($D=="-"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #28 en la categoría comprensión
  if($A=="+"){$com=0;}
  elseif($A=="-"){$com=3;}
  else{$com=2;}
    
  //Realizando cálculos para la tétrada #28 en la categoría vitalidad
  if($B=="-"){$vit=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $vit=$t1+$t2;
    }
  else{
    if($A=="-"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #28
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #29---------
//lectura de tetrada #29 en tabla ipg
try {
  $tetrada = 29;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #29 en la categoría cautela
  if($A=="-"){$cau=0;}
  elseif($A=="+"){$cau=3;}
  else{$cau=2;}
  
  //Realizando cálculos para la tétrada #29 en la categoría originalidad
  if($D=="+"){$ori=0;}
  elseif($D=="-"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #29 en la categoría comprensión
  if($C=="-"){$com=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $com=$t1+$t2;
    }
  else{
    if($D=="-"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #29 en la categoría vitalidad
  if($B=="+"){$vit=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $vit=$t1+$t2;
    }
  else{
    if($A=="+"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #29
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #30---------
//lectura de tetrada #30 en tabla ipg
try {
  $tetrada = 30;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #30 en la categoría cautela
  if($D=="-"){$cau=0;}
  elseif($D=="+"){$cau=3;}
  else{$cau=2;}
  
  //Realizando cálculos para la tétrada #30 en la categoría originalidad
  if($C=="-"){$ori=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $ori=$t1+$t2;
    }
  else{
    if($D=="-"){$ori=1;}
    else{$ori=2;}
  }

  //Realizando cálculos para la tétrada #30 en la categoría comprensión
  if($A=="+"){$com=0;}
  elseif($A=="-"){$com=3;}
  else{$com=2;}
    
  //Realizando cálculos para la tétrada #30 en la categoría vitalidad
  if($B=="+"){$vit=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $vit=$t1+$t2;
    }
  else{
    if($A=="+"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #30
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #31---------
//lectura de tetrada #31 en tabla ipg
try {
  $tetrada = 31;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #31 en la categoría cautela
  if($A=="+"){$cau=0;}
  elseif($A=="-"){$cau=3;}
  else{$cau=2;}
  
  //Realizando cálculos para la tétrada #31 en la categoría originalidad
  if($D=="-"){$ori=0;}
  elseif($D=="+"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #31 en la categoría comprensión
  if($C=="+"){$com=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $com=$t1+$t2;
    }
  else{
    if($D=="+"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #31 en la categoría vitalidad
  if($B=="-"){$vit=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $vit=$t1+$t2;
    }
  else{
    if($A=="-"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #31
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #32---------
//lectura de tetrada #32 en tabla ipg
try {
  $tetrada = 32;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #32 en la categoría cautela
  if($C=="+"){$cau=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $cau=$t1+$t2;
    }
  else{
    if($D=="+"){$cau=1;}
    else{$cau=2;}
  }
  
  //Realizando cálculos para la tétrada #32 en la categoría originalidad
  if($D=="-"){$ori=0;}
  elseif($D=="+"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #32 en la categoría comprensión
  if($B=="-"){$com=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $com=$t1+$t2;
    }
  else{
    if($A=="-"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #32 en la categoría vitalidad
  if($A=="+"){$vit=0;}
  elseif($A=="-"){$vit=3;}
  else{$vit=2;}
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #32
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #33---------
//lectura de tetrada #33 en tabla ipg
try {
  $tetrada = 33;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #33 en la categoría cautela
  if($D=="+"){$cau=0;}
  elseif($D=="-"){$cau=3;}
  else{$cau=2;}
  
  //Realizando cálculos para la tétrada #33 en la categoría originalidad
  if($C=="+"){$ori=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $ori=$t1+$t2;
    }
  else{
    if($D=="+"){$ori=1;}
    else{$ori=2;}
  }

  //Realizando cálculos para la tétrada #33 en la categoría comprensión
  if($B=="-"){$com=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $com=$t1+$t2;
    }
  else{
    if($A=="-"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #33 en la categoría vitalidad
  if($A=="-"){$vit=0;}
  elseif($A=="+"){$vit=3;}
  else{$vit=2;}
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #33
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #34---------
//lectura de tetrada #34 en tabla ipg
try {
  $tetrada = 34;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #34 en la categoría cautela
  if($B=="-"){$cau=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $cau=$t1+$t2;
    }
  else{
    if($A=="-"){$cau=1;}
    else{$cau=2;}
  }
  
  //Realizando cálculos para la tétrada #34 en la categoría originalidad
  if($C=="+"){$ori=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $ori=$t1+$t2;
    }
  else{
    if($D=="+"){$ori=1;}
    else{$ori=2;}
  }

  //Realizando cálculos para la tétrada #34 en la categoría comprensión
  if($A=="-"){$com=0;}
  elseif($A=="+"){$com=3;}
  else{$com=2;}
    
  //Realizando cálculos para la tétrada #34 en la categoría vitalidad
  if($D=="+"){$vit=0;}
  elseif($D=="-"){$vit=3;}
  else{$vit=2;}
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #34
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #35---------
//lectura de tetrada #35 en tabla ipg
try {
  $tetrada = 35;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #35 en la categoría cautela
  if($B=="-"){$cau=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $cau=$t1+$t2;
    }
  else{
    if($A=="-"){$cau=1;}
    else{$cau=2;}
  }
  
  //Realizando cálculos para la tétrada #35 en la categoría originalidad
  if($A=="+"){$ori=0;}
  elseif($A=="-"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #35 en la categoría comprensión
  if($D=="+"){$com=0;}
  elseif($D=="-"){$com=3;}
  else{$com=2;}
    
  //Realizando cálculos para la tétrada #35 en la categoría vitalidad
  if($C=="-"){$vit=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $vit=$t1+$t2;
    }
  else{
    if($D=="-"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #35
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #36---------
//lectura de tetrada #36 en tabla ipg
try {
  $tetrada = 36;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #36 en la categoría cautela
  if($B=="+"){$cau=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $cau=$t1+$t2;
    }
  else{
    if($A=="+"){$cau=1;}
    else{$cau=2;}
  }
  
  //Realizando cálculos para la tétrada #36 en la categoría originalidad
  if($D=="-"){$ori=0;}
  elseif($D=="+"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #36 en la categoría comprensión
  if($C=="+"){$com=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $com=$t1+$t2;
    }
  else{
    if($D=="+"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #36 en la categoría vitalidad
  if($A=="-"){$vit=0;}
  elseif($A=="+"){$vit=3;}
  else{$vit=2;}
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #36
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #37---------
//lectura de tetrada #37 en tabla ipg
try {
  $tetrada = 37;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #37 en la categoría cautela
  if($C=="+"){$cau=0;}
  elseif($C=="-")
    {$t2=1;
      if($D=="+"){$t1=1;}
      else{$t1=2;}
      $cau=$t1+$t2;
    }
  else{
    if($D=="+"){$cau=1;}
    else{$cau=2;}
  }
  
  //Realizando cálculos para la tétrada #37 en la categoría originalidad
  if($B=="+"){$ori=0;}
  elseif($B=="-")
    {$t2=1;
      if($A=="+"){$t1=1;}
      else{$t1=2;}
      $ori=$t1+$t2;
    }
  else{
    if($A=="+"){$ori=1;}
    else{$ori=2;}
  }

  //Realizando cálculos para la tétrada #37 en la categoría comprensión
  if($A=="-"){$com=0;}
  elseif($A=="+"){$com=3;}
  else{$com=2;}
    
  //Realizando cálculos para la tétrada #37 en la categoría vitalidad
  if($D=="-"){$vit=0;}
  elseif($D=="+"){$vit=3;}
  else{$vit=2;}
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #37
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//---------EVALUANDO TÉTRADA #38---------
//lectura de tetrada #38 en tabla ipg
try {
  $tetrada = 38;
  $consultaSQL = "SELECT * FROM ipg WHERE exam_number_id = '{$num_prueba}' AND tetrad = '{$tetrada}'";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$datos) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado la fila';
  }

  $A = escapar($datos['A']);
  $B = escapar($datos['B']);
  $C = escapar($datos['C']);
  $D = escapar($datos['D']);

  //Realizando cálculos para la tétrada #38 en la categoría cautela
  if($A=="+"){$cau=0;}
  elseif($A=="-"){$cau=3;}
  else{$cau=2;}
  
  //Realizando cálculos para la tétrada #38 en la categoría originalidad
  if($D=="+"){$ori=0;}
  elseif($D=="-"){$ori=3;}
  else{$ori=2;}

  //Realizando cálculos para la tétrada #38 en la categoría comprensión
  if($B=="-"){$com=0;}
  elseif($B=="+")
    {$t1=1;
      if($A=="-"){$t2=1;}
      else{$t2=2;}
      $com=$t1+$t2;
    }
  else{
    if($A=="-"){$com=1;}
    else{$com=2;}
  }
    
  //Realizando cálculos para la tétrada #38 en la categoría vitalidad
  if($C=="-"){$vit=0;}
  elseif($C=="+")
    {$t1=1;
      if($D=="-"){$t2=1;}
      else{$t2=2;}
      $vit=$t1+$t2;
    }
  else{
    if($D=="-"){$vit=1;}
    else{$vit=2;}
  }
  
  //Actualizando el valor de cautela, originalidad, comprensión y vitalidad en tétrada #38
  try {
    //Preparamos los valores
    datos_ipg();

    //Hacemos la consulta
    actualiza_ipg();

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($nuevo_dato);
  }
  catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}

catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}


//-----SUMANDO CADA CATEGORIA DE TABLA IPG-----
$select=$conexion->prepare("SELECT SUM(caution) AS cau, SUM(originality) AS ori, SUM(comprehension) AS com, SUM(vitality) AS vit FROM ipg WHERE exam_number_id = '{$num_prueba}'") ;
$select->execute();
foreach ($select as $row)

//Actualizando el valor total final en la tabla num_prueba
try {
  //Preparamos los valores
  $nuevo_dato = [
    "id"  => $num_prueba,
    "cau" => $row[0],
    "ori" => $row[1],
    "com" => $row[2],
    "vit" => $row[3]
  ];

  //Hacemos la consulta
  $consultaSQL = "UPDATE exam_number SET
  cau = :cau,
  ori = :ori,
  com = :com,
  vit = :vit
  WHERE id = :id";

  $consulta = $conexion->prepare($consultaSQL);
  $consulta->execute($nuevo_dato);
}
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
  }

//---- cerrando la conexión ----
$consulta->closeCursor();
$consulta = null;
$conexion = null;

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
  header("Location: resultados.php?id=$num_prueba");  
?>
<script>window.location = 'resultados.php'</script> 
</body>     