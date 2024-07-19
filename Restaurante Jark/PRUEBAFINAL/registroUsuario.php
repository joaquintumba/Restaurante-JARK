<?php
session_start();

// Verificar si el usuario está autenticado como administrador


// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar a la base de datos
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'carrito';
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $rol = $_POST['rol']; // Agregar un campo select en el formulario para seleccionar el rol

    // Insertar nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, password, email, rol) VALUES ('$nombre', '$password', '$email', '$rol')";
    if ($conn->query($sql) === TRUE) {
        header("Location: loginAdmin.php");
    } else {
        echo "Error en la consulta: " . $conn->error;
    }

    // Cerrar conexión
    $conn->close();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registro de Usuario</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="diseño/admin.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Registro de Usuario</h2>
                    </div>
                    <div class="card-body">
                        <form action="registroUsuario.php" method="post">
                            <div class="form-group">
                                <label for="nombre">Nombre de usuario:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="rol">Rol:</label>
                                <select id="rol" name="rol" class="form-control" required>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Vendedor">Vendedor</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Registrar</button>
                                <a href="loginAdmin.php" class="btn btn-link">Volver al inicio de sesión</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
