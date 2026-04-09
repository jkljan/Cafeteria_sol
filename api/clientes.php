<?php
// Carga de dependencias necesarias (conexión, repositorio y servicio)
require_once "../config/Database.php";
require_once "../repositories/ClienteRepository.php";
require_once "../services/ClienteService.php";

// Se crea la conexión a la base de datos
$db = (new Database())->connect();

// Se inicializa el repositorio con la conexión
$repo = new ClienteRepository($db);

// Se inicializa el servicio que contiene la lógica de negocio
$service = new ClienteService($repo);

// Se define que la respuesta será en formato JSON
header("Content-Type: application/json");

// Manejo de solicitudes GET (listar clientes)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($service->listarClientes());
}

// Manejo de solicitudes POST (registrar un nuevo cliente)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se obtiene el cuerpo de la petición y se convierte de JSON a array asociativo
    $data = json_decode(file_get_contents("php://input"), true);

    // Se llama al servicio para registrar el cliente
    $service->registrarCliente($data['nombre'], $data['email'], $data['telefono']);

    // Respuesta simple de éxito
    echo json_encode(["ok" => true]);
}