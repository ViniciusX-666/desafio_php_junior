<?php
class UsuarioModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function autenticar($dados) {
        $sql = "SELECT * FROM users  WHERE email = :email AND password = :senha";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':password', $dados['senha']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Create
    public function cadastrar($dados) {
        
        $sql = "INSERT INTO users (name, email, password, access_level) VALUES (:name, :email, :password, :access_level)";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':name', $dados['nome']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':password', $dados['senha']);
        $stmt->bindParam(':access_level', $dados['nivel_acesso']);
    
        // Executa a inserção e verifica se foi bem-sucedida
        if ($stmt->execute()) {
            return true; // Inserção bem-sucedida
        } else {
            return false; // Falha na inserção
        }
    }

    //Read
    public function buscarTodos(){

        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Update
    public function editar($id, $dados) {
        $sql = "UPDATE users SET name = :name, email = :email,password = :password, access_level = :access_level WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $dados['name']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':password', $dados['password']);
        $stmt->bindParam(':access_level', $dados['access_level']);
        
        $stmt->bindParam(':id', $id);
        return $stmt->execute();

    }

    //Delete    
    public function excluir($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $this->pdo = null;
        return $stmt->execute();
    }

    // Verifica se o email existe
    public function verificaEmail($email) {
        
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = null;
        $this->pdo = null;

        if($resultado){
            return true
        }

        return false;
    }
    
}
?>
