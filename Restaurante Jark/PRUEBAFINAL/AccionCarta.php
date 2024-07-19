<?php
date_default_timezone_set("America/Lima");

include 'La-Carta.php';
$cart = new Cart;

include 'Configuracion.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    if ($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])) {
        $productID = $_REQUEST['id'];

        $query = $db->prepare("SELECT * FROM mis_productos WHERE id = ?");
        $query->bind_param("i", $productID);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $itemData = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'price' => $row['price'],
                'qty' => 1
            );

            $insertItem = $cart->insert($itemData);
            $redirectLoc = $insertItem ? 'VerCarta.php' : 'index.php';
            header("Location: $redirectLoc");
            exit;
        } else {
            header("Location: index.php");
            exit;
        }
    } elseif ($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])) {
        $rowid = $_REQUEST['id'];
        $newQty = $_REQUEST['qty'];

        $item = $cart->get_item($rowid);
        $productId = $item['id'];
        $currentQty = $item['qty'];
        $qtyDiff = $newQty - $currentQty;

        $query = $db->prepare("SELECT cantidad FROM mis_productos WHERE id = ?");
        $query->bind_param("i", $productId);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        $availableQty = $row['cantidad'];

        if ($availableQty >= $qtyDiff) {
            $itemData = array(
                'rowid' => $rowid,
                'qty' => $newQty
            );
            $updateItem = $cart->update($itemData);

            $newAvailableQty = $availableQty - $qtyDiff;
            $updateQty = $db->prepare("UPDATE mis_productos SET cantidad = ? WHERE id = ?");
            $updateQty->bind_param("ii", $newAvailableQty, $productId);
            $updateQty->execute();

            echo $updateItem ? 'ok' : 'err';
        } else {
            echo 'err';
        }
        die;
    } elseif ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])) {
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: VerCarta.php");
        exit;
    } elseif ($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['customer_id'])) {
        $customerID = $_SESSION['customer_id'];

        $insertOrder = $db->prepare("INSERT INTO orden (customer_id, total_price, created, modified) VALUES (?, ?, ?, ?)");
        if (!$insertOrder) {
            die('Error al preparar la consulta: ' . $db->error);
        }

        $total_price = $cart->total();
        $created = date("Y-m-d H:i:s");
        $modified = date("Y-m-d H:i:s");
        $result = $insertOrder->bind_param("idss", $customerID, $total_price, $created, $modified);
        if (!$result) {
            die('Error al bindear los parámetros: ' . $insertOrder->error);
        }

        $insertOrderResult = $insertOrder->execute();
        if (!$insertOrderResult) {
            die('Error al ejecutar la consulta: ' . $insertOrder->error);
        }

        if ($insertOrderResult) {
            $orderID = $db->insert_id;

            $sql = "INSERT INTO orden_articulos (order_id, product_id, quantity) VALUES (?, ?, ?)";
            $insertOrderItems = $db->prepare($sql);
            if (!$insertOrderItems) {
                die('Error al preparar la consulta: ' . $db->error);
            }

            foreach ($cart->contents() as $item) {
                $result = $insertOrderItems->bind_param("iii", $orderID, $item['id'], $item['qty']);
                if (!$result) {
                    die('Error al bindear los parámetros: ' . $insertOrderItems->error);
                }
                $insertOrderItems->execute();
            }

            $cart->destroy();
            header("Location: OrdenExito.php?id=$orderID");
            exit;
        } else {
            header("Location: Pagos.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
