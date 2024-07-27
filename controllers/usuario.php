<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/usuarioModel.php';
require_once __DIR__ . '/../../config/config.php'; 


class UsuarioController {
    private $usuarioModel;
    private $db;
    private $banco;

    public function __construct() {
        $this->banco = new BancoDados();
        $this->db = $this->banco->ConectarBanco();
        $this->usuarioModel = new UsuarioModel($this->db);
    }

    public function __destruct() {
        $this->banco->fecharConexao();
    }

    public function index() {
        $usuarios = $this->usuarioModel->buscarTodos();
        include __DIR__ . '/../views/Usuarios/listarUsuarios.php';
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
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $access_level = $_POST['access_level'] ?? '';

            $dados = [];
            if (!empty($name) && !empty($email) && !empty($password) && !empty($access_level)) {

                if ($this->usuarioModel->verificaEmail($email)) {
                    session_start();
                    $_SESSION['mensagem'] = 'Alguém possui esse email cadastrado, utilize outro email!';
                    header('Location: /desafio_php_junior/views/Usuarios/cadastrarUsuario.php');
                    exit();
                }

                $dados = [];
                $dados = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'access_level' => $access_level
                ];
                
                $this->usuarioModel->cadastrar($dados);
                
                $_SESSION['mensagem'] = 'Usuário cadastrado com sucesso!';
                header('Location: /desafio_php_junior/views/Usuarios/listarUsuarios.php');
                exit();
            } else {
                
                $_SESSION['mensagem'] = 'Todos os campos são obrigatórios.';
                header('Location: /desafio_php_junior/views/Usuarios/cadastrarUsuario.php');
                exit();
            }
        }
    }

    public function editarUsuario() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $access_level = $_POST['access_level'] ?? '';
    
            $dados = [];
            $dados = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'access_level' => $access_level
            ];

            if ($id > 0) {

                if (!empty($name) && !empty($email) && !empty($password) && !empty($access_level)) {
    
                    $this->usuarioModel->editar($id,$dados);

                    
                    $_SESSION['mensagem'] = 'Cadastro do usuário editado com sucesso!';
                    header('Location: /desafio_php_junior/views/Usuarios/listarUsuarios.php');
                    exit();
                } else {
                    
                    $_SESSION['mensagem'] = 'Todos os campos são obrigatórios.';
                    header('Location: /desafio_php_junior/views/Usuarios/cadastrarUsuario.php');
                    exit();
                }
                
            } else {
                header('Location: /desafio_php_junior/views/Usuarios/cadastrarUsuario.php/'.$id);
            }
        } else {
            die('Método de requisição inválido.');
        }
    }

    public function apagarUsuario() {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']);
             $excluiu = $this->usuarioModel->excluir($id);
            session_start();
            if($excluiu){
                $_SESSION['mensagem'] = 'Usuário excluído com sucesso';
            }else{
                $_SESSION['mensagem'] = 'Não foi possível excluir usuário';
            }
            
            header('Location: /desafio_php_junior/views/Usuarios/listarUsuarios.php');
            exit();
        }
    }
    

    public function buscarTodosUsuarios() {
        $usuarios = $this->usuarioModel->buscarTodos();
        return $usuarios;
    }
}

$usuarioController = new UsuarioController();
if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'cadastrarUsuario':
            $usuarioController->cadastrarUsuario();
            break;
        case 'editarUsuario':
            $usuarioController->editarUsuario();
            break;
        case 'apagarUsuario':
            $usuarioController->apagarUsuario();            
            break;
        case 'autenticar':
            $usuarioController->autenticar();
            break;
        default:
            $usuarioController->index();
            break;
    }
} else {
    $usuarioController->index();
}
?>
