<?php
if (!isset($_REQUEST['id'])) {
    header("Location: Menu.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="diseño/Menu.css">
    <title>Orden Completado</title>
    <meta charset="utf-8">
    <style>
        .container {
            padding: 20px;
        }

        p {
            color: #34a853;
            font-size: 18px;
        }

        .btn-container {
            margin-top: 20px;
        }

        .btn {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">

                <ul class="nav nav-pills">
                    <li role="presentation" class="active"><a href="Menu.php">Volver</a></li>
                </ul>
            </div>

            <div class="panel-body">

                <h1>Gracias por confiar en nosotros</h1>
                <p>Su orden se envió con éxito y está siendo procesada en este momento. Relájese mientras espera por su comida. El ID de su pedido es <?php echo $_GET['id']; ?></p>
                <!-- Botón para finalizar -->
                <div class="btn-container">
                    <a href="index.php" class="btn btn-primary">Finalizar</a>
                </div>
            </div>
        </div>
        <!--Panel cierra-->
    </div>
</body>

</html>