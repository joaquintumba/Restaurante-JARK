<?php
// Incluir el archivo de configuración de la base de datos
include 'Configuracion.php';

// Funciones para encriptar y desencriptar
function encrypt($data, $key) {
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

// Clave de encriptación (debe ser segura y almacenada en un lugar seguro)
$encryption_key = 'b8e9f8e2d7892d7892f8e2b8e9f8e2d7'; // Ejemplo de clave, debes cambiarla

// Iniciar la sesión del usuario
session_start();

// Obtener los datos del formulario y evitar la inyección SQL
$name = $_POST['name'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$payment_method = $_POST['payment_method'];
$card_number = isset($_POST['card-number']) ? encrypt($_POST['card-number'], $encryption_key) : null;
$card_expiry = isset($_POST['card-expiry']) ? encrypt($_POST['card-expiry'], $encryption_key) : null;
$card_cvc = isset($_POST['card-cvc']) ? encrypt($_POST['card-cvc'], $encryption_key) : null;

// Preparar la consulta para insertar los datos del cliente en la tabla clientes
$query_cliente = $db->prepare("INSERT INTO clientes (name, apellido, email, created, modified, status) VALUES (?, ?, ?, NOW(), NOW(), 'activo')");

// Vincular los parámetros y ejecutar la consulta
$query_cliente->bind_param("sss", $name, $apellido, $email);
$result_cliente = $query_cliente->execute();

if ($result_cliente) {
    // Obtener el ID del cliente recién insertado
    $customerID = $db->insert_id;

    // Almacenar los datos del cliente en la sesión
    $_SESSION['customer_id'] = $customerID;
    $_SESSION['customer_name'] = $name;
    $_SESSION['customer_apellido'] = $apellido;

    // Insertar los detalles de la tarjeta en la tabla detalles_tarjeta si no es "Pagar en tienda"
    if ($payment_method !== 'Tienda') {
        $query_tarjeta = $db->prepare("INSERT INTO detalles_tarjeta (customer_id, payment_method, card_number, card_expiry, card_cvc) VALUES (?, ?, ?, ?, ?)");
        $query_tarjeta->bind_param("issss", $customerID, $payment_method, $card_number, $card_expiry, $card_cvc);
        $result_tarjeta = $query_tarjeta->execute();

        if (!$result_tarjeta) {
            // Guardar el error en la sesión
            $_SESSION['error'] = "Error al registrar los detalles de la tarjeta: " . $db->error;

            // Cerrar la consulta de la tarjeta
            $query_tarjeta->close();

            // Cerrar la consulta del cliente
            $query_cliente->close();

            // Redireccionar de vuelta al formulario con el error
            header("Location: formularioCliente.php");
            exit();
        }

        // Cerrar la consulta de la tarjeta
        $query_tarjeta->close();
    }

    // Limpiar cualquier error anterior
    unset($_SESSION['error']);

    // Cerrar la consulta del cliente
    $query_cliente->close();

    // Redireccionar a Pagos.php
    header("Location: Pagos.php");
    exit();
} else {
    // Guardar el error en la sesión
    $_SESSION['error'] = "Error al registrar el cliente: " . $db->error;

    // Cerrar la consulta del cliente
    $query_cliente->close();

    // Redireccionar de vuelta al formulario con el error
    header("Location: formularioCliente.php");
    exit();
}

// Cerrar la conexión a la base de datos
$db->close();
?>
