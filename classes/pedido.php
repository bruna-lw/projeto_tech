<?php

class Pedido {
    private $id_pedido;
    private $id_cliente;
    private $produtos = []; // Armazena os produtos e quantidades do pedido
    private $valor_total = 0;
    private $pdo; // Conexão com o banco de dados

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

    // Construtor - Recebe a conexão PDO e os dados do pedido
    public function __construct($pdo, $id_cliente, $produtos) {
        $this->pdo = $pdo;
        $this->id_cliente = $id_cliente;
        $this->produtos = $produtos;
        $this->criarPedido(); // Cria o pedido automaticamente ao instanciar
    }

    // Cria o pedido na tabela 'pedido' e insere os produtos na tabela 'produtos_pedido'
    private function criarPedido() {
        try {
            // Iniciar uma transação
            $this->pdo->beginTransaction();

            // Inserir o pedido na tabela 'pedido'
            $sql_pedido = "INSERT INTO pedido (id_cliente) VALUES (:id_cliente)";
            $stmt = $this->pdo->prepare($sql_pedido);
            $stmt->bindValue(":id_cliente", $this->id_cliente, PDO::PARAM_INT);
            $stmt->execute();

            // Obtém o ID do pedido recém-criado
            $this->id_pedido = $this->pdo->lastInsertId();

            // Iterar pelos produtos e inseri-los na tabela 'produtos_pedido'
            foreach ($this->produtos as $produto) {
                $this->adicionarProdutoAoPedido($produto['id_produto'], $produto['quantidade']);
            }

            // Atualizar o valor total do pedido na tabela 'pedido'
            $this->atualizarValorTotal();

            // Confirmar a transação
            $this->pdo->commit();

            echo "Pedido criado com sucesso! ID do Pedido: " . $this->id_pedido;
        } catch (PDOException $e) {
            // Reverter a transação em caso de erro
            $this->pdo->rollBack();
            echo "Erro ao criar o pedido: " . $e->getMessage();
        }
    }

    // Adiciona um produto ao pedido na tabela 'produtos_pedido'
    private function adicionarProdutoAoPedido($id_produto, $quantidade) {
        try {
            // Buscar o valor unitário do produto na tabela 'produto'
            $sql_produto = "SELECT valor FROM produto WHERE id_produto = :id_produto";
            $stmt_produto = $this->pdo->prepare($sql_produto);
            $stmt_produto->bindValue(":id_produto", $id_produto, PDO::PARAM_INT);
            $stmt_produto->execute();

            $produto_data = $stmt_produto->fetch(PDO::FETCH_ASSOC);
            if ($produto_data) {
                $valor_unitario = $produto_data['valor'];

                // Calcular o valor parcial (quantidade * valor_unitario)
                $valor_parcial = $quantidade * $valor_unitario;

                // Inserir na tabela 'produtos_pedido'
                $sql_inserir_produto = "INSERT INTO produtos_pedido (id_pedido, id_produto, quantidade, valor_unitario, valor_parcial) 
                                        VALUES (:id_pedido, :id_produto, :quantidade, :valor_unitario, :valor_parcial)";
                $stmt_inserir_produto = $this->pdo->prepare($sql_inserir_produto);
                $stmt_inserir_produto->bindValue(":id_pedido", $this->id_pedido, PDO::PARAM_INT);
                $stmt_inserir_produto->bindValue(":id_produto", $id_produto, PDO::PARAM_INT);
                $stmt_inserir_produto->bindValue(":quantidade", $quantidade, PDO::PARAM_INT);
                $stmt_inserir_produto->bindValue(":valor_unitario", $valor_unitario, PDO::PARAM_STR);
                $stmt_inserir_produto->bindValue(":valor_parcial", $valor_parcial, PDO::PARAM_STR);
                $stmt_inserir_produto->execute();

                // Atualizar o valor total do pedido na memória
                $this->valor_total += $valor_parcial;
            } else {
                throw new Exception("Produto não encontrado. ID do Produto: $id_produto");
            }
        } catch (PDOException $e) {
            echo "Erro ao adicionar produto ao pedido: " . $e->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // Atualiza o valor total do pedido na tabela 'pedido'
    private function atualizarValorTotal() {
        try {
            $sql_update = "UPDATE pedido SET valor_total = :valor_total WHERE id_pedido = :id_pedido";
            $stmt_update = $this->pdo->prepare($sql_update);
            $stmt_update->bindValue(":valor_total", $this->valor_total, PDO::PARAM_STR);
            $stmt_update->bindValue(":id_pedido", $this->id_pedido, PDO::PARAM_INT);
            $stmt_update->execute();
        } catch (PDOException $e) {
            echo "Erro ao atualizar o valor total do pedido: " . $e->getMessage();
        }
    }
}

// // Exemplo de uso:

// // Conexão com o banco de dados usando PDO
// $dsn = "mysql:dbname=sistema_pedidos;host=localhost";
// $user = "seu_usuario";
// $password = "sua_senha";

// try {
//     $pdo = new PDO($dsn, $user, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     // Dados de exemplo para criar um pedido
//     $id_cliente = 1; // ID do cliente
//     $produtos = [
//         ['id_produto' => 1, 'quantidade' => 2], // Produto A
//         ['id_produto' => 2, 'quantidade' => 1]  // Produto B
//     ];

//     // Criar um novo pedido
//     $pedido = new Pedido($pdo, $id_cliente, $produtos);

// } catch (PDOException $e) {
//     echo "Erro com o banco de dados: " . $e->getMessage();
// }

// ?>
