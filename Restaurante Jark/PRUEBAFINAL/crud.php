<?php
session_start();
include 'Configuracion.php';

// Verificar si el usuario ha iniciado sesión y obtener su rol
if (!isset($_SESSION['user_id'])) {
    header("Location: loginAdmin.php");
    exit();
}

$user_role = $_SESSION['user_role'];

// Funciones CRUD para productos

// Función para obtener todos los productos
function obtenerProductos()
{
    global $db;
    $query = $db->query("SELECT * FROM mis_productos");
    return $query->fetch_all(MYSQLI_ASSOC);
}

// Función para obtener un producto por su ID
function obtenerProductoPorId($id)
{
    global $db;
    $query = $db->prepare("SELECT * FROM mis_productos WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_assoc();
}

// Función para agregar un producto
function agregarProducto($name, $description, $price, $image, $categoria, $cantidad)
{
    global $db;
    $query = $db->prepare("INSERT INTO mis_productos (name, description, price, image, categoria, cantidad) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssdssi", $name, $description, $price, $image, $categoria, $cantidad);
    return $query->execute();
}

// Función para actualizar un producto
function actualizarProducto($id, $name, $description, $price, $image, $categoria, $cantidad)
{
    global $db;
    $query = $db->prepare("UPDATE mis_productos SET name = ?, description = ?, price = ?, image = ?, categoria = ?, cantidad = ? WHERE id = ?");
    $query->bind_param("ssdssii", $name, $description, $price, $image, $categoria, $cantidad, $id);
    return $query->execute();
}

// Función para eliminar un producto
function eliminarProducto($id)
{
    global $db;
    // Eliminar primero los registros relacionados en orden_articulos si existen
    $query = $db->prepare("DELETE FROM orden_articulos WHERE product_id = ?");
    $query->bind_param("i", $id);
    $query->execute();

    // Ahora eliminar el producto
    $query = $db->prepare("DELETE FROM mis_productos WHERE id = ?");
    $query->bind_param("i", $id);
    return $query->execute();
}

// Manejar las solicitudes CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar'])) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $nombreImagen = $_FILES['image']['name'];
            $rutaImagen = 'Multimedia/imagenes/' . $nombreImagen;
            move_uploaded_file($_FILES['image']['tmp_name'], $rutaImagen);
        } else {
            $rutaImagen = '';
        }
        agregarProducto($_POST['name'], $_POST['description'], $_POST['price'], $rutaImagen, $_POST['categoria'], $_POST['cantidad']);
    } elseif (isset($_POST['actualizar'])) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $nombreImagen = $_FILES['image']['name'];
            $rutaImagen = 'Multimedia/imagenes/' . $nombreImagen;
            move_uploaded_file($_FILES['image']['tmp_name'], $rutaImagen);
        } else {
            $productoExistente = obtenerProductoPorId($_POST['id']);
            $rutaImagen = $productoExistente['image'];
        }
        actualizarProducto($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $rutaImagen, $_POST['categoria'], $_POST['cantidad']);
        header("Refresh:0");
    } elseif (isset($_POST['eliminar'])) {
        eliminarProducto($_POST['id']);
    }
}

$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro y Actualización de Productos</title>
    <link rel="stylesheet" href="diseño/crud.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <h1>Registro de Productos</h1>

    <!-- Botón para volver a la Navegación -->
    <a href="navegacion.php" class="back-btn">Volver</a>
    <a href="Menu.php" class="back-btn">Ver el menú</a>

    <?php if ($user_role == 'administrador' || $user_role == 'vendedor') : ?>
        <!-- Formulario para agregar producto -->
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="">
            <label for="name">Nombre:</label><br>
            <input type="text" id="name" name="name"><br>
            <label for="description">Descripción:</label><br>
            <textarea id="description" name="description"></textarea><br>
            <label for="cantidad">Cantidad:</label><br>
            <input type="text" id="cantidad" name="cantidad"><br>
            <label for="price">Precio:</label><br>
            <input type="text" id="price" name="price"><br>
            <label for="categoria">Categoría:</label><br>
            <select id="categoria" name="categoria">
                <option value="Bebida">Bebidas</option>
                <option value="Postre">Postres</option>
                <option value="Comida Rápida">Comida Rápida</option>
            </select><br>
            <label for="image">Imagen:</label><br>
            <input type="file" id="image" name="image"><br>
            <button type="submit" name="agregar" class="btn btn-success">Agregar</button>
        </form>
    <?php endif; ?>

    <!-- Secciones para productos -->
    <?php
    $categories = array("Bebida", "Postre", "Comida Rápida");

    foreach ($categories as $category) {
        echo "<div id='$category'>";
        echo "<h2>$category</h2>";
        echo "<table class='table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Nombre</th>";
        echo "<th>Descripción</th>";
        echo "<th>Precio</th>";
        echo "<th>Cantidad</th>"; // Nueva columna para cantidad
        echo "<th>Imagen</th>";
        echo "<th>Acciones</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($productos as $producto) {
            if ($producto['categoria'] === $category) {
                echo "<tr>";
                echo "<td>" . $producto['id'] . "</td>";
                echo "<td>" . $producto['name'] . "</td>";
                echo "<td>" . $producto['description'] . "</td>";
                echo "<td>" . $producto['price'] . "</td>";
                echo "<td>" . $producto['cantidad'] . "</td>"; // Mostrar cantidad
                echo "<td><img src='" . $producto['image'] . "' alt='" . $producto['name'] . "' width='50'></td>";
                echo "<td>";
                if ($user_role == 'administrador' || $user_role == 'vendedor') {
                    echo "<button class='btn btn-primary' onclick=\"editarProducto(" . $producto['id'] . ", '" . $producto['name'] . "', '" . $producto['description'] . "', " . $producto['price'] . ", '" . $producto['image'] . "', '" . $producto['categoria'] . "', " . $producto['cantidad'] . ")\">Editar</button>";
                }
                if ($user_role == 'administrador') {
                    echo "<form method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='id' value='" . $producto['id'] . "'>";
                    echo "<button type='submit' name='eliminar' class='btn btn-danger'>Eliminar</button>";
                    echo "</form>";
                }
                echo "</td>";
                echo "</tr>";
            }
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
    ?>

    <!-- Modal para editar producto -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Producto</h4>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="edit_id" name="id" value="">
                        <label for="edit_name">Nombre:</label><br>
                        <input type="text" id="edit_name" name="name"><br>
                        <label for="edit_description">Descripción:</label><br>
                        <textarea id="edit_description" name="description"></textarea><br>
                        <label for="edit_cantidad">Cantidad:</label><br>
                        <input type="text" id="edit_cantidad" name="cantidad"><br>
                        <label for="edit_price">Precio:</label><br>
                        <input type="text" id="edit_price" name="price"><br>
                        <label for="edit_categoria">Categoría:</label><br>
                        <select id="edit_categoria" name="categoria">
                            <option value="Bebida">Bebidas</option>
                            <option value="Postre">Postres</option>
                            <option value="Comida Rápida">Comida Rápida</option>
                        </select><br>
                        <label for="edit_image">Imagen:</label><br>
                        <input type="file" id="edit_image" name="image"><br>
                        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        function editarProducto(id, name, description, price, image, categoria, cantidad) {
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_description').val(description);
            $('#edit_cantidad').val(cantidad);
            $('#edit_price').val(price);
            $('#edit_categoria').val(categoria);
            $('#editModal').modal('show');
        }
    </script>
</body>

</html>
