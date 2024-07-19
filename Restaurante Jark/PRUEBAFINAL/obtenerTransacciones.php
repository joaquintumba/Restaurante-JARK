<?php
include 'Configuracion.php';

// Función para obtener las transacciones con filtros
function obtenerTransacciones($nombreCliente = null, $entidadBancaria = null)
{
    global $db;
    $whereClause = [];

    // Agregar filtro por nombre de cliente si está presente
    if ($nombreCliente) {
        $nombreCliente = $db->real_escape_string($nombreCliente);
        $whereClause[] = "(c.name LIKE '%$nombreCliente%' OR c.apellido LIKE '%$nombreCliente%')";
    }

    // Agregar filtro por entidad bancaria si está presente
    if ($entidadBancaria) {
        $entidadBancaria = $db->real_escape_string($entidadBancaria);
        $whereClause[] = "dt.payment_method LIKE '%$entidadBancaria%'";
    }

    // Unir todos los filtros en una sola cláusula WHERE
    $whereClause = !empty($whereClause) ? "WHERE " . implode(" AND ", $whereClause) : "";

    // Consulta para obtener los detalles de las transacciones
    $query = $db->query("
        SELECT 
            dt.id as transaction_id,
            c.name as customer_name,
            c.apellido as customer_lastname,
            c.email as customer_email,
            dt.payment_method
        FROM detalles_tarjeta dt
        JOIN clientes c ON dt.customer_id = c.id
        $whereClause
        ORDER BY dt.id DESC
    ");

    // Manejo de errores en la consulta
    if ($query === false) {
        die('Error en la consulta: ' . $db->error);
    }

    return $query->fetch_all(MYSQLI_ASSOC);
}

// Determinar los filtros
$nombreCliente = isset($_GET['nombreCliente']) ? $_GET['nombreCliente'] : null;
$entidadBancaria = isset($_GET['entidadBancaria']) ? $_GET['entidadBancaria'] : null;
$transacciones = obtenerTransacciones($nombreCliente, $entidadBancaria);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Transacciones</title>
    <link rel="stylesheet" href="diseño/reporte_ventas.css">
    <script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Reporte de Transacciones</h1>

        <!-- Botón para volver al Menu -->
        <a href="navegacion.php" class="back-btn">Volver</a>

        <!-- Formulario para buscar por nombre del cliente y entidad bancaria -->
        <form method="get" action="obtenerTransacciones.php">
            <div class="filter-container">
                <label for="nombreCliente">Nombre del Cliente:</label>
                <input type="text" id="nombreCliente" name="nombreCliente" value="<?php echo htmlspecialchars($nombreCliente); ?>">
            </div>

            <div class="filter-container">
                <label for="entidadBancaria">Entidad Bancaria:</label>
                <input type="text" id="entidadBancaria" name="entidadBancaria" value="<?php echo htmlspecialchars($entidadBancaria); ?>">
            </div>

            <div class="filter-container">
                <button type="submit" class="search-button">Buscar</button>
            </div>
        </form>

        <!-- Tabla de transacciones -->
        <div class="button-container">
            <button type="button" id="btnExportar" class="export-button">Exportar a Excel</button>
        </div>
        <table id="tabla">
            <thead>
                <tr>
                    <th>ID Transacción</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Método de Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transacciones)) : ?>
                    <?php foreach ($transacciones as $transaccion) : ?>
                        <tr>
                            <td><?php echo $transaccion['transaction_id']; ?></td>
                            <td><?php echo $transaccion['customer_name']; ?></td>
                            <td><?php echo $transaccion['customer_lastname']; ?></td>
                            <td><?php echo $transaccion['customer_email']; ?></td>
                            <td><?php echo $transaccion['payment_method']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No se encontraron transacciones.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <script>
            const $btnExportar = document.querySelector("#btnExportar"),
                $tabla = document.querySelector("#tabla");

            $btnExportar.addEventListener("click", function() {
                let tableExport = new TableExport($tabla, {
                    exportButtons: false,
                    filename: "Reporte de Transacciones",
                    sheetname: "Reporte de Transacciones",
                });
                let datos = tableExport.getExportData();
                let preferenciasDocumento = datos.tabla.xlsx;
                tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
            });
        </script>
    </div>
</body>

</html>