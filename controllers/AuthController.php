<?php
// Controller para manejar login y logout

class AuthController {

    private $service; // Servicio de autenticación

    // Constructor con inyección de dependencias
    public function __construct($service) {
        $this->service = $service;
    }

    // Función para iniciar sesión
    public function login($post) {
        try {
            $this->service->login($post['username'], $post['password']); // Llamamos al service
            header("Location: clientes.php"); // Redirige al panel de clientes
            exit;
        } catch (Exception $e) {
            return $e->getMessage(); // Mensaje de error si falla login
        }
    }

    // Función para cerrar sesión
    public function logout() {
        session_destroy(); // Destruye sesión
        header("Location: login.php"); // Redirige al login
        exit;
    }
}