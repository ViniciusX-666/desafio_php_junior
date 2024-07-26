<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/usuario.css">
    <link rel="stylesheet" href="../public/js/usuarioValidation.js">


</head>
<body>
    
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3>Cadastrar Usuários</h3>
                <form id="userForm" action="../controller/usuario/cadastrarUsuario" method="post">  
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Nome:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nome">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="access_level">Nível de acesso:</label>
                                <select class="form-control" id="access_level" name="access_level">
                                    <option value="" disabled selected>Selecione</option>
                                    <option value="admin">Administrador</option>
                                    <option value="user">Usuário</option>
                                </select>
                            </div>
                        </div>
                    </div>                  
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
                    </div>
                    <div class="d-flex justify-content-center">
                        <input type="hidden" name="registerUser" value="1">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-Kc0eL9j36HgpKkKKt3FwTvCWScC4jKGvxuO9ZyBmMJJ5GUKsL5n0YgWoG5iXpCz6" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
