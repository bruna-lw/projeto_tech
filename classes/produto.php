<?php

class Produto {
    protected $nome;
    protected $sku;
    protected $valor;
    protected $descricao;
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


    // Função para cadastrar produto no BD
    public function cadastrarProduto ($nome, $sku, $valor, $descricao, $imagem = null){
        // antes de cadastrar, vamos verificar se já possui sku cadastrado
        $cmd = $this->pdo->prepare("SELECT id_produto FROM produto WHERE sku = :sku");
        $cmd->bindValue(":sku", $sku);
        $cmd->execute();
        if($cmd->rowCount() > 0){ //sku já existe
            return false;
        } else {
            if ($imagem) {
                $cmd = $this->pdo->prepare("INSERT INTO produto SET nome = :n, sku = :sku, valor = :v, descricao = :d, imagem = :img");
                $cmd->bindValue(":img", $imagem, PDO::PARAM_LOB); // armazenar a imagem como BLOB
            } else {
                $cmd = $this->pdo->prepare("INSERT INTO produto (nome, sku, valor, descricao) VALUES (:n, :sku, :v, :d)");
            }

            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":sku", $sku);
            $cmd->bindValue(":v", $valor);
            $cmd->bindValue(":d", $descricao);
            $cmd->execute();
            return true;
         }
     }

    //  Função para buscar e retornar os dados do BD
     public function buscarDados(){
        $dadosProduto = array();
        $cmd = $this->pdo->query("SELECT id_produto, imagem, nome, sku, descricao, valor, quantidade FROM produto ORDER BY id_produto");
        $dadosProduto = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dadosProduto;
    }

    // Função para excluir o produto do BD
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
    public function atualizarProduto($id, $nome, $sku, $valor, $descricao, $imagem = null) {
        if ($imagem) {
            $cmd = $this->pdo->prepare("UPDATE produto SET nome = :n, sku = :sku, valor = :v, descricao = :d, imagem = :img WHERE id_produto = :id");
            $cmd->bindValue(":img", $imagem, PDO::PARAM_LOB);
        } else {
            $cmd = $this->pdo->prepare("UPDATE produto SET nome = :n, sku = :sku, valor = :v, descricao = :d WHERE id_produto = :id");
        }
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":sku", $sku);
        $cmd->bindValue(":v", $valor);
        $cmd->bindValue(":d", $descricao);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    // Função para contar os itens do BD
    public function contarProdutos() {
        $cmd = $this->pdo->query("SELECT COUNT(*) as total FROM produto");
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res['total']; // retorna o número de produtos
    }

    // Método para adicionar estoque
    public function adicionarEstoque($id, $quantidade) {
        $cmd = $this->pdo->prepare("UPDATE produto SET quantidade = quantidade + :q WHERE id_produto = :id");
        $cmd->bindValue(":q", $quantidade);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    // Método para retirar do estoque
    public function retirarEstoque($id, $quantidade) {
        $cmd = $this->pdo->prepare("UPDATE produto SET quantidade = quantidade - :q WHERE id_produto = :id");
        $cmd->bindValue(":q", $quantidade);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

}
?>