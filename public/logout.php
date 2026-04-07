<?php
session_start();
require_once "../config/Database.php";
require_once "../repositories/UsuarioRepository.php";
require_once "../services/AuthService.php";
require_once "../controllers/AuthController.php";

$db = (new Database())->connect();
$usuarioRepo = new UsuarioRepository($db);
$authService = new AuthService($usuarioRepo);
$authController = new AuthController($authService);

$authController->logout(); // Cerramos sesión y redirigimos