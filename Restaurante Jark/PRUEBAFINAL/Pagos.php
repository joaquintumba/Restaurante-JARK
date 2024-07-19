<?php
// include database configuration file
include 'Configuracion.php';

// initializ shopping cart class
include 'La-carta.php';
$cart = new Cart;

// redirect to home if cart is empty
if ($cart->total_items() <= 0) {
    header("Location: Menu.php");
}

// set customer ID in session
$_SESSION['sessCustomerID'] = 1;

// get customer details by session customer ID
$query = $db->query("SELECT * FROM clientes WHERE id = " . $_SESSION['sessCustomerID']);
$custRow = $query->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pagos - PHP Carrito de compras Tutorial</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .container {
            padding: 20px;
        }

        .table {
            width: 65%;
            float: left;
        }

        .shipAddr {
            width: 30%;
            float: left;
            margin-left: 30px;
        }

        .footBtn {
            width: 95%;
            float: left;
        }

        .orderBtn {
            float: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1>Vista previa de la Orden</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Sub total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($cart->total_items() > 0) {
                            //get cart items from session
                            $cartItems = $cart->contents();
                            foreach ($cartItems as $item) {
                        ?>
                                <tr>
                                    <td><?php echo $item["name"]; ?></td>
                                    <td><?php echo 'S/ ' . $item["price"] . ' PEN '; ?></td>
                                    <td><?php echo $item["qty"]; ?></td>
                                    <td><?php echo 'S/ ' . $item["subtotal"] . ' PEN '; ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4">
                                    <p>No hay articulos en tu carta......</p>
                                </td>
                            <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <?php if ($cart->total_items() > 0) { ?>
                                <td class="text-center"><strong>Total <?php echo 'S/ ' . $cart->total() . ' PEN '; ?></strong></td>
                            <?php } ?>
                        </tr>
                    </tfoot>
                </table>





                <div class="footBtn">

                    <a href="AccionCarta.php?action=placeOrder" class="btn btn-success orderBtn">Realizar pedido <i class="glyphicon glyphicon-menu-right"></i></a>
                    <link rel="stylesheet" href="diseño/Menu.css">
                </div>
            </div>
        </div>
    </div>
</body>

</html>