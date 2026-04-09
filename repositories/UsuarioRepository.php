<?php
// Cargar la interfaz (define el contrato que este repositorio debe cumplir)
require_once __DIR__ . '/../ports/UsuarioRepositoryPort.php';

// Repositorio para manejar la tabla usuarios (acceso a datos)
class UsuarioRepository implements UsuarioRepositoryPort {

    private $db; // Conexión a la base de datos (PDO)

    // Inyección de dependencias: se recibe la conexión desde el exterior
    public function __construct($db) {
        $this->db = $db;
    }

    // Busca un usuario por su nombre de usuario (username)
    // Se usa comúnmente para procesos de autenticación
    public function buscarPorUsuario($username) {
        $sql = "SELECT * FROM usuarios WHERE username=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);

        // Retorna un array asociativo con los datos del usuario o false si no existe
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}