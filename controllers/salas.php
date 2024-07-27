<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/salasModel.php';
include __DIR__ . '/../../config/verificaLogin.php';

class SalasController {
    private $salaModel;
    private $db;
    private $banco;

    public function __construct() {
        $this->banco = new BancoDados();
        $this->db = $this->banco->ConectarBanco();
        $this->salaModel = new SalasModel($this->db);
    }

    public function __destruct() {
        $this->banco->fecharConexao();
    }

    public function index() {
        $salas = $this->salaModel->buscarTodos();
        include __DIR__ . '/../views/Salas/listarSalas.php';
    }
    
    public function cadastrarSalas() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['name']);
            $capacidade = trim($_POST['capacity']);
            $locacao = trim($_POST['location']);

            if (!empty($nome) && !empty($capacidade) && !empty($locacao)) {
                $dados = [
                    'nome' => $nome,
                    'capacidade' => $capacidade,
                    'locacao' => $locacao,
                ];

                $this->salaModel->cadastrarSalas($dados);

                session_start();
                $_SESSION['mensagem'] = 'Sala cadastrada com sucesso!';
                header('Location: /desafio_php_junior/views/Salas/listarSalas.php');
                exit();
            } else {
                session_start();
                $_SESSION['mensagem'] = 'Todos os campos são obrigatórios.';
                header('Location: /desafio_php_junior/views/Salas/cadastrarSalas.php');
                exit();
            }
        }
    }

    public function buscarTodasSalas() {
        return $this->salaModel->buscarTodos();
    }

    public function editarSalas() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $id = intval($_POST['id'] ?? 0);
            $nome = trim($_POST['name'] ?? '');
            $capacidade = intval($_POST['capacity'] ?? 0);
            $locacao = trim($_POST['location'] ?? '');
    
            if ($id > 0 && !empty($nome) && $capacidade > 0) {
                $dados = [
                    'name' => $nome,
                    'capacity' => $capacidade,
                    'location' => $locacao,
                ];
    
                $this->salaModel->editar($id, $dados);
                $_SESSION['mensagem'] = 'Cadastro da sala editado com sucesso!';
            } else {
                $_SESSION['mensagem'] = 'Todos os campos são obrigatórios.';
            }
    
            header('Location: /desafio_php_junior/views/Salas/listarSalas.php');
            exit();
        }
    }

    public function apagarSalas(){
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']);
             $excluiu = $this->salaModel->excluir($id);
            session_start();
            if($excluiu){
                $_SESSION['mensagem'] = 'Sala excluída com sucesso';
            }else{
                $_SESSION['mensagem'] = 'Não foi possível excluir sala';
            }
            
            header('Location: /desafio_php_junior/views/Salas/listarSalas.php');
            exit();
        }
    }
}

$salasController = new SalasController();
if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'cadastrarSalas':
            $salasController->cadastrarSalas();
            break;
        case 'editarSalas':
            $salasController->editarSalas();
            break;
        case 'apagarSalas':
            $salasController->apagarSalas();
            break;
        default:
            $salasController->index();
            break;
    }
} else {
    $salasController->index();
}
?>
