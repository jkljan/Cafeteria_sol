<?php
// Repositorio para manejar operaciones con la tabla clientes
class ClienteRepository {

    private $db; // Variable para almacenar la conexión PDO

    // Constructor con inyección de dependencias (Dependency Injection)
    public function __construct($db) {
        $this->db = $db; // Guardamos la conexión
    }

    // Crear un nuevo cliente en la base de datos
    public function crear($nombre, $email, $telefono) {
        $sql = "INSERT INTO clientes (nombre, email, telefono) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql); // Preparamos la consulta
        return $stmt->execute([$nombre, $email, $telefono]); // Ejecutamos con los datos
    }

    // Actualizar información de un cliente existente
    public function actualizar($id, $nombre, $email, $telefono) {
        $sql = "UPDATE clientes SET nombre=?, email=?, telefono=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $email, $telefono, $id]); // Ejecuta update
    }

    // Eliminar un cliente de la base de datos
    public function eliminar($id) {
        $sql = "DELETE FROM clientes WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Obtener todos los clientes
    public function obtenerTodos() {
        $stmt = $this->db->query("SELECT * FROM clientes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna array asociativo
    }

    // Obtener un cliente específico por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM clientes WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo cliente
    }
}