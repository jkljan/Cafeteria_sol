<?php
require_once __DIR__ . '/../ports/ClienteRepositoryPort.php'; // Cargar la interfaz
// Repositorio para manejar operaciones con la tabla clientes
class ClienteRepository implements ClienteRepositoryPort {

    private $db; // Variable para almacenar la conexión PDO

    public function __construct($db) {
        $this->db = $db;
    }

    public function crear($nombre, $email, $telefono) {
        $sql = "INSERT INTO clientes (nombre, email, telefono) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $email, $telefono]);
    }

    public function actualizar($id, $nombre, $email, $telefono) {
        $sql = "UPDATE clientes SET nombre=?, email=?, telefono=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $email, $telefono, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM clientes WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerTodos() {
        $stmt = $this->db->query("SELECT * FROM clientes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM clientes WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}