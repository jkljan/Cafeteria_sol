<?php
// Service para manejar la autenticación de usuarios
class AuthService {

    private $repo; // Ahora es UsuarioRepositoryPort

    public function __construct(UsuarioRepositoryPort $repo) {
        $this->repo = $repo;
    }

    public function login($username, $password) {
        $user = $this->repo->buscarPorUsuario($username);
        if (!$user || $user['password'] !== md5($password)) {
            throw new Exception("Usuario o contraseña incorrectos");
        }
        $_SESSION['user'] = $user['username'];
        return true;
    }
}