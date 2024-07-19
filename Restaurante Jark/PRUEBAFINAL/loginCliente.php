<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente</title>
    <link rel="stylesheet" href="diseño/cliente.css">
    <link rel="stylesheet" href="diseño/Menu.css">
    <style>
        .payment-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .payment-option img {
            margin-right: 10px;
            height: 30px;
        }

        #card-details {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        #card-details input {
            display: block;
            margin-bottom: 10px;
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            z-index: 1001;
        }

        .notification.error {
            background-color: #f44336;
        }
    </style>
</head>

<body>
    <h2>Solo un paso más para completar su pedido, por favor rellene los campos</h2>
    <form id="registroForm" action="procesarlogCliente.php" method="post">
        <label for="name">Nombre:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="apellido">Apellido:</label><br>
        <input type="text" id="apellido" name="apellido" required><br>

        <label for="email">Correo Electrónico:</label><br>
        <input type="email" id="email" name="email" required><br>

        <h3>Seleccione su método de pago:</h3>

        <div class="payment-option">
            <input type="radio" id="bcp" name="payment_method" value="BCP" required>
            <label for="bcp">
                <img src="Multimedia/imagenes/imagen-bcp.jpg" alt="BCP"> BCP
            </label>
        </div>

        <div class="payment-option">
            <input type="radio" id="interbank" name="payment_method" value="Interbank">
            <label for="interbank">
                <img src="Multimedia/imagenes/inter.png" alt="Interbank"> Interbank
            </label>
        </div>

        <div class="payment-option">
            <input type="radio" id="mastercard" name="payment_method" value="Mastercard">
            <label for="mastercard">
                <img src="Multimedia/imagenes/mas.png" alt="Mastercard"> Mastercard
            </label>
        </div>

        <div class="payment-option">
            <input type="radio" id="tienda" name="payment_method" value="Tienda">
            <label for="tienda">Pagar en tienda</label>
        </div>

        <input type="submit" value="Seguir con el pedido">
    </form>

    <div id="card-details">
        <h3>Detalles de la tarjeta</h3>
        <label for="card-number">Número de tarjeta:</label>
        <input type="text" id="card-number" name="card-number">
        <label for="card-expiry">Fecha de expiración (MM/AA):</label>
        <input type="text" id="card-expiry" name="card-expiry">
        <label for="card-cvc">CVC:</label>
        <input type="text" id="card-cvc" name="card-cvc">
        <button type="button" onclick="submitCardDetails()">Aceptar</button>
    </div>

    <div id="overlay"></div>

    <div id="notification" class="notification"></div>

    <?php
    session_start();
    if (isset($_SESSION['error'])) : ?>
        <script>
            alert("<?php echo $_SESSION['error']; ?>");
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach((input) => {
            input.addEventListener('change', function() {
                if (this.value === 'BCP' || this.value === 'Interbank' || this.value === 'Mastercard') {
                    clearCardDetails();
                    showCardDetails();
                } else {
                    hideCardDetails();
                }
            });
        });

        function clearCardDetails() {
            document.getElementById('card-number').value = '';
            document.getElementById('card-expiry').value = '';
            document.getElementById('card-cvc').value = '';
        }

        function showCardDetails() {
            document.getElementById('card-details').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('card-number').setAttribute('required', true);
            document.getElementById('card-expiry').setAttribute('required', true);
            document.getElementById('card-cvc').setAttribute('required', true);
        }

        function hideCardDetails() {
            document.getElementById('card-details').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('card-number').removeAttribute('required');
            document.getElementById('card-expiry').removeAttribute('required');
            document.getElementById('card-cvc').removeAttribute('required');
        }

        function showNotification(message, isError = false) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.style.display = 'block';
            if (isError) {
                notification.classList.add('error');
            } else {
                notification.classList.remove('error');
            }
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

        function submitCardDetails() {
            // Simular un cobro
            setTimeout(() => {
                hideCardDetails();
                showNotification('Pago realizado con éxito');
            }, 1000);
        }
    </script>
</body>

</html>