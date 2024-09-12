<?php

class Usuario {
    protected $nome;
    protected $email;
    protected $cpf;
    protected $telefone;
    protected $senha;
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


    // Função para cadastrar usuario no BD
    public function cadastrarUsuario ($nome, $email, $cpf, $telefone, $senha){
        // antes de cadastrar, vamos verificar se já possui email cadastrado
        $cmd = $this->pdo->prepare("SELECT id_usuario FROM usuario WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        if($cmd->rowCount() > 0){ //email já existe
            return false;
        } else {
            // Criptografia da senha usando sha1
            $senhaCriptografada = sha1($senha);

            $cmd = $this->pdo->prepare("INSERT INTO usuario (nome, email, cpf, telefone, senha) VALUES (:n, :e, :c, :t, :s)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":c", $cpf);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":s", $senhaCriptografada);
            $cmd->execute();
            return true;
         }
     }
}