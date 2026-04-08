## Requisitos

Requisitos basicos para poder ejecutar el codigo
- **XAMPP** (Apache + MySQL)
- Navegador web
- Git (para clonar el repositorio)
  
## Instalación
para este proceso 
1. **Descargar o clonar el repositorio:**
para esto se copia el siguiente link https://github.com/jkljan/Cafeteria_sol.git
2. **Buscar la direccion en la que se va a guardar:**
Importante mover la carpeta a tu directorio de XAMPP (C:\xampp\htdocs\) dentro de la carpeta de htdocs es donde
se debe quedar guardado el git clonado
3. **Git Bash here:**
Dentro de la carpeta htdocs damos clik derecho y escogemos git bash here una vez abierto la consola de git ingresamos el comando
git init damos enter iniciando el repositorio luego agregamos el comando git clone https://github.com/jkljan/Cafeteria_sol.git damos
entre para que el repositorio quede clonado
4. **Importar la base de datos:**
 - Abrir phpMyAdmin
 - Crear una base de datos vacía llamada cafeteria_sol
 - Importar el archivo database.sql
5. **Configurar conexión en config/Database.php:** este proceso se realiza si tienes un usuario o contraseña diferente en tu propio xampp.
```bash
<?php
class Database {
    private $host = "localhost";
    private $db_name = "cafeteria_sol";
    private $username = "root";
    private $password = ""; // Cambia si tu XAMPP tiene password
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
        return $this->conn;
    }
}
```
6. **Abrir el proyecto en el navegador:** 
http://localhost/Cafeteria_sol/public/login.php
 - Iniciar sesión:
   - Usuario: admin
   - Contraseña: admin

# Sistema de Reservas - Cafetería Sol

Este proyecto es un sistema web para administrar reservas de una cafetería.  
Está desarrollado con **PHP**, **MySQL**, **Bootstrap** y aplica **Dependency Injection**.

##  Estructura del Proyecto
#### Cafeteria_sol/
#### config/
  - Database.php
#### controllers/
  - AuthController.php
  - ClienteController.php
  - ReservaController.php
#### repositories/
  - UsuarioRepository.php
  - ClienteRepository.php
  - ReservaRepository.php
#### services/
  - AuthService.php
  - ClienteService.php
  - ReservaService.php
#### public/
  - index.php
  - login.php
  - logout.php
  - clientes.php
  - reservas.php
  - database.sql

# Funcionalidades
Login y Logout con sesiones
CRUD de clientes
CRUD de reservas (crear, editar, eliminar)
Validación de duplicados de reserva
Filtrado de reservas por fecha
Diseño responsive con Bootstrap

# Notas
Todas las acciones están registradas en los servicios y controladores usando Dependency Injection.
Las relaciones están definidas para mantener integridad referencial (cliente → reserva).
Se puede ampliar con notificaciones, reportes y roles de usuario.
