<?php
include 'La-carta.php';
$cart = new Cart;
include 'Configuracion.php'; // Asegúrate de incluir la configuración para la conexión a la base de datos
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Cart - PHP Shopping Cart Tutorial</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="diseño/Menu.css">

    <script>
        function updateCartItem(obj, id) {
            $.get("AccionCarta.php", {
                action: "updateCartItem",
                id: id,
                qty: obj.value
            }, function(data) {
                if (data == 'ok') {
                    location.reload();
                } else {
                    alert('Error al actualizar el carrito, por favor intente nuevamente.');
                }
            });
        }

        function confirmPurchase() {
            if (confirm("¿Es todo lo que quiere ordenar?\n\nSi presiona 'CANCELAR', volverá al menú para seguir ordenando.\nSi presiona 'ACEPTAR', procederemos con su compra.")) {
                window.location.href = "loginCliente.php";
            } else {
                // No hacer nada si el usuario presiona "NO"
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1>Carrito de compras</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Sub total</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($cart->total_items() > 0) {
                            $cartItems = $cart->contents();
                            foreach ($cartItems as $item) {
                                // Obtener la cantidad disponible desde la base de datos
                                $query = $db->prepare("SELECT cantidad FROM mis_productos WHERE id = ?");
                                $query->bind_param("i", $item['id']);
                                $query->execute();
                                $result = $query->get_result();
                                $row = $result->fetch_assoc();
                                $available_qty = $row['cantidad'];
                        ?>
                                <tr>
                                    <td><?php echo $item["name"]; ?></td>
                                    <td><?php echo 'S/ ' . $item["price"] . ' PEN '; ?></td>
                                    <td>
                                        <input type="number" class="form-control text-center" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')" min="1" max="<?php echo $available_qty; ?>">
                                    </td>
                                    <td><?php echo 'S/ ' . $item["subtotal"] . ' PEN '; ?></td>
                                    <td>
                                        <a href="AccionCarta.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>" class="btn btn-danger" onclick="return confirm('¿Confirma eliminar?')"><i class="glyphicon glyphicon-trash"></i></a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="5">
                                    <p>No has agregado ningún producto al carrito.</p>
                                </td>
                            <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><a href="Menu.php" class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Volver a la tienda</a></td>
                            <td colspan="2"></td>
                            <?php if ($cart->total_items() > 0) { ?>
                                <td class="text-center"><strong>Total <?php echo 'S/ ' . $cart->total() . ' PEN'; ?></strong></td>
                                <td><button onclick="confirmPurchase()" class="btn btn-success btn-block">Pagos <i class="glyphicon glyphicon-menu-right"></i></button></td>
                            <?php } ?>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</body>

</html>
