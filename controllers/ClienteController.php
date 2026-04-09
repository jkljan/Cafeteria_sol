<?php
// Controller para manejar las solicitudes relacionadas con clientes

class ClienteController {

    private $service; // Servicio de clientes

    // Constructor con inyección de dependencias 
    public function __construct($service) {
        $this->service = $service;
    }

    // Función para registrar un cliente desde un formulario
    public function registrar($post) {
        try {
            // Llamamos al service para registrar
            return $this->service->registrarCliente($post['nombre'], $post['email'], $post['telefono']);
        } catch (Exception $e) {
            return $e->getMessage(); // Retorna mensaje de error si falla
        }
    }

    // Función para actualizar cliente
    public function actualizar($post) {
        try {
            return $this->service->actualizarCliente($post['id'], $post['nombre'], $post['email'], $post['telefono']);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Función para eliminar cliente
    public function eliminar($id) {
        try {
            return $this->service->eliminarCliente($id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Función para listar todos los clientes
    public function listar() {
        return $this->service->listarClientes();
    }

    // Obtener un cliente por ID
    public function obtener($id) {
        return $this->service->obtenerCliente($id);
    }
}