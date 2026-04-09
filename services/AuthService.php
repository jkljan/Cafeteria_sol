<?php
// Cargar la interfaz del repositorio (puerto)
require_once __DIR__ . '/../ports/UsuarioRepositoryPort.php';

// Service para manejar la autenticación de usuarios
class AuthService {

    private $repo; // Dependencia del repositorio (abstracción)

    // Se inyecta el repositorio mediante su interfaz (desacoplamiento)
    public function __construct(UsuarioRepositoryPort $repo) {
        $this->repo = $repo;
    }

    // Método para autenticar un usuario
    public function login($username, $password) {
        // Buscar el usuario en la base de datos
        $user = $this->repo->buscarPorUsuario($username);

        // Validar existencia y contraseña
        if (!$user || $user['password'] !== md5($password)) {
            throw new Exception("Usuario o contraseña incorrectos");
        }

        // Guardar el usuario en sesión (inicio de sesión)
        $_SESSION['user'] = $user['username'];

        return true;
    }
}