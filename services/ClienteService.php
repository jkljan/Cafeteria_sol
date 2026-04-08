<?php
require_once __DIR__ . '/../ports/ClienteRepositoryPort.php'; // Puerto del repo
// Service para manejar la lógica de negocio de clientes
class ClienteService {

    private $repo; // Ahora es ClienteRepositoryPort

    public function __construct(ClienteRepositoryPort $repo) {
        $this->repo = $repo;
    }

    public function registrarCliente($nombre, $email, $telefono) {
        if (empty($nombre)) {
            throw new Exception("El nombre del cliente es obligatorio");
        }
        return $this->repo->crear($nombre, $email, $telefono);
    }

    public function actualizarCliente($id, $nombre, $email, $telefono) {
        return $this->repo->actualizar($id, $nombre, $email, $telefono);
    }

    public function eliminarCliente($id) {
        return $this->repo->eliminar($id);
    }

    public function listarClientes() {
        return $this->repo->obtenerTodos();
    }

    public function obtenerCliente($id) {
        return $this->repo->obtenerPorId($id);
    }
}