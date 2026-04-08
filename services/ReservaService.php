<?php
require_once __DIR__ . '/../ports/ReservaRepositoryPort.php'; // Puerto del repo
// Service para manejar la lógica de negocio de reservas
class ReservaService {

    private $repo; // Ahora es ReservaRepositoryPort
    private $eventManager;

    public function __construct(ReservaRepositoryPort $repo, $eventManager) {
        $this->repo = $repo;
        $this->eventManager = $eventManager;
    }

    public function crearReserva($cliente_id, $fecha, $hora, $mesa) {
        if ($this->repo->existeReserva($fecha, $hora, $mesa)) {
            throw new Exception("La mesa ya está ocupada en esa fecha y hora");
        }
        $this->repo->crear($cliente_id, $fecha, $hora, $mesa);

        // Publish/subscribe
        $this->eventManager->notify([
            'cliente_id' => $cliente_id,
            'fecha' => $fecha,
            'hora' => $hora,
            'mesa' => $mesa
        ]);

        return true;
    }

    public function listarReservas($fecha) {
        return $this->repo->obtenerPorFecha($fecha);
    }

    public function eliminarReserva($id) {
        return $this->repo->eliminar($id);
    }

    public function actualizarReserva($id, $fecha, $hora, $mesa) {
        return $this->repo->actualizar($id, $fecha, $hora, $mesa);
    }
}