<?php
require_once('INVOICE-main/INVOICE-main/fpdf.php');
require_once('INVOICE-main/INVOICE-main/code128.php');

class TicketPDF extends PDF_Code128
{
    function addEmpresaInfo($nombre, $ruc, $direccion, $telefono, $email)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", strtoupper("RESTAURANTE-JARK")), 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
      
        $this->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "SAN JUAN DE LURIGANCHO_AV EL SOL"), 0, 1, 'C');
        $this->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "Teléfono: 902735546"), 0, 1, 'C');
        $this->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "Email: Restaurant-JARK@gmail.com"), 0, 1, 'C');
        $this->Ln(1);
        $this->Cell(0, 5, "------------------------------------------------------", 0, 1, 'C');
        $this->Ln(5);
    }

    function addTicketInfo($fecha, $caja, $cajero, $ticketNro)
    {
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 5, "Fecha: $fecha " . date("h:s A"), 0, 1, 'C');
        $this->Cell(0, 5, "Caja Nro: $caja", 0, 1, 'C');
        $this->Cell(0, 5, "Usuario: $cajero", 0, 1, 'C');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, strtoupper("Ticket Nro: $ticketNro"), 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Ln(1);
        $this->Cell(0, 5, "------------------------------------------------------", 0, 1, 'C');
        $this->Ln(5);
    }

    function addClienteInfo($cliente, $documento, $telefono, $direccion)
    {
        $this->Cell(0, 5, "Cliente: $cliente", 0, 1, 'C');
        $this->Ln(1);
        $this->Cell(0, 5, "------------------------------------------------------", 0, 1, 'C');
        $this->Ln(3);
    }

    function addProducto($nombre, $cantidad, $precio, $descuento, $total)
    {
        // Centering each product information
        $this->Cell(0, 4, iconv("UTF-8", "ISO-8859-1", "Producto Comprado: $nombre"), 0, 1, 'C');
        $this->Cell(0, 4, "Cantidad :$cantidad ". "     " . " Precio: S/ $precio" . "      " . "      " . 
        "Total: $total", 0, 1, 'C');
        $this->Ln(4);
    }

    function addTotal($subtotal, $iva, $totalPagar, $totalPagado, $cambio, $ahorro)
    {
        $this->Cell(0, 5, "-------------------------------------------------------------------", 0, 1, 'C');
        $this->Ln(5);
        $this->Cell(0, 5, "SUBTOTAL : $subtotal", 0, 1, 'C');
        
        $this->Cell(0, 5, "-------------------------------------------------------------------", 0, 1, 'C');
        $this->Ln(5);
        $this->Cell(0, 5, "TOTAL A PAGAR: $totalPagar", 0, 1, 'C');
        $this->Ln(5);
    }

    function addFooter($texto)
    {
        $this->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", $texto), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 7, "Gracias por su compra", 0, 1, 'C');
        $this->Ln(9);
    }

    function addBarcode($codigo)
    {
        // Centering the barcode by adjusting the x-position
        $x = ($this->GetPageWidth() - 70) / 2;
        $this->Code128($x, $this->GetY(), $codigo, 70, 20);
        $this->SetXY(0, $this->GetY() + 21);
        $this->SetFont('Arial', '', 14);
        $this->Cell(0, 5, $codigo,0,1,'C');
}
}