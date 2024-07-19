<?php
// Verificar si se ha proporcionado un ID de orden en la URL
if (!isset($_GET['id'])) {
    header("Location: Menu.php");
    exit;
}

// Incluir el archivo de configuración de la base de datos
include 'Configuracion.php';

// Obtener el ID de la orden de la URL
$orderID = $_GET['id'];

// Obtener los detalles de la orden
$query = $db->prepare("SELECT * FROM orden WHERE id = ?");
$query->bind_param("i", $orderID);
$query->execute();
$orderResult = $query->get_result();

if ($orderResult->num_rows === 0) {
    // Si no se encuentra la orden, redirigir a la página de inicio
    header("Location: index.php");
    exit;
}

$order = $orderResult->fetch_assoc();

// Obtener los detalles del cliente asociado a la orden
$customerID = $order['customer_id'];
$query = $db->prepare("SELECT * FROM clientes WHERE id = ?");
$query->bind_param("i", $customerID);
$query->execute();
$customerResult = $query->get_result();

if ($customerResult->num_rows === 0) {
    // Si no se encuentra el cliente asociado, redirigir a la página de inicio
    header("Location: index.php");
    exit;
}

$customer = $customerResult->fetch_assoc();

// Obtener los detalles de los productos comprados en la orden
$query = $db->prepare("SELECT oa.quantity, mp.name, mp.price FROM orden_articulos oa JOIN mis_productos mp ON oa.product_id = mp.id WHERE oa.order_id = ?");
$query->bind_param("i", $orderID);
$query->execute();
$orderItemsResult = $query->get_result();
$orderItems = $orderItemsResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="diseño/Menu.css">
</head>

<body>
    <div class="container factura">
        <div class="header">
            <h1>Pedido exitoso</h1>
            <p class="text-right">Fecha: <?php echo date('d/m/Y'); ?></p>
        </div>
        <div class="customer-details">
            <h2>Datos del Cliente:</h2>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($customer['name']); ?></p>
            <p><strong>Apellido:</strong> <?php echo htmlspecialchars($customer['apellido']); ?></p>
        </div>

        <div class="order-details">
            <h2>Productos Comprados:</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Precio Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalPrice = 0;
                    foreach ($orderItems as $item) {
                        $subtotal = $item['quantity'] * $item['price'];
                        $totalPrice += $subtotal;
                        echo "<tr>";
                        echo "<td>{$item['name']}</td>";
                        echo "<td>{$item['quantity']}</td>";
                        echo "<td>{$item['price']}</td>";
                        echo "<td>{$subtotal}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <p><strong>Total de la Orden:</strong> <?php echo $totalPrice; ?></p>
        </div>
    </div>

    <div class="text-center">
        <a href="index.php" class="btn btn-primary">Volver al Inicio</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>