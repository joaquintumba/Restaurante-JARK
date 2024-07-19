<?php
session_start();

// Verificar si el usuario ha iniciado sesión y obtener su rol
if (!isset($_SESSION['user_id'])) {
    header("Location: loginAdmin.php");
    exit();
}

$user_role = $_SESSION['user_role'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Navegación</title>
    <link rel="stylesheet" href="diseño/navegacion.css">
</head>

<body>
  
    <div class="container">
        <ul>
            <li><a href="crud.php">Registro de Productos</a></li>
            <?php if ($user_role == 'administrador' || $user_role == 'vendedor') : ?>
                <li><a href="ver_pedidos.php">Ver Pedidos</a></li>
            <?php endif; ?>
            <?php if ($user_role == 'administrador') : ?>
                <li><a href="contacto-prov.php">Contactar Proveedores</a></li>
                <li><a href="reporteventasPro.php">Reportes de venta - Proveedores</a></li>
                <li><a href="reporteventasCli.php">Reportes de venta - Clientes</a></li>
                <li><a href="obtenerTransacciones.php">Reportes de venta - Pagos</a></li>
            <?php endif; ?>
            <li><a href="index.php">Atrás</a></li>
        </ul>
    </div>
</body>

</html>