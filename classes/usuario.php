<?php

class Usuario {
    protected $nome;
    protected $email;
    protected $cpf;
    protected $telefone;
    protected $senha;
    protected $imagem;
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

     //  Função para buscar e retornar os dados do BD
     public function buscarDados(){
        $dadosUsuario = array();
        $cmd = $this->pdo->query("SELECT * FROM usuario ORDER BY id_usuario");
        $dadosUsuario = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dadosUsuario;
    }

    // Função para buscar dados de um usuario específico
    public function buscarDadosUsuario($id){
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    // Atualizar os dados no BD
    public function atualizarUsuario($id, $nome, $email, $cpf, $telefone, $senha, $imagem = null) {
        // Criptografar a senha antes de atualizá-la
        // $senhaCriptografada = sha1($senha);
    
        if ($imagem) {
            // Atualiza com a imagem incluída
            $cmd = $this->pdo->prepare("UPDATE usuario SET nome = :n, email = :e, cpf = :cpf, telefone = :t, senha = :s, imagem = :img WHERE id_usuario = :id");
            $cmd->bindValue(":img", $imagem, PDO::PARAM_LOB); // PDO::PARAM_LOB para grandes objetos binários (imagem)
        } else {
            // Atualiza sem a imagem (mantém a imagem anterior)
            $cmd = $this->pdo->prepare("UPDATE usuario SET nome = :n, email = :e, cpf = :cpf, telefone = :t, senha = :s WHERE id_usuario = :id");
        }
    
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":e", $email);
        $cmd->bindValue(":cpf", $cpf);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":id", $id);
        $cmd->bindValue(":s", $senha);
        $cmd->execute();
    }

    // Função para excluir o usuario do BD
    public function excluirUsuario($id){
        $cmd = $this->pdo->prepare("DELETE FROM usuario WHERE id_usuario = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}    

?>