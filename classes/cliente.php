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

         //  Função para buscar e retornar os dados do BD
         public function buscarDados(){
            $dadosCliente = array();
            $cmd = $this->pdo->query("SELECT id_cliente, nome, cpf, email, telefone FROM cliente ORDER BY id_cliente");
            $dadosCliente = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $dadosCliente;
        }
    
        // Função para excluir o cliente do BD
        public function excluirCliente($id){
            $cmd = $this->pdo->prepare("DELETE FROM cliente WHERE id_cliente = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }

        // Função para buscar dados de um cliente específico
        public function buscarDadosCliente($id){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            return $res;
        }
    
        // Atualizar os dados no BD
        public function atualizarCliente($id, $nome, $email, $cpf, $telefone){
            $cmd = $this->pdo->prepare("UPDATE cliente SET nome = :n, email = :e, cpf = :cpf, telefone = :t WHERE id_cliente = :id");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":cpf", $cpf);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }

        // Função para contar os itens do BD
        public function contarClientes() {
            $cmd = $this->pdo->query("SELECT COUNT(*) as total FROM cliente");
            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            return $res['total']; // retorna o número de clientes
        }
}

?>