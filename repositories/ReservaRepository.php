<?php
// Repositorio para manejar operaciones con la tabla reservas
class ReservaRepository {

    private $db; // Conexión PDO

    // Constructor con Dependency Injection
    public function __construct($db) {
        $this->db = $db;
    }

    // Crear una nueva reserva
    public function crear($cliente_id, $fecha, $hora, $mesa) {
        $sql = "INSERT INTO reservas (cliente_id, fecha, hora, mesa) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cliente_id, $fecha, $hora, $mesa]);
    }

    // Verificar si ya existe una reserva en la misma fecha, hora y mesa
    public function existeReserva($fecha, $hora, $mesa) {
        $sql = "SELECT COUNT(*) FROM reservas WHERE fecha=? AND hora=? AND mesa=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fecha, $hora, $mesa]);
        return $stmt->fetchColumn() > 0; // Retorna true si existe
    }

    // Obtener reservas de un día específico
    public function obtenerPorFecha($fecha) {
        $sql = "SELECT r.*, c.nombre FROM reservas r
                JOIN clientes c ON r.cliente_id=c.id
                WHERE fecha=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fecha]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar una reserva por ID
    public function eliminar($id) {
        $sql = "DELETE FROM reservas WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Actualizar una reserva existente
    public function actualizar($id, $fecha, $hora, $mesa) {
        $sql = "UPDATE reservas SET fecha=?, hora=?, mesa=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$fecha, $hora, $mesa, $id]);
    }
}