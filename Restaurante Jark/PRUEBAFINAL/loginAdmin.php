<!DOCTYPE html>
<html>

<head>
    <title>Iniciar sesión como Administrador</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="diseño/admin.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Ingrese su usuario</h2>
                    </div>
                    <div class="card-body">
                        <form action="autenticacion.php" method="post">
                            <div class="form-group">
                                <label for="nombre">Nombre de usuario:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                                <a href="registroUsuario.php" class="btn btn-link">Registrar</a> <!-- Enlace para registrar nuevos usuarios -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>