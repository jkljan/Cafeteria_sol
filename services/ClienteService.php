<?php
// Service para manejar la lógica de negocio de clientes
class ClienteService {

    private $repo; // Variable para el repositorio de clientes

    // Constructor con inyección de dependencias
    public function __construct($repo) {
        $this->repo = $repo;
    }

    // Registrar un nuevo cliente con validaciones básicas
    public function registrarCliente($nombre, $email, $telefono) {
        if (empty($nombre)) {
            throw new Exception("El nombre del cliente es obligatorio"); // Validación
        }
        return $this->repo->crear($nombre, $email, $telefono); // Llamada al repo
    }

    // Actualizar un cliente existente
    public function actualizarCliente($id, $nombre, $email, $telefono) {
        return $this->repo->actualizar($id, $nombre, $email, $telefono);
    }

    // Eliminar un cliente
    public function eliminarCliente($id) {
        return $this->repo->eliminar($id);
    }

    // Listar todos los clientes
    public function listarClientes() {
        return $this->repo->obtenerTodos();
    }

    // Obtener un cliente específico
    public function obtenerCliente($id) {
        return $this->repo->obtenerPorId($id);
    }
}