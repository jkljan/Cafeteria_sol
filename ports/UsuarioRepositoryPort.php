<?php
// Puerto para usuarios (login)
interface UsuarioRepositoryPort {
    public function buscarPorUsuario($username);
}