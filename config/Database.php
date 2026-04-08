<?php
//hola cuate  da
// Clase para manejar la conexión a la base de datos usando PDO
class Database {

    // Datos de conexión
    private $host = "localhost";       // Servidor donde está MySQL
    private $db = "cafeteria_sol";     // Nombre de la base de datos
    private $user = "root";            // Usuario de MySQL
    private $pass = "";                // Contraseña de MySQL (por defecto vacía en XAMPP)

    // Función que retorna la conexión PDO
    public function connect() {
        try {
            // Creamos objeto PDO con DSN, usuario y contraseña
            $pdo = new PDO(
                "mysql:host=$this->host;dbname=$this->db", 
                $this->user, 
                $this->pass
            );
            // Configuramos PDO para que lance excepciones en caso de error
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo; // Retornamos la conexión
        } catch (PDOException $e) {
            // Si falla la conexión, mostramos el error y detenemos la ejecución
            die("Error de conexión: " . $e->getMessage());
        }
    }
}