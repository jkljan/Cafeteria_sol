-- Base de datos: cafeteria_sol
CREATE DATABASE IF NOT EXISTS cafeteria_sol;
USE cafeteria_sol;

-- Tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insertar usuario administrador (usuario: admin, contraseña: admin)
INSERT INTO usuarios (username, password) VALUES ('admin', MD5('admin'));

-- Tabla clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telefono VARCHAR(20)
);

-- Tabla reservas
CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    mesa INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
);