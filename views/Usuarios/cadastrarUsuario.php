<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../model/usuarioModel.php';
require_once __DIR__ . '/../../config/config.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /desafio_php_junior/views/login.php');
    exit();
}

$banco = new BancoDados();
$db = $banco->ConectarBanco();
$usuarioModel = new UsuarioModel($db);

function getIdFromUrl() {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $pathSegments = explode('/', trim($path, '/'));
    return !empty($pathSegments) ? intval(end($pathSegments)) : 0;
}

$id = getIdFromUrl();

$usuario = null;

if ($id) {

    $usuario = $usuarioModel->buscarPorId($id);    
}

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Editar Usuário' : 'Cadastrar Usuário'; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="/desafio_php_junior/public/css/usuario.css?v=1.0">
    <link rel="stylesheet" href="../../public/js/usuarioValidation.js">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3><?php echo $id ? 'Editar Usuário' : 'Cadastrar Usuário'; ?></h3>
                <?php if ($mensagem): ?>
                    <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($mensagem); ?>                        
                    </div>
                <?php endif; ?>
                <form id="userForm" action="<?php echo $id ? '/desafio_php_junior/controllers/usuario.php?acao=editarUsuario' : '/desafio_php_junior/controllers/usuario.php?acao=cadastrarUsuario'; ?>" method="post">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Nome:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($usuario[0]['name'] ?? ''); ?>" placeholder="Nome">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="access_level">Nível de acesso:</label>
                                <select class="form-control" id="access_level" name="access_level">
                                    <option value="" disabled <?php echo !$usuario ? 'selected' : ''; ?>>Selecione</option>
                                    <option value="admin" <?php echo ($usuario[0]['access_level'] ?? '') === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                                    <option value="user" <?php echo ($usuario[0]['access_level'] ?? '') === 'user' ? 'selected' : ''; ?>>Usuário</option>
                                </select>
                            </div>
                        </div>
                    </div>                  
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario[0]['email'] ?? ''); ?>" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Senha" value="<?php echo htmlspecialchars($usuario[0]['password'] ?? ''); ?>">
                    </div>
                    <div class="d-flex justify-content-between">
                    <a href="/desafio_php_junior/views/Usuarios/listarUsuarios.php" class="btn btn-secondary">Voltar</a>

                    <input type="hidden" name="registerUser" value="1">
                        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Atualizar' : 'Cadastrar'; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-Kc0eL9j36HgpKkKKt3FwTvCWScC4jKGvxuO9ZyBmMJJ5GUKsL5n0YgWoG5iXpCz6" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="../../public/js/usuarioValidation.js"></script>

    <script>
        $(document).ready(function() {
            var $alert = $('#alert');
            if ($alert.length) {
                setTimeout(function() {
                    $alert.alert('close');
                }, 3000);
            }
        });
    </script>
</body>
</html>