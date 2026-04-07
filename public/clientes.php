<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirige si no hay sesión
    exit;
}

require_once "../config/Database.php";
require_once "../repositories/ClienteRepository.php";
require_once "../services/ClienteService.php";
require_once "../controllers/ClienteController.php";

$db = (new Database())->connect();
$clienteRepo = new ClienteRepository($db);
$clienteService = new ClienteService($clienteRepo);
$clienteController = new ClienteController($clienteService);

// Manejo de formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear'])) {
        $mensaje = $clienteController->registrar($_POST);
    } elseif (isset($_POST['actualizar'])) {
        $mensaje = $clienteController->actualizar($_POST);
    } elseif (isset($_POST['eliminar'])) {
        $mensaje = $clienteController->eliminar($_POST['id']);
    }
}

// Obtenemos todos los clientes
$clientes = $clienteController->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes - Cafetería Sol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Cafetería Sol</a>
    <div class="d-flex">
      <a class="btn btn-outline-light" href="reservas.php">Reservas</a>
      <a class="btn btn-outline-light ms-2" href="logout.php">Cerrar sesión</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h3>Clientes</h3>

    <?php if(isset($mensaje)): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>

    <!-- Formulario para agregar cliente -->
    <form method="post" class="row g-3 mb-3">
        <input type="hidden" name="id" id="clienteId">
        <div class="col-md-4">
            <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input type="email" name="email" id="email" placeholder="Email" class="form-control">
        </div>
        <div class="col-md-3">
            <input type="text" name="telefono" id="telefono" placeholder="Teléfono" class="form-control">
        </div>
        <div class="col-md-1">
            <button type="submit" name="crear" class="btn btn-success w-100">+</button>
        </div>
    </form>

    <!-- Tabla de clientes -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clientes as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= $c['nombre'] ?></td>
                    <td><?= $c['email'] ?></td>
                    <td><?= $c['telefono'] ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                            <button type="submit" name="eliminar" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                        <!-- Botón para cargar datos al formulario -->
                        <button class="btn btn-primary btn-sm" onclick="cargarDatos(<?= $c['id'] ?>,'<?= $c['nombre'] ?>','<?= $c['email'] ?>','<?= $c['telefono'] ?>')">Editar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Botón para actualizar cliente -->
    <form method="post" id="formActualizar">
        <input type="hidden" name="id" id="clienteIdUpdate">
        <input type="hidden" name="actualizar" value="1">
        <input type="hidden" name="nombre" id="nombreUpdate">
        <input type="hidden" name="email" id="emailUpdate">
        <input type="hidden" name="telefono" id="telefonoUpdate">
    </form>
</div>

<script>
function cargarDatos(id,nombre,email,telefono){
    document.getElementById('clienteIdUpdate').value = id;
    document.getElementById('nombreUpdate').value = nombre;
    document.getElementById('emailUpdate').value = email;
    document.getElementById('telefonoUpdate').value = telefono;
    document.getElementById('formActualizar').submit();
}
</script>
</body>
</html>