<?php
require_once "Subscriber.php";

class LogNotifier implements Subscriber {
    public function update($data) {
        // Simulación de log
        echo "📝 Log: Reserva creada para fecha " . $data['fecha'] . "<br>";
    }
}