<?php
class c_usuario {
    private $m_usuario;
    public function __construct($m_usuarios) {
        $this->m_usuario = $m_usuarios;
    }
    public function index() {
        include('View/index.php');
    }
    public function login() {
        include('View/login.php');
    }
    public function traductor() {
        $this->m_usuario->traductor();
    }
    public function agregar() {
        $this->m_usuario->agregar();
    }
}