## Objetivo del proyecto 
Desarrollar un sistema web para la gestión de clientes y reservas en una cafetería, aplicando los patrones de diseño:
 - Dependency Injection (Inyección de Dependencias).
 - Publish – Subscribe (Publicador – Suscriptor).

El sistema permite evidenciar de forma clara la implementación de estos patrones en un entorno real.

## Tecnologías Utilizadas
 - PHP (Programación backend)
 - MySQL (Base de datos)
 - Bootstrap (Diseño responsive)
 - XAMPP (Servidor local)
   
## Requisitos
Requisitos basicos para poder ejecutar el codigo
- XAMPP (Apache + MySQL)
- Navegador web
- Git (para clonar el repositorio)
  
## Instalación
para este proceso 
1. **Descargar o clonar el repositorio:**
para esto se copia el siguiente link
```bash
https://github.com/jkljan/Cafeteria_sol.git
```
2. **Buscar la direccion en la que se va a guardar:**
Importante mover la carpeta a tu directorio de XAMPP
```bash
(C:\xampp\htdocs\)
```
dentro de la carpeta de htdocs es donde se debe quedar guardado el git clonado.

3. **Git Bash here:**
Dentro de la carpeta htdocs damos clik derecho y escogemos git bash here una vez abierto la consola de git ingresamos el comando
git init damos enter iniciando el repositorio luego agregamos el comando
```bash
git clone https://github.com/jkljan/Cafeteria_sol.git
```
damos enter para que el repositorio quede clonado

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
abrir el navegador
```bash
http://localhost/Cafeteria_sol/public/login.php
```

 - Iniciar sesión:
   - Usuario: admin
   - Contraseña: admin

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
#### api/
  - clientes.php
  - servicios.php
#### ports/
  - clienteRepositoryPort.php
  - reservaRepositoryPort.php
  - usuarioRepositoryPort.php
#### event/
  - EmailNotifer.php
  - EventManager.php
  - LogNotifer.php
  - Subcriber.php
#### database.sql


## Funcionalidades
 - Login y Logout con sesiones
 - CRUD de clientes
 - CRUD de reservas (crear, editar, eliminar)
 - Validación de duplicados de reserva
 - Filtrado de reservas por fecha
 - Diseño responsive con Bootstrap

## patron 1: Dependency injection
Este patron permite desacoplar las clases evitando que unas creen directamente otras.
un ejemplo de esto es cuando 
 - clienteController depende de clienteService
 - clienteService depende de clienteRepository
 - las dependencias se inyectan desde afura
   
los beneficios de esto es

 - bajo acoplamiento
 - codigo mas mantenible
 - facilita pruebas

## patron 2 publish - subscribe
Este permite que multiples objetivos en este caso suscriptores reaccionen automaticamente a un evento.

### funcionamiento
 - se crea una reserva
 - se dispara un evento
 - el eventManager notifica a todos los suscriptores
 - cada suscriptor ejecuta una accion
   
### evidencia
al crear una reserva se muestra 
```bash
Email: enviado para reserva del cliente ID:
Log: reserva creada para la fecha: 
```
demostrando que multiples clases reacionan al mismo evento sin estar acopladas

### beneficios

 - escalabilidad
 - facil agrefar nuevas funcionalidades
 - bajo acoplamiento

### flujo del sistema

 - usuario -> controller -> service -> repository -> base de datos
 - reservaservice -> eventManager -> subscibers

## Notas
- se usa arquitectura por capas
- se aplican inyeccion de dependencias en controllers y servicios
- se implementa patron publish-subscribe en reservas

## conclusion
este proyecto demuestra la aplicacion practica de los patrones 
 - Dependency Injection -> desacoplamiento de clases
 - Publish–Subscribe -> comunicación basada en eventos
Logrando un sistema modular, escalable y fácil de mantener.
