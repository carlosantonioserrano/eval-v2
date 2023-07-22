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
    include 'funciones.php';

    $config = include 'con_pdo.php';

    $resultado = [
    'error' => false,
    'mensaje' => ''
    ];

    try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        
    $id = $_GET['id'];
    $consultaSQL = "DELETE FROM num_prueba WHERE id_prueba =" . $id;

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    header('Location: activar_prueba.php');

    } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
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


</body>
</html>