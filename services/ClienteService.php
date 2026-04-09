<?php
// Cargar la interfaz del repositorio (puerto)
require_once __DIR__ . '/../ports/ClienteRepositoryPort.php';

// Service para manejar la lógica de negocio de clientes
class ClienteService {

    private $repo; // Dependencia del repositorio (abstracción)

    // Inyección de dependencias usando la interfaz (desacoplamiento)
    public function __construct(ClienteRepositoryPort $repo) {
        $this->repo = $repo;
    }

    // Registra un nuevo cliente con validación básica
    public function registrarCliente($nombre, $email, $telefono) {
        // Validación de negocio: el nombre es obligatorio
        if (empty($nombre)) {
            throw new Exception("El nombre del cliente es obligatorio");
        }

        return $this->repo->crear($nombre, $email, $telefono);
    }

    // Actualiza los datos de un cliente existente
    public function actualizarCliente($id, $nombre, $email, $telefono) {
        return $this->repo->actualizar($id, $nombre, $email, $telefono);
    }

    // Elimina un cliente por su ID
    public function eliminarCliente($id) {
        return $this->repo->eliminar($id);
    }

    // Retorna la lista completa de clientes
    public function listarClientes() {
        return $this->repo->obtenerTodos();
    }

    // Obtiene un cliente específico por su ID
    public function obtenerCliente($id) {
        return $this->repo->obtenerPorId($id);
    }
}