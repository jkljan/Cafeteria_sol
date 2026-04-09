<?php
// Interfaz que define el contrato para los suscriptores (patrón Observer)
interface Subscriber {
    // Método que se ejecuta cuando ocurre un evento
    // $data contiene la información relevante del evento
    public function update($data);
}