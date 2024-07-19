<?php
// Incluir el archivo de configuración de la base de datos
include 'Configuracion.php';

// Verificar si se ha enviado un pedido ID válido
if (isset($_POST['pedido_id'])) {
    // Obtener el ID del pedido a eliminar
    $pedido_id = $_POST['pedido_id'];

    // Obtener el ID del cliente asociado al pedido
    $query = $db->prepare("SELECT customer_id FROM orden WHERE id = ?");
    $query->bind_param("i", $pedido_id);
    $query->execute();
    $result = $query->get_result();
    $cliente_id = $result->fetch_assoc()['customer_id'];

    // Eliminar los registros relacionados en la tabla orden_articulos
    $query = $db->prepare("DELETE FROM orden_articulos WHERE order_id = ?");
    $query->bind_param("i", $pedido_id);
    $result = $query->execute();

    if ($result) {
        // Eliminar el registro de la tabla orden
        $query = $db->prepare("DELETE FROM orden WHERE id = ?");
        $query->bind_param("i", $pedido_id);
        $result = $query->execute();

        if ($result) {
            // Eliminar el registro de la tabla clientes
            $query = $db->prepare("DELETE FROM clientes WHERE id = ?");
            $query->bind_param("i", $cliente_id);
            $result = $query->execute();

            if ($result) {
                // Redireccionar al inicio
                header("Location: ver_pedidos.php");
                exit();
            } else {
                echo "Error al eliminar el registro del cliente: " . $db->error;
            }
        } else {
            echo "Error al eliminar el registro del pedido: " . $db->error;
        }
    } else {
        echo "Error al eliminar los registros de los artículos del pedido: " . $db->error;
    }
} else {
    echo "No se ha proporcionado un ID de pedido válido.";
}

// Cerrar la consulta
$query->close();

// Cerrar la conexión a la base de datos
$db->close();
