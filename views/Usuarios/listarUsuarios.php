<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/config.php'; 
// include __DIR__ . '/../../config/verificaLogin.php';

require_once __DIR__ . '/../../model/usuarioModel.php';

$banco = new BancoDados();
$db = $banco->ConectarBanco();
$usuarioModel = new UsuarioModel($db);

$usuarios = $usuarioModel->buscarTodos();

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuários</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/usuarioLista.css">   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Usuários</h3>
                    <?php if (isset($_SESSION['access_level']) && $_SESSION['access_level'] === 'admin'): ?>
                    <a href="cadastrarUsuario.php" class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Cadastrar</a>
                    <?php endif; ?>
                </div>
                <?php if ($mensagem): ?>
                    <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($mensagem); ?>                        
                    </div>
                <?php endif; ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Nível de Acesso</th>
                            <?php if (isset($_SESSION['access_level']) && $_SESSION['access_level'] === 'admin'): ?>
                            <th>#</th>
                            <?php endif; ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($usuarios)): ?>
                            <tr>
                                <td colspan="3" class="text-center">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?php echo $usuario['name']; ?></td>
                                    <td><?php echo $usuario['email']; ?></td>
                                    <td><?php if ($usuario['access_level'] === 'admin') {
                                            echo 'Administrador';
                                        } else {
                                            echo 'Usuário';
                                        }
                                        ?>
                                    </td>
                                    <?php if (isset($_SESSION['access_level']) && $_SESSION['access_level'] === 'admin'): ?>
                                    <td>
                                        <a href="cadastrarUsuario.php/<?php echo urlencode($usuario['id']); ?>" class="btn btn-primary">
                                    <i class="bi bi-pencil"></i></a>
                                    <a href="/desafio_php_junior/controllers/usuario.php?acao=apagarUsuario&id=<?php echo urlencode($usuario['id']); ?>" class="btn btn-danger">
                                    <i class="bi bi-trash"></i></a>
                                    </td>
                                    <?php endif; ?>

                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <a href="/desafio_php_junior/views/home.php" class="btn btn-secondary">Voltar</a>
                </div>
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
                }, 5000);
            }
        });
    </script>
</html>
