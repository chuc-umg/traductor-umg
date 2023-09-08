<?php
require_once 'Controller/C_usuarios.php';
require_once 'Model/M_usuarios.php';
$m_usuarios = new M_usuarios();
$c_usuario = new c_usuario($m_usuarios);
//echo $_SERVER['REQUEST_METHOD'];
if ($_SERVER['REQUEST_METHOD']=='POST') {

}
else {
    if (isset($_GET['accion'])) {
        switch ($_GET['accion']) {
            case 'login':
                $c_usuario->login();
                break;
            default:
                break;
        }
    } else {    
        $c_usuario->index();
    }
     

}