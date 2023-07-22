<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
        <!-- Estilo de galería -->
    <style>
        body {
            margin: 100;
            background-color: rgb(249, 249, 84);
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

        --2do estilo
        body {
            background-color: #1F2039;
        }

        section {
            padding: 5mm;
        }

        .grid {
            display: grid;
            justify-content: center;
            grid-template-columns: repeat(auto-fit, minmax(320px, 320px));
            grid-template-rows: 320px;
            gap: 10px;
        }

        .grid img {
            object-fit:contain;
            width: 100%;
            height: 100%;
            border-radius: 20px;
        }

        .box-image {
            position:relative;
        }

        .box-hover {
            position:absolute;
            top: 0;
            bottom: 0;
            right: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: rgb(255, 255, 255);
            display: none;
            justify-content: center;
            align-items: center;
            display: center;
            border-radius: 20px;
        }

        .box-image:hover .box-hover {
            display: flex;
        }

        @media screen and (max-width: 996px) {

            .grid img,
            .box-hover {
                min-height: 320px;
                max-height: 320px;
            }
            .gallery {
                padding: 5px;
            }
        }
    </style>
</head>

<body>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div></div>
                <div class="col-sm-12">
                    <h2>
                        <center>PSICO UEES</center>
                    </h2><br>
                    <h3>
                        <center>Bienvenido Administrador</center>
                    </h3><br>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div align="center">
        <a class="btn btn-primary" href="index.html" onclick="preguntar()">Salir del Aplicativo</a>
    </div>
    <section class="gallery">
        <div class="grid">
            <a class="box-image" href="reg_pac.php">
                <img src="https://thumbs.dreamstime.com/b/icono-de-vector-plano-datos-personales-bellamente-dise%C3%B1ado-171544399.jpg"
                    alt="">
                <div class="box-hover"><h4>REGISTRAR PACIENTES</h4></div>
            </a>
            <a class="box-image" href="calificar_prueba.php">
                <img src="https://st3.depositphotos.com/7438112/14031/v/450/depositphotos_140318556-stock-illustration-form-icon-on-white-background.jpg"
                    alt="">
                <div class="box-hover"><h4 align="center">CALIFICAR PRUEBA</h4></div>
            </a>
        </div>
    </section>
    
</body>
</html>