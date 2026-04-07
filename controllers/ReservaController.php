<?php
// Controller para manejar solicitudes de reservas

class ReservaController {

    private $service; // Servicio de reservas

    // Constructor con inyección de dependencias
    public function __construct($service) {
        $this->service = $service;
    }

    // Crear reserva desde un formulario
    public function crear($post) {
        try {
            return $this->service->crearReserva($post['cliente_id'], $post['fecha'], $post['hora'], $post['mesa']);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Actualizar una reserva
    public function actualizar($post) {
        try {
            return $this->service->actualizarReserva($post['id'], $post['fecha'], $post['hora'], $post['mesa']);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Eliminar reserva
    public function eliminar($id) {
        try {
            return $this->service->eliminarReserva($id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Listar reservas por fecha
    public function listar($fecha) {
        return $this->service->listarReservas($fecha);
    }
}