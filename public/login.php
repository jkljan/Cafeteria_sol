<?php
session_start(); // Iniciamos sesión
require_once "../config/Database.php"; // Conexión DB
require_once "../repositories/UsuarioRepository.php";
require_once "../services/AuthService.php";
require_once "../controllers/AuthController.php";

// Instanciamos objetos con Dependency Injection
$db = (new Database())->connect();
$usuarioRepo = new UsuarioRepository($db);
$authService = new AuthService($usuarioRepo);
$authController = new AuthController($authService);

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = $authController->login($_POST); // Intentamos login
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Cafetería Sol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h3 class="text-center mb-3">Login Cafetería Sol</h3>
            <?php if($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label>Usuario</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">Ingresar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>