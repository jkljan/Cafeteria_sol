<?php
require_once "../config/Database.php";
require_once "../repositories/ReservaRepository.php";
require_once "../services/ReservaService.php";
require_once "../events/EventManager.php";
require_once "../events/EmailNotifier.php";
require_once "../events/LogNotifier.php";

$db = (new Database())->connect();

$repo = new ReservaRepository($db);

$eventManager = new EventManager();
$eventManager->subscribe(new EmailNotifier());
$eventManager->subscribe(new LogNotifier());

$service = new ReservaService($repo, $eventManager);

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $fecha = $_GET['fecha'] ?? date("Y-m-d");
    echo json_encode($service->listarReservas($fecha));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $service->crearReserva(
        $data['cliente_id'],
        $data['fecha'],
        $data['hora'],
        $data['mesa']
    );

    echo json_encode(["ok" => true]);
}