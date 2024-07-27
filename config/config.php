<?php
session_start();

class Config{

    public function logout(){
        
        session_unset(); 
        session_destroy();

        header('Location: /desafio_php_junior/views/login.php');
        exit();
    }
}

?>