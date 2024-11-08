<?php

class Conection
{
    private $servidor_mysql;
    private $porta;
    private $nome_banco;
    private $usuario;
    private $senha; 
    private $con;

    public function __construct()
    {
        // Obter credenciais do banco de dados das variáveis de ambiente
        $this->servidor_mysql = getenv('DB_HOST');
        $this->porta = getenv('DB_PORT');
        $this->nome_banco = getenv('DB_NAME');
        $this->usuario = getenv('DB_USER');
        $this->senha = getenv('DB_PASSWORD');
    }

    public function getConexao()
    {
        try {
            $dsn = "mysql:host=$this->servidor_mysql;port=$this->porta;dbname=$this->nome_banco;charset=utf8";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];

            $this->con = new PDO($dsn, $this->usuario, $this->senha, $options);

            if (!$this->con) {
                throw new Exception('Falha na conexão com o banco de dados.');
            }

            return $this->con;
        } catch (PDOException $e) {
            echo 'Falha na conexão: ' . $e->getMessage();
            exit; // Encerra a execução em caso de erro de conexão
        } catch (Exception $e) {
            echo 'Erro: ' . $e->getMessage();
            exit; // Encerra a execução em caso de outros erros
        }
    }
}


?>

