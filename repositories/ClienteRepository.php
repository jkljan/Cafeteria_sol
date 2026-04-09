<?php
// Cargar la interfaz (contrato que este repositorio debe cumplir)
require_once __DIR__ . '/../ports/ClienteRepositoryPort.php';

// Repositorio para manejar operaciones con la tabla clientes (acceso a datos)
class ClienteRepository implements ClienteRepositoryPort {

    private $db; // Conexión a la base de datos (PDO)

    // Se recibe la conexión desde afuera (inyección de dependencias)
    public function __construct($db) {
        $this->db = $db;
    }

    // Inserta un nuevo cliente en la base de datos
    public function crear($nombre, $email, $telefono) {
        $sql = "INSERT INTO clientes (nombre, email, telefono) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $email, $telefono]);
    }

    // Actualiza los datos de un cliente existente por su ID
    public function actualizar($id, $nombre, $email, $telefono) {
        $sql = "UPDATE clientes SET nombre=?, email=?, telefono=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $email, $telefono, $id]);
    }

    // Elimina un cliente por su ID
    public function eliminar($id) {
        $sql = "DELETE FROM clientes WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Obtiene todos los clientes de la tabla
    public function obtenerTodos() {
        $stmt = $this->db->query("SELECT * FROM clientes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtiene un cliente específico por su ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM clientes WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}