<?php
require_once "../config/Database.php";
require_once "../repositories/ClienteRepository.php";
require_once "../services/ClienteService.php";

$db = (new Database())->connect();
$repo = new ClienteRepository($db);
$service = new ClienteService($repo);

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($service->listarClientes());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $service->registrarCliente($data['nombre'], $data['email'], $data['telefono']);
    echo json_encode(["ok" => true]);
}