<?php
require_once '../../controllers/reservas.php';

$controller = new ReservasController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'cadastrarReservas':
        $controller->cadastrarReservas();
        break;
    default:
        $controller->index();
        break;
}
?>