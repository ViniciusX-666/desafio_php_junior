<?php
require_once '../config/database.php';
require_once '../model/reservasModel.php';
require_once '../model/salasModel.php';

class ReservasController {

    private $reservasModel;
    private $salasModel;

    public function __construct($pdo) {
        $this->reservasModel = new ReservasModel($pdo);
        $this->salasModel = new SalasModel($pdo);
    }

    
    public function cadastrarReservas() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerReservations'])) {

            $roomId = trim($_POST['room_id ']);
            $userId = $_POST['user_id'];
            $startTime = $_POST['start_time'];           
            $endTime = $_POST['end_time '];

            $dados = [
                'roomId' => $roomId,
                'userId' => $userId,
                'startTime' => $startTime,               
                'endTime' => $endTime,               
            ];

            $reservas = $this->reservasModel->cadastrarReservas($dados);

            if ($salas) {
                echo "Cadastro bem-sucedido!";
            } else {
                echo "Erro ao cadastrar reserva.";
            }
        }
    }

    public function buscarTodasSalas(){

        $buscou = $this->salasModel->buscarTodos();
    }
}

$pdo = include('../config/database.php');
$reservasController = new ReservasController($pdo);

if (isset($_POST['registerReservations'])) {
    $reservasController->cadastrarReservas();
} 
?>
