<?php

class Conection
{
    private $servidor_mysql = 'localhost';
    private $nome_banco = 'lojaweb';
    private $usuario = 'root';
    private $senha = ''; 
    private $con;

    public function getConexao()
    {
        $this->con = new PDO("mysql:host=$this->servidor_mysql;dbname=$this->nome_banco","$this->usuario","$this->senha");
        return $this->con;
    }
}

?>

