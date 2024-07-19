<?php
include 'configuracion.php';

// Función para obtener el reporte de ventas con filtros
function obtenerReporteVentas($filtro, $fecha = null, $proveedor = null, $tipoProveedor = null)
{
    global $db;
    $whereClause = "WHERE 1=1";

    // Determinar el rango de tiempo según el filtro seleccionado
    switch ($filtro) {
        case 'diario':
            $whereClause .= " AND DATE(fecha_compra) = CURDATE()";
            break;
        case 'semanal':
            $whereClause .= " AND DATE(fecha_compra) BETWEEN DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY) AND DATE_ADD(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL 6 DAY)";
            break;
        case 'mensual':
            $whereClause .= " AND MONTH(fecha_compra) = MONTH(CURDATE()) AND YEAR(CURDATE()) = YEAR(CURDATE())";
            break;
        case 'anual':
            $whereClause .= " AND YEAR(fecha_compra) = YEAR(CURDATE())";
            break;
        case 'fecha':
            if ($fecha) {
                $whereClause .= " AND DATE(fecha_compra) = '$fecha'";
            }
            break;
    }

    // Agregar filtro por proveedor
    if ($proveedor) {
        $whereClause .= " AND p.nombre = '$proveedor'";
    }

    // Agregar filtro por tipo de proveedor
    if ($tipoProveedor) {
        $whereClause .= " AND p.tipo = '$tipoProveedor'";
    }

    // Consulta para obtener los detalles de las ventas con filtro de tiempo
    $query = $db->query("
        SELECT 
            vp.id as order_id,
            p.nombre as proveedor_name,
            p.tipo,
            vp.nombre_producto,
            vp.precio,
            vp.fecha_compra,
            vp.cantidad,
            vp.total_general
        FROM ventas_proveedor vp
        JOIN proveedores p ON vp.proveedor_id = p.id
        $whereClause
        ORDER BY vp.fecha_compra DESC
    ");

    return $query->fetch_all(MYSQLI_ASSOC);
}

// Determinar el filtro seleccionado y la fecha especificada
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todos';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
$proveedor = isset($_GET['proveedor']) ? $_GET['proveedor'] : null;
$tipoProveedor = isset($_GET['tipo_proveedor']) ? $_GET['tipo_proveedor'] : null;
$reporteVentas = obtenerReporteVentas($filtro, $fecha, $proveedor, $tipoProveedor);

// Calcular el total general de todos los productos vendidos
$totalGeneral = 0;
foreach ($reporteVentas as $reporte) {
    $totalGeneral += $reporte['total_general'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - Proveedores</title>
    <link rel="stylesheet" href="diseño/reporte_ventas.css">
    <!-- Enlaces para exportar a Excel -->
    <script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
</head>
<script>
    function mostrarCampoFecha(valor) {
        var fechaContainer = document.getElementById('fecha-container');
        if (valor === 'fecha') {
            fechaContainer.style.display = 'inline-block';
        } else {
            fechaContainer.style.display = 'none';
        }
    }
</script>
</head>

<body>
    <div class="container">
        <h1>Reporte de Ventas</h1>

        <!-- Botón para volver al Menu -->
        <a href="navegacion.php" class="back-btn">Volver</a>

        <!-- Formulario para seleccionar el filtro de tiempo -->
        <form method="get" action="reporteventasPro.php" class="filter-container">
            <div class="filter-group">
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
            <div class="filter-group">
                <label for="proveedor">Proveedor:</label>
                <input type="text" id="proveedor" name="proveedor" value="<?php echo htmlspecialchars($proveedor); ?>">
            </div>
            <div class="filter-group">
                <label for="tipo_proveedor">Tipo de Proveedor:</label>
                <select id="tipo_proveedor" name="tipo_proveedor">
                    <option value="">Todos</option>
                    <option value="gaseosas" <?php if ($tipoProveedor == 'gaseosas') echo 'selected'; ?>>Gaseosas</option>
                    <option value="verduras" <?php if ($tipoProveedor == 'verduras') echo 'selected'; ?>>Verduras</option>
                    <option value="otros" <?php if ($tipoProveedor == 'otros') echo 'selected'; ?>>Otros</option>
                </select>
            </div>
            <button type="submit">Buscar</button>
            <button type="button" id="btnExportar" class="search-button">Exportar a Excel</button>
        </form>

        <table id="tabla">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Proveedor</th>
                    <th>Tipo de Proveedor</th>
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
                            <td><?php echo $reporte['order_id']; ?></td>
                            <td><?php echo $reporte['proveedor_name']; ?></td>
                            <td><?php echo $reporte['tipo']; ?></td>
                            <td><?php echo $reporte['fecha_compra']; ?></td>
                            <td><?php echo $reporte['nombre_producto']; ?></td>
                            <td><?php echo $reporte['cantidad']; ?></td>
                            <td><?php echo $reporte['precio']; ?></td>
                            <td><?php echo $reporte['total_general']; ?></td>
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
    </div>
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
</body>

</html>