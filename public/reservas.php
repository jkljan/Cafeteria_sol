<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirige si no hay sesión activa
    exit;
}

require_once "../config/Database.php";
require_once "../repositories/ReservaRepository.php";
require_once "../repositories/ClienteRepository.php";
require_once "../services/ReservaService.php";
require_once "../services/ClienteService.php";
require_once "../controllers/ReservaController.php";
require_once "../controllers/ClienteController.php";
require_once "../events/EventManager.php";
require_once "../events/EmailNotifier.php";
require_once "../events/LogNotifier.php";

// ===== CONEXIÓN =====
$db = (new Database())->connect();

// ===== REPOSITORIOS =====
$clienteRepo = new ClienteRepository($db);
$reservaRepo = new ReservaRepository($db);

// ===== SERVICES =====
$clienteService = new ClienteService($clienteRepo);

// ===== EVENTOS =====
$eventManager = new EventManager();
$eventManager->subscribe(new EmailNotifier());
$eventManager->subscribe(new LogNotifier());

// ===== SERVICE DE RESERVAS (con eventos) =====
$reservaService = new ReservaService($reservaRepo, $eventManager);

// ===== CONTROLLERS =====
$clienteController = new ClienteController($clienteService);
$reservaController = new ReservaController($reservaService);

// ===== LÓGICA DE FORMULARIOS =====
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear'])) {
        $mensaje = $reservaController->crear($_POST);
    } elseif (isset($_POST['actualizar'])) {
        $mensaje = $reservaController->actualizar($_POST);
    } elseif (isset($_POST['eliminar'])) {
        $mensaje = $reservaController->eliminar($_POST['id']);
    }
}

// Listado de clientes para dropdown
$clientes = $clienteController->listar();

// Filtrar por fecha
$fechaSeleccionada = $_POST['fechaFiltro'] ?? date("Y-m-d");
$reservas = $reservaController->listar($fechaSeleccionada);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas - Cafetería Sol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Cafetería Sol</a>
    <div class="d-flex">
      <a class="btn btn-outline-light" href="clientes.php">Clientes</a>
      <a class="btn btn-outline-light ms-2" href="logout.php">Cerrar sesión</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h3>Reservas</h3>

    <?php if($mensaje): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>

    <!-- Filtro por fecha -->
    <form method="post" class="row g-3 mb-3">
        <div class="col-md-3">
            <input type="date" name="fechaFiltro" class="form-control" value="<?= $fechaSeleccionada ?>">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <!-- Formulario crear reserva -->
    <form method="post" class="row g-3 mb-3">
        <div class="col-md-3">
            <select name="cliente_id" class="form-select" required>
                <option value="">Seleccionar Cliente</option>
                <?php foreach($clientes as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="col-md-2">
            <input type="time" name="hora" class="form-control" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="mesa" class="form-control" placeholder="Mesa" required>
        </div>
        <div class="col-md-1">
            <button type="submit" name="crear" class="btn btn-success w-100">+</button>
        </div>
    </form>

    <!-- Tabla de reservas -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th><th>Cliente</th><th>Fecha</th><th>Hora</th><th>Mesa</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($reservas as $r): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= $r['nombre'] ?></td>
                    <td><?= $r['fecha'] ?></td>
                    <td><?= $r['hora'] ?></td>
                    <td><?= $r['mesa'] ?></td>
                    <td>
                        <!-- Eliminar reserva -->
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button type="submit" name="eliminar" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                        <!-- Editar reserva -->
                        <button class="btn btn-primary btn-sm" onclick="cargarDatos(<?= $r['id'] ?>,'<?= $r['cliente_id'] ?>','<?= $r['fecha'] ?>','<?= $r['hora'] ?>','<?= $r['mesa'] ?>')">Editar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Formulario oculto para actualizar reserva -->
    <form method="post" id="formActualizar">
        <input type="hidden" name="actualizar" value="1">
        <input type="hidden" name="id" id="reservaId">
        <input type="hidden" name="cliente_id" id="reservaCliente">
        <input type="hidden" name="fecha" id="reservaFecha">
        <input type="hidden" name="hora" id="reservaHora">
        <input type="hidden" name="mesa" id="reservaMesa">
    </form>
</div>

<script>
function cargarDatos(id,cliente,fecha,hora,mesa){
    document.getElementById('reservaId').value = id;
    document.getElementById('reservaCliente').value = cliente;
    document.getElementById('reservaFecha').value = fecha;
    document.getElementById('reservaHora').value = hora;
    document.getElementById('reservaMesa').value = mesa;
    document.getElementById('formActualizar').submit();
}
</script>

</body>
</html>