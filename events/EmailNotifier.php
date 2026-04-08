<?php
require_once "Subscriber.php";

class EmailNotifier implements Subscriber {
    public function update($data) {
        // Simulación de envío de correo
        echo "📧 Email enviado para reserva del cliente ID: " . $data['cliente_id'] . "<br>";
    }
}