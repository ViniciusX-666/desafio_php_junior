<?php
require_once '../../controllers/salas.php';

$controller = new SalasController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'cadastrarSalas':
        $controller->cadastrarSala();
        break;
    default:
        $controller->index();
        break;
}
?>