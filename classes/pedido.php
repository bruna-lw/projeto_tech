<?php

class Pedido {
    private $pdo;
    private $id_cliente;
    private $produtos = []; // Produtos e suas quantidades
    private $valorTotal;

    public function __construct($pdo, $nome_cliente, $produtos, $valorTotal) {
        $this->pdo = $pdo;
        $this->produtos = $produtos;
        $this->valorTotal = $valorTotal;

        // Buscar ID do cliente
        $this->id_cliente = $this->buscarIdCliente($nome_cliente);

        if (!$this->id_cliente) {
            throw new Exception("Cliente não encontrado: $nome_cliente");
            }
    }
    

    private function buscarIdCliente($nome_cliente) {
        try {
            $sql = "SELECT id_cliente FROM cliente WHERE nome = :nome_cliente LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['id_cliente'] : null;
        } catch (PDOException $e) {
            echo "Erro ao buscar cliente: " . $e->getMessage();
            return null;
        }
    }

    public function criarPedido() {
        try {
            $this->pdo->beginTransaction();
    
            // Insere o pedido
            $sql_pedido = "INSERT INTO pedido (id_cliente, valor_total) VALUES (:id_cliente, :valor_total)";
            $stmt = $this->pdo->prepare($sql_pedido);
            $stmt->bindValue(":id_cliente", $this->id_cliente, PDO::PARAM_INT);
            $stmt->bindValue(":valor_total", $this->valorTotal, PDO::PARAM_STR);
            $stmt->execute();
    
            $id_pedido = $this->pdo->lastInsertId();
    
            // Insere os produtos
            foreach (array_keys($this->produtos['nome']) as $index) {
                $nome = $this->produtos['nome'][$index];
                $quantidade = $this->produtos['quantidade'][$index];
                
                // Verifica se os dados estão corretos antes de inserir
                if (!empty($nome) && !empty($quantidade)) {
                    $this->inserirProduto($id_pedido, $nome, $quantidade);
                } else {
                    throw new Exception("Dados inválidos para produto: Nome = $nome, Quantidade = $quantidade");
                }
            }
    
            $this->pdo->commit();
            header('location: /projeto-capacitacao-tecnologia-main/pedido-cadastrado-sucesso.php');
            // echo "Pedido criado com sucesso! ID do Pedido: " . $id_pedido;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo "Erro ao criar o pedido: " . $e->getMessage();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Erro ao processar o pedido: " . $e->getMessage();
        }
    }

    private function obterIdProduto($nome_produto) {
        $sql = "SELECT id_produto FROM produto WHERE nome = :nome_produto";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nome_produto", $nome_produto, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }

    private function inserirProduto($id_pedido, $nome_produto, $quantidade) {
        $id_produto = $this->obterIdProduto($nome_produto);

        if ($id_produto) {
            $sql_inserir = "INSERT INTO produtos_pedido (id_pedido, id_produto, quantidade) VALUES (:id_pedido, :id_produto, :quantidade)";
            $stmt_inserir = $this->pdo->prepare($sql_inserir);
            $stmt_inserir->bindValue(":id_pedido", $id_pedido, PDO::PARAM_INT);
            $stmt_inserir->bindValue(":id_produto", $id_produto, PDO::PARAM_INT);
            $stmt_inserir->bindValue(":quantidade", $quantidade, PDO::PARAM_INT);
            $stmt_inserir->execute();
        } else {
            throw new Exception("Produto não encontrado: $nome_produto");
        }
    }
}
