<?php
session_start();
include 'configuracion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $db->real_escape_string($_POST['email']);
    $password = $db->real_escape_string($_POST['password']);

    $query = "SELECT * FROM proveedores WHERE email = '$email'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['proveedor_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['tipo'] = $row['tipo'];
            // Mensaje de éxito y redirección a proveedores.php
            echo "<script>alert('Inicio de sesión exitoso.'); window.location.href='proveedores.php';</script>";
            exit();
        } else {
            $error_msg = "Contraseña incorrecta.";
        }
    } else {
        $error_msg = "No existe una cuenta con ese email.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión de Proveedor</title>
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
            max-width: 400px;
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

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-msg {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Inicio de Sesión de Proveedor</h1>
        <?php
        if (isset($error_msg)) {
            echo '<p class="error-msg">' . $error_msg . '</p>';
        }
        ?>
        <form action="loginProveedor.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br><br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <input type="submit" value="Iniciar Sesión">
            <button type="button" onclick="window.location.href='registro.php'" class="btn btn-primary">Registrarse</button>
        </form>
    </div>
</body>

</html>