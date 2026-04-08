<?php
// Puerto (interfaz) para clientes
interface ClienteRepositoryPort {
    public function crear($nombre, $email, $telefono);
    public function actualizar($id, $nombre, $email, $telefono);
    public function eliminar($id);
    public function obtenerTodos();
    public function obtenerPorId($id);
}