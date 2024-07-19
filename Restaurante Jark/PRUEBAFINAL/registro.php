<?php
include 'configuracion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $db->real_escape_string($_POST['nombre']);
    $email = $db->real_escape_string($_POST['email']);
    $password = password_hash($db->real_escape_string($_POST['password']), PASSWORD_BCRYPT);
    $tipo = $db->real_escape_string($_POST['tipo']);
    $telefono = $db->real_escape_string($_POST['telefono']); // Nuevo campo

    echo "Datos recibidos: $nombre, $email, $tipo, $telefono<br>";

    $query = "INSERT INTO proveedores (nombre, email, password, tipo, telefono) VALUES ('$nombre', '$email', '$password', '$tipo', '$telefono')";

    if ($db->query($query) === TRUE) {
        echo "Proveedor registrado exitosamente.";
        header("Location: loginProveedor.php"); // Redirige al login después del registro
        exit();
    } else {
        echo "Error en la consulta: " . $db->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Proveedor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="diseño/proveedor.css">
</head>

<body>
    <div class="container">
        <h1>Registro de Proveedor</h1>
        <form action="registro.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo de Proveedor:</label>
                <select id="tipo" name="tipo" class="form-control" required>
                    <option value="gaseosas">Gaseosas</option>
                    <option value="verduras">Verduras</option>
                    <option value="otros">Otros</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
</body>

</html>