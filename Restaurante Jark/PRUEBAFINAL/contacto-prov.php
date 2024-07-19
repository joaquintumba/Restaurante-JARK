<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto si tu configuración es diferente
$password = "";
$dbname = "carrito";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar las variables de búsqueda
$search_name = '';
$search_type = '';

// Verificar si se envió una búsqueda
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['search_name'])) {
        $search_name = $conn->real_escape_string($_POST['search_name']);
    }
    if (!empty($_POST['search_type'])) {
        $search_type = $conn->real_escape_string($_POST['search_type']);
    }
}

// Consulta para obtener los datos de los proveedores
$sql = "SELECT nombre, email, telefono, tipo FROM proveedores WHERE 1=1";
if (!empty($search_name)) {
    $sql .= " AND nombre LIKE '%$search_name%'";
}
if (!empty($search_type)) {
    $sql .= " AND tipo = '$search_type'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Proveedores Registrados</title>
    <link rel="stylesheet" href="diseño/reporte_ventas.css">
</head>

<body>
    <h1>Lista de Proveedores Registrados</h1>
    <a href="navegacion.php" class="back-btn">Volver</a>
    <form method="post" action="" class="filter-container">
        <div class="filter-group">
            <label for="search_name">Buscar por nombre:</label>
            <input type="text" id="search_name" name="search_name" value="<?php echo htmlspecialchars($search_name); ?>">
        </div>
        <div class="filter-group">
            <label for="search_type">Tipo de Proveedor:</label>
            <select id="search_type" name="search_type">
                <option value="">Todos</option>
                <option value="gaseosas" <?php if ($search_type == 'gaseosas') echo 'selected'; ?>>Gaseosas</option>
                <option value="verduras" <?php if ($search_type == 'verduras') echo 'selected'; ?>>Verduras</option>
                <option value="otros" <?php if ($search_type == 'otros') echo 'selected'; ?>>Otros</option>
            </select>
        </div>
        <button type="submit">Buscar</button>
        <button type="submit" name="export_csv">Exportar a CSV</button>
    </form>
    <?php
    // Mostrar la tabla de proveedores si hay resultados
    if ($result->num_rows > 0) {
        echo "<table id='tabla'>";
        echo "<tr><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Tipo</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
            echo "<td><a href='https://wa.me/" . urlencode($row["telefono"]) . "' target='_blank'>" . htmlspecialchars($row["telefono"]) . "</a></td>";
            echo "<td>" . htmlspecialchars($row["tipo"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay proveedores registrados.</p>";
    }


    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
    <script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
    <script>
        const $btnExportar = document.querySelector("button[name='export_csv']"),
            $tabla = document.querySelector("#tabla");

        $btnExportar.addEventListener("click", function() {
            let tableExport = new TableExport($tabla, {
                exportButtons: false,
                filename: "Reporte de proveedores",
                sheetname: "Proveedores",
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });
    </script>
</body>

</html>