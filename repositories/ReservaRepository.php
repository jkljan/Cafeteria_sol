<?php
require_once __DIR__ . '/../ports/ReservaRepositoryPort.php'; // Cargar la interfaz
// Repositorio para manejar operaciones con la tabla reservas
class ReservaRepository implements ReservaRepositoryPort {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function crear($cliente_id, $fecha, $hora, $mesa) {
        $sql = "INSERT INTO reservas (cliente_id, fecha, hora, mesa) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cliente_id, $fecha, $hora, $mesa]);
    }

    public function existeReserva($fecha, $hora, $mesa) {
        $sql = "SELECT COUNT(*) FROM reservas WHERE fecha=? AND hora=? AND mesa=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fecha, $hora, $mesa]);
        return $stmt->fetchColumn() > 0;
    }

    public function obtenerPorFecha($fecha) {
        $sql = "SELECT r.*, c.nombre FROM reservas r
                JOIN clientes c ON r.cliente_id=c.id
                WHERE fecha=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fecha]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM reservas WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function actualizar($id, $fecha, $hora, $mesa) {
        $sql = "UPDATE reservas SET fecha=?, hora=?, mesa=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$fecha, $hora, $mesa, $id]);
    }
}