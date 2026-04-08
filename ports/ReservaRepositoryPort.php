<?php
// Puerto para reservas
interface ReservaRepositoryPort {
    public function crear($cliente_id, $fecha, $hora, $mesa);
    public function existeReserva($fecha, $hora, $mesa);
    public function obtenerPorFecha($fecha);
    public function eliminar($id);
    public function actualizar($id, $fecha, $hora, $mesa);
}