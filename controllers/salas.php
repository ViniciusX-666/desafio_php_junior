<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/salasModel.php';

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
            $nome = $_POST['name'];
            $capacidade = $_POST['capacity'];
            $locacao = $_POST['location'];

            if (!empty($nome) && !empty($capacidade) && !empty($locacao)) {
                $dados = [
                    'nome' => $nome,
                    'capacidade' => $capacidade,
                    'locacao' => $locacao,
                ];

                $this->salaModel->cadastrarSalas($dados);

                
                $_SESSION['mensagem'] = 'Sala cadastrada com sucesso!';
                header('Location: /desafio_php_junior/views/Salas/listarSalas.php');
                exit();
            } else {
                
                $_SESSION['mensagem'] = 'Todos os campos são obrigatórios.';
                header('Location: /desafio_php_junior/views/Salas/cadastrarSalas.php');
                exit();
            }
        }
    }

    public function buscarTodasSalas() {
        return $this->salaModel->buscarTodos();
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
