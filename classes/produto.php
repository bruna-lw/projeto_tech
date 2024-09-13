<?php

class Produto {
    protected $nome;
    protected $sku;
    protected $valor;
    protected $descricao;
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
    public function cadastrarProduto ($nome, $sku, $valor, $descricao){
        // antes de cadastrar, vamos verificar se já possui sku cadastrado
        $cmd = $this->pdo->prepare("SELECT id_produto FROM produto WHERE sku = :sku");
        $cmd->bindValue(":sku", $sku);
        $cmd->execute();
        if($cmd->rowCount() > 0){ //sku já existe
            return false;
        } else {

            $cmd = $this->pdo->prepare("INSERT INTO produto (nome, sku, valor, descricao) VALUES (:n, :sku, :v, :d)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":sku", $sku);
            $cmd->bindValue(":v", $valor);
            $cmd->bindValue(":d", $descricao);
            $cmd->execute();
            return true;
         }
     }

     public function buscarDados(){
        $dadosProduto = array();
        $cmd = $this->pdo->query("SELECT id_produto, nome, sku, descricao, valor FROM produto ORDER BY id_produto");
        $dadosProduto = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dadosProduto;
    }

    public function excluirProduto($id){
        $cmd = $this->pdo->prepare("DELETE FROM produto WHERE id_produto = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    // Buscar os dados de um produto específico
    public function buscarDadosProduto($id){
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM produto WHERE id_produto = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    // Atualizar os dados no BD
    public function atualizarProduto($id, $nome, $sku, $valor, $descricao){
        $cmd = $this->pdo->prepare("UPDATE produto SET nome = :n, sku = :sku, valor = :v, descricao = :d WHERE id_produto = :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":sku", $sku);
        $cmd->bindValue(":v", $valor);
        $cmd->bindValue(":d", $descricao);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        }
}
