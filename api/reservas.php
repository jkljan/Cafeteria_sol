<?php
// Carga de dependencias: base de datos, repositorio, servicio y sistema de eventos
require_once "../config/Database.php";
require_once "../repositories/ReservaRepository.php";
require_once "../services/ReservaService.php";
require_once "../events/EventManager.php";
require_once "../events/EmailNotifier.php";
require_once "../events/LogNotifier.php";

// Inicializa la conexión a la base de datos
$db = (new Database())->connect();

// Se crea el repositorio encargado del acceso a datos de reservas
$repo = new ReservaRepository($db);

// Configuración del sistema de eventos (patrón Observer)
$eventManager = new EventManager();

// Suscriptores que reaccionarán cuando ocurra un evento (ej: nueva reserva)
$eventManager->subscribe(new EmailNotifier()); // Envía notificaciones por correo
$eventManager->subscribe(new LogNotifier());   // Registra eventos en logs

// Servicio que contiene la lógica de negocio, usando repositorio y eventos
$service = new ReservaService($repo, $eventManager);

// Se define que la respuesta será en formato JSON
header("Content-Type: application/json");

// Manejo de solicitudes GET (listar reservas por fecha)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Si no se envía fecha, se usa la fecha actual por defecto
    $fecha = $_GET['fecha'] ?? date("Y-m-d");

    echo json_encode($service->listarReservas($fecha));
}

// Manejo de solicitudes POST (crear una nueva reserva)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se obtiene el cuerpo de la petición y se convierte de JSON a array
    $data = json_decode(file_get_contents("php://input"), true);

    // Se llama al servicio para crear la reserva
    $service->crearReserva(
        $data['cliente_id'],
        $data['fecha'],
        $data['hora'],
        $data['mesa']
    );

    // Respuesta simple de éxito
    echo json_encode(["ok" => true]);
}