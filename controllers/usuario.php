<?php
require_once '../config/database.php';
require_once '../model/usuarioModel.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct($pdo) {
        echo 'aqui';die;
        $this->usuarioModel = new UsuarioModel($pdo);
    }

    public function autenticar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $senha = trim($_POST['password']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die('Email inválido.');
            }

            if (empty($senha)) {
                die('Senha é obrigatória.');
            }

            $dados = [
                'email' => $email,
                'senha' => $senha
            ];

            $usuario = $this->usuarioModel->autenticar($dados);

            if ($usuario) {
                echo "Login bem-sucedido!";
            } else {
                echo "Email ou senha incorretos.";
            }
        }
    }

    public function cadastrarUsuario() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerUser'])) {
            $nome = trim($_POST['name']);
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $senha = trim($_POST['password']);
            $nivel_acesso = trim($_POST['access_level']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die('Email inválido.');
            }

            if (empty($nome) || empty($senha) || empty($nivel_acesso)) {
                die('Todos os campos são obrigatórios.');
            }

            $dados = [
                'nome' => $nome,
                'email' => $email,
                'senha' => $senha,
                'nivel_acesso' => $nivel_acesso
            ];

            $usuario = $this->usuarioModel->cadastrar($dados);

            if ($usuario) {
                echo "Cadastro bem-sucedido!";
            } else {
                echo "Erro ao cadastrar usuário.";
            }
        }
    }

    public function buscarTodosUsuarios() {
        $usuarios = $this->usuarioModel->buscarTodos();
        return $usuarios;
    }
}

$pdo = include('../config/database.php');
$usuarioController = new UsuarioController($pdo);

if (isset($_POST['login'])) {
    $usuarioController->autenticar();
} elseif (isset($_POST['registerUser'])) {
    $usuarioController->cadastrarUsuario();
}
?>
