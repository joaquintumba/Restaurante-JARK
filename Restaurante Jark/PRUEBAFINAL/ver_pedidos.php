<?php
include_once 'Configuracion.php';
include_once 'INVOICE-main/INVOICE-main/code128.php'; // Incluye la clase para generar PDF
include_once 'TicketPDF.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Función para obtener todos los pedidos con detalles del cliente
function obtenerPedidos()
{
    global $db;
    $query = $db->query("SELECT o.id, o.created, o.total_price, c.name AS cliente_nombre, c.apellido AS cliente_apellido, c.email AS cliente_email FROM orden o JOIN clientes c ON o.customer_id = c.id");
    return $query->fetch_all(MYSQLI_ASSOC);
}

// Función para obtener los detalles de un pedido por su ID
function obtenerDetallesPedido($pedido_id)
{
    global $db;
    $query = $db->prepare("SELECT oa.quantity, mp.name AS producto_nombre, mp.price FROM orden_articulos oa JOIN mis_productos mp ON oa.product_id = mp.id WHERE oa.order_id = ?");
    $query->bind_param("i", $pedido_id);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Función para generar la boleta en PDF
function generarBoleta($pedido, $detalles_pedido)
{
    $pdf = new TicketPDF();
    $pdf->AddPage(); // Agregar una página al PDF
    $pdf->addEmpresaInfo("Nombre de empresa", "0000000000", "Direccion San Salvador, El Salvador", "00000000", "correo@ejemplo.com");
    $pdf->addTicketInfo($pedido['created'], "1", $pedido['cliente_nombre'] . " " . $pedido['cliente_apellido'], $pedido['id']);
    $pdf->addClienteInfo($pedido['cliente_nombre'] . " " . $pedido['cliente_apellido'], "DNI 00000000", "00000000", "San Salvador, El Salvador, Centro America");
    foreach ($detalles_pedido as $detalle) {
        $pdf->addProducto($detalle['producto_nombre'], $detalle['quantity'], $detalle['price'], "$0.00 USD", "$" . number_format($detalle['quantity'] * $detalle['price'], 2) . " USD");
    }
    $pdf->addTotal("$" . number_format($pedido['total_price'], 2) . " USD", "$0.00 USD", "$" . number_format($pedido['total_price'], 2) . " USD", "$100.00 USD", "$30.00 USD", "$0.00 USD");
    $pdf->addFooter("*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar este ticket ***");
    $pdf->addBarcode("COD000001V0001");

    // Guardar el PDF en un archivo temporal
    $filename = "boleta_" . $pedido['id'] . ".pdf";
    $pdf->Output("F", $filename);
    return $filename;
}

// Función para enviar correo con PHPMailer
function enviarCorreoConBoleta($email, $nombre, $archivo_pdf)
{
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP para Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'paulsilvaquesquen24@gmail.com'; // Cambiar por tu dirección de correo
        $mail->Password = 'ljgmoqebuwqfanbs'; // Cambiar por tu contraseña de correo o contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipientes
        $mail->setFrom('tu_email@gmail.com', 'Restaurante-Jark');
        $mail->addAddress($email, $nombre);

        // Archivos adjuntos
        $mail->addAttachment($archivo_pdf);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Gracias por su preferencia';
        $mail->Body    = 'Estimado cliente,<br><br>Adjunto encontrará la boleta de su compra.<br><br>Gracias por su preferencia.<br><br>Saludos,<br>Restaurante JARK';

        $mail->send();
        echo 'El mensaje ha sido enviado';
    } catch (Exception $e) {
        echo "El mensaje no se pudo enviar. Error de Mailer: {$mail->ErrorInfo}";
    }
}

$pedidos = obtenerPedidos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Visualizar Pedidos</title>
    <link rel="stylesheet" href="diseño/ver_pedidos.css">
</head>

<body>
    <h1>Visualizar Pedidos</h1>
    <a href="navegacion.php">Volver</a>
    <div>
        <?php foreach ($pedidos as $pedido) : ?>
            <div class="pedido">
                <h2>Pedido ID: <?php echo $pedido['id']; ?></h2>
                <p>Fecha del Pedido: <?php echo $pedido['created']; ?></p>
                <p>Cliente: <?php echo $pedido['cliente_nombre'] . " " . $pedido['cliente_apellido']; ?></p>
                <p>Correo electrónico: <?php echo $pedido['cliente_email']; ?></p>
                <p>Total Precio: <?php echo $pedido['total_price']; ?></p>
                <h3>Detalles del Pedido:</h3>
                <ul>
                    <?php
                    $detalles_pedido = obtenerDetallesPedido($pedido['id']);
                    foreach ($detalles_pedido as $detalle) : ?>
                        <li><?php echo $detalle['quantity']; ?> x <?php echo $detalle['producto_nombre']; ?> (Precio: <?php echo $detalle['price']; ?>)</li>
                    <?php endforeach; ?>
                </ul>
                <form action="" method="post">
                    <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                    <input type="hidden" name="cliente_email" value="<?php echo $pedido['cliente_email']; ?>">
                    <input type="hidden" name="cliente_nombre" value="<?php echo $pedido['cliente_nombre'] . ' ' . $pedido['cliente_apellido']; ?>">
                    <button type="submit" name="generar_boleta">Generar Boleta</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
    // Procesar la solicitud de generación de boleta
    if (isset($_POST['generar_boleta'])) {
        $pedido_id = $_POST['pedido_id'];
        $cliente_email = $_POST['cliente_email'];
        $cliente_nombre = $_POST['cliente_nombre'];
        $pedido = null;
        foreach ($pedidos as $p) {
            if ($p['id'] == $pedido_id) {
                $pedido = $p;
                break;
            }
        }
        if ($pedido) {
            $detalles_pedido = obtenerDetallesPedido($pedido_id);
            $boleta = generarBoleta($pedido, $detalles_pedido);
            enviarCorreoConBoleta($cliente_email, $cliente_nombre, $boleta);
            echo "<script>window.open('$boleta', '_blank');</script>";
        }
    }
    ?>
</body>

</html>