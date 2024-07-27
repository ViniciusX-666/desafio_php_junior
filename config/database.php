<?php

class BancoDados{

    private $dsn = 'mysql:host=desafio-tecnico.cf1afo0ns4vr.us-west-2.rds.amazonaws.com;dbname=vinicius_ribeiro';
    private $username = 'vinicius_ribeiro';
    private $password = 'DesafioAvant@2024';
    public $conect;

    public function ConectarBanco(){

        try {
            $this->conect = new PDO($this->dsn, $this->username, $this->password);
            
        } catch (PDOException $e) {
            print_r('Erro na conexao: ' . $e->getMessage());
        }
        return $this->conect;
    }

    public function fecharConexao() {
        $this->conect = null;
    }
}
?>

