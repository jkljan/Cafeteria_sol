<?php
// Repositorio para manejar la tabla usuarios
class UsuarioRepository implements UsuarioRepositoryPort {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function buscarPorUsuario($username) {
        $sql = "SELECT * FROM usuarios WHERE username=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}