<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/config.php'; 

require_once __DIR__ . '/../../model/salasModel.php';

$banco = new BancoDados();
$db = $banco->ConectarBanco();
$salasModel = new SalasModel($db);

$salas = $salasModel->buscarTodos();

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Salas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/salaLista.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Salas</h3>
                    <a href="cadastrarSalas.php" class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Cadastrar</a>
                </div>
                <?php if ($mensagem): ?>
                    <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($mensagem); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Capacidade</th>
                            <th>Locação</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($salas)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Nenhuma sala encontrada.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($salas as $sala): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($sala['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($sala['capacidade']); ?></td>
                                    <td><?php echo htmlspecialchars($sala['locacao']); ?></td>
                                    <td>
                                        <a href="editarSalas.php/<?php echo urlencode($sala['id']); ?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-danger" onclick="confirmDelete(<?php echo urlencode($sala['id']); ?>)"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-Kc0eL9j36HgpKkKKt3FwTvCWScC4jKGvxuO9ZyBmMJJ5GUKsL5n0YgWoG5iXpCz6" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
        function confirmDelete(id) {
            if (confirm('Tem certeza de que deseja excluir esta sala?')) {
                window.location.href = '/desafio_php_junior/controllers/salasController.php?acao=apagarSalas&id=' + id;
            }
        }
    </script>
</body>
</html>
