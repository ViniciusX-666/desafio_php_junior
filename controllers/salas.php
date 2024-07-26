<?php
require_once '../config/database.php';
require_once '../model/salasModel.php';

class SalasController {

    private $salasModel;

    public function __construct($pdo) {
        $this->salasModel = new SalasModel($pdo);
    }

    
    public function cadastrarSalas() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerRoom'])) {
            $nome = trim($_POST['name']);
            $capacidade = $_POST['capacity '];
            $locacao = $_POST['location '];           

            $dados = [
                'nome' => $nome,
                'capacidade' => $capacidade,
                'locacao' => $locacao,               
            ];

            $salas = $this->salasModel->cadastrarSalas($dados);

            if ($salas) {
                echo "Cadastro bem-sucedido!";
            } else {
                echo "Erro ao cadastrar usuário.";
            }
        }
    }

    public function buscarTodasSalas(){

        $buscou = $this->salasModel->buscarTodos();
    }
}

$pdo = include('../config/database.php');
$salasController = new SalasController($pdo);

if (isset($_POST['registerRoom'])) {
    $salasController->cadastrarSalas();
} 
?>
