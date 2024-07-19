<?php
session_start();
include 'Configuracion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];

    // Consulta para verificar las credenciales del usuario
    $query = $db->prepare("SELECT id, nombre, rol FROM usuarios WHERE nombre = ? AND password = ? AND activo = 1");
    $query->bind_param("ss", $nombre, $password);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_role'] = $user['rol'];

        // Redirigir al CRUD
        header("Location: navegacion.php");
    } else {
        echo "Credenciales incorrectas.";
    }
}
