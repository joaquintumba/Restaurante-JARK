<?php
include 'Configuracion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Carrito de Compras</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="diseño/Menu.css">
    <style>
        #products {
            max-height: 500px;
            /* Establece la altura máxima del contenedor */
            overflow-y: scroll;
            /* Habilita la barra de desplazamiento vertical */
        }

        .product-image {
            width: 100%;
            /* Ajusta las imágenes para que se vean bien en su contenedor */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1>Nuestro Delicioso Menú</h1>
                <a href="index.php" class="btn btn-primary" style="margin-bottom: 10px;">Volver a la pagina principal</a>
                <div id="products" class="row list-group">
                    <?php
                    //get rows query
                    $query = $db->query("SELECT * FROM mis_productos ORDER BY id DESC");
                    if ($query->num_rows > 0) {
                        while ($row = $query->fetch_assoc()) {
                    ?>
                            <div class="item col-lg-4">
                                <div class="thumbnail">
                                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="product-image">
                                    <div class="caption">
                                        <h4 class="list-group-item-heading"><?php echo $row["name"]; ?></h4>
                                        <p class="list-group-item-text"><?php echo $row["description"]; ?></p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="lead"><?php echo 'S/ ' . $row["price"] . ' PEN'; ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <a class="btn btn-success" href="AccionCarta.php?action=addToCart&id=<?php echo $row["id"]; ?>">Enviar al Carrito</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <p>Producto(s) no existe.....</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>