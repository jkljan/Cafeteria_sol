<?php
// Service para manejar la lógica de negocio de reservas
class ReservaService {

    private $repo;
    private $eventManager; 

    // Inyección de dependencias
    public function __construct($repo, $eventManager) {
        $this->repo = $repo;
        $this->eventManager = $eventManager;
    }

    // Crear reserva con validación de duplicados
    public function crearReserva($cliente_id, $fecha, $hora, $mesa) {
    if ($this->repo->existeReserva($fecha, $hora, $mesa)) {
        throw new Exception("La mesa ya está ocupada en esa fecha y hora");
    }
    $this->repo->crear($cliente_id, $fecha, $hora, $mesa);
    // aqui se aplica publish subscribe
    $this->eventManager->notify([
        'cliente_id' => $cliente_id,
        'fecha' => $fecha,
        'hora' => $hora,
        'mesa' => $mesa
    ]);

    return true;
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