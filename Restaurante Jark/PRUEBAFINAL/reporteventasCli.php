<?php
include 'Configuracion.php';

// Función para obtener el reporte de ventas con filtros
function obtenerReporteVentas($filtro, $fecha = null, $nombreCliente = null)
{
    global $db;
    $whereClause = [];

    // Determinar el rango de tiempo según el filtro seleccionado
    switch ($filtro) {
        case 'diario':
            $whereClause[] = "DATE(orden.created) = CURDATE()";
            break;
        case 'semanal':
            // Utilizar BETWEEN para las fechas de la semana actual (de lunes a domingo)
            $whereClause[] = "DATE(orden.created) BETWEEN DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY) AND DATE_ADD(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL 6 DAY)";
            break;
        case 'mensual':
            $whereClause[] = "MONTH(orden.created) = MONTH(CURDATE()) AND YEAR(orden.created) = YEAR(CURDATE())";
            break;
        case 'anual':
            $whereClause[] = "YEAR(orden.created) = YEAR(CURDATE())";
            break;
        case 'fecha':
            if ($fecha) {
                $whereClause[] = "DATE(orden.created) = '$fecha'";
            }
            break;
    }

    // Agregar filtro por nombre de cliente si está presente
    if ($nombreCliente) {
        $whereClause[] = "(clientes.name LIKE '%$nombreCliente%' OR clientes.apellido LIKE '%$nombreCliente%')";
    }

    // Unir todos los filtros en una sola cláusula WHERE
    $whereClause = !empty($whereClause) ? "WHERE " . implode(" AND ", $whereClause) : "";

    // Consulta para obtener los detalles de las ventas con filtro de tiempo
    $query = $db->query("
        SELECT 
            orden.id as order_id,
            clientes.name as customer_name,
            clientes.apellido as customer_lastname,
            orden.created as order_date,
            orden_articulos.quantity,
            mis_productos.name as product_name,
            mis_productos.price as product_price,
            (orden_articulos.quantity * mis_productos.price) as total_price
        FROM orden
        JOIN clientes ON orden.customer_id = clientes.id
        JOIN orden_articulos ON orden.id = orden_articulos.order_id
        JOIN mis_productos ON orden_articulos.product_id = mis_productos.id
        $whereClause
        ORDER BY orden.created DESC
    ");

    return $query->fetch_all(MYSQLI_ASSOC);
}

// Función para eliminar los pedidos seleccionados
function eliminarPedidos($orderIds)
{
    global $db;
    // Eliminar filas relacionadas en la tabla orden_articulos
    $placeholders = implode(',', array_fill(0, count($orderIds), '?'));
    $stmt = $db->prepare("DELETE FROM orden_articulos WHERE order_id IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($orderIds)), ...$orderIds);
    $stmt->execute();

    // Eliminar filas en la tabla orden
    $stmt = $db->prepare("DELETE FROM orden WHERE id IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($orderIds)), ...$orderIds);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Manejar la solicitud de eliminación de pedidos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $orderIds = isset($_POST['seleccionar']) ? $_POST['seleccionar'] : [];
    if (!empty($orderIds)) {
        eliminarPedidos($orderIds);
        header("Location: reporteventasCli.php");
        exit();
    }
}

// Determinar el filtro seleccionado, la fecha especificada y el nombre del cliente
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todos';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
$nombreCliente = isset($_GET['nombreCliente']) ? $_GET['nombreCliente'] : null;
$reporteVentas = obtenerReporteVentas($filtro, $fecha, $nombreCliente);

// Calcular el total general de todos los productos vendidos
$totalGeneral = 0;
foreach ($reporteVentas as $reporte) {
    $totalGeneral += $reporte['total_price'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - Clientes</title>
    <link rel="stylesheet" href="diseño/reporte_ventas.css">
    <!-- Enlaces para exportar a Excel -->
    <script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
</head>

<body>
<div class="container">
    <h1>Reporte de Ventas</h1>

    <!-- Botón para volver al Menu -->
    <a href="navegacion.php" class="back-btn">Volver</a>

    <!-- Formulario para seleccionar el filtro de tiempo -->
    <form method="get" action="reporteventasCli.php">
        <div class="filter-container">
            <label for="filtro">Filtrar por:</label>
            <select name="filtro" id="filtro" onchange="mostrarCampoFecha(this.value)">
                <option value="todos" <?php if ($filtro == 'todos') echo 'selected'; ?>>Todos</option>
                <option value="diario" <?php if ($filtro == 'diario') echo 'selected'; ?>>Diario</option>
                <option value="semanal" <?php if ($filtro == 'semanal') echo 'selected'; ?>>Semanal</option>
                <option value="mensual" <?php if ($filtro == 'mensual') echo 'selected'; ?>>Mensual</option>
                <option value="anual" <?php if ($filtro == 'anual') echo 'selected'; ?>>Anual</option>
                <option value="fecha" <?php if ($filtro == 'fecha') echo 'selected'; ?>>Fecha Específica</option>
            </select>
            <div id="fecha-container" style="display: <?php echo ($filtro == 'fecha') ? 'inline-block' : 'none'; ?>; margin-left: 10px;">
                <input type="date" name="fecha" value="<?php echo $fecha; ?>">
            </div>
        </div>

        <div class="filter-container">
            <label for="nombreCliente">Nombre del Cliente:</label>
            <input type="text" id="nombreCliente" name="nombreCliente" value="<?php echo htmlspecialchars($nombreCliente); ?>">
            <button type="submit" class="search-button">Buscar</button>
        </div>
    </form>

    <!-- Formulario para eliminar pedidos -->
    <form method="post" action="reporteventasCli.php">
        <div class="button-container">
            <button type="submit" name="eliminar" class="delete-button">Eliminar</button>
            <button type="button" id="btnExportar" class="export-button">Exportar a Excel</button>
        </div>
        <table id="tabla">
            <thead>
                <tr>
                    <th></th>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha de Pedido</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total del Pedido</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reporteVentas)) : ?>
                    <?php foreach ($reporteVentas as $reporte) : ?>
                        <tr>
                            <td><input type="checkbox" name="seleccionar[]" value="<?php echo $reporte['order_id']; ?>"></td>
                            <td><?php echo $reporte['order_id']; ?></td>
                            <td><?php echo $reporte['customer_name'] . ' ' . $reporte['customer_lastname']; ?></td>
                            <td><?php echo $reporte['order_date']; ?></td>
                            <td><?php echo $reporte['product_name']; ?></td>
                            <td><?php echo $reporte['quantity']; ?></td>
                            <td><?php echo $reporte['product_price']; ?></td>
                            <td><?php echo $reporte['total_price']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="7" style="text-align: right;"><strong>Total General:</strong></td>
                        <td><strong><?php echo $totalGeneral; ?></strong></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No se encontraron ventas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>

        <script>
            function mostrarCampoFecha(valor) {
                const fechaContainer = document.getElementById('fecha-container');
                if (valor === 'fecha') {
                    fechaContainer.style.display = 'block';
                } else {
                    fechaContainer.style.display = 'none';
                }
            }

            const $btnExportar = document.querySelector("#btnExportar"),
                $tabla = document.querySelector("#tabla");

            $btnExportar.addEventListener("click", function() {
                let tableExport = new TableExport($tabla, {
                    exportButtons: false, // No queremos botones
                    filename: "Reporte de Ventas", // Nombre del archivo de Excel
                    sheetname: "Reporte de Ventas", // Título de la hoja
                });
                let datos = tableExport.getExportData();
                let preferenciasDocumento = datos.tabla.xlsx;
                tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
            });
        </script>
    </div>
</body>

</html>