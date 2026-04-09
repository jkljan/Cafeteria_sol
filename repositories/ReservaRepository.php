<?php
// Cargar la interfaz (contrato que este repositorio debe cumplir)
require_once __DIR__ . '/../ports/ReservaRepositoryPort.php';

// Repositorio para manejar operaciones con la tabla reservas
class ReservaRepository implements ReservaRepositoryPort {

    private $db; // Conexión a la base de datos (PDO)

    // Inyección de dependencias: se recibe la conexión desde el exterior
    public function __construct($db) {
        $this->db = $db;
    }

    // Inserta una nueva reserva en la base de datos
    public function crear($cliente_id, $fecha, $hora, $mesa) {
        $sql = "INSERT INTO reservas (cliente_id, fecha, hora, mesa) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cliente_id, $fecha, $hora, $mesa]);
    }

    // Verifica si ya existe una reserva para la misma fecha, hora y mesa
    // Evita duplicados o conflictos de disponibilidad
    public function existeReserva($fecha, $hora, $mesa) {
        $sql = "SELECT COUNT(*) FROM reservas WHERE fecha=? AND hora=? AND mesa=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fecha, $hora, $mesa]);
        return $stmt->fetchColumn() > 0;
    }

    // Obtiene todas las reservas de una fecha específica
    // Incluye el nombre del cliente mediante un JOIN
    public function obtenerPorFecha($fecha) {
        $sql = "SELECT r.*, c.nombre FROM reservas r
                JOIN clientes c ON r.cliente_id=c.id
                WHERE fecha=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fecha]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Elimina una reserva por su ID
    public function eliminar($id) {
        $sql = "DELETE FROM reservas WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Actualiza los datos de una reserva existente
    public function actualizar($id, $fecha, $hora, $mesa) {
        $sql = "UPDATE reservas SET fecha=?, hora=?, mesa=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$fecha, $hora, $mesa, $id]);
    }
}