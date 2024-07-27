<?php
require_once '../../controllers/usuario.php';

$controller = new UsuarioController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'cadastrarUsuario':
        $controller->cadastrarUsuario();
        break;
    default:
        $controller->index();
        break;
}
?>