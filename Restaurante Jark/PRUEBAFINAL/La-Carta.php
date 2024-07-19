<?php
session_start();
include 'Configuracion.php';

class Cart
{
    protected $cart_contents = array();

    public function __construct()
    {
        // obtener el array del carrito de la sesión
        $this->cart_contents = !empty($_SESSION['cart_contents']) ? $_SESSION['cart_contents'] : NULL;
        if ($this->cart_contents === NULL) {
            // establecer algunos valores base si no hay contenido en el carrito
            $this->cart_contents = array('cart_total' => 0, 'total_items' => 0);
        }
    }

    /**
     * Cart Contents: Retorna todo el array del carrito
     * @param   bool
     * @return  array
     */
    public function contents()
    {
        // reorganizar con los más nuevos primero
        $cart = array_reverse($this->cart_contents);

        // eliminar estos para evitar problemas al mostrar la tabla del carrito
        unset($cart['total_items']);
        unset($cart['cart_total']);

        return $cart;
    }

    /**
     * Obtener ítem del carrito: Retorna los detalles específicos de un ítem del carrito
     * @param   string  $row_id
     * @return  array
     */
    public function get_item($row_id)
    {
        return (in_array($row_id, array('total_items', 'cart_total'), TRUE) or !isset($this->cart_contents[$row_id]))
            ? FALSE
            : $this->cart_contents[$row_id];
    }

    /**
     * Total de ítems: Retorna el conteo total de ítems
     * @return  int
     */
    public function total_items()
    {
        return $this->cart_contents['total_items'];
    }

    /**
     * Total del carrito: Retorna el precio total
     * @return  int
     */
    public function total()
    {
        return $this->cart_contents['cart_total'];
    }

    /**
     * Insertar ítems en el carrito y guardar en la sesión
     * @param   array   $item
     * @return  bool
     */
    public function insert($item = array())
    {
        global $db;

        if (!is_array($item) or count($item) === 0) {
            return FALSE;
        } else {
            if (!isset($item['id'], $item['name'], $item['price'], $item['qty'])) {
                return FALSE;
            } else {
                // preparar la cantidad
                $item['qty'] = (float) $item['qty'];
                if ($item['qty'] == 0) {
                    return FALSE;
                }

                // obtener la cantidad disponible en la base de datos
                $query = $db->prepare("SELECT cantidad FROM mis_productos WHERE id = ?");
                $query->bind_param("i", $item['id']);
                $query->execute();
                $query->bind_result($available_qty);
                $query->fetch();
                $query->close();

                // verificar si hay suficiente cantidad disponible
                if ($item['qty'] > $available_qty) {
                    return FALSE; // no hay suficiente cantidad disponible
                }

                // preparar el precio
                $item['price'] = (float) $item['price'];

                // crear un identificador único para el ítem que se está insertando en el carrito
                $rowid = md5($item['id']);

                // obtener la cantidad si ya está ahí y agregarla
                $old_qty = isset($this->cart_contents[$rowid]['qty']) ? (int) $this->cart_contents[$rowid]['qty'] : 0;

                // actualizar la cantidad en la base de datos
                $new_quantity = $available_qty - $item['qty'];
                $update_query = $db->prepare("UPDATE mis_productos SET cantidad = ? WHERE id = ?");
                $update_query->bind_param("ii", $new_quantity, $item['id']);
                $update_query->execute();
                $update_query->close();

                // recrear la entrada con identificador único y cantidad actualizada
                $item['rowid'] = $rowid;
                $item['qty'] += $old_qty;

                // actualizar el contenido del carrito
                $this->cart_contents[$rowid] = $item;

                // guardar el ítem del carrito
                if ($this->save_cart()) {
                    return isset($rowid) ? $rowid : TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    /**
     * Actualizar el carrito
     * @param   array   $item
     * @return  bool
     */
    public function update($item = array())
    {
        if (!is_array($item) or count($item) === 0) {
            return FALSE;
        } else {
            if (!isset($item['rowid'], $this->cart_contents[$item['rowid']])) {
                return FALSE;
            } else {
                // preparar la cantidad
                if (isset($item['qty'])) {
                    $item['qty'] = (float) $item['qty'];
                    // remover el ítem del carrito si la cantidad es cero
                    if ($item['qty'] == 0) {
                        unset($this->cart_contents[$item['rowid']]);
                        return TRUE;
                    }
                }

                // encontrar claves actualizables
                $keys = array_intersect(array_keys($this->cart_contents[$item['rowid']]), array_keys($item));
                // preparar el precio
                if (isset($item['price'])) {
                    $item['price'] = (float) $item['price'];
                }
                // id del producto y nombre no deberían ser cambiados
                foreach (array_diff($keys, array('id', 'name')) as $key) {
                    $this->cart_contents[$item['rowid']][$key] = $item[$key];
                }
                // guardar los datos del carrito
                $this->save_cart();
                return TRUE;
            }
        }
    }

    /**
     * Guardar el array del carrito en la sesión
     * @return  bool
     */
    protected function save_cart()
    {
        $this->cart_contents['total_items'] = $this->cart_contents['cart_total'] = 0;
        foreach ($this->cart_contents as $key => $val) {
            // asegurarse de que el array contenga el menú adecuado
            if (!is_array($val) or !isset($val['price'], $val['qty'])) {
                continue;
            }

            $this->cart_contents['cart_total'] += ($val['price'] * $val['qty']);
            $this->cart_contents['total_items'] += $val['qty'];
            $this->cart_contents[$key]['subtotal'] = ($this->cart_contents[$key]['price'] * $this->cart_contents[$key]['qty']);
        }

        // si el carrito está vacío, eliminarlo de la sesión
        if (count($this->cart_contents) <= 2) {
            unset($_SESSION['cart_contents']);
            return FALSE;
        } else {
            $_SESSION['cart_contents'] = $this->cart_contents;
            return TRUE;
        }
    }

    /**
     * Eliminar ítem: Elimina un ítem del carrito
     * @param   int
     * @return  bool
     */
    public function remove($row_id)
    {
        // eliminar y guardar
        unset($this->cart_contents[$row_id]);
        $this->save_cart();
        return TRUE;
    }

    /**
     * Destruir el carrito: Vacía el carrito y destruye la sesión
     * @return  void
     */
    public function destroy()
    {
        $this->cart_contents = array('cart_total' => 0, 'total_items' => 0);
        unset($_SESSION['cart_contents']);
    }
}
?>
