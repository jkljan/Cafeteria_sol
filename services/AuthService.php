<?php
// Service para manejar la autenticación de usuarios
class AuthService {

    private $repo; // Repositorio de usuarios

    // Constructor con inyección de dependencias
    public function __construct($repo) {
        $this->repo = $repo;
    }

    // Función para iniciar sesión
    public function login($username, $password) {
        $user = $this->repo->buscarPorUsuario($username); // Buscar usuario en DB
        if (!$user || $user['password'] !== md5($password)) {
            throw new Exception("Usuario o contraseña incorrectos"); // Error login
        }
        // Guardar nombre de usuario en sesión
        $_SESSION['user'] = $user['username'];
        return true;
    }
}