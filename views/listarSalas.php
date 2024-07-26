<?php
require_once '../config/database.php';
require_once '../model/salasModel.php';

$pdo = include('../config/database.php');
$salasModel = new SalasModel($pdo);

$salas = $salasModel->buscarTodos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Salas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/salaLista.css">
</head>
<body>
    
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3>Salas</h3>
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
                                <td colspan="3" class="text-center">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($salas as $sala): ?>
                                <tr>
                                    <td><?php echo $sala['name']; ?></td>
                                    <td><?php echo $sala['capacity']; ?></td>
                                    <td><?php echo $sala['location']; ?></td>
                                    
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
</body>
</html>
