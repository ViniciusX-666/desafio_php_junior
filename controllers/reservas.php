<?php

// include __DIR__ . '/../../config/verificaLogin.php';

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/reservasModel.php';

class ReservasController {

    private $reservaModel;
    private $db;
    private $banco;

    public function __construct() {
        $this->banco = new BancoDados();
        $this->db = $this->banco->ConectarBanco();
        $this->reservaModel = new ReservasModel($this->db);
    }

    public function __destruct() {
        $this->banco->fecharConexao();
    }

    public function index() {
        $reservas = $this->reservaModel->buscarTodos();
        include __DIR__ . '/../views/Reservas/listarReservas.php';
    }

    public function cadastrarReservas() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $roomId = $_POST['room_id'];
            $userId = $_POST['user_id'];
            $startTime = $_POST['start_time'];           
            $endTime = $_POST['end_time'];

            $startTime = $this->formatarDataParaBanco($startTime);
            $endTime = $this->formatarDataParaBanco($endTime);

            if (!empty($roomId) && !empty($userId) && !empty($startTime) && !empty($endTime)) {
                
                if ($this->reservaModel->verificaReserva($startTime,$endTime)) {
                    
                    $_SESSION['mensagem'] = 'Alguém reservou antes de você, escolha outro dia ou horário!';
                    header('Location: /desafio_php_junior/views/Reservas/cadastrarReservas.php');
                    exit();
                }
                
                $dados = [
                    'roomId' => $roomId,
                    'userId' => $userId,
                    'startTime' => $startTime,               
                    'endTime' => $endTime,               
                ];
                echo json_encode($dados);
    
                $this->reservaModel->cadastrarReservas($dados);

                $_SESSION['mensagem'] = 'Reserva efetuada com sucesso!';
                header('Location: /desafio_php_junior/views/Reservas/listarReservas.php');
                exit();
            } else {
                $_SESSION['mensagem'] = 'Todos os campos são obrigatórios.';
                header('Location: /desafio_php_junior/views/Reservas/cadastrarReservas.php');
                exit();
            }
        }
    }

    public function editarReservas() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $userId = $_POST['user_id'];
            $roomId = $_POST['room_id'];
            $startTime = $_POST['start_time'];           
            $endTime = $_POST['end_time'];

            $startTime = $this->formatarDataParaBanco($startTime);
            $endTime = $this->formatarDataParaBanco($endTime);
        
            if ($id > 0) {

                if (!empty($roomId) && !empty($userId)) {
    
                    $dados = [
                        'roomId' => $roomId,
                        'userId' => $userId,
                        'start_time' => $startTime,               
                        'end_time' => $endTime,               
                    ];
                    
                    $this->reservaModel->editar($id,$dados);
                    
                    $_SESSION['mensagem'] = 'Reserva editado com sucesso!';
                    header('Location: /desafio_php_junior/views/Reservas/listarReservas.php');
                    exit();
                } else {
                    
                    $_SESSION['mensagem'] = 'Todos os campos são obrigatórios.';
                    header('Location: /desafio_php_junior/views/Reservas/cadastrarReservas.php/'.$id);

                    exit();
                }
                
            } else {
                header('Location: /desafio_php_junior/views/Reservas/cadastrarReservas.php');
            }
            if ($start_time && $end_time) {

                $dados = [
                    'room_id' => $room_id,
                    'user_id' => $user_id,
                    'start_time' => $startTime,               
                    'end_time' => $endTime,               
                ];
                $reservasModel->editar($id,$dados);
            } else {
                
                $_SESSION['mensagem'] = "Data de início ou término inválida";
                header("Location: /desafio_php_junior/views/Reservas/cadastrarReservas.php");
                exit;
            }
        }
    }


    public function apagarReservas(){
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']);
             $excluiu = $this->reservaModel->excluir($id);
            session_start();
            if($excluiu){
                $_SESSION['mensagem'] = 'Sala excluída com sucesso';
            }else{
                $_SESSION['mensagem'] = 'Não foi possível excluir sala';
            }
            
            header('Location: /desafio_php_junior/views/Reservas/listarReservas.php');
            exit();
        }
    }

    public function formatarDataParaBanco($dateTime) {

        $date = DateTime::createFromFormat('Y-m-d\TH:i', $dateTime);
        if ($date) {
            return $date->format('Y-m-d H:i:s');
        }
        return null;
    }
    
    

}

$reservasController = new ReservasController();
if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'cadastrarReservas':
            $reservasController->cadastrarReservas();
            break;
        case 'editarReservas':
            $reservasController->editarReservas();
            break;
        case 'apagarReservas':
            $reservasController->apagarReservas();
            break;
        default:
            $reservasController->index();
            break;
    }
} else {
    $reservasController->index();
}
?>
