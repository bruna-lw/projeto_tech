<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dsn = "mysql:dbname=projeto;host=localhost";
$user = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['query'])) {
        $query = $_GET['query'];
        
        // Preparar e executar a consulta SQL para buscar produtos com base na consulta
        $stmt = $pdo->prepare("SELECT id_produto, nome, sku, descricao, valor, imagem FROM produto WHERE nome LIKE :query ORDER BY nome");
        $stmt->execute([':query' => '%' . $query . '%']);
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Converter a imagem para base64
        foreach ($produtos as &$produto) {
            if (!empty($produto['imagem'])) {
                $produto['imagem'] = base64_encode($produto['imagem']);
            }
        }

        echo json_encode($produtos); // Certifique-se de que apenas JSON é retornado
    } else {
        echo json_encode([]); // Retorna um array vazio se não houver consulta
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

