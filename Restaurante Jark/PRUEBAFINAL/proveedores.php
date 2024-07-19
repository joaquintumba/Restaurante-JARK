<?php
session_start();
include 'configuracion.php';

date_default_timezone_set('America/Lima'); // Ajusta 'America/Your_City' a tu zona horaria

// Verificar si el proveedor ha iniciado sesión
if (!isset($_SESSION['proveedor_id'])) {
    echo "<script>alert('Debe iniciar sesión primero.'); window.location.href='loginProveedor.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $proveedor_id = $_SESSION['proveedor_id'];
    $nombre_producto = $db->real_escape_string($_POST['nombre_producto']);
    $precio = $db->real_escape_string($_POST['precio']);
    $cantidad = $db->real_escape_string($_POST['cantidad']);
    $fecha_compra = date('Y-m-d');  // Fecha actual
    $total_general = $precio * $cantidad;

    $query = "INSERT INTO ventas_proveedor (proveedor_id, nombre_producto, precio, fecha_compra, cantidad, total_general) VALUES ('$proveedor_id', '$nombre_producto', '$precio', '$fecha_compra', '$cantidad', '$total_general')";

    if ($db->query($query) === TRUE) {
        $success_msg = "Venta registrada exitosamente.";
    } else {
        $error_msg = "Error: " . $query . "<br>" . $db->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Ventas del Proveedor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="diseño/proveedor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"],
        .back-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin: 5px;
        }

        input[type="submit"]:hover,
        .back-btn:hover {
            background-color: #0056b3;
        }

        .success-msg {
            color: green;
            margin-bottom: 20px;
        }

        .error-msg {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Registro de Ventas del Proveedor</h1>
        <?php
        if (isset($success_msg)) {
            echo '<p class="success-msg">' . $success_msg . '</p>';
        }
        if (isset($error_msg)) {
            echo '<p class="error-msg">' . $error_msg . '</p>';
        }
        ?>
        <form action="proveedores.php" method="post">
            <label for="nombre_producto">Nombre del Producto:</label>
            <input type="text" id="nombre_producto" name="nombre_producto" required>
            <br>
            <label for="precio">Precio Unitario:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>
            <br>
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" required>
            <br>
            <input type="submit" value="Registrar Venta">
            <a href="index.php" class="back-btn">Volver al Inicio</a>
        </form>
    </div>
</body>

</html>