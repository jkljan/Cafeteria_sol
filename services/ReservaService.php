<?php
// Service para manejar la lógica de negocio de reservas
class ReservaService {

    private $repo; // Repositorio de reservas

    // Constructor con inyección de dependencias
    public function __construct($repo) {
        $this->repo = $repo;
    }

    // Crear reserva con validación de duplicados
    public function crearReserva($cliente_id, $fecha, $hora, $mesa) {
        // Verifica si ya existe una reserva para la misma mesa, fecha y hora
        if ($this->repo->existeReserva($fecha, $hora, $mesa)) {
            throw new Exception("La mesa ya está ocupada en esa fecha y hora");
        }
        return $this->repo->crear($cliente_id, $fecha, $hora, $mesa);
    }

    // Listar reservas de una fecha específica
    public function listarReservas($fecha) {
        return $this->repo->obtenerPorFecha($fecha);
    }

    // Eliminar una reserva
    public function eliminarReserva($id) {
        return $this->repo->eliminar($id);
    }

    // Actualizar una reserva existente
    public function actualizarReserva($id, $fecha, $hora, $mesa) {
        return $this->repo->actualizar($id, $fecha, $hora, $mesa);
    }
}