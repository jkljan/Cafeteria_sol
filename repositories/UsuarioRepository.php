<?php
// Repositorio para manejar la tabla usuarios (login)
class UsuarioRepository {

    private $db; // Conexión PDO

    public function __construct($db) {
        $this->db = $db; // Inyección de dependencias
    }

    // Buscar usuario por username
    public function buscarPorUsuario($username) {
        $sql = "SELECT * FROM usuarios WHERE username=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna el usuario o false
    }
}