<?php

class Cliente {
    protected $nome;
    protected $email;
    protected $cpf;
    protected $telefone;
    private $pdo;

    public function __construct($dbname, $host, $user, $senha) {
        try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
        } catch (PDOException $e) {
            echo "Erro com banco de dados: ".$e->getMessage();
            exit();
        } catch (Exception $e) {
            echo "Erro genérico: ".$e->getMessage();
        }
    }


    // Função para cadastrar cliente no BD
    public function cadastrarCliente ($nome, $email, $cpf, $telefone){
        // antes de cadastrar, vamos verificar se já possui cpf cadastrado
        $cmd = $this->pdo->prepare("SELECT id_cliente FROM cliente WHERE cpf = :cpf");
        $cmd->bindValue(":cpf", $cpf);
        $cmd->execute();
        if($cmd->rowCount() > 0){ //cpf já existe
            return false;
        } else {

            $cmd = $this->pdo->prepare("INSERT INTO cliente (nome, email, cpf, telefone) VALUES (:n, :e, :cpf, :t)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":cpf", $cpf);
            $cmd->bindValue(":t", $telefone);
            $cmd->execute();
            return true;
         }
     }
}