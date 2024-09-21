<?php
// Conexão com o banco de dados
$dsn = "mysql:dbname=projeto;host=localhost";
$user = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se os dados foram enviados via POST
    if (isset($_POST['pedidos'])) {
        $produtos_pedido = $_POST['pedidos'];

        // Prepara a consulta SQL para inserir os dados no banco de dados
        $sql = "INSERT INTO pedidos (produto, quantidade, valor_unitario, valor_total) VALUES (:produto, :quantidade, :valor_unitario, :valor_total)";
        $stmt = $pdo->prepare($sql);

        // Percorre os pedidos e insere cada um no banco de dados
        foreach ($produtos_pedido as $produto) {
            $stmt->execute([
                ':produto' => $produto['produto'],
                ':quantidade' => $produto['quantidade'],
                ':valor_unitario' => $produto['valor_unitario'],
                ':valor_total' => $produto['valor_total']
            ]);
        }

        echo "Pedido salvo com sucesso!";
    } else {
        echo "Nenhum dado recebido.";
    }
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    }
?>
